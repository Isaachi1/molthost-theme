@props(['href', 'spa' => true])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex flex-row items-center p-3 gap-2 text-sm font-semibold text-wrap rounded-lg transition-colors ' . ($href === request()->url() ? 'text-primary' : 'text-base/70 hover:text-base')]) }} @if($spa) wire:navigate @endif>
    {{ $slot }}
</a>
