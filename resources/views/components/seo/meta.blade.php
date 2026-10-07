{{--
    Meta tags de SEO, Open Graph (Facebook, WhatsApp, LinkedIn) y Twitter/X.
    Las páginas los definen con las props del layout:

    <x-layouts.app title="..." description="..." image="images/..." canonical="..." />
--}}
@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'imageAlt' => null,
    'canonical' => null,
    'type' => 'website',
    'noindex' => false,
])

@use('App\Support\Seo')

@php
    $seo = config('losos.seo');
    $siteName = config('losos.name');
    $fullTitle = $title ? $title.' | '.$siteName : $siteName.' | '.config('losos.tagline');
    $description = Seo::description($description);
    $canonical ??= url()->current();
    $og = Seo::image($image) ?? Seo::image($seo['image']);
    $imageAlt ??= $image ? ($title ?? $siteName) : $seo['image_alt'];
    $indexable = $seo['indexable'] && ! $noindex;
@endphp

<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $indexable ? 'index, follow, max-image-preview:large' : 'noindex, nofollow' }}">
<link rel="canonical" href="{{ $canonical }}">

{{-- Open Graph --}}
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="{{ $seo['locale'] }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:title" content="{{ $title ?? $fullTitle }}">
<meta property="og:description" content="{{ $description }}">
@if ($og)
    <meta property="og:image" content="{{ $og['url'] }}">
    @if (str_starts_with($og['url'], 'https'))
        <meta property="og:image:secure_url" content="{{ $og['url'] }}">
    @endif
    @if ($og['width'])
        <meta property="og:image:width" content="{{ $og['width'] }}">
        <meta property="og:image:height" content="{{ $og['height'] }}">
    @endif
    <meta property="og:image:alt" content="{{ $imageAlt }}">
@endif

{{-- Twitter / X --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ?? $fullTitle }}">
<meta name="twitter:description" content="{{ $description }}">
@if ($og)
    <meta name="twitter:image" content="{{ $og['url'] }}">
    <meta name="twitter:image:alt" content="{{ $imageAlt }}">
@endif
@if ($seo['twitter'])
    <meta name="twitter:site" content="{{ $seo['twitter'] }}">
@endif

{{-- Íconos y color del navegador --}}
<meta name="theme-color" content="{{ $seo['theme_color'] }}">
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
<link rel="icon" href="{{ asset('images/seo/icon-192.png') }}" type="image/png" sizes="192x192">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">

{{-- Datos estructurados --}}
<x-seo.json-ld :data="Seo::business()" />
<x-seo.json-ld :data="Seo::website()" />
