<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Information
    |--------------------------------------------------------------------------
    */
    'site_name' => env('SEO_SITE_NAME', 'Cateto'),
    'site_description' => env('SEO_SITE_DESCRIPTION', 'Portfolio - Technológiai megoldások egyedi igényekre szabva'),
    'site_url' => env('APP_URL', 'https://yourwebsite.com'),

    /*
    |--------------------------------------------------------------------------
    | Organization Information (Schema.org)
    |--------------------------------------------------------------------------
    */
    'organization' => [
        'name' => env('ORG_NAME', 'Cateto'),
        'legal_name' => env('ORG_LEGAL_NAME', 'Cateto Kft.'),
        'description' => env('ORG_DESCRIPTION', 'Webes megoldások, AI integráció és grafikai szolgáltatások'),
        'logo' => '/images/logo.png',
        'founded_year' => env('ORG_FOUNDED', '1999'),

        // Kapcsolati információk
        'email' => env('ORG_EMAIL', null), // pl: info@cateto.hu
        'phone' => env('ORG_PHONE', null), // pl: +36 1 234 5678
        'address' => [
            'street' => env('ORG_ADDRESS_STREET', null),
            'city' => env('ORG_ADDRESS_CITY', null),
            'postal_code' => env('ORG_ADDRESS_POSTAL', null),
            'country' => env('ORG_ADDRESS_COUNTRY', 'HU'),
        ],

        // Social Media
        'social_media' => [
            'facebook' => env('SOCIAL_FACEBOOK', null),
            'twitter' => env('SOCIAL_TWITTER', null),
            'linkedin' => env('SOCIAL_LINKEDIN', null),
            'instagram' => env('SOCIAL_INSTAGRAM', null),
            'youtube' => env('SOCIAL_YOUTUBE', null),
            'github' => env('SOCIAL_GITHUB', null),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Meta Tags
    |--------------------------------------------------------------------------
    */
    'meta' => [
        'author' => env('SEO_AUTHOR', 'Cateto'),
        'robots' => env('SEO_ROBOTS', 'index, follow'),
        'og_image' => env('SEO_OG_IMAGE', '/images/og-default.jpg'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Google & Analytics
    |--------------------------------------------------------------------------
    */
    'google' => [
        'analytics_id' => env('GOOGLE_ANALYTICS_ID', null), // G-XXXXXXXXXX
        'tag_manager_id' => env('GOOGLE_TAG_MANAGER_ID', null), // GTM-XXXXXXX
        'site_verification' => env('GOOGLE_SITE_VERIFICATION', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap Configuration
    |--------------------------------------------------------------------------
    */
    'sitemap' => [
        'cache_enabled' => env('SITEMAP_CACHE', true),
        'cache_duration' => env('SITEMAP_CACHE_DURATION', 3600), // másodpercben
    ],

];
