{{-- MoltHost — Category / Products listing (databases · LLM hosting · etc) --}}
<div class="container mt-10 pb-20 md:pb-12">
    {{-- Header --}}
    <div class="mb-10 grid grid-cols-1 md:grid-cols-[1fr_1.4fr] gap-8 md:gap-20 items-start">
        <div>
            <div class="mh-eyebrow mb-3">{{ __('molthost::messages.products.category_eyebrow') }}</div>
            <h1 class="text-3xl md:text-5xl font-medium tracking-tight leading-[1.05]">{{ $category->name }}</h1>
        </div>
        <article class="prose prose-base max-w-none text-muted">
            {!! $category->description !!}
        </article>
    </div>

    <div class="flex flex-col md:grid md:grid-cols-4 gap-6">
        {{-- Sidebar --}}
        <aside class="flex flex-col gap-4">
            <div class="bg-background-secondary/70 border border-neutral/15 p-3 rounded-2xl">
                <div class="mh-mono text-[10px] uppercase tracking-[0.10em] text-muted px-2.5 pb-2 pt-1">{{ __('molthost::messages.products.sidebar_categories') }}</div>
                @foreach ($categories as $ccategory)
                <a href="{{ route('category.show', ['category' => $ccategory->slug]) }}" wire:navigate
                   class="flex items-center justify-between gap-2 p-2.5 rounded-lg text-sm transition-colors {{ $category->id == $ccategory->id ? 'text-primary font-semibold bg-primary/10 border border-primary/20' : 'text-muted hover:text-base hover:bg-background border border-transparent' }}">
                    <span>{{ $ccategory->name }}</span>
                    @if($category->id == $ccategory->id)<span class="mh-mono text-[10px]">●</span>@endif
                </a>
                @endforeach
            </div>
        </aside>

        {{-- Products grid --}}
        <div class="flex flex-col gap-6 col-span-3">
            @if (count($childCategories) >= 1)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach ($childCategories as $childCategory)
                <a href="{{ route('category.show', ['category' => $childCategory->slug]) }}" wire:navigate
                   class="group flex flex-col bg-background-secondary border border-neutral/15 p-5 rounded-2xl hover:border-primary/40 transition-all duration-200">
                    @if(theme('small_images', false))
                    <div class="flex gap-x-3 items-center">
                    @endif
                        @if ($childCategory->image)
                        <img src="{{ Storage::url($childCategory->image) }}" alt="{{ $childCategory->name }}"
                            class="rounded-xl {{ theme('small_images', false) ? 'w-10 h-10 object-cover' : 'w-full aspect-[4/3] object-cover object-center mb-3 border border-neutral/15' }}">
                        @endif
                        <h2 class="text-lg font-semibold tracking-tight">{{ $childCategory->name }}</h2>
                    @if(theme('small_images', false))
                    </div>
                    @endif
                    @if(theme('show_category_description', true))
                    <div class="mt-2 text-sm text-muted line-clamp-3 prose-sm">{!! $childCategory->description !!}</div>
                    @endif
                    <span class="mt-auto pt-3 mh-mono text-xs text-primary uppercase tracking-[0.08em] group-hover:translate-x-0.5 transition-transform">
                        {{ __('molthost::messages.products.see_plans_arrow') }}
                    </span>
                </a>
                @endforeach
            </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach ($products as $idx => $product)
                @php $popular = $idx === 1; @endphp
                <div class="relative {{ $popular ? 'pt-3' : '' }}">
                    @if ($popular)
                        <span class="mh-mono absolute top-0 left-5 z-10 text-[10px] font-semibold tracking-[0.10em] px-2.5 py-1 rounded-md bg-primary text-inverted shadow-[0_4px_14px_-2px_hsl(var(--c-primary)/0.45)]">{{ __('molthost::messages.products.popular_badge') }}</span>
                    @endif
                <div class="group flex flex-col bg-background-secondary border {{ $popular ? 'border-primary/40' : 'border-neutral/15' }} p-5 rounded-2xl hover:border-primary/40 transition-all duration-200 relative overflow-hidden h-full">
                    {{-- Stock badge --}}
                    @if ($product->stock === 0)
                    <div class="absolute top-3 right-3">
                        <span class="mh-mono text-[10px] font-semibold px-2 py-0.5 rounded bg-error/15 text-error uppercase tracking-wider">{{ __('molthost::messages.products.out_of_stock') }}</span>
                    </div>
                    @endif

                    @if(theme('small_images', false))
                    <div class="flex gap-x-3 items-center">
                    @endif
                        @if ($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                            class="rounded-xl {{ theme('small_images', false) ? 'w-10 h-10 object-cover' : 'w-full aspect-[4/3] object-cover object-center mb-3 border border-neutral/15' }}">
                        @endif
                        <div>
                            <div class="mh-mono text-[10px] uppercase tracking-[0.10em] text-primary">{{ $product->slug ?? str_pad((string)($idx + 1), 2, '0', STR_PAD_LEFT) }}</div>
                            <h2 class="text-lg font-semibold tracking-tight">{{ $product->name }}</h2>
                        </div>
                    @if(theme('small_images', false))
                    </div>
                    @endif

                    @if(theme('direct_checkout', false) && $product->description)
                    <div class="text-sm text-muted mt-2 line-clamp-2 prose-sm">{!! $product->description !!}</div>
                    @endif

                    {{-- Price --}}
                    <div class="mt-4 mb-1 flex items-baseline gap-1.5">
                        <span class="text-3xl font-medium tracking-tight text-primary">{{ $product->price()->formatted->price }}</span>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-auto pt-4 flex items-center gap-2">
                        @if($product->stock !== 0 && $product->price()->available && theme('direct_checkout', false))
                        <a href="{{ route('products.checkout', ['category' => $product->category, 'product' => $product->slug]) }}" wire:navigate class="flex-grow">
                            <x-button.primary class="w-full">{{ __('product.add_to_cart') }}</x-button.primary>
                        </a>
                        @else
                        <a href="{{ route('products.show', ['category' => $product->category, 'product' => $product->slug]) }}" wire:navigate class="flex-grow">
                            <x-button.primary class="w-full">{{ __('common.button.view') }}</x-button.primary>
                        </a>
                        @if ($product->stock !== 0 && $product->price()->available)
                        <a href="{{ route('products.checkout', ['category' => $category, 'product' => $product->slug]) }}" wire:navigate>
                            <x-button.secondary><x-ri-shopping-bag-4-fill class="size-4" /></x-button.secondary>
                        </a>
                        @endif
                        @endif
                    </div>
                </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
