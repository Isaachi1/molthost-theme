{{-- MoltHost — Tickets listing --}}
<div class="container mt-10 pb-20 md:pb-12">
    <x-navigation.breadcrumb />

    <div class="mb-6 flex items-end justify-between gap-3 flex-wrap">
        <div>
            <div class="mh-eyebrow mb-2">{{ __('molthost::messages.tickets_list.eyebrow') }}</div>
            <h1 class="text-3xl md:text-4xl font-medium tracking-tight">{{ __('molthost::messages.tickets_list.title') }}</h1>
            <p class="text-muted mt-1.5">{{ __('molthost::messages.tickets_list.subtitle') }}</p>
        </div>
        <a href="{{ route('tickets.create') }}" wire:navigate>
            <x-button.primary class="!w-auto inline-flex">
                <x-ri-add-line class="size-4" /> {{ __('ticket.create_ticket') }}
            </x-button.primary>
        </a>
    </div>

    <div class="space-y-3">
        @forelse ($tickets as $ticket)
            @php
                $statusMap = [
                    'open'    => ['icon' => 'ri-add-circle-fill',  'color' => 'success', 'label' => __('molthost::messages.tickets_list.status_open')],
                    'replied' => ['icon' => 'ri-chat-smile-2-fill','color' => 'info',    'label' => __('molthost::messages.tickets_list.status_replied')],
                    'closed'  => ['icon' => 'ri-forbid-fill',      'color' => 'inactive','label' => __('molthost::messages.tickets_list.status_closed')],
                ];
                $s = $statusMap[$ticket->status] ?? $statusMap['open'];
                $lastActivity = $ticket->messages()->orderBy('created_at', 'desc')->first();
            @endphp
            <a href="{{ route('tickets.show', $ticket) }}" wire:navigate class="block group">
                <div class="bg-background-secondary border border-neutral/15 hover:border-primary/30 p-5 rounded-2xl transition-all duration-200">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="bg-primary/10 border border-primary/20 p-2.5 rounded-xl shrink-0">
                                <x-ri-ticket-line class="size-5 text-primary" />
                            </div>
                            <div class="min-w-0">
                                <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em]">#{{ $ticket->id }}{{ $ticket->department ? ' · ' . $ticket->department : '' }}</div>
                                <div class="font-medium tracking-tight truncate max-w-md">{{ $ticket->subject }}</div>
                                @if ($lastActivity)
                                    <div class="mh-mono text-xs text-muted mt-0.5">↳ {{ __('ticket.last_activity') }} {{ $lastActivity->created_at->diffForHumans() }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
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
                    <x-ri-customer-service-2-fill class="size-6 text-primary" />
                </div>
                <p class="text-lg font-medium tracking-tight">{{ __('ticket.no_tickets') }}</p>
                <p class="text-muted text-sm mt-1.5">{{ __('molthost::messages.tickets_list.empty_hint') }}</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $tickets->links() }}</div>
</div>
