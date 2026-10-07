@props([
    'title' => null,
    'description' => config('losos.description'),
    'header' => 'solid', // solid | transparent
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title.' | '.config('losos.name') : config('losos.name').' | '.config('losos.tagline') }}</title>
    <meta name="description" content="{{ $description }}">

    <meta property="og:title" content="{{ $title ?? config('losos.name') }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="website">

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @stack('head')
</head>
<body {{ $attributes->class(['page']) }}>
    <x-site.header :variant="$header" />

    <main id="contenido" class="site-main">
        {{ $slot }}
    </main>

    <x-site.footer />

    @stack('scripts')
</body>
</html>
