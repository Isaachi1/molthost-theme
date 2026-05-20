{{-- MoltHost — Invoices widget (compact for dashboard) --}}
<div class="space-y-2.5">
    @forelse ($invoices as $invoice)
        @php
            $statusMap = [
                'paid'      => ['color' => 'success', 'label' => 'PAID'],
                'pending'   => ['color' => 'warning', 'label' => 'PENDING'],
                'cancelled' => ['color' => 'info',    'label' => 'CANCELLED'],
            ];
            $s = $statusMap[$invoice->status] ?? $statusMap['pending'];
        @endphp
        <a href="{{ route('invoices.show', $invoice) }}" wire:navigate class="block group">
            <div class="bg-background border border-neutral/15 hover:border-primary/30 p-3.5 rounded-xl transition-all duration-200">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="bg-primary/10 border border-primary/20 p-1.5 rounded-lg shrink-0">
                            <x-ri-bill-line class="size-4 text-primary" />
                        </div>
                        <div class="min-w-0">
                            <div class="font-medium tracking-tight truncate text-sm">
                                {{ !$invoice->number && config('settings.invoice_proforma', false) ? __('invoices.proforma_invoice', ['id' => $invoice->id]) : __('invoices.invoice', ['id' => $invoice->number]) }}
                            </div>
                            <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.06em]">
                                {{ $invoice->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="mh-mono text-sm font-medium">{{ $invoice->formattedTotal }}</span>
                        <span class="mh-mono text-[10px] text-{{ $s['color'] }}">●</span>
                    </div>
                </div>
            </div>
        </a>
    @empty
        <p class="text-sm text-muted">{{ __('invoices.no_invoices') }}</p>
    @endforelse
</div>
