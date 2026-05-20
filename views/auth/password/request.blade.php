{{-- MoltHost — Password reset request --}}
<div class="container">
    <div class="mx-auto max-w-xl">
        <div class="flex flex-col items-center mt-10 mb-6 text-center">
            <x-logo class="scale-[1.6] mb-5" />
            <div class="mh-chip mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse-slow"></span>
                molt://auth · password reset
            </div>
            <h1 class="text-3xl md:text-4xl font-medium tracking-tight">{{ __('auth.reset_password') }}</h1>
            <p class="mt-2 text-sm text-muted">We'll send a reset link to your inbox.</p>
        </div>

        <form class="flex flex-col gap-3 p-6 sm:p-9 bg-background-secondary border border-neutral/20 rounded-2xl shadow-[0_30px_80px_-20px_hsl(0_0%_0%_/_0.40)]"
              wire:submit="submit" id="reset">
            <x-form.input name="email" type="text" :label="__('general.input.email')" :placeholder="__('general.input.email_placeholder')" wire:model="email" required />
            <x-captcha :form="'reset'" />
            <x-button.primary class="w-full mt-2" type="submit">{{ __('auth.reset_password') }}</x-button.primary>

            <div class="text-center py-1 mt-3 text-sm text-muted">
                <a class="text-primary hover:text-primary/80 font-semibold transition-colors" href="{{ route('login') }}" wire:navigate>
                    ← {{ __('auth.sign_in') }}
                </a>
            </div>
        </form>
    </div>
</div>
