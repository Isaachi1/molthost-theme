<x-app-layout>
    <x-slot name="title">{{ __('errors.404.title') }}</x-slot>
    <div class="container flex flex-col items-center justify-center text-center py-24">
        <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mb-5">
            <span class="text-2xl font-extrabold text-primary">404</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-bold">{{ __('errors.404.title') }}</h1>
        <p class="mt-3 text-muted max-w-md">{{ __('errors.404.message') }}</p>
        <div class="mt-6">
            <a href="{{ route('home') }}" wire:navigate>
                <x-button.primary>{{ __('errors.404.return_home') }}</x-button.primary>
            </a>
        </div>
    </div>
</x-app-layout>
