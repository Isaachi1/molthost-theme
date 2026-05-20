{{-- MoltHost — Register --}}
<div class="container">
    <div class="mx-auto max-w-2xl">
        <div class="flex flex-col items-center mt-10 mb-6 text-center">
            <x-logo class="scale-[1.6] mb-5" />
            <div class="mh-chip mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse-slow"></span>
                {{ __('molthost::messages.auth.register_chip') }}
            </div>
            <h1 class="text-3xl md:text-4xl font-medium tracking-tight">{{ __('auth.sign_up_title') }}</h1>
            <p class="mt-2 text-sm text-muted max-w-sm">{{ __('molthost::messages.auth.register_subtitle') }}</p>
        </div>

        <form class="flex flex-col gap-3 p-6 sm:p-9 bg-background-secondary border border-neutral/20 rounded-2xl shadow-[0_30px_80px_-20px_hsl(0_0%_0%_/_0.40)]"
              wire:submit.prevent="submit" id="register">
            <div class="flex flex-col md:grid md:grid-cols-2 gap-4">
                <x-form.input name="first_name" type="text" :label="__('general.input.first_name')"
                    :placeholder="__('general.input.first_name_placeholder')" wire:model="first_name" required />
                <x-form.input name="last_name" type="text" :label="__('general.input.last_name')"
                    :placeholder="__('general.input.last_name_placeholder')" wire:model="last_name" required />
                <x-form.input name="email" type="email" :label="__('general.input.email')"
                    :placeholder="__('general.input.email_placeholder')" required wire:model="email" divClass="col-span-2" />
                <x-form.input name="password" type="password" :label="__('general.input.password')" :placeholder="__('general.input.password_placeholder')"
                    wire:model="password" required />
                <x-form.input name="password_confirm" type="password" :label="__('general.input.password_confirmation')"
                    :placeholder="__('general.input.password_confirmation_placeholder')" wire:model="password_confirmation" required />
                <x-form.properties :custom_properties="$custom_properties" :properties="$properties" />
                @if(config('settings.tos'))
                    <x-form.checkbox wire:model="tos" name="tos" required>
                        {{ __('product.tos') }}
                        <a href="{{ config('settings.tos') }}" target="_blank" class="text-primary hover:text-primary/80">{{ __('product.tos_link') }}</a>
                    </x-form.checkbox>
                @endif
            </div>

            <x-captcha :form="'register'" />
            <x-button.primary class="w-full mt-2">{{ __('auth.sign_up') }}</x-button.primary>

            <div class="text-center py-1 mt-3 text-sm text-muted">
                {{ __('auth.already_have_account') }}
                <a class="text-primary hover:text-primary/80 font-semibold transition-colors" href="{{ route('login') }}" wire:navigate>
                    {{ __('auth.sign_in') }}
                </a>
            </div>
        </form>
    </div>
</div>
