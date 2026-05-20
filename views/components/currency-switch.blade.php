@php
    $currencyFlags = [
        'USD' => "\u{1F1FA}\u{1F1F8}", 'EUR' => "\u{1F1EA}\u{1F1FA}", 'GBP' => "\u{1F1EC}\u{1F1E7}",
        'BRL' => "\u{1F1E7}\u{1F1F7}", 'JPY' => "\u{1F1EF}\u{1F1F5}", 'CNY' => "\u{1F1E8}\u{1F1F3}",
        'KRW' => "\u{1F1F0}\u{1F1F7}", 'INR' => "\u{1F1EE}\u{1F1F3}", 'RUB' => "\u{1F1F7}\u{1F1FA}",
        'AUD' => "\u{1F1E6}\u{1F1FA}", 'CAD' => "\u{1F1E8}\u{1F1E6}", 'CHF' => "\u{1F1E8}\u{1F1ED}",
        'MXN' => "\u{1F1F2}\u{1F1FD}", 'ARS' => "\u{1F1E6}\u{1F1F7}", 'CLP' => "\u{1F1E8}\u{1F1F1}",
        'COP' => "\u{1F1E8}\u{1F1F4}", 'PEN' => "\u{1F1F5}\u{1F1EA}", 'UYU' => "\u{1F1FA}\u{1F1FE}",
        'TRY' => "\u{1F1F9}\u{1F1F7}", 'PLN' => "\u{1F1F5}\u{1F1F1}", 'SEK' => "\u{1F1F8}\u{1F1EA}",
        'NOK' => "\u{1F1F3}\u{1F1F4}", 'DKK' => "\u{1F1E9}\u{1F1F0}", 'CZK' => "\u{1F1E8}\u{1F1FF}",
        'HUF' => "\u{1F1ED}\u{1F1FA}", 'RON' => "\u{1F1F7}\u{1F1F4}", 'BGN' => "\u{1F1E7}\u{1F1EC}",
        'HRK' => "\u{1F1ED}\u{1F1F7}", 'ZAR' => "\u{1F1FF}\u{1F1E6}", 'NZD' => "\u{1F1F3}\u{1F1FF}",
        'SGD' => "\u{1F1F8}\u{1F1EC}", 'HKD' => "\u{1F1ED}\u{1F1F0}", 'TWD' => "\u{1F1F9}\u{1F1FC}",
        'THB' => "\u{1F1F9}\u{1F1ED}", 'IDR' => "\u{1F1EE}\u{1F1E9}", 'MYR' => "\u{1F1F2}\u{1F1FE}",
        'PHP' => "\u{1F1F5}\u{1F1ED}", 'VND' => "\u{1F1FB}\u{1F1F3}", 'ILS' => "\u{1F1EE}\u{1F1F1}",
        'SAR' => "\u{1F1F8}\u{1F1E6}", 'AED' => "\u{1F1E6}\u{1F1EA}", 'EGP' => "\u{1F1EA}\u{1F1EC}",
        'NGN' => "\u{1F1F3}\u{1F1EC}", 'KES' => "\u{1F1F0}\u{1F1EA}", 'UAH' => "\u{1F1FA}\u{1F1E6}",
    ];
    $currencyOptions = collect($this->currencies)->map(fn($c) => [
        'value' => $c['value'],
        'label' => ($currencyFlags[$c['value']] ?? "\u{1F4B1}") . '  ' . $c['label'],
    ])->values()->toArray();
@endphp
@if(count($currencyOptions) > 1)
<div class="w-auto min-w-[140px]">
    <x-select wire:model.live="currentCurrency" :options="$currencyOptions" placeholder="Select currency" />
</div>
@endif