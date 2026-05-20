@props([
    'regions' => [],
    'height' => null,
])

@php
    $located = collect($regions)->filter(fn ($r) => !is_null($r['lat'] ?? null) && !is_null($r['lng'] ?? null))->values();
    $markers = $located->map(fn ($r, $i) => [
        'code' => 'edge-' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT),
        'coords' => [(float) $r['lat'], (float) $r['lng']],
        'city' => $r['city'] ?? __('molthost::messages.regions.unknown_location'),
        'country' => $r['country'] ?? '',
        'status' => $r['status'] ?? 'unknown',
    ])->all();
    $activeCount = $located->where('status', 'active')->count();
@endphp

<div
    x-data="molthostWorldMap({{ json_encode($markers, JSON_UNESCAPED_UNICODE) }})"
    x-init="$nextTick(() => init($refs.canvas))"
    class="relative w-full rounded-2xl border border-neutral/15 bg-background-secondary/40 overflow-hidden h-[280px] sm:h-[360px] md:h-[420px] lg:h-[500px]"
    @if($height) style="height: {{ $height }};" @endif
>
    {{-- decorative grid behind the map --}}
    <div aria-hidden="true" class="absolute inset-0 grid-pattern opacity-40 pointer-events-none"></div>
    <div aria-hidden="true" class="absolute inset-0 pointer-events-none"
         style="background-image: radial-gradient(hsl(var(--c-muted) / 0.18) 1.2px, transparent 1.2px); background-size: 22px 22px;"></div>

    @if(count($markers) === 0)
        {{-- Empty state: nothing geo-resolvable --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-6">
            <div class="w-12 h-12 mb-4 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center">
                <x-ri-global-fill class="size-5 text-primary" />
            </div>
            <h3 class="text-base font-semibold tracking-tight">{{ __('molthost::messages.regions.empty_title') }}</h3>
            <p class="mt-2 max-w-sm text-sm text-muted leading-relaxed">{{ __('molthost::messages.regions.empty_hint') }}</p>
        </div>
    @endif

    {{-- The jsvectormap canvas. Always rendered (alpine init still runs on empty markers) --}}
    <div x-ref="canvas" class="absolute inset-0"></div>

    {{-- Caption --}}
    <div class="mh-mono absolute bottom-3 right-3 text-[10px] text-muted bg-background/70 px-2 py-1 rounded border border-neutral/20 backdrop-blur-sm">
        {{ __('molthost::messages.regions.map_caption', ['n' => $activeCount]) }}
    </div>
</div>
