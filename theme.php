<?php

/**
 * Raze / MoltHost — Tech-premium DB & LLM hosting UI
 *
 * Vibe: lobster red on warm near-black · Geist sans/mono · pixel-art mascot ·
 * shells vocabulary · São Paulo first.
 */

require_once __DIR__ . '/src/molthost-helpers.php';

return [
    'name' => 'molthost',
    'author' => 'contact@molthost.com.br',
    'url' => 'https://paymenter.org',

    'settings' => [
        // ─── Display Options ───────────────────────────────────
        [
            'name' => 'direct_checkout',
            'label' => 'Direct Checkout',
            'type' => 'checkbox',
            'default' => false,
            'database_type' => 'boolean',
            'description' => 'Don\'t show the product overview page, go directly to the checkout page',
        ],
        [
            'name' => 'small_images',
            'label' => 'Small Images',
            'type' => 'checkbox',
            'default' => false,
            'database_type' => 'boolean',
            'description' => 'Show small images in the product overview page',
        ],
        [
            'name' => 'show_category_description',
            'label' => 'Show Category Description',
            'type' => 'checkbox',
            'default' => true,
            'database_type' => 'boolean',
            'description' => 'Show the category description in the product overview page/homepage',
        ],
        [
            'name' => 'logo_display',
            'label' => 'Logo display',
            'type' => 'select',
            'options' => [
                'logo-only' => 'Logo only',
                'logo-and-name' => 'Logo and Name',
            ],
            'default' => 'logo-and-name',
        ],
        [
            'name' => 'hero_variant',
            'label' => 'Hero variant',
            'type' => 'select',
            'options' => [
                'split' => 'Split — copy + terminal',
                'terminal' => 'Centered — big headline',
                'manifesto' => 'Manifesto — editorial',
            ],
            'default' => 'split',
            'description' => 'Three personalities for the landing hero — pick one.',
        ],

        // ─── Hero Section ──────────────────────────────────────
        [
            'name' => 'hero_eyebrow',
            'label' => 'Hero Eyebrow',
            'type' => 'text',
            'default' => 'v3 · GPU-backed Postgres now in São Paulo',
        ],
        [
            'name' => 'hero_title',
            'label' => 'Hero Title (HTML allowed)',
            'type' => 'text',
            'default' => 'Databases and LLMs that <em>molt</em> instead of break.',
        ],
        [
            'name' => 'hero_subtitle',
            'label' => 'Hero Subtitle',
            'type' => 'text',
            'default' => 'Managed Postgres, vector stores and open-source LLM inference on bare metal. Scale by shedding shells, not by adding meetings.',
        ],
        [
            'name' => 'hero_cta_text',
            'label' => 'Hero CTA Button Text',
            'type' => 'text',
            'default' => 'Deploy in 90 seconds',
        ],
        [
            'name' => 'hero_secondary_cta',
            'label' => 'Hero Secondary CTA',
            'type' => 'text',
            'default' => 'Browse plans',
        ],
        [
            'name' => 'home_page_text',
            'label' => 'Home Page Text',
            'type' => 'markdown',
            'default' => 'Pick a **shell** size. Swap to the next one when you outgrow it — no migration weekend, no incident report.',
        ],

        // ─── Hero Metrics ──────────────────────────────────────
        [
            'name' => 'metric_1_value',
            'label' => 'Metric 1 Value',
            'type' => 'text',
            'default' => '99.99%',
        ],
        [
            'name' => 'metric_1_label',
            'label' => 'Metric 1 Label',
            'type' => 'text',
            'default' => 'Uptime SLA',
        ],
        [
            'name' => 'metric_2_value',
            'label' => 'Metric 2 Value',
            'type' => 'text',
            'default' => '1.8ms',
        ],
        [
            'name' => 'metric_2_label',
            'label' => 'Metric 2 Label',
            'type' => 'text',
            'default' => 'p99 query latency',
        ],
        [
            'name' => 'metric_3_value',
            'label' => 'Metric 3 Value',
            'type' => 'text',
            'default' => 'R$ 0',
        ],
        [
            'name' => 'metric_3_label',
            'label' => 'Metric 3 Label',
            'type' => 'text',
            'default' => 'Egress fees',
        ],
        [
            'name' => 'metric_4_value',
            'label' => 'Metric 4 Value',
            'type' => 'text',
            'default' => '≤ 90s',
        ],
        [
            'name' => 'metric_4_label',
            'label' => 'Metric 4 Label',
            'type' => 'text',
            'default' => 'Time to provision',
        ],

        // ─── Features Section ──────────────────────────────────
        [
            'name' => 'feature_1_title',
            'label' => 'Feature 1 Title',
            'type' => 'text',
            'default' => 'Managed Postgres',
        ],
        [
            'name' => 'feature_1_description',
            'label' => 'Feature 1 Description',
            'type' => 'text',
            'default' => 'Postgres 16 with pgvector and postgis preinstalled. Backups, PITR and replicas — included.',
        ],
        [
            'name' => 'feature_2_title',
            'label' => 'Feature 2 Title',
            'type' => 'text',
            'default' => 'LLM inference',
        ],
        [
            'name' => 'feature_2_description',
            'label' => 'Feature 2 Description',
            'type' => 'text',
            'default' => 'Open weights on dedicated GPUs. OpenAI-shaped API. Llama, Mistral, Qwen, DeepSeek — by the minute.',
        ],
        [
            'name' => 'feature_3_title',
            'label' => 'Feature 3 Title',
            'type' => 'text',
            'default' => 'Bare-metal performance',
        ],
        [
            'name' => 'feature_3_description',
            'label' => 'Feature 3 Description',
            'type' => 'text',
            'default' => 'NVMe-backed storage and AMD EPYC compute. No noisy neighbors, no surprise throttling.',
        ],
        [
            'name' => 'feature_4_title',
            'label' => 'Feature 4 Title',
            'type' => 'text',
            'default' => 'Molting, not migrating',
        ],
        [
            'name' => 'feature_4_description',
            'label' => 'Feature 4 Description',
            'type' => 'text',
            'default' => 'Swap shells with zero downtime. We script the molt, you keep shipping.',
        ],
        [
            'name' => 'feature_5_title',
            'label' => 'Feature 5 Title',
            'type' => 'text',
            'default' => 'São Paulo first',
        ],
        [
            'name' => 'feature_5_description',
            'label' => 'Feature 5 Description',
            'type' => 'text',
            'default' => 'sa-east-1 in SP, plus Ashburn and Frankfurt. Brazilian latency, not an afterthought.',
        ],
        [
            'name' => 'feature_6_title',
            'label' => 'Feature 6 Title',
            'type' => 'text',
            'default' => 'Honest billing',
        ],
        [
            'name' => 'feature_6_description',
            'label' => 'Feature 6 Description',
            'type' => 'text',
            'default' => 'Billed by the minute. No per-seat fees. No silent overage. Cancel by deleting.',
        ],

        // ─── Social Links ──────────────────────────────────────
        [
            'name' => 'discord_url',
            'label' => 'Discord URL',
            'type' => 'text',
            'default' => '',
        ],
        [
            'name' => 'instagram_url',
            'label' => 'Instagram URL',
            'type' => 'text',
            'default' => '',
        ],
        [
            'name' => 'twitter_url',
            'label' => 'Twitter / X URL',
            'type' => 'text',
            'default' => '',
        ],

        /*
        | MoltHost palette — lobster red on warm near-black.
        | HSL approximations of the design's oklch tokens
        | (oklch 0.64 0.205 28 → roughly hsl(10, 82%, 56%)).
        */

        // ─── Colors (Light) ────────────────────────────────────
        [
            'name' => 'primary',
            'label' => 'Primary — Lobster Red (Light)',
            'type' => 'color',
            'default' => 'hsl(10, 82%, 56%)',
        ],
        [
            'name' => 'secondary',
            'label' => 'Secondary (Light)',
            'type' => 'color',
            'default' => 'hsl(210, 12%, 22%)',
        ],
        [
            'name' => 'neutral',
            'label' => 'Borders, Accents… (Light)',
            'type' => 'color',
            'default' => 'hsl(30, 12%, 86%)',
        ],
        [
            'name' => 'base',
            'label' => 'Base — Text Color (Light)',
            'type' => 'color',
            'default' => 'hsl(22, 18%, 12%)',
        ],
        [
            'name' => 'muted',
            'label' => 'Muted — Text Color (Light)',
            'type' => 'color',
            'default' => 'hsl(30, 10%, 45%)',
        ],
        [
            'name' => 'inverted',
            'label' => 'Inverted — Text Color (Light)',
            'type' => 'color',
            'default' => 'hsl(40, 12%, 98%)',
        ],
        [
            'name' => 'background',
            'label' => 'Background (Light)',
            'type' => 'color',
            'default' => 'hsl(40, 18%, 96%)',
        ],
        [
            'name' => 'background-secondary',
            'label' => 'Background Secondary (Light)',
            'type' => 'color',
            'default' => 'hsl(40, 14%, 92%)',
        ],

        // ─── Colors (Dark) ─────────────────────────────────────
        [
            'name' => 'dark-primary',
            'label' => 'Primary — Lobster Red (Dark)',
            'type' => 'color',
            'default' => 'hsl(10, 82%, 58%)',
        ],
        [
            'name' => 'dark-secondary',
            'label' => 'Secondary (Dark)',
            'type' => 'color',
            'default' => 'hsl(22, 10%, 26%)',
        ],
        [
            'name' => 'dark-neutral',
            'label' => 'Borders, Accents… (Dark)',
            'type' => 'color',
            'default' => 'hsl(22, 8%, 22%)',
        ],
        [
            'name' => 'dark-base',
            'label' => 'Base — Text Color (Dark)',
            'type' => 'color',
            'default' => 'hsl(40, 12%, 96%)',
        ],
        [
            'name' => 'dark-muted',
            'label' => 'Muted — Text Color (Dark)',
            'type' => 'color',
            'default' => 'hsl(32, 8%, 64%)',
        ],
        [
            'name' => 'dark-inverted',
            'label' => 'Inverted — Text Color (Dark)',
            'type' => 'color',
            'default' => 'hsl(22, 18%, 8%)',
        ],
        [
            'name' => 'dark-background',
            'label' => 'Background (Dark) — warm near-black',
            'type' => 'color',
            'default' => 'hsl(22, 14%, 6%)',
        ],
        [
            'name' => 'dark-background-secondary',
            'label' => 'Background Secondary (Dark)',
            'type' => 'color',
            'default' => 'hsl(22, 12%, 9%)',
        ],
    ],
];
