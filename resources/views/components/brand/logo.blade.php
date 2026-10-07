{{-- Logo de Losos (versión blanca). Para cambiarlo reemplaza public/images/brand/logo-losos.png --}}
@props(['src' => 'images/brand/logo-losos.png'])

<span {{ $attributes->class(['brand-logo']) }}>
    <img src="{{ asset($src) }}" alt="{{ config('losos.name') }}" width="98" height="54">
</span>
