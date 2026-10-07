@php
    $contact = config('losos.contact');
    $office = config('losos.locations.office');
    $showroom = config('losos.locations.showroom');
@endphp

<footer class="site-footer">
    <div class="container">
        <div class="site-footer__grid">
            <div class="site-footer__brand">
                <a href="{{ route('home') }}" aria-label="{{ config('losos.name') }}">
                    <x-brand.logo />
                </a>

                <p class="site-footer__about">{{ config('losos.description') }}</p>

                <x-ui.social-links />
            </div>

            <x-site.footer-column title="Páginas">
                @foreach (config('losos.navigation') as $route => $label)
                    <li><a href="{{ route($route) }}">{{ $label }}</a></li>
                @endforeach
            </x-site.footer-column>

            <x-site.footer-column title="Productos">
                <li><a href="{{ route('products.index', 'maquinaria-muevetierra') }}">Maquinaria Muevetierra</a></li>
                <li><a href="{{ route('products.index', 'equipo-industrial') }}">Equipo Industrial</a></li>
                <li><a href="{{ route('services') }}#renta">Renta de maquinaria</a></li>
                <li><a href="{{ route('services') }}#refacciones">Refacciones y lubricantes</a></li>
            </x-site.footer-column>

            <x-site.footer-column title="Contacto">
                <li><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></li>
                <li><a href="tel:{{ $contact['phone_href'] }}">{{ $contact['phone'] }}</a></li>
                <li><address>{{ $office['short'] }}</address></li>
            </x-site.footer-column>
        </div>

        <p class="site-footer__bottom">
            {{ $showroom['name'] }} {{ $showroom['short'] }}
        </p>
    </div>
</footer>
