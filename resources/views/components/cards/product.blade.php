{{-- Tarjeta de producto del catálogo (enlaza al detalle) --}}
@props(['product'])

<article {{ $attributes->class(['product-card']) }}>
    <a href="{{ $product['url'] }}" class="product-card__media-link" tabindex="-1" aria-hidden="true">
        <x-ui.media :src="$product['image'] ?? null" :alt="$product['name']" fit="contain" class="product-card__media" />
    </a>

    <div class="product-card__body">
        <h3 class="product-card__title">
            <a href="{{ $product['url'] }}">{{ $product['name'] }}</a>
        </h3>

        @if (! empty($product['specs']))
            <dl class="product-card__specs">
                @foreach ($product['specs'] as $label => $value)
                    <div>
                        <dt>{{ $label }}:</dt>
                        <dd>{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        @endif

        <x-ui.button :href="$product['url']" variant="outline-primary" class="product-card__action">
            Ver detalle
        </x-ui.button>
    </div>
</article>
