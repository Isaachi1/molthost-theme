{{-- MoltHost — Landing
    Sections: Hero (split / terminal / manifesto) → Trust strip → Products (Paymenter categories)
    → Specs row → Regions (live world map from Server extensions) → Pricing teaser → Final CTA
--}}
@php
    $heroVariant      = theme('hero_variant', 'split');
    $heroEyebrow      = molthost_or_trans('hero_eyebrow',      'molthost::messages.hero.eyebrow_default');
    $heroTitle        = molthost_or_trans('hero_title',        'molthost::messages.hero.title_default');
    $heroSubtitle     = molthost_or_trans('hero_subtitle',     'molthost::messages.hero.subtitle_default');
    $heroCtaText      = molthost_or_trans('hero_cta_text',     'molthost::messages.hero.cta_default');
    $heroSecondaryCta = molthost_or_trans('hero_secondary_cta','molthost::messages.hero.cta_secondary_default');

    $metrics = collect([
        ['value' => theme('metric_1_value'), 'label' => theme('metric_1_label')],
        ['value' => theme('metric_2_value'), 'label' => theme('metric_2_label')],
        ['value' => theme('metric_3_value'), 'label' => theme('metric_3_label')],
        ['value' => theme('metric_4_value'), 'label' => theme('metric_4_label')],
    ])->filter(fn($m) => !empty($m['value']));

    $features = collect([
        ['icon' => 'ri-database-2-fill',   'title' => theme('feature_1_title'), 'desc' => theme('feature_1_description'), 'tag' => '01 / DB'],
        ['icon' => 'ri-cpu-fill',          'title' => theme('feature_2_title'), 'desc' => theme('feature_2_description'), 'tag' => '02 / LLM'],
        ['icon' => 'ri-hard-drive-3-fill', 'title' => theme('feature_3_title'), 'desc' => theme('feature_3_description'), 'tag' => '03 / METAL'],
        ['icon' => 'ri-refresh-fill',      'title' => theme('feature_4_title'), 'desc' => theme('feature_4_description'), 'tag' => '04 / MOLT'],
        ['icon' => 'ri-global-fill',       'title' => theme('feature_5_title'), 'desc' => theme('feature_5_description'), 'tag' => '05 / EDGE'],
        ['icon' => 'ri-coins-fill',        'title' => theme('feature_6_title'), 'desc' => theme('feature_6_description'), 'tag' => '06 / $'],
    ])->filter(fn($f) => !empty($f['title']));

    // ── Live regions from enabled Server extensions (auto-detected via GeoIP) ──
    $regions = molthost_get_server_regions();
    $regionsCount = count($regions);
    $activeCount  = collect($regions)->where('status', 'active')->count();

    $trustLogos = ['kuru.dev', 'nimbus/ai', 'TROPICÁLIA', 'tatu.so', 'Cortex Labs', 'BANDA·OS', 'vector++', 'midnight.zip'];
@endphp

<div>
    {{-- ═══ HERO ══════════════════════════════════════════════ --}}
    @if ($heroVariant === 'manifesto')
        {{-- Manifesto: editorial layout, big serif vibe, mascot column --}}
        <section class="relative bg-background-secondary/40 border-b border-neutral/15">
            <div class="container py-20 md:py-28">
                <div class="grid grid-cols-1 md:grid-cols-[200px_1fr] gap-12 md:gap-20 items-start">
                    <div class="flex md:flex-col items-center md:items-start gap-4">
                        <x-logo class="scale-[2.2] origin-top-left" />
                        <div class="mh-mono text-[11px] text-muted tracking-[0.10em] mt-2 md:mt-16">{{ __('molthost::messages.hero.manifesto_established') }}</div>
                    </div>
                    <div>
                        <div class="mh-eyebrow mb-5">{{ __('molthost::messages.hero.manifesto_eyebrow') }}</div>
                        <h1 class="text-3xl sm:text-5xl md:text-6xl font-medium leading-[1.05] tracking-tight max-w-3xl">
                            {!! __('molthost::messages.hero.manifesto_title_html') !!}
                        </h1>
                        <p class="mt-7 text-lg text-muted leading-relaxed max-w-xl">
                            {{ $heroSubtitle }}
                        </p>
                        <div class="mt-9 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            <a href="#products" class="cursor-pointer">
                                <button class="w-full sm:w-auto flex items-center justify-center gap-2 bg-primary text-inverted font-semibold py-3 px-7 rounded-lg hover:bg-primary/90 transition-all duration-200 glow-primary-sm hover:glow-primary cursor-pointer">
                                    {{ $heroCtaText }}
                                    <x-ri-arrow-right-line class="size-4" />
                                </button>
                            </a>
                            <a href="#pricing" class="cursor-pointer">
                                <button class="w-full sm:w-auto flex items-center justify-center gap-2 bg-background border border-neutral/30 text-base font-medium py-3 px-7 rounded-lg hover:border-neutral/50 transition-all duration-200 cursor-pointer">
                                    {{ $heroSecondaryCta }}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @elseif ($heroVariant === 'terminal')
        {{-- Terminal-style: centered headline, big and confident --}}
        <section class="relative overflow-hidden grid-pattern border-b border-neutral/15">
            <div class="absolute inset-0 mh-glow-radial opacity-60 pointer-events-none"></div>
            <div class="container relative py-24 md:py-32 flex flex-col items-center text-center">
                <div class="mh-chip mb-7">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse-slow"></span>
                    {{ $heroEyebrow }}
                </div>
                <div class="mh-mono text-xs text-muted tracking-normal mb-5">
                    {{ str_replace([' ', '_'], ['', ''], strtolower(config('app.name'))) }}.io / v3 / {{ __('molthost::messages.hero.lobster_tagline') }}
                </div>
                <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-medium leading-[0.95] tracking-tight max-w-5xl text-balance">
                    {!! $heroTitle !!}
                </h1>
                <p class="mt-7 text-lg sm:text-xl text-muted max-w-2xl leading-relaxed">
                    {{ $heroSubtitle }}
                </p>
                <div class="mt-9 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <a href="#products" class="cursor-pointer">
                        <button class="flex items-center justify-center gap-2 bg-primary text-inverted font-semibold py-3.5 px-8 rounded-lg hover:bg-primary/90 transition-all duration-200 glow-primary-sm hover:glow-primary cursor-pointer">
                            {{ $heroCtaText }}
                            <x-ri-arrow-right-line class="size-4" />
                        </button>
                    </a>
                    <a href="#pricing" class="cursor-pointer">
                        <button class="flex items-center justify-center gap-2 bg-background-secondary border border-neutral/30 text-base font-medium py-3.5 px-8 rounded-lg hover:border-neutral/50 transition-all duration-200 cursor-pointer">
                            {{ $heroSecondaryCta }}
                        </button>
                    </a>
                </div>
            </div>
        </section>

    @else
        {{-- Default "split": copy on the left, terminal mockup on the right --}}
        <section class="relative overflow-hidden grid-pattern border-b border-neutral/15">
            {{-- Big lobster-red glow top-right --}}
            <div aria-hidden="true" class="absolute -top-32 -right-24 w-[700px] h-[700px] rounded-full pointer-events-none"
                 style="background: radial-gradient(circle, hsl(var(--c-primary) / 0.18), transparent 60%); filter: blur(60px);"></div>

            <div class="container relative pt-14 md:pt-24 lg:pt-28 pb-14 md:pb-20 lg:pb-24">
                <div class="grid grid-cols-1 lg:grid-cols-[1.1fr_1fr] gap-10 lg:gap-16 items-center">
                    {{-- Copy column --}}
                    <div class="animate-fade-in">
                        <div class="mh-chip mb-6">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse-slow"></span>
                            {{ $heroEyebrow }}
                        </div>

                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-[5.25rem] font-medium leading-[0.98] tracking-tight text-balance">
                            {!! $heroTitle !!}
                        </h1>

                        <p class="mt-6 text-lg sm:text-xl text-muted max-w-xl leading-relaxed">
                            {{ $heroSubtitle }}
                        </p>

                        <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            <a href="#products" class="cursor-pointer">
                                <button class="flex items-center justify-center gap-2 bg-primary text-inverted font-semibold py-3.5 px-7 rounded-lg hover:bg-primary/90 transition-all duration-200 glow-primary-sm hover:glow-primary cursor-pointer">
                                    {{ $heroCtaText }}
                                    <x-ri-arrow-right-line class="size-4" />
                                </button>
                            </a>
                            <a href="#pricing" class="cursor-pointer">
                                <button class="flex items-center justify-center gap-2 bg-background-secondary border border-neutral/30 text-base font-medium py-3.5 px-7 rounded-lg hover:border-neutral/50 transition-all duration-200 cursor-pointer">
                                    {{ $heroSecondaryCta }}
                                </button>
                            </a>
                        </div>

                        <div class="mh-mono mt-7 flex flex-wrap items-center gap-x-7 gap-y-2 text-xs text-muted">
                            <span>↳ {{ __('molthost::messages.hero.chip_uptime') }}</span>
                            <span>↳ {{ __('molthost::messages.hero.chip_egress') }}</span>
                            <span>↳ {{ __('molthost::messages.hero.chip_iso') }}</span>
                        </div>
                    </div>

                    {{-- Terminal mockup --}}
                    <div class="mh-terminal animate-slide-up">
                        {{-- Window chrome --}}
                        <div class="flex items-center gap-2 px-3.5 py-2.5 border-b border-neutral/20 bg-background/60">
                            <span class="w-2.5 h-2.5 rounded-full" style="background: hsl(0 70% 55%)"></span>
                            <span class="w-2.5 h-2.5 rounded-full" style="background: hsl(38 90% 58%)"></span>
                            <span class="w-2.5 h-2.5 rounded-full" style="background: hsl(150 50% 50%)"></span>
                            <span class="mh-mono ml-3 text-[11px] text-muted">~/molt · zsh</span>
                        </div>
                        {{-- Terminal body --}}
                        <pre class="font-mono text-[13px] leading-[1.7] text-muted m-0 px-5 py-5 sm:px-6 sm:py-6 whitespace-pre-wrap"><span class="text-muted">$ </span><span class="text-base">molt new postgres prod-db</span>
  <span class="text-muted">↳ region</span>        <span class="text-base">sa-east-1</span>
  <span class="text-muted">↳ tier</span>          <span class="text-base">shell-8 (8 vCPU, 32GB)</span>
  <span class="text-muted">↳ extensions</span>    <span class="text-primary">pgvector, postgis</span>

<span class="text-success">✓ provisioned</span> in 87s
   <span class="text-muted">↳</span> <span class="text-base">postgres://prod-db.molthost.io:5432</span>

<span class="text-muted">$ </span><span class="text-base">molt llm spawn llama-3.1-70b --gpus=2</span>
  <span class="text-muted">↳ model</span>         <span class="text-base">llama-3.1-70b-instruct</span>
  <span class="text-muted">↳ accelerator</span>   <span class="text-primary">2 × H100 SXM</span>
  <span class="text-muted">↳ throughput</span>    <span class="text-base">~190 tok/s</span>

<span class="text-success">✓ inference endpoint live</span>
   <span class="text-muted">↳</span> <span class="text-base">https://api.molthost.io/v1/chat/completions</span>

<span class="text-muted">$ </span><span class="mh-caret"></span></pre>
                    </div>
                </div>

                {{-- Metrics bar --}}
                @if($metrics->isNotEmpty())
                <div class="mt-16 md:mt-20 grid grid-cols-2 md:grid-cols-4 divide-x divide-neutral/15 border-y border-neutral/15 animate-slide-up">
                    @foreach($metrics as $metric)
                    <div class="px-5 sm:px-8 py-5">
                        <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.06em] mb-2">{{ $metric['label'] }}</div>
                        <div class="text-3xl md:text-4xl font-medium tracking-tight leading-none text-base">{{ $metric['value'] }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>
    @endif

    {{-- ═══ TRUST STRIP ═══════════════════════════════════════ --}}
    <section class="border-b border-neutral/15">
        <div class="container py-7 flex items-center gap-x-8 gap-y-4 flex-wrap justify-between">
            <div class="mh-mono text-[11px] text-muted tracking-[0.10em]">{{ __('molthost::messages.trust.label') }}</div>
            <div class="flex items-center gap-x-7 gap-y-2 flex-wrap text-sm text-muted">
                @foreach($trustLogos as $logo)
                    <span class="font-medium tracking-tight hover:text-base transition-colors cursor-default">{{ $logo }}</span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ PRODUCTS — Paymenter categories with MoltHost flavor ═══ --}}
    <section id="products" class="py-14 md:py-24 lg:py-28 border-b border-neutral/15">
        <div class="container">
            {{-- Section head: two-column --}}
            <div class="grid grid-cols-1 md:grid-cols-[1fr_1.4fr] gap-8 md:gap-20 mb-14 md:mb-16">
                <div>
                    <div class="mh-eyebrow mb-3.5">{{ __('molthost::messages.products.eyebrow') }}</div>
                    <h2 class="text-3xl md:text-5xl font-medium tracking-tight leading-[1.05]">
                        {{ __('molthost::messages.products.title_line1') }} <br class="hidden md:block">{{ __('molthost::messages.products.title_line2') }}
                    </h2>
                </div>
                <div class="text-lg text-muted leading-relaxed max-w-xl mt-1.5">
                    {!! Str::markdown(molthost_or_trans('home_page_text', 'molthost::messages.products.home_text_default'), [
                        'allow_unsafe_links' => false,
                        'renderer' => ['soft_break' => "<br>"]
                    ]) !!}
                </div>
            </div>

            @if (isset($categories) && count($categories) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($categories as $idx => $category)
                @php $popular = $idx === 1; @endphp
                <div class="group relative {{ $popular ? 'pt-3' : '' }}">
                    @if ($popular)
                        <span class="absolute top-0 left-6 z-10 mh-mono text-[10px] font-semibold tracking-[0.10em] px-2.5 py-1 rounded-md bg-primary text-inverted shadow-[0_4px_14px_-2px_hsl(var(--c-primary)/0.45)]">
                            {{ __('molthost::messages.products.popular_badge') }}
                        </span>
                    @endif
                    <div class="flex flex-col bg-background-secondary border {{ $popular ? 'border-primary/40' : 'border-neutral/15' }} rounded-2xl overflow-hidden hover:border-primary/40 transition-all duration-200 h-full">
                    @if ($category->image && !theme('small_images', false))
                    <div class="relative overflow-hidden border-b border-neutral/15">
                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                            class="w-full h-40 object-cover object-center group-hover:scale-[1.03] transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-background-secondary/90 to-transparent"></div>
                    </div>
                    @endif
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mh-mono text-[11px] text-primary tracking-[0.10em] mb-3">
                            {{ str_pad((string)($idx + 1), 2, '0', STR_PAD_LEFT) }} / {{ Str::upper(Str::limit($category->name, 14, '…')) }}
                        </div>
                        <div class="flex items-center gap-3 mb-2">
                            @if ($category->image && theme('small_images', false))
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                class="w-10 h-10 rounded-lg object-cover border border-neutral/15">
                            @endif
                            <h3 class="text-lg font-semibold tracking-tight">{{ $category->name }}</h3>
                        </div>
                        @if(theme('show_category_description', true) && $category->description)
                        <div class="text-muted text-sm leading-relaxed mb-4 line-clamp-3">
                            {!! $category->description !!}
                        </div>
                        @endif
                        <a href="{{ route('category.show', ['category' => $category->slug]) }}" wire:navigate class="mt-auto">
                            <x-button.primary>
                                {{ __('molthost::messages.products.see_plans') }}
                                <x-ri-arrow-right-s-line class="size-4" />
                            </x-button.primary>
                        </a>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    {{-- ═══ SPECS ROW — editorial numbers ════════════════════ --}}
    @if($metrics->isNotEmpty())
    <section class="border-b border-neutral/15 bg-background-secondary/30">
        <div class="container py-14 md:py-20">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-10">
                @foreach($metrics as $i => $metric)
                <div class="px-2 md:px-6 {{ $i > 0 ? 'md:border-l border-neutral/15' : '' }}">
                    <div class="mh-mono text-[11px] text-muted uppercase tracking-[0.06em] mb-3">{{ $metric['label'] }}</div>
                    <div class="text-4xl md:text-5xl font-medium tracking-tight leading-none">{{ $metric['value'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ REGIONS — live world map fed by Server extensions ═══ --}}
    <section id="regions" class="py-16 md:py-28 border-b border-neutral/15">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_minmax(0,1.4fr)] gap-8 md:gap-10 lg:gap-16 items-start">
                <div>
                    <div class="mh-eyebrow mb-3.5">
                        {{ __('molthost::messages.regions.eyebrow', ['count' => str_pad((string) max($regionsCount, 0), 2, '0', STR_PAD_LEFT)]) }}
                    </div>
                    <h2 class="text-3xl md:text-4xl font-medium tracking-tight leading-[1.05] mb-5">
                        {{ __('molthost::messages.regions.title') }}
                    </h2>
                    <p class="text-base md:text-lg text-muted leading-relaxed mb-7 max-w-md">
                        {{ __('molthost::messages.regions.subtitle', ['active' => $activeCount]) }}
                        {{ __('molthost::messages.regions.sa_note') }}
                    </p>
                    @if ($regionsCount > 0)
                    <div class="flex flex-col gap-2.5">
                        @foreach($regions as $idx => $region)
                        @php
                            $isActive = ($region['status'] ?? 'unknown') === 'active';
                            $regionCode = 'edge-' . str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
                            if (!empty($region['countryCode'])) {
                                $regionCode .= ' · ' . Str::lower($region['countryCode']);
                            }
                            $cityLabel = $region['city'] ?? __('molthost::messages.regions.unknown_location');
                        @endphp
                        <div class="grid grid-cols-[auto_1fr_auto] gap-4 items-center px-4 py-3 bg-background-secondary border border-neutral/15 rounded-xl">
                            <span class="w-2 h-2 rounded-full {{ $isActive ? 'bg-success' : 'bg-muted/60' }} {{ $isActive ? 'animate-pulse-slow' : '' }}"></span>
                            <div class="min-w-0">
                                <div class="mh-mono text-[11px] text-muted truncate tracking-wider uppercase">{{ $regionCode }}</div>
                                <div class="text-sm text-base truncate">
                                    {{ $cityLabel }}@if(!empty($region['country'])), {{ $region['country'] }}@endif
                                </div>
                            </div>
                            <span class="mh-mono text-[11px] {{ $isActive ? 'text-success' : 'text-warning' }} uppercase tracking-wider">
                                {{ $isActive ? __('molthost::messages.regions.badge_active') : __('molthost::messages.regions.badge_unknown') }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="flex flex-col gap-2 px-4 py-5 bg-background-secondary border border-neutral/15 rounded-xl">
                        <div class="mh-mono text-[11px] text-muted uppercase tracking-wider">{{ __('molthost::messages.regions.badge_inactive') }}</div>
                        <div class="text-sm text-base">{{ __('molthost::messages.regions.empty_title') }}</div>
                        <div class="text-sm text-muted leading-relaxed">{{ __('molthost::messages.regions.empty_hint') }}</div>
                    </div>
                    @endif
                </div>

                {{-- Live world map (jsvectormap + Alpine) — height responsivo do componente --}}
                <x-world-map :regions="$regions" />
            </div>
        </div>
    </section>

    {{-- ═══ FEATURES ══════════════════════════════════════════ --}}
    @if($features->count() > 0)
    <section id="pricing" class="py-14 md:py-24 lg:py-28 border-b border-neutral/15">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-[1fr_1.4fr] gap-8 md:gap-20 mb-14">
                <div>
                    <div class="mh-eyebrow mb-3.5">{{ __('molthost::messages.features.eyebrow') }}</div>
                    <h2 class="text-3xl md:text-5xl font-medium tracking-tight leading-[1.05]">
                        {{ __('molthost::messages.features.title') }}
                    </h2>
                </div>
                <p class="text-lg text-muted leading-relaxed max-w-xl mt-1.5">
                    {{ __('molthost::messages.features.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($features as $feature)
                <div class="group relative bg-background-secondary/60 border border-neutral/15 rounded-2xl p-6 hover:border-primary/30 transition-all duration-200 overflow-hidden">
                    <div aria-hidden="true" class="absolute -top-12 -right-12 w-32 h-32 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                         style="background: radial-gradient(circle, hsl(var(--c-primary) / 0.10), transparent 60%);"></div>

                    <div class="mh-mono text-[11px] text-primary tracking-[0.10em] mb-4">{{ $feature['tag'] }}</div>
                    <div class="w-11 h-11 bg-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors">
                        <x-dynamic-component :component="$feature['icon']" class="size-5 text-primary" />
                    </div>
                    <h3 class="font-semibold text-lg tracking-tight mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-muted text-sm leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ FINAL CTA ═════════════════════════════════════════ --}}
    <section class="relative overflow-hidden border-b border-neutral/15">
        <div aria-hidden="true" class="absolute inset-0 mh-glow-radial opacity-70"></div>
        <div class="container relative py-16 md:py-24 lg:py-32 text-center flex flex-col items-center">
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-medium tracking-tight leading-[1] text-balance max-w-3xl">
                {{ __('molthost::messages.cta.title') }}
            </h2>
            <p class="mt-5 text-lg text-muted max-w-lg leading-relaxed">
                {{ __('molthost::messages.cta.subtitle') }}
            </p>
            <div class="mt-9 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="#products" class="cursor-pointer">
                    <button class="flex items-center justify-center gap-2 bg-primary text-inverted font-semibold py-3.5 px-8 rounded-lg hover:bg-primary/90 transition-all duration-200 glow-primary-sm hover:glow-primary cursor-pointer">
                        {{ $heroCtaText }}
                        <x-ri-arrow-right-line class="size-4" />
                    </button>
                </a>
                @if(theme('discord_url'))
                <a href="{{ theme('discord_url') }}" target="_blank" rel="noopener noreferrer" class="cursor-pointer">
                    <button class="flex items-center justify-center gap-2 bg-background-secondary border border-neutral/30 text-base font-medium py-3.5 px-8 rounded-lg hover:border-neutral/50 transition-all duration-200 cursor-pointer">
                        <x-ri-discord-fill class="size-4" />
                        {{ __('molthost::messages.cta.discord') }}
                    </button>
                </a>
                @endif
            </div>
        </div>
    </section>

    {!! hook('pages.home') !!}
</div>
