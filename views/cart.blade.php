{{-- MoltHost — Cart --}}
<div class="container mt-12 pb-20 md:pb-12">
    <div class="mb-8">
        <div class="mh-eyebrow mb-2">{{ __('molthost::messages.cart.eyebrow') }}</div>
        <h1 class="text-3xl md:text-4xl font-medium tracking-tight">{{ __('molthost::messages.cart.title') }}</h1>
        <p class="text-muted mt-2">{{ __('molthost::messages.cart.subtitle') }}</p>
    </div>

    <div class="flex flex-col md:grid md:grid-cols-4 gap-6">
        <div class="flex flex-col col-span-3 gap-3">
            @if (Cart::items()->count() === 0)
                <div class="text-center py-20 bg-background-secondary border border-neutral/15 rounded-2xl">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center">
                        <x-ri-shopping-bag-4-line class="size-7 text-primary" />
                    </div>
                    <h2 class="text-2xl font-medium tracking-tight">{{ __('product.empty_cart') }}</h2>
                    <p class="text-muted mt-2 mb-6">{{ __('molthost::messages.cart.empty_subtitle') }}</p>
                    <a href="{{ route('home') }}" wire:navigate>
                        <x-button.primary class="!w-auto inline-flex">
                            {{ __('molthost::messages.cart.browse_plans') }} <x-ri-arrow-right-line class="size-4" />
                        </x-button.primary>
                    </a>
                </div>
            @endif

            @foreach (Cart::items() as $item)
            <div class="flex flex-col sm:flex-row justify-between w-full bg-background-secondary border border-neutral/15 hover:border-neutral/30 p-5 rounded-2xl gap-4 transition-colors">
                <div class="flex flex-col gap-1.5 min-w-0">
                    <div class="mh-mono text-[11px] text-primary tracking-[0.10em] uppercase">{{ __('molthost::messages.cart.shell_item') }}</div>
                    <h2 class="text-xl font-semibold tracking-tight truncate">{{ $item->product->name }}</h2>
                    <div class="text-sm text-muted">
                        @foreach ($item->config_options as $option)
                            <div class="mh-mono text-xs"><span class="text-muted/70">↳</span> {{ $option['option_name'] }}: <span class="text-base">{{ $option['value_name'] }}</span></div>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col justify-between items-end gap-4 shrink-0">
                    <div class="text-right">
                        <div class="text-2xl font-medium tracking-tight text-primary">
                            {{ $item->price->format($item->price->total * $item->quantity) }}
                        </div>
                        @if ($item->quantity > 1)
                            <div class="text-xs text-muted mh-mono">{{ $item->price }} × {{ $item->quantity }}</div>
                        @endif
                    </div>
                    <div class="flex flex-row gap-2 items-stretch">
                        @if ($item->product->allow_quantity == 'combined')
                        <div class="flex flex-row gap-1 items-center mr-2">
                            <x-button.secondary wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="h-full !w-fit">-</x-button.secondary>
                            <x-form.input class="h-10 text-center" disabled divClass="!mt-0 !w-14" value="{{ $item->quantity }}" name="quantity" />
                            <x-button.secondary wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }});" class="h-full !w-fit">+</x-button.secondary>
                        </div>
                        @endif
                        <a href="{{ route('products.checkout', [$item->product->category, $item->product, 'edit' => $item->id]) }}" wire:navigate>
                            <x-button.primary class="h-fit !w-fit">{{ __('product.edit') }}</x-button.primary>
                        </a>
                        <x-button.danger wire:click="removeProduct({{ $item->id }})" class="h-fit !w-fit">
                            <x-loading target="removeProduct({{ $item->id }})" />
                            <div wire:loading.remove wire:target="removeProduct({{ $item->id }})">{{ __('product.remove') }}</div>
                        </x-button.danger>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex flex-col gap-4">
            @if (Cart::items()->count() > 0)
            <div class="flex flex-col gap-3 w-full bg-background-secondary border border-neutral/20 p-5 rounded-2xl sticky top-20 shadow-[0_30px_80px_-30px_hsl(0_0%_0%_/_0.35)]">
                <div class="mh-mono text-[10px] uppercase tracking-[0.10em] text-muted">{{ __('molthost::messages.cart.order_summary_eyebrow') }}</div>
                <h2 class="text-xl font-medium tracking-tight mb-2">{{ __('product.order_summary') }}</h2>

                <div class="flex items-end gap-2">
                    @if(!$coupon)
                    <x-form.input wire:model="coupon" name="coupon" label="Coupon" />
                    <x-button.primary wire:click="applyCoupon" class="h-fit !w-fit mb-0.5" wire:loading.attr="disabled">
                        <x-loading target="applyCoupon" />
                        <div wire:loading.remove wire:target="applyCoupon">{{ __('product.apply') }}</div>
                    </x-button.primary>
                    @else
                    <div class="flex justify-between items-center w-full bg-primary/10 border border-primary/20 rounded-lg px-3 py-2">
                        <div>
                            <div class="mh-mono text-[10px] uppercase tracking-[0.10em] text-muted">coupon</div>
                            <div class="text-primary font-semibold">{{ $coupon->code }}</div>
                        </div>
                        <x-button.secondary wire:click="removeCoupon" class="h-fit !w-fit">{{ __('product.remove') }}</x-button.secondary>
                    </div>
                    @endif
                </div>

                <div class="flex justify-between text-sm text-muted mt-2">
                    <span>{{ __('invoices.subtotal') }}</span>
                    <span class="mh-mono text-base">{{ $total->format($total->subtotal) }}</span>
                </div>
                @if ($total->tax > 0)
                <div class="flex justify-between text-sm text-muted">
                    <span>{{ \App\Classes\Settings::tax()->name }} ({{ \App\Classes\Settings::tax()->rate }}%)</span>
                    <span class="mh-mono text-base">{{ $total->format($total->tax) }}</span>
                </div>
                @endif
                <div class="flex justify-between border-t border-neutral/20 pt-3 mt-1">
                    <span class="font-medium">{{ __('invoices.total') }}</span>
                    <span class="text-2xl font-medium tracking-tight text-primary">{{ $total->format($total->total) }}</span>
                </div>

                <div class="flex flex-col gap-3 mt-3">
                    @if(config('settings.tos'))
                    <x-form.checkbox wire:model="tos" name="tos">
                        {{ __('product.tos') }}
                        <a href="{{ config('settings.tos') }}" target="_blank" class="text-primary hover:text-primary/80">{{ __('product.tos_link') }}</a>
                    </x-form.checkbox>
                    @endif
                    <x-button.primary wire:click="checkout" class="h-fit" wire:loading.attr="disabled">
                        <x-loading target="checkout" />
                        <div wire:loading.remove wire:target="checkout">{{ __('product.checkout') }} →</div>
                    </x-button.primary>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
