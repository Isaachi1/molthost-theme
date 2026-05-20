@php
    /**
     * MoltHost wordmark fallback — 13×11 pixel-art lobster mascot built from
     * a CSS grid of colored squares. Cells: a=mid, b=bright, d=deep,
     * k=eye, e=empty.
     */
    $lightLogo = config('settings.logo');
    $darkLogo = config('settings.logo_dark');

    $grid = [
        'e e e a e e e e e a e e e',
        'e a a a a e e e a a a a e',
        'a d a d a e e e a d a d a',
        'e a a a e e e e e a a a e',
        'e e e e e a a a e e e e e',
        'e e e a a b b b a a e e e',
        'e e e a b b k b b a e e e',
        'e e e a b b b b b a e e e',
        'e e e e a a a a a e e e e',
        'e e e a e a a a e a e e e',
        'e e a e e e a e e e a e e',
    ];
@endphp

@if ($lightLogo && $darkLogo)
    <img src="{{ Storage::url($lightLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto inline-block dark:hidden']) }}>
    <img src="{{ Storage::url($darkLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto hidden dark:inline-block']) }}>
@elseif ($lightLogo)
    <img src="{{ Storage::url($lightLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto inline-block']) }}>
@elseif ($darkLogo)
    <img src="{{ Storage::url($darkLogo) }}" alt="{{ config('app.name') }}" {{ $attributes->merge(['class' => 'w-auto inline-block']) }}>
@else
    {{-- Pixel-art lobster mascot (default MoltHost mark) --}}
    <span
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center align-middle']) }}
        aria-label="{{ config('app.name', 'MoltHost') }}"
    >
        <span class="mh-lobster-pixel" style="--px: 3px;">
            @foreach ($grid as $row)
                @foreach (explode(' ', $row) as $cell)
                    <i class="{{ $cell }}"></i>
                @endforeach
            @endforeach
        </span>
    </span>
@endif
