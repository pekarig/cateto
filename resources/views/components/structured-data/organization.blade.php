{{-- Organization Schema.org JSON-LD --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "{{ config('seo.organization.name') }}",
    "legalName": "{{ config('seo.organization.legal_name') }}",
    "description": "{{ config('seo.organization.description') }}",
    "url": "{{ config('seo.site_url') }}",
    "logo": {
        "@type": "ImageObject",
        "url": "{{ asset(config('seo.organization.logo')) }}",
        "width": 600,
        "height": 600
    },
    "foundingDate": "{{ config('seo.organization.founded_year') }}",
    @if(config('seo.organization.email'))
    "email": "{{ config('seo.organization.email') }}",
    @endif
    @if(config('seo.organization.phone'))
    "telephone": "{{ config('seo.organization.phone') }}",
    @endif
    @php
        $socialLinks = array_filter(config('seo.organization.social_media', []));
    @endphp
    @if(!empty($socialLinks))
    "sameAs": [
        @foreach($socialLinks as $platform => $url)
        "{{ $url }}"@if(!$loop->last),@endif
        @endforeach
    ],
    @endif
    @if(config('seo.organization.address.street'))
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ config('seo.organization.address.street') }}",
        "addressLocality": "{{ config('seo.organization.address.city') }}",
        "postalCode": "{{ config('seo.organization.address.postal_code') }}",
        "addressCountry": "{{ config('seo.organization.address.country') }}"
    },
    @endif
    "contactPoint": {
        "@type": "ContactPoint",
        "contactType": "customer service",
        "availableLanguage": ["Hungarian", "English"]
        @if(config('seo.organization.email'))
        ,"email": "{{ config('seo.organization.email') }}"
        @endif
        @if(config('seo.organization.phone'))
        ,"telephone": "{{ config('seo.organization.phone') }}"
        @endif
    }
}
</script>
