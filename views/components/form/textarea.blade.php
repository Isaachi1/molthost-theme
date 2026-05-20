@props(['name', 'label' => null, 'required' => false, 'divClass' => null, 'class' => null, 'placeholder' => null, 'id' => null, 'type' => null, 'hideRequiredIndicator' => false, 'dirty' => false])
<fieldset class="flex flex-col w-full {{ $divClass ?? '' }}">
    @if ($label)
    <label for="{{ $name }}" class="mb-1.5 text-sm font-medium text-base/70">
        {{ $label }}
        @if ($required && !$hideRequiredIndicator)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @endif
    <textarea id="{{ $id ?? $name }}" name="{{ $name }}"
        class="block w-full text-sm text-base bg-background border border-neutral/30 rounded-xl outline-none focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300 ease-in-out disabled:bg-background-secondary/50 disabled:cursor-not-allowed {{ $class ?? '' }} px-3.5 py-2.5"
        placeholder="{{ $placeholder ?? ($label ?? '') }}" @if ($dirty && isset($attributes['wire:model']))
        wire:dirty.class="!border-yellow-600" @endif {{ $attributes->except(['placeholder', 'label', 'id', 'name', 'type', 'class', 'divClass', 'required', 'hideRequiredIndicator', 'dirty']) }}
        @required($required)>{{ $slot }}</textarea>
    @error($name)
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</fieldset>
