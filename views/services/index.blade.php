{{-- MoltHost — Services / Shells listing --}}
<div class="container mt-10 pb-20 md:pb-12">
    <x-navigation.breadcrumb />

    <div class="mb-6 flex items-end justify-between gap-3 flex-wrap">
        <div>
            <div class="mh-eyebrow mb-2">{{ __('molthost::messages.services_list.eyebrow') }}</div>
            <h1 class="text-3xl md:text-4xl font-medium tracking-tight">{{ __('molthost::messages.services_list.title') }}</h1>
            <p class="text-muted mt-1.5">{{ __('molthost::messages.services_list.subtitle') }}</p>
        </div>
        <span class="mh-chip-neutral">{{ __('molthost::messages.services_list.total', ['n' => $services->total() ?? $services->count()]) }}</span>
    </div>

    <div class="space-y-3">
        @forelse ($services as $service)
            @php
                $statusMap = [
                    'active'    => ['icon' => 'ri-checkbox-circle-fill', 'color' => 'success', 'label' => __('molthost::messages.services_list.status_active')],
                    'pending'   => ['icon' => 'ri-error-warning-fill',   'color' => 'warning', 'label' => __('molthost::messages.services_list.status_pending')],
                    'suspended' => ['icon' => 'ri-forbid-fill',          'color' => 'error',   'label' => __('molthost::messages.services_list.status_suspended')],
                    'cancelled' => ['icon' => 'ri-forbid-fill',          'color' => 'inactive','label' => __('molthost::messages.services_list.status_cancelled')],
                ];
                $s = $statusMap[$service->status] ?? $statusMap['pending'];
            @endphp
            <a href="{{ route('services.show', $service) }}" wire:navigate class="block group">
                <div class="bg-background-secondary border border-neutral/15 hover:border-primary/30 p-5 rounded-2xl transition-all duration-200">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="bg-primary/10 border border-primary/20 p-2.5 rounded-xl shrink-0">
                                <x-ri-instance-line class="size-5 text-primary" />
                            </div>
                            <div class="min-w-0">
                                <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em]">{{ __('molthost::messages.services_list.shell_billing', ['unit' => $service->plan->billing_unit ?? 'monthly']) }}</div>
                                <div class="text-lg font-medium tracking-tight truncate">{{ $service->label }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 flex-wrap">
                            <div class="text-sm text-muted">
                                {{ in_array($service->plan->type, ['recurring']) ? __('services.every_period', [
                                    'period' => $service->plan->billing_period > 1 ? $service->plan->billing_period : '',
                                    'unit' => trans_choice(__('services.billing_cycles.' . $service->plan->billing_unit), $service->plan->billing_period)
                                ]) : '' }}
                                @if($service->expires_at && $service->expires_at > now())
                                    · {{ __('services.renews_in') }}
                                    <x-tooltip :message="$service->expires_at->format('M d, Y')">
                                        <span class="mh-mono">{{ $service->expires_at->longAbsoluteDiffForHumans() }}</span>
                                    </x-tooltip>
                                @endif
                            </div>
                            <span class="mh-mono inline-flex items-center gap-1.5 text-[10px] tracking-[0.08em] px-2 py-1 rounded border bg-{{ $s['color'] }}/10 border-{{ $s['color'] }}/30 text-{{ $s['color'] }} uppercase">
                                <x-dynamic-component :component="$s['icon']" class="size-3" />
                                {{ $s['label'] }}
                            </span>
                            <x-ri-arrow-right-s-line class="size-4 text-muted/60 group-hover:text-primary group-hover:translate-x-0.5 transition-all" />
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-background-secondary border border-neutral/15 p-10 rounded-2xl text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center">
                    <x-ri-instance-line class="size-6 text-primary" />
                </div>
                <p class="text-lg font-medium tracking-tight">{{ __('services.no_services') }}</p>
                <p class="text-muted text-sm mt-1.5">{{ __('molthost::messages.services_list.empty_hint') }}</p>
                <a href="{{ route('home') }}" wire:navigate class="inline-block mt-4">
                    <x-button.primary class="!w-auto inline-flex">{{ __('molthost::messages.services_list.browse_plans') }} <x-ri-arrow-right-line class="size-4" /></x-button.primary>
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $services->links() }}</div>
</div>
