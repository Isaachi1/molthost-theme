<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(in_array(app()->getLocale(), config('app.rtl_locales'))) dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name', 'Paymenter') }}
        @isset($title)
        - {{ $title }}
        @endisset
    </title>
    @livewireStyles
    {{-- Geist + Geist Mono (display + body + numerics) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['themes/' . config('settings.theme') . '/js/app.js', 'themes/' . config('settings.theme') . '/css/app.css'], config('settings.theme'))
    @include('layouts.colors')

    @if (config('settings.favicon'))
    <link rel="icon" href="{{ Storage::url(config('settings.favicon')) }}">
    @endif
    @isset($title)
    <meta content="{{ isset($title) ? config('app.name', 'Paymenter') . ' - ' . $title : config('app.name', 'Paymenter') }}" property="og:title">
    <meta content="{{ isset($title) ? config('app.name', 'Paymenter') . ' - ' . $title : config('app.name', 'Paymenter') }}" name="title">
    @endisset
    @isset($description)
    <meta content="{{ $description }}" property="og:description">
    <meta content="{{ $description }}" name="description">
    @endisset
    @isset($image)
    <meta content="{{ $image }}" property="og:image">
    <meta content="{{ $image }}" name="image">
    @endisset

    <meta name="theme-color" content="{{ theme('dark-primary') }}">

    {!! hook('head') !!}
</head>

<body class="w-full bg-background text-base min-h-screen flex flex-col antialiased"
    x-cloak
    x-data="{
        theme: $persist('system').as('theme_mode'),
        systemDark: window.matchMedia('(prefers-color-scheme: dark)').matches,
        init() {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                this.systemDark = e.matches;
            });
        },
        get isDark() {
            return this.theme === 'dark' || (this.theme === 'system' && this.systemDark);
        }
    }"
    :class="{'dark': isDark}"
>
    {!! hook('body') !!}
    <x-navigation />
    <div class="w-full flex flex-grow">
        @if (isset($sidebar) && $sidebar)
        <x-navigation.sidebar title="$title" />
        @endif
        <div class="{{ (isset($sidebar) && $sidebar) ? 'md:ml-64 rtl:ml-0 rtl:md:mr-64' : '' }} flex flex-col flex-grow overflow-auto">
            <main class="mt-16 grow">
                {{ $slot }}
            </main>
            <x-notification />
            <x-confirmation />
            <div class="flex">
                <x-navigation.footer />
            </div>
        </div>
        <x-impersonating />
    </div>

    {{-- Mobile Bottom Nav --}}
    @auth
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-30 bg-background-secondary/95 backdrop-blur-md border-t border-neutral/20 safe-area-bottom">
        <div class="flex items-stretch justify-around h-16 px-2">
            <a href="{{ route('home') }}" wire:navigate
               class="flex flex-col items-center justify-center gap-0.5 py-1 px-3 rounded-lg transition-colors min-w-[64px] {{ request()->routeIs('home') ? 'text-primary' : 'text-muted hover:text-base' }}">
                <x-ri-home-5-fill class="size-5" />
                <span class="text-[10px] font-medium leading-tight">{{ molthost_resolve_label(__('navigation.home')) }}</span>
            </a>
            <a href="{{ route('services') }}" wire:navigate
               class="flex flex-col items-center justify-center gap-0.5 py-1 px-3 rounded-lg transition-colors min-w-[64px] {{ request()->routeIs('services*') ? 'text-primary' : 'text-muted hover:text-base' }}">
                <x-ri-server-fill class="size-5" />
                <span class="text-[10px] font-medium leading-tight">{{ molthost_resolve_label(__('services.services')) }}</span>
            </a>
            <a href="{{ route('invoices') }}" wire:navigate
               class="flex flex-col items-center justify-center gap-0.5 py-1 px-3 rounded-lg transition-colors min-w-[64px] {{ request()->routeIs('invoices*') ? 'text-primary' : 'text-muted hover:text-base' }}">
                <x-ri-receipt-fill class="size-5" />
                <span class="text-[10px] font-medium leading-tight">{{ molthost_resolve_label(__('invoices.invoices')) }}</span>
            </a>
            @if(!config('settings.tickets_disabled', false))
            <a href="{{ route('tickets') }}" wire:navigate
               class="flex flex-col items-center justify-center gap-0.5 py-1 px-3 rounded-lg transition-colors min-w-[64px] {{ request()->routeIs('tickets*') ? 'text-primary' : 'text-muted hover:text-base' }}">
                <x-ri-customer-service-fill class="size-5" />
                <span class="text-[10px] font-medium leading-tight">{{ molthost_resolve_label(__('ticket.support')) }}</span>
            </a>
            @endif
        </div>
    </nav>
    @endauth

    @livewireScriptConfig
    {!! hook('footer') !!}
</body>

</html>
