{{-- Datos de contacto + redes (columna izquierda de Contacto) --}}
@php
    $contact = config('losos.contact');
    $office = config('losos.locations.office');
@endphp

<div {{ $attributes->class(['contact-details']) }}>
    <div class="contact-details__item">
        <p class="contact-details__label">Email</p>
        <p class="contact-details__value"><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></p>
    </div>

    <div class="contact-details__item">
        <p class="contact-details__label">Teléfono</p>
        <p class="contact-details__value"><a href="tel:{{ $contact['phone_href'] }}">{{ $contact['phone'] }}</a></p>
    </div>

    <div class="contact-details__item">
        <p class="contact-details__label">Dirección</p>
        <address class="contact-details__value">{{ $office['short'] }}</address>
    </div>

    <div class="contact-details__social">
        <span>Síguenos</span>
        <x-ui.social-links />
    </div>
</div>
