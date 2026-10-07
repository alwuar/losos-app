{{-- Tarjeta de producto del catálogo --}}
@props(['product'])

<article {{ $attributes->class(['product-card']) }}>
    <x-ui.media :src="$product['image'] ?? null" :alt="$product['name']" fit="contain" class="product-card__media" />

    <div class="product-card__body">
        <h3 class="product-card__title">{{ $product['name'] }}</h3>

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

        <x-ui.button
            :href="route('contact', ['equipo' => $product['name']])"
            variant="outline-primary"
            class="product-card__action">
            {{ $product['type_label'] ?? 'Cotizar' }}
        </x-ui.button>
    </div>
</article>
