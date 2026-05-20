{{-- MoltHost — Primary CTA (lobster red + dark text + glow on hover) --}}
<button
    {{ $attributes->merge(['class' => 'flex items-center gap-2 justify-center bg-primary text-inverted text-sm font-semibold hover:bg-primary/90 py-2.5 px-5 rounded-lg w-full duration-200 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50 transition-all glow-primary-sm hover:glow-primary']) }}>
    @if (isset($type) && $type === 'submit')
        <div role="status" wire:loading>
            <x-ri-loader-5-fill aria-hidden="true" class="size-5 me-2 fill-current animate-spin" />
            <span class="sr-only">Loading...</span>
        </div>
        <div wire:loading.remove>
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</button>
