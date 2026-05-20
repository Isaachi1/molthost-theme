{{-- MoltHost — Login --}}
<div class="container">
    <div class="mx-auto max-w-xl">
        <div class="flex flex-col items-center mt-10 mb-6 text-center">
            <x-logo class="scale-[1.6] mb-5" />
            <div class="mh-chip mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse-slow"></span>
                {{ __('molthost::messages.auth.login_chip') }}
            </div>
            <h1 class="text-3xl md:text-4xl font-medium tracking-tight">{{ __('auth.sign_in_title') }}</h1>
            <p class="mt-2 text-sm text-muted">{{ __('molthost::messages.auth.login_subtitle') }}</p>
        </div>

        <form class="flex flex-col gap-3 p-6 sm:p-9 bg-background-secondary border border-neutral/20 rounded-2xl shadow-[0_30px_80px_-20px_hsl(0_0%_0%_/_0.40)]"
              wire:submit="submit" id="login">
            <x-form.input name="email" type="email" :label="__('general.input.email')"
                :placeholder="__('general.input.email_placeholder')" wire:model="email" hideRequiredIndicator required autocomplete="email" />
            <x-form.input name="password" type="password" :label="__('general.input.password')"
                :placeholder="__('general.input.password_placeholder')" required hideRequiredIndicator wire:model="password" autocomplete="current-password" />

            <div class="flex flex-row items-center">
                <x-form.checkbox name="remember" label="{{ __('molthost::messages.auth.remember_me') }}" wire:model="remember" />
                <a class="text-sm text-primary hover:text-primary/80 ml-auto transition-colors"
                   href="{{ route('password.request') }}">
                    {{ __('auth.forgot_password') }}
                </a>
            </div>

            <x-captcha :form="'login'" />
            <x-button.primary class="w-full mt-2" type="submit">{{ __('auth.sign_in') }}</x-button.primary>

            @if (config('settings.oauth_github') || config('settings.oauth_google') || config('settings.oauth_discord'))
            <div class="flex flex-col items-center mt-3">
                <div class="my-4 flex items-center w-full">
                    <span class="h-px grow bg-neutral/20"></span>
                    <span class="mh-mono px-3 py-1 text-[10px] uppercase tracking-[0.10em] text-muted">{{ __('auth.or_sign_in_with') }}</span>
                    <span class="h-px grow bg-neutral/20"></span>
                </div>
                <div class="flex flex-row flex-wrap justify-center gap-3">
                    @foreach (['github', 'google', 'discord'] as $provider)
                    @if (config('settings.oauth_' . $provider))
                    <a href="{{ route('oauth.redirect', $provider) }}"
                       class="flex items-center justify-center px-5 h-10 bg-background border border-neutral/30 rounded-lg text-muted hover:border-primary/40 hover:text-base transition-all">
                        <img src="/assets/images/{{ $provider }}-dark.svg" alt="{{ $provider }}" class="size-5 mr-2">
                        {{ __(ucfirst($provider)) }}
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif

            @if(!config('settings.registration_disabled', false))
            <div class="text-center py-1 mt-3 text-sm text-muted">
                {{ __('auth.dont_have_account') }}
                <a class="text-primary hover:text-primary/80 font-semibold transition-colors" href="{{ route('register') }}" wire:navigate>
                    {{ __('auth.sign_up') }}
                </a>
            </div>
            @endif
        </form>
    </div>
</div>
