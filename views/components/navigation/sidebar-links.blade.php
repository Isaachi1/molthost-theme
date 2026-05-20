{{-- Raze Theme - Sidebar Links (Hosting Panel style) --}}
<div class="lg:px-4 lg:py-5 flex flex-col gap-0.5">
    <div class="flex flex-col gap-0.5 md:hidden">
        @foreach (\App\Classes\Navigation::getLinks() as $nav)
        @if (!empty($nav['children']))
        <div x-data="{ activeAccordion: {{ $nav['active'] ? 'true' : 'false' }} }"
            class="relative w-full overflow-hidden text-sm">
            <button @click="activeAccordion = !activeAccordion"
                class="flex items-center justify-between w-full p-2.5 text-sm font-medium rounded-lg hover:bg-primary/5 transition-colors">
                <div class="flex flex-row gap-2.5 items-center">
                    @isset($nav['icon'])
                        <x-dynamic-component :component="$nav['icon']"
                        class="size-4 {{ $nav['active'] ? 'text-primary' : 'text-muted' }}" />
                    @endisset
                    <span>{{ molthost_resolve_label($nav['name']) }}</span>
                </div>
                <x-ri-arrow-down-s-line x-bind:class="{ 'rotate-180': activeAccordion }"
                    class="size-4 text-muted transition-transform duration-200" />
            </button>
            <div x-show="activeAccordion" x-collapse x-cloak>
                <div class="pl-7 py-1">
                    @foreach ($nav['children'] as $child)
                    <x-navigation.link :href="$child['url']"
                        :spa="$child['spa'] ?? true"
                        class="block py-1.5 text-sm {{ $child['active'] ? 'text-primary font-semibold' : 'text-muted hover:text-base' }}">
                        {{ molthost_resolve_label($child['name']) }}
                    </x-navigation.link>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="rounded-lg {{ $nav['active'] ? 'bg-primary/8' : 'hover:bg-primary/5' }} transition-colors">
            <x-navigation.link :href="$nav['url']"
                :spa="$nav['spa'] ?? true" class="w-full flex items-center gap-2.5 p-2.5 text-sm font-medium">
                @isset($nav['icon'])
                    <x-dynamic-component :component="$nav['icon']"
                        class="size-4 {{ $nav['active'] ? 'text-primary' : 'text-muted' }}" />
                @endisset
                {{ molthost_resolve_label($nav['name']) }}
            </x-navigation.link>
        </div>
        @endif
        @isset($nav['separator'])
        <div class="h-px w-full bg-neutral/10 my-1.5"></div>
        @endisset
        @endforeach
    </div>

    <div class="flex flex-col gap-0.5">
        @foreach (\App\Classes\Navigation::getDashboardLinks() as $nav)
        @if (!empty($nav['children']))
        <div x-data="{ activeAccordion: {{ $nav['active'] ? 'true' : 'false' }} }"
            class="relative w-full overflow-hidden text-sm">
            <button @click="activeAccordion = !activeAccordion"
                class="flex items-center justify-between w-full p-2.5 text-sm font-medium rounded-lg hover:bg-primary/5 transition-colors">
                <div class="flex flex-row gap-2.5 items-center">
                    @isset($nav['icon'])
                        <x-dynamic-component :component="$nav['icon']"
                        class="size-4 {{ $nav['active'] ? 'text-primary' : 'text-muted' }}" />
                    @endisset
                    <span>{{ molthost_resolve_label($nav['name']) }}</span>
                </div>
                <x-ri-arrow-down-s-line x-bind:class="{ 'rotate-180': activeAccordion }"
                    class="size-4 text-muted transition-transform duration-200" />
            </button>
            <div x-show="activeAccordion" x-collapse x-cloak>
                <div class="pl-7 py-1">
                    @foreach ($nav['children'] as $child)
                        @if ($child['condition'] ?? true)
                        <x-navigation.link :href="$child['url']"
                            :spa="$child['spa'] ?? true"
                            class="block py-1.5 text-sm {{ $child['active'] ? 'text-primary font-semibold' : 'text-muted hover:text-base' }}">
                            {{ molthost_resolve_label($child['name']) }}
                        </x-navigation.link>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="rounded-lg {{ $nav['active'] ? 'bg-primary/8' : 'hover:bg-primary/5' }} transition-colors">
            <x-navigation.link :href="$nav['url']"
                :spa="$nav['spa'] ?? true"
                class="w-full flex items-center gap-2.5 p-2.5 text-sm font-medium">
                @isset($nav['icon'])
                    <x-dynamic-component :component="$nav['icon']"
                        class="size-4 {{ $nav['active'] ? 'text-primary' : 'text-muted' }}" />
                @endisset
                {{ molthost_resolve_label($nav['name']) }}
            </x-navigation.link>
        </div>
        @endif
        @isset($nav['separator'])
        <div class="h-px w-full bg-neutral/10 my-1.5"></div>
        @endisset
        @endforeach
        <div class="flex flex-row items-center gap-2 mt-4 justify-between md:hidden">
            <div class="flex-1 min-w-0">
                <livewire:components.language-switch />
            </div>
            <div class="flex-1 min-w-0">
                <livewire:components.currency-switch />
            </div>
            <div class="shrink-0">
                <x-theme-toggle />
            </div>
        </div>
    </div>
</div>
