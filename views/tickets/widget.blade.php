{{-- MoltHost — Tickets widget (compact for dashboard) --}}
<div class="space-y-2.5">
    @forelse ($tickets as $ticket)
        @php
            $statusMap = [
                'open'    => ['color' => 'success', 'label' => 'OPEN'],
                'replied' => ['color' => 'info',    'label' => 'REPLIED'],
                'closed'  => ['color' => 'inactive','label' => 'CLOSED'],
            ];
            $s = $statusMap[$ticket->status] ?? $statusMap['open'];
            $last = $ticket->messages()->orderBy('created_at', 'desc')->first();
        @endphp
        <a href="{{ route('tickets.show', $ticket) }}" wire:navigate class="block group">
            <div class="bg-background border border-neutral/15 hover:border-primary/30 p-3.5 rounded-xl transition-all duration-200">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="bg-primary/10 border border-primary/20 p-1.5 rounded-lg shrink-0">
                            <x-ri-ticket-line class="size-4 text-primary" />
                        </div>
                        <div class="min-w-0">
                            <div class="font-medium tracking-tight truncate text-sm">
                                <span class="mh-mono text-muted text-[11px]">#{{ $ticket->id }}</span> {{ $ticket->subject }}
                            </div>
                            <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.06em]">
                                ↳ {{ $last?->created_at->diffForHumans() ?? 'No activity yet' }}
                            </div>
                        </div>
                    </div>
                    <span class="mh-mono text-[10px] text-{{ $s['color'] }} shrink-0">●</span>
                </div>
            </div>
        </a>
    @empty
        <p class="text-sm text-muted">{{ __('ticket.no_tickets') }}</p>
    @endforelse
</div>
