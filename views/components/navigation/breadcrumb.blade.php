@php
    $currentRoute = request()->livewireUrl();
    $navigation = [
        \App\Classes\Navigation::getLinks(),
        \App\Classes\Navigation::getAccountDropdownLinks(),
        \App\Classes\Navigation::getDashboardLinks(),
    ];

    function findBreadcrumb($items, $currentRoute) {
        foreach ($items as $item) {
            if (isset($item['url']) && $item['url'] === $currentRoute) {
                return [$item];
            }
            if (!empty($item['children'])) {
                $childTrail = findBreadcrumb($item['children'], $currentRoute);
                if (!empty($childTrail)) {
                    return array_merge([$item], $childTrail);
                }
            }
        }
        return [];
    }

    $breadcrumbs = [];
    foreach ($navigation as $group) {
        $breadcrumbs = findBreadcrumb($group, $currentRoute);
        if (!empty($breadcrumbs)) break;
    }
@endphp

{{-- MoltHost — Breadcrumb (mono pathline) --}}
<nav class="flex flex-row items-center pb-1 mh-mono text-xs text-muted" aria-label="Breadcrumb">
    <a href="{{ route('home') }}" wire:navigate class="hover:text-primary transition-colors uppercase tracking-[0.08em]">~</a>
    @if (!empty($breadcrumbs))
        @foreach ($breadcrumbs as $index => $breadcrumb)
            <span class="mx-2 text-muted/50">/</span>
            @if ($index === count($breadcrumbs) - 1)
                <span class="text-base uppercase tracking-[0.08em]">{{ $breadcrumb['name'] ?? '' }}</span>
            @else
                <a href="{{ isset($breadcrumb['route']) ? route($breadcrumb['route'], $breadcrumb['params'] ?? []) : '#' }}"
                   class="hover:text-primary transition-colors uppercase tracking-[0.08em]">
                    {{ $breadcrumb['name'] ?? '' }}
                </a>
            @endif
        @endforeach
    @else
        <span class="mx-2 text-muted/50">/</span>
        <span class="text-base uppercase tracking-[0.08em]">{{ __('navigation.home') }}</span>
    @endif
</nav>
