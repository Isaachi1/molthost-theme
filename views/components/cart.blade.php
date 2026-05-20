@if($cartCount > 0)
<div class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-neutral/20 transition relative">
    <x-navigation.link :href="route('cart')">
        <x-ri-shopping-bag-4-fill class="size-4" />
        <div class="absolute inline-flex items-center justify-center w-4 h-4 font-bold text-inverted bg-primary rounded-full top-0 end-0 text-[10px]">
            {{ $cartCount }}
        </div>
    </x-navigation.link>
</div>
@endif
