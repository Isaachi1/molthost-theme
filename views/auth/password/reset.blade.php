{{-- MoltHost — Password reset --}}
<div class="container">
    <div class="mx-auto max-w-xl">
        <div class="flex flex-col items-center mt-10 mb-6 text-center">
            <x-logo class="scale-[1.6] mb-5" />
            <div class="mh-chip mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse-slow"></span>
                molt://auth · choose new password
            </div>
            <h1 class="text-3xl md:text-4xl font-medium tracking-tight">{{ __('auth.reset_password') }}</h1>
        </div>

        <form class="flex flex-col gap-3 p-6 sm:p-9 bg-background-secondary border border-neutral/20 rounded-2xl shadow-[0_30px_80px_-20px_hsl(0_0%_0%_/_0.40)]"
              wire:submit="submit" id="reset">
            <x-form.input name="email" type="text" :label="__('general.input.email')" :placeholder="__('general.input.email_placeholder')" wire:model="email" required disabled />
            <x-form.input name="password" type="password" :label="__('general.input.password')" :placeholder="__('general.input.password_placeholder')" wire:model="password" required />
            <x-form.input name="password_confirm" type="password" :label="__('general.input.password_confirmation')" :placeholder="__('general.input.password_confirmation_placeholder')" wire:model="password_confirmation" required />
            <x-captcha :form="'reset'" />
            <x-button.primary class="w-full mt-2" type="submit">{{ __('auth.reset_password') }}</x-button.primary>
        </form>
    </div>
</div>
