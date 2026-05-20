{{-- MoltHost — Configure & Checkout (Paymenter configure step) --}}
<div class="container mt-8 md:mt-10 pb-24 md:pb-12">
    {{-- Top bar: back button + breadcrumb --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('products.show', ['category' => $product->category, 'product' => $product->slug]) }}" wire:navigate
           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-background-secondary border border-neutral/15 text-sm text-muted hover:text-base hover:border-neutral/30 transition-colors min-h-[40px]">
            <x-ri-arrow-left-line class="size-4" />
            <span class="hidden sm:inline">{{ __('molthost::messages.common.back') }}</span>
        </a>
        <nav class="flex-1 min-w-0 flex items-center mh-mono text-xs text-muted overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-primary transition-colors uppercase tracking-[0.08em]">~</a>
            <span class="mx-2 text-muted/50">/</span>
            <a href="{{ route('category.show', ['category' => $product->category->slug]) }}" wire:navigate
               class="hover:text-primary transition-colors uppercase tracking-[0.08em] truncate max-w-[28vw]">{{ $product->category->name }}</a>
            <span class="mx-2 text-muted/50">/</span>
            <a href="{{ route('products.show', ['category' => $product->category, 'product' => $product->slug]) }}" wire:navigate
               class="hover:text-primary transition-colors uppercase tracking-[0.08em] truncate max-w-[28vw]">{{ $product->name }}</a>
            <span class="mx-2 text-muted/50">/</span>
            <span class="text-base uppercase tracking-[0.08em] truncate">{{ __('molthost::messages.checkout.step_configure') }}</span>
        </nav>
    </div>

    {{-- Stepper (visible from sm, compact on mobile inside breadcrumb above) --}}
    <ol class="mt-2 mb-8 hidden sm:flex items-center gap-3 mh-mono text-[11px] tracking-[0.08em] text-muted">
        <li class="flex items-center gap-2 text-base"><span class="w-5 h-5 rounded-full bg-primary text-inverted flex items-center justify-center text-[10px] font-semibold">1</span> {{ __('molthost::messages.checkout.step_configure') }}</li>
        <li class="text-muted/40">─────</li>
        <li class="flex items-center gap-2"><span class="w-5 h-5 rounded-full border border-neutral/30 flex items-center justify-center text-[10px]">2</span> {{ __('molthost::messages.checkout.step_cart') }}</li>
        <li class="text-muted/40">─────</li>
        <li class="flex items-center gap-2"><span class="w-5 h-5 rounded-full border border-neutral/30 flex items-center justify-center text-[10px]">3</span> {{ __('molthost::messages.checkout.step_payment') }}</li>
    </ol>

    <div class="flex flex-col md:grid md:grid-cols-4 gap-6">
        <div class="flex flex-col gap-4 w-full col-span-3">
            <div>
                <div class="mh-eyebrow mb-2">{{ __('molthost::messages.checkout.configure_title') }}</div>
                <h1 class="text-3xl md:text-4xl font-medium tracking-tight">{{ $product->name }}</h1>
            </div>

            <div class="flex flex-col sm:flex-row w-full gap-4 bg-background-secondary border border-neutral/15 p-5 rounded-2xl">
                @if ($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full sm:max-w-40 sm:h-32 object-cover rounded-xl border border-neutral/15">
                @endif
                <div class="max-h-32 overflow-y-auto w-full">
                    <article class="prose prose-sm prose-invert max-w-none text-muted">{!! $product->description !!}</article>
                </div>
            </div>

            @if ($product->availablePlans()->count() > 1)
                <div class="bg-background-secondary border border-neutral/15 p-5 rounded-2xl">
                    <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em] mb-3">{{ __('molthost::messages.checkout.billing_cycle_label') }}</div>
                    <x-form.select wire:model.live="plan_id" class="text-base bg-background px-3 py-2.5 rounded-lg w-full" name="plan_id" label="">
                        @foreach ($product->availablePlans() as $availablePlan)
                            <option value="{{ $availablePlan->id }}">
                                {{ $availablePlan->name }} — {{ $availablePlan->price()->formatted->price }}
                                @if ($availablePlan->price()->has_setup_fee) + {{ $availablePlan->price()->formatted->setup_fee }} {{ __('product.setup_fee') }} @endif
                            </option>
                        @endforeach
                    </x-form.select>
                </div>
            @endif

            @if($product->configOptions->count() > 0 || count($this->getCheckoutConfig()) > 0)
                <div class="bg-background-secondary border border-neutral/15 p-5 rounded-2xl">
                    <div class="mh-mono text-[10px] text-muted uppercase tracking-[0.10em] mb-4">{{ __('molthost::messages.checkout.configurable_options_label') }}</div>
                    <div class="flex flex-col gap-4">
                        @foreach ($product->configOptions as $configOption)
                            @php $showPriceTag = $configOption->children->filter(fn ($value) => !$value->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->is_free)->count() > 0; @endphp
                            <x-form.configoption :config="$configOption" :name="'configOptions.' . $configOption->id" :showPriceTag="$showPriceTag" :plan="$plan">
                                @if ($configOption->type == 'select')
                                    @foreach ($configOption->children as $configOptionValue)
                                        <option value="{{ $configOptionValue->id }}">{{ $configOptionValue->name }} {{ ($showPriceTag && $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->available) ? ' - ' . $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit) : '' }}</option>
                                    @endforeach
                                @elseif($configOption->type == 'radio')
                                    @foreach ($configOption->children as $configOptionValue)
                                        <div class="flex items-center gap-2">
                                            <input type="radio" id="{{ $configOptionValue->id }}" name="{{ $configOption->id }}" wire:model.live="configOptions.{{ $configOption->id }}" value="{{ $configOptionValue->id }}" />
                                            <label for="{{ $configOptionValue->id }}">{{ $configOptionValue->name }} {{ ($showPriceTag && $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->available) ? ' - ' . $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit) : '' }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </x-form.configoption>
                        @endforeach
                        @foreach ($this->getCheckoutConfig() as $configOption)
                            @php $configOption = (object) $configOption; @endphp
                            <x-form.configoption :config="$configOption" :name="'checkoutConfig.' . $configOption->name">
                                @if ($configOption->type == 'select')
                                    @foreach ($configOption->options as $configOptionValue => $configOptionValueName)
                                        <option value="{{ $configOptionValue }}">{{ $configOptionValueName }}</option>
                                    @endforeach
                                @elseif($configOption->type == 'radio')
                                    @foreach ($configOption->options as $configOptionValue => $configOptionValueName)
                                        <div class="flex items-center gap-2">
                                            <input type="radio" id="{{ $configOptionValue }}" name="{{ $configOption->name }}" wire:model.live="checkoutConfig.{{ $configOption->name }}" value="{{ $configOptionValue }}" />
                                            <label for="{{ $configOptionValue }}">{{ $configOptionValueName }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </x-form.configoption>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Order Summary --}}
        <div class="flex flex-col gap-3 w-full col-span-1 bg-background-secondary border border-neutral/20 p-5 rounded-2xl h-fit sticky top-20 shadow-[0_30px_80px_-30px_hsl(0_0%_0%_/_0.35)]">
            <div class="mh-mono text-[10px] uppercase tracking-[0.10em] text-muted">{{ __('molthost::messages.checkout.order_summary_eyebrow') }}</div>
            <h2 class="text-lg font-medium tracking-tight">{{ __('product.order_summary') }}</h2>

            @if ($total->total_tax > 0)
                <div class="flex justify-between text-sm text-muted">
                    <span>{{ __('invoices.subtotal') }}</span>
                    <span class="mh-mono text-base">{{ $total->format($total->subtotal) }}</span>
                </div>
                <div class="flex justify-between text-sm text-muted">
                    <span>{{ \App\Classes\Settings::tax()->name }} ({{ \App\Classes\Settings::tax()->rate }}%)</span>
                    <span class="mh-mono text-base">{{ $total->formatted->total_tax }}</span>
                </div>
            @endif

            <div class="flex justify-between items-baseline border-t border-neutral/20 pt-3 mt-1">
                <span class="font-medium">{{ __('product.total_today') }}</span>
                <span class="text-2xl font-medium tracking-tight text-primary">{{ $total }}</span>
            </div>

            @if ($total->setup_fee > 0 && $plan->type == 'recurring')
                <div class="text-xs text-muted flex justify-between mh-mono">
                    <span>↳ {{ __('product.then_after_x', ['time' => $plan->billing_period . ' ' . trans_choice(__('services.billing_cycles.' . $plan->billing_unit), $plan->billing_period)]) }}</span>
                    <span>{{ $total->format($total->price) }}</span>
                </div>
            @endif

            @if (($product->stock > 0 || !$product->stock) && $product->price()->available)
                <x-button.primary wire:click="checkout" wire:loading.attr="disabled" class="mt-3">
                    <x-loading target="checkout" />
                    <div wire:loading.remove wire:target="checkout">{{ __('product.checkout') }} →</div>
                </x-button.primary>
            @endif
        </div>
    </div>
</div>
