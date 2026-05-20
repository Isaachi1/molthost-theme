<x-app-layout>
    <x-slot name="title">{{ __('errors.500.title') }}</x-slot>
    <div class="container flex flex-col items-center justify-center text-center py-24">
        <div class="w-16 h-16 bg-error/10 rounded-xl flex items-center justify-center mb-5">
            <span class="text-2xl font-extrabold text-error">500</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-bold">{{ __('errors.500.title') }}</h1>
        <p class="mt-3 text-muted max-w-md">{{ __('errors.500.message') }}</p>
    </div>
</x-app-layout>
