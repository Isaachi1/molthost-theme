@php
    $localeFlags = [
        'en' => "\u{1F1FA}\u{1F1F8}", 'pt' => "\u{1F1E7}\u{1F1F7}", 'es' => "\u{1F1EA}\u{1F1F8}",
        'fr' => "\u{1F1EB}\u{1F1F7}", 'de' => "\u{1F1E9}\u{1F1EA}", 'it' => "\u{1F1EE}\u{1F1F9}",
        'nl' => "\u{1F1F3}\u{1F1F1}", 'ru' => "\u{1F1F7}\u{1F1FA}", 'ja' => "\u{1F1EF}\u{1F1F5}",
        'zh' => "\u{1F1E8}\u{1F1F3}", 'ko' => "\u{1F1F0}\u{1F1F7}", 'ar' => "\u{1F1F8}\u{1F1E6}",
        'tr' => "\u{1F1F9}\u{1F1F7}", 'pl' => "\u{1F1F5}\u{1F1F1}", 'sv' => "\u{1F1F8}\u{1F1EA}",
        'da' => "\u{1F1E9}\u{1F1F0}", 'fi' => "\u{1F1EB}\u{1F1EE}", 'no' => "\u{1F1F3}\u{1F1F4}",
        'cs' => "\u{1F1E8}\u{1F1FF}", 'hu' => "\u{1F1ED}\u{1F1FA}", 'ro' => "\u{1F1F7}\u{1F1F4}",
        'uk' => "\u{1F1FA}\u{1F1E6}", 'el' => "\u{1F1EC}\u{1F1F7}", 'th' => "\u{1F1F9}\u{1F1ED}",
        'vi' => "\u{1F1FB}\u{1F1F3}", 'id' => "\u{1F1EE}\u{1F1E9}", 'ms' => "\u{1F1F2}\u{1F1FE}",
        'hi' => "\u{1F1EE}\u{1F1F3}", 'bn' => "\u{1F1E7}\u{1F1E9}", 'he' => "\u{1F1EE}\u{1F1F1}",
        'bg' => "\u{1F1E7}\u{1F1EC}", 'hr' => "\u{1F1ED}\u{1F1F7}", 'sk' => "\u{1F1F8}\u{1F1F0}",
        'sl' => "\u{1F1F8}\u{1F1EE}", 'lt' => "\u{1F1F1}\u{1F1F9}", 'lv' => "\u{1F1F1}\u{1F1FB}",
        'et' => "\u{1F1EA}\u{1F1EA}", 'pt_BR' => "\u{1F1E7}\u{1F1F7}", 'zh_TW' => "\u{1F1F9}\u{1F1FC}",
        'en_GB' => "\u{1F1EC}\u{1F1E7}",
    ];

    // Criamos a lista formatada aqui para o Blade não se perder
    $formattedOptions = collect($locales)->map(function($locale, $code) use ($localeFlags) {
        $flag = $localeFlags[$code] ?? "\u{1F3F3}\u{FE0F}";
        return [
            'value' => $code,
            'label' => $flag . '  ' . $locale
        ];
    })->values()->toArray();
@endphp

@if(count($locales) > 1)
<div class="w-auto min-w-[140px]">
    <x-select
        wire:model.live="currentLocale"
        :options="$formattedOptions"
        placeholder="Select language"
    />
</div>
@endif
