{{-- Raze / MoltHost — Dynamic CSS Variables --}}
<style>
    :root {
        /* Branding Colors (Light) */
        --c-primary: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('primary', '10 82% 56%'))) }};
        --c-secondary: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('secondary', '210 12% 22%'))) }};

        /* Neutral Colors (Light) */
        --c-neutral: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('neutral', '30 12% 86%'))) }};

        /* Text Colors (Light) */
        --c-base: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('base', '22 18% 12%'))) }};
        --c-muted: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('muted', '30 10% 45%'))) }};
        --c-inverted: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('inverted', '40 12% 98%'))) }};

        /* State Colors */
        --c-success: 152 56% 50%;
        --c-error: 0 78% 56%;
        --c-warning: 38 92% 58%;
        --c-inactive: 0 0% 63%;
        --c-info: 218 68% 60%;

        /* Background Colors (Light) */
        --c-background: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('background', '40 18% 96%'))) }};
        --c-background-secondary: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('background-secondary', '40 14% 92%'))) }};

        /* MoltHost shared (theme-agnostic) */
        --mh-lobster-soft: hsl(var(--c-primary) / 0.18);
        --mh-lobster-wash: hsl(var(--c-primary) / 0.08);
        --mh-lobster-deep: hsl(var(--c-primary) / 0.80);
        --mh-lobster-bright: hsl(8 92% 68%);
    }

    .dark {
        /* Branding Colors (Dark) */
        --c-primary: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('dark-primary', '10 82% 58%'))) }};
        --c-secondary: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('dark-secondary', '22 10% 26%'))) }};

        /* Neutral Colors (Dark) */
        --c-neutral: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('dark-neutral', '22 8% 22%'))) }};

        /* Text Colors (Dark) */
        --c-base: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('dark-base', '40 12% 96%'))) }};
        --c-muted: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('dark-muted', '32 8% 64%'))) }};
        --c-inverted: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('dark-inverted', '22 18% 8%'))) }};

        /* Background Colors (Dark) — warm near-black */
        --c-background: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('dark-background', '22 14% 6%'))) }};
        --c-background-secondary: {{ str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', theme('dark-background-secondary', '22 12% 9%'))) }};

        --mh-lobster-soft: hsl(var(--c-primary) / 0.22);
        --mh-lobster-wash: hsl(var(--c-primary) / 0.12);
        --mh-lobster-bright: hsl(12 90% 70%);
    }
</style>
