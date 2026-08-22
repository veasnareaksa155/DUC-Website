<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Digital University of Cambodia') }}</title>
    <link rel="icon" type="image/png" href="/favicon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Battambang:wght@400;700&family=Siemreap&family=Moul&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @php
        $pageData = json_decode(request()->route()->action['middleware'][0] ?? '{}', true); // Fallback
        $settings = $page['props']['settings'] ?? [];
        $globalBg = $settings['global_bg_color'] ?? '#c9e0e4';
        $cardBg = $settings['card_bg_color'] ?? '#ffffff';
        $btnPrimary = $settings['primary_button_color'] ?? '#104652';
        $btnPrimaryHover = $settings['primary_button_hover'] ?? '#316d7a';
    @endphp
    <style>
        :root {
            --global-bg: {{ $globalBg }};
            --card-bg: {{ $cardBg }};
            --btn-primary: {{ $btnPrimary }};
            --btn-primary-hover: {{ $btnPrimaryHover }};
        }
    </style>
    @inertiaHead
</head>

<body class="font-sans antialiased bg-global-bg text-slate-900 selection:bg-amber-400 selection:text-slate-900 transition-colors duration-300">
    @inertia
</body>

</html>
