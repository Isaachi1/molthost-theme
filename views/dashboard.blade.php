{{-- MoltHost — Console / Dashboard --}}
<div class="container mt-10 pb-20 md:pb-12">
    <x-navigation.breadcrumb />

    {{-- Welcome strip --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 mt-4 mb-8">
        <div>
            <div class="mh-eyebrow mb-2">{{ __('molthost::messages.dashboard.eyebrow') }}</div>
            <h1 class="text-3xl md:text-4xl font-medium tracking-tight">
                <span class="text-muted">$</span> {{ __('molthost::messages.dashboard.molt_status_prefix') }}
                <span class="text-base/50 mh-mono text-base">--user={{ Str::slug(Auth::user()->first_name ?? Auth::user()->name) }}</span>
            </h1>
        </div>
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-success/10 border border-success/20 text-success text-xs font-medium self-start md:self-auto">
            <span class="w-1.5 h-1.5 rounded-full bg-success animate-pulse-slow"></span>
            {{ __('molthost::messages.dashboard.systems_operational') }}
        </div>
    </div>

    {{-- Stats overview — KPI cards --}}
    @php
        $activeServices = Auth::user()->services()->where('status', 'active')->count();
        $unpaidInvoices = Auth::user()->invoices()->where('status', 'pending')->count();
        $openTickets = Auth::user()->tickets()->where('status', '!=', 'closed')->count();
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-8">
        <div class="bg-background-secondary border border-neutral/15 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em]">{{ __('dashboard.active_services') }}</span>
                <x-ri-server-fill class="size-4 text-primary" />
            </div>
            <div class="text-4xl font-medium tracking-tight">{{ $activeServices }}</div>
            <div class="mh-mono text-[11px] text-muted mt-1">↳ {{ __('molthost::messages.dashboard.shells_running') }}</div>
        </div>
        <div class="bg-background-secondary border border-neutral/15 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em]">{{ __('dashboard.unpaid_invoices') }}</span>
                <x-ri-receipt-fill class="size-4 text-warning" />
            </div>
            <div class="text-4xl font-medium tracking-tight {{ $unpaidInvoices > 0 ? 'text-warning' : '' }}">{{ $unpaidInvoices }}</div>
            <div class="mh-mono text-[11px] text-muted mt-1">↳ {{ __('molthost::messages.dashboard.awaiting_payment') }}</div>
        </div>
        @if(!config('settings.tickets_disabled', false))
        <div class="bg-background-secondary border border-neutral/15 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em]">{{ __('dashboard.open_tickets') }}</span>
                <x-ri-customer-service-fill class="size-4 text-info" />
            </div>
            <div class="text-4xl font-medium tracking-tight">{{ $openTickets }}</div>
            <div class="mh-mono text-[11px] text-muted mt-1">↳ {{ __('molthost::messages.dashboard.in_conversation') }}</div>
        </div>
        @endif
        @php
            $primaryRegion = collect(molthost_get_server_regions())
                ->firstWhere('status', 'active');
        @endphp
        <div class="bg-background-secondary border border-neutral/15 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em]">{{ __('molthost::messages.dashboard.region_label') }}</span>
                <x-ri-global-fill class="size-4 {{ $primaryRegion ? 'text-success' : 'text-muted' }}" />
            </div>
            @if($primaryRegion)
                <div class="text-xl font-medium tracking-tight">{{ Str::lower($primaryRegion['extension'] ?? 'server') }}{{ !empty($primaryRegion['countryCode']) ? ' · ' . Str::lower($primaryRegion['countryCode']) : '' }}</div>
                <div class="mh-mono text-[11px] text-success mt-1">● {{ $primaryRegion['city'] ?? '—' }}@if(!empty($primaryRegion['country'])), {{ $primaryRegion['country'] }}@endif</div>
            @else
                <div class="text-xl font-medium tracking-tight">—</div>
                <div class="mh-mono text-[11px] text-muted mt-1">{{ __('molthost::messages.regions.empty_title') }}</div>
            @endif
        </div>
    </div>

    {{-- Main grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">
        <div class="flex flex-col gap-5">
            {{-- Active Services --}}
            <div class="bg-background-secondary border border-neutral/15 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em]">{{ __('molthost::messages.dashboard.services_path') }}</div>
                        <h2 class="text-lg font-medium tracking-tight mt-0.5">{{ __('dashboard.active_services') }}</h2>
                    </div>
                    <a href="{{ route('services') }}" wire:navigate class="mh-mono text-[11px] text-primary font-medium hover:underline">
                        {{ __('dashboard.view_all') }} →
                    </a>
                </div>
                <div class="space-y-2">
                    <livewire:services.widget status="active" />
                </div>
            </div>

            {{-- Open Tickets --}}
            @if(!config('settings.tickets_disabled', false))
            <div class="bg-background-secondary border border-neutral/15 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em]">{{ __('molthost::messages.dashboard.tickets_path') }}</div>
                        <h2 class="text-lg font-medium tracking-tight mt-0.5">{{ __('dashboard.open_tickets') }}</h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('tickets.create') }}" wire:navigate class="w-7 h-7 rounded-lg flex items-center justify-center bg-primary/10 border border-primary/20 text-primary hover:bg-primary/20 transition-colors">
                            <x-ri-add-fill class="size-4" />
                        </a>
                        <a href="{{ route('tickets') }}" wire:navigate class="mh-mono text-[11px] text-primary font-medium hover:underline">
                            {{ __('dashboard.view_all') }} →
                        </a>
                    </div>
                </div>
                <div class="space-y-2">
                    <livewire:tickets.widget />
                </div>
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-5">
            {{-- Unpaid Invoices --}}
            <div class="bg-background-secondary border border-neutral/15 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em]">{{ __('molthost::messages.dashboard.invoices_path') }}</div>
                        <h2 class="text-lg font-medium tracking-tight mt-0.5">{{ __('dashboard.unpaid_invoices') }}</h2>
                    </div>
                    <a href="{{ route('invoices') }}" wire:navigate class="mh-mono text-[11px] text-primary font-medium hover:underline">
                        {{ __('dashboard.view_all') }} →
                    </a>
                </div>
                <div class="space-y-2">
                    <livewire:invoices.widget :limit="3" />
                </div>
            </div>
            {!! hook('pages.dashboard') !!}
        </div>
    </div>
</div>
