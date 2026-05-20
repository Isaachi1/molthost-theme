{{-- MoltHost — Invoices listing --}}
<div class="container mt-10 pb-20 md:pb-12">
    <x-navigation.breadcrumb />

    <div class="mb-6 flex items-end justify-between gap-3 flex-wrap">
        <div>
            <div class="mh-eyebrow mb-2">{{ __('molthost::messages.invoices_list.eyebrow') }}</div>
            <h1 class="text-3xl md:text-4xl font-medium tracking-tight">{{ __('molthost::messages.invoices_list.title') }}</h1>
            <p class="text-muted mt-1.5">{{ __('molthost::messages.invoices_list.subtitle') }}</p>
        </div>
        <span class="mh-chip-neutral">{{ __('molthost::messages.invoices_list.total', ['n' => $invoices->total() ?? $invoices->count()]) }}</span>
    </div>

    <div class="space-y-3">
        @forelse ($invoices as $invoice)
            @php
                $statusMap = [
                    'paid'      => ['icon' => 'ri-checkbox-circle-fill', 'color' => 'success', 'label' => __('molthost::messages.invoices_list.status_paid')],
                    'pending'   => ['icon' => 'ri-error-warning-fill',   'color' => 'warning', 'label' => __('molthost::messages.invoices_list.status_pending')],
                    'cancelled' => ['icon' => 'ri-forbid-fill',          'color' => 'info',    'label' => __('molthost::messages.invoices_list.status_cancelled')],
                ];
                $s = $statusMap[$invoice->status] ?? $statusMap['pending'];
            @endphp
            <a href="{{ route('invoices.show', $invoice) }}" wire:navigate class="block group">
                <div class="bg-background-secondary border border-neutral/15 hover:border-primary/30 p-5 rounded-2xl transition-all duration-200">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="bg-primary/10 border border-primary/20 p-2.5 rounded-xl shrink-0">
                                <x-ri-bill-line class="size-5 text-primary" />
                            </div>
                            <div class="min-w-0">
                                <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em]">
                                    {{ __('molthost::messages.invoices_list.item_prefix', ['date' => $invoice->created_at->format('d M Y')]) }}
                                </div>
                                <div class="font-medium tracking-tight truncate">
                                    {{ !$invoice->number && config('settings.invoice_proforma', false) ? __('invoices.proforma_invoice', ['id' => $invoice->id]) : __('invoices.invoice', ['id' => $invoice->number]) }}
                                </div>
                                @if ($invoice->items->first())
                                    <div class="text-xs text-muted mt-0.5 truncate max-w-md">{{ $invoice->items->first()->description }}{{ $invoice->items->count() > 1 ? ' ' . __('molthost::messages.invoices_list.more_items', ['n' => $invoice->items->count() - 1]) : '' }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="mh-mono text-lg font-medium tracking-tight">{{ $invoice->formattedTotal }}</span>
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
                    <x-ri-bill-line class="size-6 text-primary" />
                </div>
                <p class="text-lg font-medium tracking-tight">{{ __('invoices.no_invoices') }}</p>
                <p class="text-muted text-sm mt-1.5">{{ __('molthost::messages.invoices_list.empty_hint') }}</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $invoices->links() }}</div>
</div>
