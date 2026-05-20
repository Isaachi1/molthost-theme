{{-- MoltHost — Account profile --}}
<div class="container mt-10 pb-20 md:pb-12">
    <x-navigation.breadcrumb />

    <div class="mt-4 mb-8">
        <div class="mh-eyebrow mb-2">{{ __('molthost::messages.account.profile_eyebrow') }}</div>
        <h1 class="text-3xl md:text-4xl font-medium tracking-tight">{{ __('molthost::messages.account.profile_title') }}</h1>
        <p class="text-muted mt-1.5">{{ __('molthost::messages.account.profile_subtitle') }}</p>
    </div>

    <div class="bg-background-secondary border border-neutral/15 rounded-2xl p-6 md:p-8">
        <div class="grid md:grid-cols-2 gap-4">
            <x-form.input name="first_name" type="text" :label="__('general.input.first_name')"
                :placeholder="__('general.input.first_name_placeholder')" wire:model="first_name" required dirty />
            <x-form.input name="last_name" type="text" :label="__('general.input.last_name')"
                :placeholder="__('general.input.last_name_placeholder')" wire:model="last_name" required dirty />

            <x-form.input name="email" type="email" :label="__('general.input.email')"
                :placeholder="__('general.input.email_placeholder')" required wire:model="email" dirty divClass="col-span-1 md:col-span-2" />

            <x-form.properties :custom_properties="$custom_properties" :properties="$properties" dirty />
        </div>

        <x-button.primary wire:click="submit" class="!w-auto inline-flex mt-6">
            {{ __('general.update') }} <x-ri-arrow-right-line class="size-4" />
        </x-button.primary>
    </div>
</div>
