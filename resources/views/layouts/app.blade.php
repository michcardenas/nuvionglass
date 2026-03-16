<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta (overridable per page) --}}
    <title>@yield('title', 'nuvion - glass | Lentes con protección de luz azul')</title>
    <meta name="description" content="@yield('meta_description', 'Protege tus ojos de la luz azul con lentes nuvion glass. Con o sin graduación. Diseño moderno, envío gratis.')">

    {{-- Canonical --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'nuvion - glass')">
    <meta property="og:description" content="@yield('og_description', 'Lentes con protección de luz azul')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:site_name" content="nuvion - glass">
    <meta property="og:locale" content="es_MX">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', 'nuvion - glass')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Lentes con protección de luz azul')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-default.jpg'))">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/isotipo.png') }}">

    {{-- Google Fonts: IBM Plex Sans + Bai Jamjuree --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;500;600;700&family=IBM+Plex+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Schema.org JSON-LD --}}
    @stack('schema')

    {{-- Page-specific head content --}}
    @stack('head')
</head>

<body class="font-body min-h-screen flex flex-col antialiased @yield('body_class', 'bg-bg-light text-text-dark')">
    {{-- Skip to content (accessibility) --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-primary focus:text-white focus:px-4 focus:py-2 focus:rounded">
        Saltar al contenido
    </a>

    {{-- Navigation --}}
    @include('partials.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition class="fixed top-20 right-4 z-50 bg-success text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition class="fixed top-20 right-4 z-50 bg-danger text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Content --}}
    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Alpine x-reveal directive + vanilla reveal observer --}}
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.directive('reveal', (el, { modifiers }, { cleanup }) => {
            el.classList.add('reveal');
            const observer = new IntersectionObserver(
                ([entry]) => {
                    if (entry.isIntersecting) {
                        el.classList.add('visible');
                        if (modifiers.includes('once')) observer.disconnect();
                    }
                },
                { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
            );
            observer.observe(el);
            cleanup(() => observer.disconnect());
        });
    });
    /* Hero scroll-driven image gallery */
    window.heroGallery = () => ({
        current: 0,
        total: 8,
        onScroll() {
            const step = 120; // px de scroll por cambio de imagen
            this.current = Math.min(Math.floor(window.scrollY / step), this.total - 1);
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const items = document.querySelectorAll('.reveal');
        const obs = new IntersectionObserver(
            entries => entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); }),
            { threshold: 0.1, rootMargin: '0px 0px -30px 0px' }
        );
        items.forEach(el => obs.observe(el));
    });
    </script>

    @stack('scripts')
</body>
</html>
