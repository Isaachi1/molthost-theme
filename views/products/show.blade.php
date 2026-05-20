{{-- MoltHost — Product detail --}}
@php
    $allCategories = \App\Models\Category::query()
        ->whereNull('parent_id')
        ->where(function ($q) {
            $q->whereHas('children')
              ->orWhereHas('products', fn ($p) => $p->where('hidden', false));
        })
        ->orderBy('order')
        ->get();
@endphp
<div class="container mt-8 md:mt-10 pb-24 md:pb-12">
    {{-- Top bar: back button + breadcrumb --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('category.show', ['category' => $category->slug]) }}" wire:navigate
           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-background-secondary border border-neutral/15 text-sm text-muted hover:text-base hover:border-neutral/30 transition-colors min-h-[40px]">
            <x-ri-arrow-left-line class="size-4" />
            <span class="hidden sm:inline">{{ __('molthost::messages.common.back') }}</span>
        </a>
        <nav class="flex-1 min-w-0 flex items-center mh-mono text-xs text-muted overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-primary transition-colors uppercase tracking-[0.08em]">~</a>
            <span class="mx-2 text-muted/50">/</span>
            <a href="{{ route('category.show', ['category' => $category->slug]) }}" wire:navigate
               class="hover:text-primary transition-colors uppercase tracking-[0.08em] truncate max-w-[40vw]">{{ $category->name }}</a>
            <span class="mx-2 text-muted/50">/</span>
            <span class="text-base uppercase tracking-[0.08em] truncate">{{ $product->name }}</span>
        </nav>
    </div>

    <div class="flex flex-col md:grid md:grid-cols-4 gap-6">
        {{-- Sidebar — categories with active marker --}}
        <aside class="flex flex-col gap-4 md:sticky md:top-20 self-start">
            <div class="bg-background-secondary/70 border border-neutral/15 p-3 rounded-2xl">
                <div class="mh-mono text-[10px] uppercase tracking-[0.10em] text-muted px-2.5 pb-2 pt-1">{{ __('molthost::messages.products.sidebar_categories') }}</div>
                @foreach ($allCategories as $ccategory)
                    @php $isActive = $ccategory->id === $category->id; @endphp
                    <a href="{{ route('category.show', ['category' => $ccategory->slug]) }}" wire:navigate
                       class="flex items-center justify-between gap-2 p-2.5 rounded-lg text-sm transition-colors min-h-[40px] {{ $isActive ? 'text-primary font-semibold bg-primary/10 border border-primary/20' : 'text-muted hover:text-base hover:bg-background border border-transparent' }}">
                        <span class="truncate">{{ $ccategory->name }}</span>
                        @if($isActive)<span class="mh-mono text-[10px] shrink-0">●</span>@endif
                    </a>
                @endforeach
            </div>
        </aside>

        {{-- Product card --}}
        <div class="md:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-[1.1fr_1fr] gap-6 md:gap-8 bg-background-secondary border border-neutral/15 p-5 md:p-10 rounded-2xl">
                @if ($product->image)
                <div class="bg-background border border-neutral/15 rounded-xl p-4 md:p-6 flex items-center justify-center">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                        class="w-full max-h-72 md:max-h-96 object-contain object-center">
                </div>
                @endif

                <div class="flex flex-col">
                    {{-- Status chip --}}
                    @if ($product->stock === 0)
                        <span class="mh-mono inline-flex items-center gap-1.5 text-[10px] tracking-[0.10em] px-2 py-1 rounded border bg-error/10 border-error/30 text-error w-fit mb-4 uppercase">
                            ● {{ __('product.out_of_stock', ['product' => $product->name]) }}
                        </span>
                    @elseif($product->stock > 0)
                        <span class="mh-mono inline-flex items-center gap-1.5 text-[10px] tracking-[0.10em] px-2 py-1 rounded border bg-success/10 border-success/30 text-success w-fit mb-4 uppercase">
                            ● {{ __('product.in_stock') }}
                        </span>
                    @else
                        <span class="mh-chip mb-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse-slow"></span>
                            {{ __('molthost::messages.product_detail.plan_chip') }}
                        </span>
                    @endif

                    <div class="mh-mono text-[10px] text-primary uppercase tracking-[0.10em] mb-1.5">{{ $product->slug ?? 'plan' }}</div>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-medium tracking-tight break-words">{{ $product->name }}</h1>

                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-3xl sm:text-4xl md:text-5xl font-medium tracking-tight text-primary">{{ $product->price()->formatted->price }}</span>
                    </div>

                    <article class="my-6 prose prose-base prose-invert max-w-none text-muted">{!! $product->description !!}</article>

                    @if ($product->stock !== 0 && $product->price()->available)
                    <a href="{{ route('products.checkout', ['category' => $category, 'product' => $product->slug]) }}" wire:navigate class="mt-auto">
                        <x-button.primary>
                            {{ __('product.add_to_cart') }} <x-ri-arrow-right-line class="size-4" />
                        </x-button.primary>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
