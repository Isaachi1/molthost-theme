{{-- MoltHost — Top Navigation --}}
<nav class="w-full px-4 lg:px-8 bg-background/85 backdrop-blur-xl border-b border-neutral/15 md:h-16 flex md:flex-row flex-col justify-between fixed top-0 z-20">
    <div
        x-data="{
            slideOverOpen: false,
            hasAside: !!document.getElementById('main-aside')
        }"
        x-init="$watch('slideOverOpen', value => { document.documentElement.style.overflow = value ? 'hidden' : '' })"
        class="relative z-50 w-full h-auto">
        <div
            class="flex flex-row items-center justify-between h-16"
            :class="hasAside ? 'w-full' : 'container'">

            {{-- Logo: MoltHost wordmark (Molt + colored Host) --}}
            <div class="flex flex-row items-center">
                <a href="{{ route('home') }}" class="flex flex-row items-center h-10 gap-2.5" wire:navigate>
                    <x-logo class="h-7" />
                    @if(theme('logo_display', 'logo-and-name') != 'logo-only')
                    @php
                        $appName = config('app.name', 'MoltHost');
                        // Split "MoltHost" → Molt + Host so we can color "Host" with the lobster accent.
                        $split = preg_match('/^([A-Za-z]+?)([A-Z][a-z]+)$/', $appName, $m);
                    @endphp
                    <span class="text-lg font-semibold leading-none tracking-tight flex items-center select-none">
                        @if($split)
                            {{ $m[1] }}<span class="text-primary">{{ $m[2] }}</span>
                        @else
                            {{ $appName }}
                        @endif
                    </span>
                    @endif
                </a>
                <div class="md:flex hidden flex-row ml-6">
                    @foreach (\App\Classes\Navigation::getLinks() as $nav)
                    @if (isset($nav['children']) && count($nav['children']) > 0)
                    <div class="relative">
                        <x-dropdown>
                            <x-slot:trigger>
                                <div class="flex flex-col">
                                    <span class="flex flex-row items-center p-3 text-sm font-medium whitespace-nowrap text-muted hover:text-base transition-colors">
                                        {{ molthost_resolve_label($nav['name']) }}
                                    </span>
                                </div>
                            </x-slot:trigger>
                            <x-slot:content>
                                @foreach ($nav['children'] as $child)
                                <x-navigation.link
                                    :href="$child['url']"
                                    :spa="isset($child['spa']) ? $nav['spa'] : true">
                                    {{ molthost_resolve_label($child['name']) }}
                                </x-navigation.link>
                                @endforeach
                            </x-slot:content>
                        </x-dropdown>
                    </div>
                    @else
                    <x-navigation.link
                        :href="$nav['url']"
                        :spa="isset($nav['spa']) ? $nav['spa'] : true"
                        class="flex items-center p-3 text-sm font-medium text-muted hover:text-base transition-colors">
                        {{ molthost_resolve_label($nav['name']) }}
                    </x-navigation.link>
                    @endif
                    @endforeach
                </div>
            </div>

            {{-- Right controls --}}
            <div class="flex flex-row items-center gap-1">
                <livewire:components.cart />

                <div class="items-center hidden md:flex flex-row gap-2">
                    <livewire:components.language-switch />
                    <livewire:components.currency-switch />
                    <x-theme-toggle />
                </div>

                @if(auth()->check())
                <livewire:components.notifications />
                <div class="hidden lg:flex">
                    <x-dropdown :showArrow="false">
                        <x-slot:trigger>
                            <img src="{{ auth()->user()->avatar }}" class="size-8 rounded-lg border border-neutral/20 bg-background-secondary" alt="avatar" />
                        </x-slot:trigger>
                        <x-slot:content>
                            <div class="flex flex-col p-3 border-b border-neutral/15">
                                <span class="text-sm font-semibold break-words">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-muted break-words">{{ auth()->user()->email }}</span>
                            </div>
                            @foreach (\App\Classes\Navigation::getAccountDropdownLinks() as $nav)
                            <x-navigation.link :href="$nav['url']" :spa="isset($nav['spa']) ? $nav['spa'] : true">
                                {{ molthost_resolve_label($nav['name']) }}
                            </x-navigation.link>
                            @endforeach
                            <livewire:auth.logout />
                        </x-slot:content>
                    </x-dropdown>
                </div>
                @else
                <div class="hidden lg:flex flex-row gap-2">
                    <a href="{{ route('login') }}" wire:navigate>
                        <x-button.secondary>
                            {{ molthost_resolve_label(__('navigation.login')) }}
                        </x-button.secondary>
                    </a>
                    @if(!config('settings.registration_disabled', false))
                    <a href="{{ route('register') }}" wire:navigate>
                        <x-button.primary>
                            {{ molthost_resolve_label(__('navigation.register')) }}
                        </x-button.primary>
                    </a>
                    @endif
                </div>
                @endif

                {{-- Mobile toggle --}}
                <button
                    @click="slideOverOpen = !slideOverOpen"
                    class="relative w-10 h-10 flex lg:hidden items-center justify-center rounded-lg hover:bg-neutral/10 transition"
                    aria-label="Toggle Menu">
                    <span x-show="!slideOverOpen"
                        x-transition:enter="transition duration-200"
                        x-transition:enter-start="opacity-0 rotate-90 scale-75"
                        x-transition:enter-end="opacity-100 rotate-0 scale-100"
                        x-transition:leave="transition duration-150"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0 flex items-center justify-center">
                        <x-ri-menu-fill class="size-5" />
                    </span>
                    <span x-show="slideOverOpen"
                        x-transition:enter="transition duration-200"
                        x-transition:enter-start="opacity-0 -rotate-90 scale-75"
                        x-transition:enter-end="opacity-100 rotate-0 scale-100"
                        x-transition:leave="transition duration-150"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0 flex items-center justify-center">
                        <x-ri-close-fill class="size-5" />
                    </span>
                </button>
            </div>
        </div>

        {{-- Mobile slide-over (sem x-teleport — o teleport causa duplicação ao usar wire:navigate, p.ex. trocar moeda/idioma) --}}
        <div
                x-show="slideOverOpen"
                @keydown.window.escape="slideOverOpen=false"
                x-cloak
                class="fixed left-0 right-0 top-16 w-full z-[99]"
                style="height:calc(100dvh - 4rem);">
                <div
                    x-show="slideOverOpen"
                    @click.away="slideOverOpen = false"
                    x-transition.opacity.duration.200ms
                    class="absolute inset-0 bg-background border-t border-neutral/15 overflow-y-auto flex flex-col">
                    <div class="flex flex-col h-full p-4">
                        <div class="flex-1 min-h-0 overflow-y-auto">
                            <x-navigation.sidebar-links />
                        </div>
                        <div class="mt-5 pb-20">
                            @if(auth()->check())
                            <div x-data="{ userPanelOpen: false }" x-cloak class="relative">
                                <button @click="userPanelOpen = true"
                                    class="flex gap-4 items-center justify-start w-full p-3 rounded-lg hover:bg-background-secondary transition-colors">
                                    <img src="{{ auth()->user()->avatar }}" class="size-10 rounded-lg border border-neutral/20" alt="avatar" />
                                    <div class="flex flex-col items-start gap-0.5">
                                        <span class="font-bold">{{ auth()->user()->name }}</span>
                                        <span class="text-sm text-muted">{{ auth()->user()->email }}</span>
                                    </div>
                                </button>

                                <div x-show="userPanelOpen"
                                    x-transition:enter="transition-opacity ease-out duration-200"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-60"
                                    x-transition:leave="transition-opacity ease-in duration-150"
                                    x-transition:leave-start="opacity-60"
                                    x-transition:leave-end="opacity-0"
                                    @click="userPanelOpen=false"
                                    class="fixed inset-0 bg-black/50 backdrop-blur-xs z-40"></div>

                                <div x-show="userPanelOpen"
                                    x-transition:enter="transition transform ease-out duration-200"
                                    x-transition:enter-start="translate-y-full opacity-0"
                                    x-transition:enter-end="translate-y-0 opacity-100"
                                    x-transition:leave="transition transform ease-in duration-150"
                                    x-transition:leave-start="translate-y-0 opacity-100"
                                    x-transition:leave-end="translate-y-full opacity-0"
                                    class="fixed bottom-0 left-0 right-0 z-50 mx-auto w-full"
                                    @click.away="userPanelOpen = false">
                                    <div class="bg-background-secondary shadow-lg rounded-t-2xl border-t border-neutral/15 p-6">
                                        <div class="flex gap-4 items-center mb-6">
                                            <img src="{{ auth()->user()->avatar }}" class="size-12 rounded-lg border border-neutral/20" alt="avatar" />
                                            <div class="flex flex-col">
                                                <span class="font-bold text-lg">{{ auth()->user()->name }}</span>
                                                <span class="text-sm text-muted">{{ auth()->user()->email }}</span>
                                            </div>
                                        </div>
                                        <div class="h-px w-full bg-neutral/15 mb-4"></div>
                                        <div class="flex flex-col gap-1">
                                            @foreach (\App\Classes\Navigation::getAccountDropdownLinks() as $nav)
                                            <x-navigation.link :href="$nav['url']" :spa="isset($nav['spa']) ? $nav['spa'] : true">
                                                {{ molthost_resolve_label($nav['name']) }}
                                            </x-navigation.link>
                                            @endforeach
                                            <livewire:auth.logout />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="flex flex-col gap-3 mb-3">
                                @if(!config('settings.registration_disabled', false))
                                <a href="{{ route('register') }}" wire:navigate>
                                    <x-button.primary>{{ molthost_resolve_label(__('navigation.register')) }}</x-button.primary>
                                </a>
                                @endif
                                <a href="{{ route('login') }}" wire:navigate>
                                    <x-button.secondary>{{ molthost_resolve_label(__('navigation.login')) }}</x-button.secondary>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
