@php
    $orgSchema = array_filter([
        '@context'    => 'https://schema.org',
        '@type'       => 'Organization',
        'name'        => config('seo.organization.name'),
        'legalName'   => config('seo.organization.legal_name'),
        'description' => config('seo.organization.description'),
        'url'         => config('seo.site_url'),
        'logo'        => [
            '@type'  => 'ImageObject',
            'url'    => asset(config('seo.organization.logo')),
            'width'  => 600,
            'height' => 600,
        ],
        'foundingDate' => config('seo.organization.founded_year'),
        'email'        => config('seo.organization.email') ?: null,
        'telephone'    => config('seo.organization.phone') ?: null,
        'sameAs'       => array_values(array_filter(config('seo.organization.social_media', []))) ?: null,
        'address'      => config('seo.organization.address.street') ? [
            '@type'           => 'PostalAddress',
            'streetAddress'   => config('seo.organization.address.street'),
            'addressLocality' => config('seo.organization.address.city'),
            'postalCode'      => config('seo.organization.address.postal_code'),
            'addressCountry'  => config('seo.organization.address.country'),
        ] : null,
        'contactPoint' => array_filter([
            '@type'             => 'ContactPoint',
            'contactType'       => 'customer service',
            'availableLanguage' => ['Hungarian', 'English'],
            'email'             => config('seo.organization.email') ?: null,
            'telephone'         => config('seo.organization.phone') ?: null,
        ]),
    ]);
@endphp
<script type="application/ld+json">
{!! json_encode($orgSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
