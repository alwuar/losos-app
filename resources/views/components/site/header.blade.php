{{--
    Barra de navegación flotante (estilo cristal). variant: solid | transparent
    Estilos en scss/layout/_header.scss; comportamiento en js/modules/header.js
--}}
@props(['variant' => 'solid'])

<header class="site-header site-header--{{ $variant }}" data-site-header>
    <div class="container">
        <nav class="navbar navbar-expand-xl navbar-dark site-header__bar" aria-label="Navegación principal">
            <a class="navbar-brand" href="{{ route('home') }}" aria-label="{{ config('losos.name') }} — Inicio">
                <x-brand.logo />
            </a>

            <button class="navbar-toggler site-header__toggle" type="button" data-bs-toggle="collapse" data-bs-target="#site-nav"
                    aria-controls="site-nav" aria-expanded="false" aria-label="Abrir menú">
                <span></span><span></span><span></span>
            </button>

            <div class="collapse navbar-collapse" id="site-nav">
                <x-site.nav class="mx-auto" />

                <x-ui.whatsapp-button class="site-header__cta" />
            </div>
        </nav>
    </div>
</header>
