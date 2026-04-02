<!doctype html>
<html lang="hu" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cateto - Portfolio')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Portfolio - Technológiai megoldások egyedi igényekre szabva')" />
    @hasSection('keywords')
    <meta name="keywords" content="@yield('keywords')" />
    @endif
    <meta name="author" content="Cateto" />
    <meta name="robots" content="index, follow" />
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Open Graph Meta Tags (Facebook, LinkedIn) -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title', 'Cateto - Portfolio')" />
    <meta property="og:description" content="@yield('description', 'Portfolio - Technológiai megoldások egyedi igényekre szabva')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="Cateto" />
    @hasSection('og_image')
    <meta property="og:image" content="@yield('og_image')" />
    @else
    <meta property="og:image" content="{{ asset('images/og-default.jpg') }}" />
    @endif

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('title', 'Cateto - Portfolio')" />
    <meta name="twitter:description" content="@yield('description', 'Portfolio - Technológiai megoldások egyedi igényekre szabva')" />
    @hasSection('og_image')
    <meta name="twitter:image" content="@yield('og_image')" />
    @else
    <meta name="twitter:image" content="{{ asset('images/og-default.jpg') }}" />
    @endif

    <!-- Structured Data (Schema.org JSON-LD) -->
    {{-- Organization Schema (Global) --}}
    @include('components.structured-data.organization')

    @hasSection('schema')
    @yield('schema')
    @else
    @php
    $websiteSchema = [
        '@context'  => 'https://schema.org',
        '@type'     => 'WebSite',
        'name'      => config('seo.site_name'),
        'url'       => config('seo.site_url'),
        'description' => config('seo.site_description'),
        'inLanguage'  => 'hu-HU',
        'publisher'   => [
            '@type' => 'Organization',
            'name'  => config('seo.organization.name'),
            'url'   => config('seo.site_url'),
            'logo'  => [
                '@type'  => 'ImageObject',
                'url'    => asset(config('seo.organization.logo')),
                'width'  => 600,
                'height' => 600,
            ],
        ],
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => ['@type' => 'EntryPoint', 'urlTemplate' => config('seo.site_url') . '?q={search_term_string}'],
            'query-input' => 'required name=search_term_string',
        ],
    ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($websiteSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    />

    <!-- Quill CSS for WYSIWYG Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('assets/main.css') }}" rel="stylesheet">

    <!-- Vendor Libraries (ezeknek előbb kell betöltődniük mint a main.js) -->
    <script src="{{ asset('vendor/swiper.min.js') }}"></script>
    <script src="{{ asset('vendor/leaflet.min.js') }}"></script>
    <script src="{{ asset('vendor/vanilla-infinite-marquee.min.js') }}"></script>
    <script src="{{ asset('vendor/split-text.min.js') }}"></script>
    <script src="{{ asset('vendor/gsap.min.js') }}"></script>
    <script src="{{ asset('vendor/scroll-trigger.min.js') }}"></script>
    <script src="{{ asset('vendor/draw-svg.min.js') }}"></script>
    <script src="{{ asset('vendor/motionpathplugin.min.js') }}"></script>
    <script src="{{ asset('vendor/lenis.min.js') }}"></script>
    <script src="{{ asset('vendor/springer.min.js') }}"></script>
    <script src="{{ asset('vendor/number-counter.js') }}"></script>
    <script src="{{ asset('vendor/stack-card.min.js') }}"></script>

    <!-- Vite Development Mode -->
    <script type="module">
        import.meta.hot?.accept()
    </script>
    <script type="module" src="{{ asset('assets/main.js') }}"></script>
</head>
<body class="bg-background-8">

    @yield('content')

    <!-- Particle Network Animation Script -->
    <script src="{{ asset('assets/js/particle-network.js') }}"></script>
</body>
</html>
