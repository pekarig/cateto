<!doctype html>
<html lang="hu" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cateto - Portfolio')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Portfolio - Technológiai megoldások egyedi igényekre szabva')" />
    <meta name="author" content="Cateto" />
    <meta name="robots" content="index, follow" />

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
