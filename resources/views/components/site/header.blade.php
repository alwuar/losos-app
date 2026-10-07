@props(['variant' => 'solid'])

<header class="site-header site-header--{{ $variant }}" data-site-header>
    <nav class="navbar navbar-expand-lg navbar-dark" aria-label="Navegación principal">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" aria-label="{{ config('losos.name') }} — Inicio">
                <x-brand.logo />
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#site-nav"
                    aria-controls="site-nav" aria-expanded="false" aria-label="Abrir menú">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="site-nav">
                <x-site.nav class="ms-auto" />

                <x-ui.whatsapp-button class="site-header__cta" />
            </div>
        </div>
    </nav>
</header>
