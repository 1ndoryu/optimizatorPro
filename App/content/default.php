<?php

use Glory\Core\PostTypeManager;
use Glory\Manager\DefaultContentManager;

/**
 * ===================================================================
 * Custom Post Type (CPT) Definition: Portfolio
 * ===================================================================
 */
PostTypeManager::define(
    'portfolio',
    [
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => ['slug' => 'portfolio'],
        'menu_icon'   => 'dashicons-portfolio',
        'supports'    => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'labels'      => [
            'name'          => 'Portfolios',
            'singular_name' => 'Portfolio',
            'add_new_item'  => 'Add New Portfolio Item',
            'edit_item'     => 'Edit Portfolio Item',
            'new_item'      => 'New Portfolio Item',
            'view_item'     => 'View Portfolio Item',
            'all_items'     => 'All Portfolios',
        ],
    ],
    null,
    null,
    [
        // Se añade el nuevo campo meta por defecto para los nuevos posts.
        '_portfolio_metrics' => [],
        'short_description' => '' // <-- NUEVO CAMPO
    ]
);

PostTypeManager::register();

/**
 * ===================================================================
 * Default Content Definition for 'Portfolio'
 * ===================================================================
 */
DefaultContentManager::define(
    'portfolio',
    [
        // Sample Post 1
        [
            'slugDefault' => 'success-story-ecommerce-seo',
            'titulo'      => 'Fashion Ecommerce Store',
            // El contenido original ahora es la descripción corta.
            'metaEntrada' => [
                'short_description' => 'A detailed analysis of the On-Page SEO and content strategy implemented for an online fashion store. Over 200 product pages were optimized, and 15 strategic blog articles were created, resulting in a dramatic improvement in Google visibility.',
                '_portfolio_metrics' => [
                    ['label' => 'Position on Google', 'before' => '58', 'after' => '3'],
                    ['label' => 'Organic Traffic', 'before' => '1,200', 'after' => '7,200'],
                    ['label' => 'Bounce Rate', 'before' => '75%', 'after' => '55%'],
                    ['label' => 'Conversions', 'before' => '15', 'after' => '45'],
                ]
            ],
            // Nuevo contenido expandido.
            'contenido'   => "The project began with a comprehensive technical SEO audit to identify and rectify issues such as crawl errors, slow page speed, and improper schema markup. We restructured the site's URL hierarchy for better logical flow and keyword relevance, ensuring search engines could efficiently index the entire product catalog.

Our content strategy focused on creating a 'topic cluster' around high-intent keywords, establishing the brand as an authority in the fashion niche. This involved producing long-form guides on seasonal trends, material care, and style matching, which not only attracted organic traffic but also provided genuine value to potential customers, building brand trust and loyalty.",
            'extracto'    => 'We managed to quintuple organic traffic and double conversions in just 6 months, bringing the client to the first page for their most important keywords.',
            'imagenDestacadaAsset' => 'glory::default1.jpg',
        ],
        // Sample Post 2
        [
            'slugDefault' => 'success-story-local-business-seo',
            'titulo'      => 'The Good Table Restaurant',
            'metaEntrada' => [
                'short_description' => 'Complete optimization of the Google Business Profile, review management, and local citation building. The strategy focused on geo-targeted keywords to attract customers within a 10km radius, positioning the restaurant in Google Maps\' "Local Pack".',
                '_portfolio_metrics' => [
                    ['label' => 'Position on Google', 'before' => 'Not Ranking', 'after' => 'Top 3'],
                    ['label' => 'Organic Traffic', 'before' => '350', 'after' => '1,400'],
                    ['label' => 'Bounce Rate', 'before' => '80%', 'after' => '62%'],
                    ['label' => 'Conversions', 'before' => '10', 'after' => '40'],
                ]
            ],
            'contenido'   => "Our local SEO approach started with a full cleanup of the restaurant's online citations, ensuring NAP (Name, Address, Phone Number) consistency across dozens of directories. We then fully optimized the Google Business Profile with high-quality photos, a keyword-rich description, Q&A seeding, and consistent weekly posts to engage local searchers.

To further boost local authority, we launched a review generation campaign that ethically encouraged satisfied customers to share their feedback on Google. This not only improved the restaurant's star rating but also provided fresh, user-generated content that Google's algorithm favors for local rankings. The results were a significant increase in local visibility and foot traffic.",
            'extracto'    => 'We increased calls from Google by 300% and direction requests by 250% in the first quarter.',
            'imagenDestacadaAsset' => 'glory::default2.jpg',
        ],
        // Sample Post 3
        [
            'slugDefault' => 'success-story-saas-seo',
            'titulo'      => 'SaaSify Pro',
            'metaEntrada' => [
                'short_description' => 'Development of a content marketing strategy based on topic clusters. Comprehensive guides, comparisons, and blog articles were created to solve the target audience\'s problems, attracting qualified traffic and generating leads.',
                '_portfolio_metrics' => [
                    ['label' => 'Position on Google', 'before' => '+100', 'after' => 'Top 5'],
                    ['label' => 'Organic Traffic', 'before' => '500', 'after' => '4,500'],
                    ['label' => 'Bounce Rate', 'before' => '85%', 'after' => '70%'],
                    ['label' => 'Conversions', 'before' => '5', 'after' => '28'],
                ]
            ],
            'contenido'   => "The challenge with SaaS SEO is to capture users at different stages of the buyer's journey. We structured our content strategy around three main pillars: 'problem-aware' articles for top-of-funnel traffic, 'solution-aware' comparisons for mid-funnel, and detailed 'product-aware' tutorials for bottom-of-funnel users ready to convert.

Each piece of content was interlinked to create a robust internal linking structure that passed authority to key landing pages. Additionally, we implemented a technical SEO strategy to ensure the site was perfectly optimized for speed and mobile use, which are critical ranking factors. This holistic approach transformed the company's blog from a simple marketing tool into a powerful lead generation engine.",
            'extracto'    => 'We increased organic leads by 150% and established the client as a thought leader in their market niche.',
            'imagenDestacadaAsset' => 'glory::default3.jpg',
        ],
    ],
    'smart'
);

DefaultContentManager::register();
