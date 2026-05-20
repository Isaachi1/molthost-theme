<?php

/**
 * MoltHost theme — helpers
 *
 * Stateless helpers que o tema usa para:
 *  - resolver host de cada Server extension em coordenadas (GeoIP via ip-api.com)
 *  - listar regiões para o mapa-múndi do home
 *  - resolver setting de tema com fallback para tradução do i18n
 *
 * Todas as funções são prefixadas com `molthost_` para evitar colisão.
 * Cacheamento via Laravel Cache facade.
 */

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

// Registra o namespace de traduções do tema (`molthost::messages.foo.bar`).
// É idempotente — addNamespace só registra uma vez.
try {
    if (class_exists(Lang::class)) {
        Lang::addNamespace('molthost', __DIR__ . '/../lang');
    }
} catch (\Throwable $e) {
    // Em CLI/install bootstrap o container pode não estar pronto. Ignorar.
}

if (!function_exists('molthost_resolve_label')) {
    /**
     * Resiliência contra lang files faltando no Paymenter core.
     *
     * Se um $value parece uma chave i18n não-resolvida (ex.: 'navigation.home',
     * 'services.title'), tenta resolver via fallback no namespace do tema
     * (`molthost::messages.nav.<key>`). Se não houver fallback, retorna o
     * próprio $value para preservar comportamento existente.
     *
     * Use nas views onde labels vêm de classes do core que podem retornar
     * a chave literal quando o lang file não está deployado.
     */
    function molthost_resolve_label(?string $value): string
    {
        $value = (string) $value;
        if ($value === '') {
            return '';
        }

        // Heurística: chave i18n = sem espaços, sem acentos, contém ponto.
        // (Strings traduzidas como "Início", "Sign in" não entram nessa peneira.)
        $looksLikeKey = preg_match('/^[a-z][a-z0-9_]*(?:\.[a-z0-9_]+)+$/i', $value) === 1;
        if (!$looksLikeKey) {
            return $value;
        }

        // Tenta resolver pela própria chave (caso o core esteja saudável).
        $native = __($value);
        if ($native !== $value) {
            return $native;
        }

        // Fallback no nosso namespace: 'navigation.home' → 'molthost::messages.nav.home'.
        // Aceita primeira parte como bucket: navigation, services, invoices, etc.
        [$bucket, $rest] = array_pad(explode('.', $value, 2), 2, '');
        $fallbackKey = 'molthost::messages.nav.' . $rest;
        $fallback = __($fallbackKey);
        if ($fallback !== $fallbackKey) {
            return $fallback;
        }

        // Última tentativa: humanizar a chave ("notifications" → "Notifications").
        return ucfirst(str_replace(['_', '-'], ' ', $rest ?: $bucket));
    }
}

if (!function_exists('molthost_or_trans')) {
    /**
     * Retorna o valor de uma setting do tema com fallback para i18n.
     *
     * Regras (em ordem):
     *  1. Setting vazia        → tradução no locale atual
     *  2. Setting == default EN → tradução no locale atual
     *     (admin nunca customizou; o valor persistido é só o default)
     *  3. Setting != default EN → valor da setting (admin customizou de fato)
     *
     * O passo 2 evita que o texto "default" em inglês do theme.php apareça
     * para um visitante PT/ES/JA/etc. quando o admin nunca tocou a setting.
     */
    function molthost_or_trans(string $settingKey, string $i18nKey, $replace = []): string
    {
        $value = theme($settingKey);
        $translated = __($i18nKey, $replace);

        if (!is_string($value) || trim($value) === '') {
            return $translated;
        }

        // Compara contra o default EN para detectar "admin nunca customizou".
        try {
            $englishDefault = app('translator')->get($i18nKey, $replace, 'en');
            if (is_string($englishDefault) && trim($value) === trim($englishDefault)) {
                return $translated;
            }
        } catch (\Throwable $e) {
            // se translator falhar, segue para retorno do valor (modo seguro)
        }

        return $value;
    }
}

if (!function_exists('molthost_geoip_resolve')) {
    /**
     * Resolve um IP ou hostname para { lat, lng, city, country, countryCode }.
     *
     * - Cache 7 dias por chave
     * - Falha gracioso: retorna null em erro / timeout / IP privado
     * - ip-api.com tem rate limit 45 req/min — o cache absorve isso
     */
    function molthost_geoip_resolve(?string $hostOrIp): ?array
    {
        if (empty($hostOrIp)) {
            return null;
        }

        $host = molthost_normalize_host($hostOrIp);
        if ($host === null) {
            return null;
        }

        return Cache::remember(
            "molthost:geoip:{$host}",
            now()->addDays(7),
            function () use ($host) {
                try {
                    $response = Http::timeout(4)
                        ->retry(1, 200)
                        ->get("http://ip-api.com/json/{$host}", [
                            'fields' => 'status,message,country,countryCode,city,lat,lon',
                        ]);

                    if (!$response->successful()) {
                        return null;
                    }

                    $data = $response->json();

                    if (($data['status'] ?? '') !== 'success') {
                        return null;
                    }

                    return [
                        'lat' => (float) $data['lat'],
                        'lng' => (float) $data['lon'],
                        'city' => $data['city'] ?? null,
                        'country' => $data['country'] ?? null,
                        'countryCode' => $data['countryCode'] ?? null,
                    ];
                } catch (\Throwable $e) {
                    Log::debug('molthost geoip failed', [
                        'host' => $host,
                        'error' => $e->getMessage(),
                    ]);
                    return null;
                }
            }
        );
    }
}

if (!function_exists('molthost_normalize_host')) {
    /**
     * Extrai o hostname utilizável de uma string config (URL/host/IP).
     *
     * Retorna null se: vazio, IP privado, hostname inválido.
     */
    function molthost_normalize_host(string $value): ?string
    {
        $value = trim($value);
        if ($value === '') {
            return null;
        }

        // se for URL, extrai o host
        if (str_contains($value, '://')) {
            $parsed = parse_url($value, PHP_URL_HOST);
            $value = $parsed ?: $value;
        } else {
            // remove qualquer path: "host:port/foo" → "host"
            $value = strtok($value, '/');
            // remove porta: "host:port" → "host"
            if (strpos($value, ':') !== false && substr_count($value, ':') === 1) {
                $value = strtok($value, ':');
            }
        }

        if (!is_string($value) || $value === '') {
            return null;
        }

        // IPs privados / reservados não fazem sentido pra GeoIP
        if (filter_var($value, FILTER_VALIDATE_IP)) {
            if (!filter_var(
                $value,
                FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
            )) {
                return null;
            }
            return $value;
        }

        // hostname básico
        if (!preg_match('/^[a-zA-Z0-9.\-]+$/', $value)) {
            return null;
        }

        return $value;
    }
}

if (!function_exists('molthost_extract_host_from_extension')) {
    /**
     * Procura no array de settings da extension um campo "host"-like:
     * host, url, panel_url, server_url, hostname, api_url.
     */
    function molthost_extract_host_from_extension($extension): ?string
    {
        $candidates = ['host', 'url', 'panel_url', 'server_url', 'hostname', 'api_url'];

        $settings = $extension->settings ?? collect();

        foreach ($candidates as $candidate) {
            $setting = $settings->firstWhere('key', $candidate);
            if ($setting && !empty($setting->value)) {
                return (string) $setting->value;
            }
        }

        return null;
    }
}

if (!function_exists('molthost_get_server_regions')) {
    /**
     * Lista as regiões (cidades) resolvidas a partir das Server extensions
     * habilitadas, agrupadas por host normalizado para não duplicar pins
     * quando várias extensions compartilham a mesma máquina (caso comum:
     * Pterodactyl + PterodactylSSO + PterodactylPlus no mesmo host).
     *
     * Cada item retornado:
     *
     *  [
     *    'id'          => 'panel.example.com',
     *    'host'        => 'panel.example.com',
     *    'extensions'  => ['Pterodactyl', 'PterodactylSSO'],  // todas que apontam pra esse host
     *    'name'        => 'Pterodactyl + 1',                  // display name
     *    'city'        => 'São Paulo',
     *    'country'     => 'Brazil',
     *    'countryCode' => 'BR',
     *    'lat'         => -23.55,
     *    'lng'         => -46.63,
     *    'status'      => 'active' | 'unknown',
     *  ]
     *
     * Cache 1h: GeoIP em si tem cache 7d, mas a lista da query DB é refeita
     * a cada hora pra refletir extensions habilitadas/desabilitadas no admin.
     */
    function molthost_get_server_regions(): array
    {
        return Cache::remember(
            'molthost:server_regions:v2',
            now()->addHour(),
            function () {
                if (!class_exists(\App\Models\Server::class)) {
                    return [];
                }

                try {
                    $servers = \App\Models\Server::query()
                        ->where('enabled', true)
                        ->with('settings')
                        ->get();
                } catch (\Throwable $e) {
                    Log::debug('molthost server_regions query failed', [
                        'error' => $e->getMessage(),
                    ]);
                    return [];
                }

                // 1. Resolve cada server para coords (mantendo extensão).
                $resolved = [];
                foreach ($servers as $server) {
                    $rawHost = molthost_extract_host_from_extension($server);
                    $normalized = $rawHost ? molthost_normalize_host($rawHost) : null;
                    if (!$normalized) {
                        // Sem host válido = não consegue ir pro mapa nem agrupar
                        continue;
                    }
                    $coords = molthost_geoip_resolve($rawHost);

                    $resolved[] = [
                        'host' => $normalized,
                        'extension' => $server->extension,
                        'coords' => $coords,
                    ];
                }

                // 2. Agrupa por host normalizado.
                $byHost = [];
                foreach ($resolved as $r) {
                    $key = $r['host'];
                    if (!isset($byHost[$key])) {
                        $byHost[$key] = [
                            'id' => $key,
                            'host' => $key,
                            'extensions' => [],
                            'coords' => $r['coords'],
                        ];
                    }
                    if (!in_array($r['extension'], $byHost[$key]['extensions'], true)) {
                        $byHost[$key]['extensions'][] = $r['extension'];
                    }
                    // Mantém a primeira resolução de coords; se outra trouxer mais info, atualiza
                    if (empty($byHost[$key]['coords']) && !empty($r['coords'])) {
                        $byHost[$key]['coords'] = $r['coords'];
                    }
                }

                // 3. Achata para o formato consumido pelas views.
                $regions = [];
                foreach ($byHost as $group) {
                    $extensions = $group['extensions'];
                    $coords = $group['coords'];
                    $displayName = $extensions[0] ?? 'Server';
                    if (count($extensions) > 1) {
                        $displayName .= ' + ' . (count($extensions) - 1);
                    }

                    $regions[] = [
                        'id' => $group['id'],
                        'host' => $group['host'],
                        'extensions' => $extensions,
                        'name' => $displayName,
                        'extension' => $extensions[0] ?? null,
                        'city' => $coords['city'] ?? null,
                        'country' => $coords['country'] ?? null,
                        'countryCode' => $coords['countryCode'] ?? null,
                        'lat' => $coords['lat'] ?? null,
                        'lng' => $coords['lng'] ?? null,
                        'status' => $coords ? 'active' : 'unknown',
                    ];
                }

                return $regions;
            }
        );
    }
}

if (!function_exists('molthost_clear_region_cache')) {
    /**
     * Util pra invalidar manualmente (chamável via tinker).
     */
    function molthost_clear_region_cache(): void
    {
        Cache::forget('molthost:server_regions');
    }
}
