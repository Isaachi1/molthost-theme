<div x-data="{ open: false }">
    <div x-anchor.offset.3="$refs.trigger" x-show="open"
        class="absolute top-0 left-0 text-base text-sm w-max p-1.5 px-2.5 rounded-lg bg-background-secondary shadow-lg z-10 border border-neutral/20"
        aria-describedby="tooltip">
        {{ $message }}
    </div>
    <div aria-describedby="tooltip" class="underline decoration-dotted decoration-base/30" x-ref="trigger" @mouseover="open = true"
        @mouseout="open = false">
        {{ $slot }}
    </div>
</div>
