@props([
    'title' => null,
    'description' => null,
    'image' => null,       // imagen para compartir en redes (ruta en /public o URL)
    'imageAlt' => null,
    'canonical' => null,
    'noindex' => false,
    'header' => 'solid',   // solid | transparent
])

<!DOCTYPE html>
<html lang="{{ config('losos.seo.lang') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Activa las animaciones de scroll antes de pintar (evita parpadeo) --}}
    <script>document.documentElement.classList.add('has-reveal')</script>

    <x-seo.meta
        :title="$title"
        :description="$description"
        :image="$image"
        :image-alt="$imageAlt"
        :canonical="$canonical"
        :noindex="$noindex" />

    @stack('schema')

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
