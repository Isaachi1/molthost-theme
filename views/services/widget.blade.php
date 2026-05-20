{{-- MoltHost — Services widget (compact card list for dashboard) --}}
<div class="space-y-2.5">
    @forelse ($services as $service)
        @php
            $statusMap = [
                'active'    => ['icon' => 'ri-checkbox-circle-fill', 'color' => 'success', 'label' => 'ACTIVE'],
                'pending'   => ['icon' => 'ri-error-warning-fill',   'color' => 'warning', 'label' => 'PENDING'],
                'suspended' => ['icon' => 'ri-forbid-fill',          'color' => 'error',   'label' => 'SUSPENDED'],
                'cancelled' => ['icon' => 'ri-forbid-fill',          'color' => 'inactive','label' => 'CANCELLED'],
            ];
            $s = $statusMap[$service->status] ?? $statusMap['pending'];
        @endphp
        <a href="{{ route('services.show', $service) }}" wire:navigate class="block group">
            <div class="bg-background border border-neutral/15 hover:border-primary/30 p-3.5 rounded-xl transition-all duration-200">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="bg-primary/10 border border-primary/20 p-1.5 rounded-lg shrink-0">
                            <x-ri-instance-line class="size-4 text-primary" />
                        </div>
                        <div class="min-w-0">
                            <div class="font-medium tracking-tight truncate text-sm">{{ $service->product->name }}</div>
                            <div class="mh-mono text-[10px] text-muted truncate uppercase tracking-[0.06em]">
                                {{ $service->product->category->name }}{{ in_array($service->plan->type, ['recurring']) ? ' · ' . __('services.every_period', [
                                    'period' => $service->plan->billing_period > 1 ? $service->plan->billing_period : '',
                                    'unit' => trans_choice(__('services.billing_cycles.' . $service->plan->billing_unit), $service->plan->billing_period)
                                ]) : '' }}
                            </div>
                        </div>
                    </div>
                    <span class="mh-mono inline-flex items-center gap-1 text-[10px] tracking-[0.06em] px-1.5 py-0.5 rounded text-{{ $s['color'] }} uppercase shrink-0">
                        ●
                    </span>
                </div>
            </div>
        </a>
    @empty
        <p class="text-sm text-muted">{{ __('services.no_services') }}</p>
    @endforelse
</div>
