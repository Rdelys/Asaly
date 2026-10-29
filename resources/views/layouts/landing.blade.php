<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', $appName)</title>
    <meta name="description" content="@yield('description', 'Gérez vos projets, votre temps et vos factures dans un seul outil.')">
    <meta name="theme-color" content="#050b24">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('logo.png') }}">
    <link rel="sitemap" type="application/xml" href="{{ url('/sitemap.xml') }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $appName }}">
    <meta property="og:title" content="@yield('title', $appName)">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:image" content="{{ asset('logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary">

    <script>document.documentElement.classList.add('js')</script>
    <link rel="preload" as="image" href="{{ asset('logo.png') }}">

    {{-- Font Awesome (icônes) --}}
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v={{ filemtime(public_path('css/landing.css')) }}">

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@graph' => array_merge([
            ['@type' => 'Organization', 'name' => $appName, 'url' => url('/'), 'logo' => asset('logo.png'), 'email' => $contactEmail],
            ['@type' => 'WebSite', 'name' => $appName, 'url' => url('/')],
        ], collect([
            'Fonctionnalités' => '#fonctionnalites', 'Jouer' => '#demo', 'Comment ça marche' => '#comment', 'À propos' => '#apropos',
            'Tarifs' => '#tarifs', 'FAQ' => '#faq', 'Contact' => '#contact',
        ])->map(fn ($anchor, $name) => [
            '@type' => 'SiteNavigationElement', 'name' => $name, 'url' => url('/') . $anchor,
        ])->values()->all()),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    @stack('head')
</head>
<body>
    <a class="skip" href="#contenu">Aller au contenu</a>

    {{-- Rideau d'intro bleu / rouge (CSS pur, se retire tout seul) --}}
    <div class="curtain" aria-hidden="true"><span></span><span></span></div>

    <div class="scroll-progress" id="sp" aria-hidden="true"></div>
    <div class="cursor-glow" id="cg" aria-hidden="true"></div>
    <canvas class="fx" id="fx" aria-hidden="true"></canvas>

    @include('partials.landing.navbar')

    <main id="contenu">
        @yield('content')
    </main>

    @include('partials.landing.footer')

    <script src="{{ asset('js/landing.js') }}?v={{ filemtime(public_path('js/landing.js')) }}" defer></script>
    @stack('scripts')
</body>
</html>