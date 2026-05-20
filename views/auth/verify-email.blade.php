{{-- MoltHost — Verify email --}}
<div class="container">
    <div class="mx-auto max-w-xl mt-10">
        <div class="bg-background-secondary border border-neutral/20 rounded-2xl p-6 sm:p-9 shadow-[0_30px_80px_-20px_hsl(0_0%_0%_/_0.40)]">
            <div class="mh-chip mb-5">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse-slow"></span>
                molt://auth · verify
            </div>
            <h1 class="text-2xl md:text-3xl font-medium tracking-tight mb-2">{{ __('auth.verification.notice') }}</h1>
            <p class="text-muted leading-relaxed mb-6">{{ __('auth.verification.check_your_email') }}</p>
            <form class="flex flex-col gap-3" wire:submit.prevent="submit" id="verify-email">
                <x-captcha :form="'verify-email'" />
                <p class="mh-mono text-xs uppercase tracking-[0.08em] text-muted">↳ {{ __('auth.verification.not_received') }}</p>
                <x-button.primary class="w-full" type="submit">{{ __('auth.verification.request_another') }}</x-button.primary>
            </form>
        </div>
    </div>
</div>
