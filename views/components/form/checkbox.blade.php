<div class="flex items-center {{ $divClass ?? '' }}">
    <input type="checkbox" name="{{ $name }}" id="{{ $id ?? $name }}"
        {{ $attributes->except(['label', 'name', 'id', 'class', 'divClass', 'required']) }}
        class="form-checkbox size-4 text-primary rounded focus:ring-primary/30 hover:bg-primary/20 ring-offset-background focus:ring-2 bg-background border-neutral/30" />
    <label class="ml-2 text-sm text-base/70" for="{{ $id ?? $name }}">
        @if(isset($label))
            {{ $label }}
        @else
            {{ $slot }}
        @endif
    </label>
    @error($name)
        <p class="text-red-500 text-xs ml-2">{{ $message }}</p>
    @enderror
</div>
