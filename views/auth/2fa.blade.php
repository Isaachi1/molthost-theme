{{-- MoltHost — 2FA Verification --}}
<section class="container max-w-lg py-14">
    <div class="bg-background-secondary border border-neutral/20 rounded-2xl shadow-[0_30px_80px_-20px_hsl(0_0%_0%_/_0.40)]">
        <div class="flex flex-col items-center gap-2 p-5 sm:p-8 md:p-12">
            <div class="mh-chip mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse-slow"></span>
                molt://auth · 2fa
            </div>
            <div class="flex items-center justify-center mb-3 w-14 h-14 bg-primary/10 rounded-2xl border border-primary/20">
                <x-ri-lock-password-fill class="size-7 text-primary" />
            </div>
            <h1 class="mb-2 text-2xl md:text-3xl font-medium tracking-tight">{{ __('auth.verify_2fa') }}</h1>
            <p class="mb-6 text-muted text-center">{{ __('account.input.two_factor_code') }}</p>
            <form x-on:submit.prevent="submit"
                x-data="{
                    isNumber(value) { return value.match(/^[0-9]$/g); },
                    getCode() { return [$refs.num1.value,$refs.num2.value,$refs.num3.value,$refs.num4.value,$refs.num5.value,$refs.num6.value].join(''); },
                    submit() { let code = this.getCode(); @this.set('code', code).then(() => { $wire.verify(); }); },
                    fillInputs(val) { $refs.num1.value=val[0]||'';$refs.num2.value=val[1]||'';$refs.num3.value=val[2]||'';$refs.num4.value=val[3]||'';$refs.num5.value=val[4]||'';$refs.num6.value=val[5]||''; },
                    handlePaste(e) { let num=e.clipboardData.getData('text/plain').trim(); if(num.length===6&&num.match(/^[0-9]+$/g)){e.preventDefault();this.fillInputs(num);this.submit();} },
                    handleAutofill(e) { let val=e.target.value; if(val.length===6){this.fillInputs(val);this.submit();}else{if(val.length>1)e.target.value=val.charAt(0);if(this.isNumber(e.target.value))$refs.num2.focus();else e.target.value='';} }
                }" class="space-y-6">
                <div class="inline-flex items-center gap-1.5" wire:ignore>
                    <input x-ref="num1" id="otp-input" autocomplete="one-time-code" x-on:input="handleAutofill($event)" x-on:paste="handlePaste" type="text" autofocus class="block w-10 h-12 rounded-xl border border-neutral/30 px-2 py-1.5 text-center text-lg focus:border-primary focus:ring-1 focus:ring-primary/30 focus:outline-none bg-background" />
                    <input x-ref="num2" x-on:input="isNumber($refs.num2.value)?$refs.num3.focus():$refs.num2.value=''" x-on:keydown.backspace="$refs.num2.value===''?$refs.num1.focus():null" type="text" maxlength="1" class="block w-10 h-12 rounded-xl border border-neutral/30 px-2 py-1.5 text-center text-lg focus:border-primary focus:ring-1 focus:ring-primary/30 focus:outline-none bg-background" />
                    <input x-ref="num3" x-on:input="isNumber($refs.num3.value)?$refs.num4.focus():$refs.num3.value=''" x-on:keydown.backspace="$refs.num3.value===''?$refs.num2.focus():null" type="text" maxlength="1" class="block w-10 h-12 rounded-xl border border-neutral/30 px-2 py-1.5 text-center text-lg focus:border-primary focus:ring-1 focus:ring-primary/30 focus:outline-none bg-background" />
                    <span class="text-base/30 text-lg">-</span>
                    <input x-ref="num4" x-on:input="isNumber($refs.num4.value)?$refs.num5.focus():$refs.num4.value=''" x-on:keydown.backspace="$refs.num4.value===''?$refs.num3.focus():null" type="text" maxlength="1" class="block w-10 h-12 rounded-xl border border-neutral/30 px-2 py-1.5 text-center text-lg focus:border-primary focus:ring-1 focus:ring-primary/30 focus:outline-none bg-background" />
                    <input x-ref="num5" x-on:input="isNumber($refs.num5.value)?$refs.num6.focus():$refs.num5.value=''" x-on:keydown.backspace="$refs.num5.value===''?$refs.num4.focus():null" type="text" maxlength="1" class="block w-10 h-12 rounded-xl border border-neutral/30 px-2 py-1.5 text-center text-lg focus:border-primary focus:ring-1 focus:ring-primary/30 focus:outline-none bg-background" />
                    <input x-ref="num6" x-on:input="if(isNumber($refs.num6.value)){if(getCode().length===6)submit();}else{$refs.num6.value=''}" x-on:keydown.backspace="$refs.num6.value===''?$refs.num5.focus():null" type="text" maxlength="1" class="block w-10 h-12 rounded-xl border border-neutral/30 px-2 py-1.5 text-center text-lg focus:border-primary focus:ring-1 focus:ring-primary/30 focus:outline-none bg-background" />
                </div>
                @error('code')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
                <div class="mt-2"><x-button.primary type="submit">{{ __('auth.verify') }}</x-button.primary></div>
            </form>
        </div>
    </div>
</section>
