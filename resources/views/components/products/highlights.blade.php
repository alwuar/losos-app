{{-- Datos destacados del equipo (valor grande + etiqueta) --}}
@props(['items' => []])

<dl {{ $attributes->class(['product-highlights']) }}>
    @foreach ($items as $label => $value)
        <div class="product-highlights__item">
            <dt class="product-highlights__label">{{ $label }}</dt>
            <dd class="product-highlights__value">{{ $value }}</dd>
        </div>
    @endforeach
</dl>
