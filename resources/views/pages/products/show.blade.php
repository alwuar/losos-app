<x-layouts.app :title="$product['name']" :description="$product['description']">

    <x-ui.breadcrumb :items="[
        ['label' => 'Productos', 'url' => route('products.index')],
        ['label' => $category['name'], 'url' => route('products.index', $category['slug'])],
        ['label' => $product['type_label'], 'url' => route('products.index', [$category['slug'], 'tipo' => $product['type']]).'#catalogo'],
        ['label' => $product['name']],
    ]" />

    {{-- Cabecera: galería + datos principales --}}
    <x-ui.section class="product-detail">
        <div class="product-detail__grid">
            <x-products.gallery :images="$product['gallery'] ?: [$product['image']]" :alt="$product['name']" />

            <div class="product-detail__info">
                <x-ui.eyebrow>{{ $product['type_label'] }}</x-ui.eyebrow>

                @isset($product['brand'])
                    <p class="product-detail__brand">{{ $product['brand'] }}</p>
                @endisset

                <h1 class="product-detail__name">{{ $product['name'] }}</h1>

                @if ($product['tagline'])
                    <p class="product-detail__tagline">{{ $product['tagline'] }}</p>
                @endif

                @if ($product['description'])
                    <p class="product-detail__description">{{ $product['description'] }}</p>
                @endif

                <x-products.highlights :items="$product['highlights'] ?: $product['specs']" />

                <div class="product-detail__actions">
                    <x-ui.button :href="route('contact', ['equipo' => $product['name']])" size="lg">Cotizar este equipo</x-ui.button>
                    <x-ui.whatsapp-button
                        label="Preguntar por WhatsApp"
                        :message="'Hola, me interesa el equipo '.$product['name'].'.'"
                        variant="outline-primary"
                        size="lg" />
                </div>

                @if ($product['brochure'])
                    <x-ui.link-arrow :href="asset($product['brochure'])" class="product-detail__brochure" target="_blank">
                        Descargar ficha técnica (PDF)
                    </x-ui.link-arrow>
                @endif
            </div>
        </div>
    </x-ui.section>

    {{-- Ventajas --}}
    @if (! empty($product['features']))
        <x-ui.section class="product-features">
            <x-ui.section-heading eyebrow="Ventajas" :title="'¿Por qué elegir la '.$product['name'].'?'" align="center" />

            <div class="feature-row">
                @foreach ($product['features'] as $feature)
                    <x-cards.feature :title="$feature['title']">{{ $feature['text'] }}</x-cards.feature>
                @endforeach
            </div>
        </x-ui.section>
    @endif

    {{-- Especificaciones técnicas --}}
    @if (! empty($product['spec_groups']))
        <x-ui.section variant="surface" class="product-specs" id="especificaciones">
            <x-ui.section-heading eyebrow="Ficha técnica" title="Especificaciones técnicas" />

            <x-products.spec-table :groups="$product['spec_groups']" />

            <p class="product-specs__note">
                Las especificaciones pueden variar según la configuración del equipo. Confirma los datos con un asesor.
            </p>
        </x-ui.section>
    @endif

    {{-- Equipos relacionados --}}
    @if ($related->isNotEmpty())
        <x-ui.section class="product-related">
            <x-ui.section-heading eyebrow="También te puede interesar" title="Equipos relacionados" />

            <div class="products-catalog__grid">
                @foreach ($related as $item)
                    <x-cards.product :product="$item" />
                @endforeach
            </div>
        </x-ui.section>
    @endif

    <x-sections.cta-banner :title="'¿Te interesa la '.$product['name'].'?'">
        Cuéntanos tu proyecto y te enviamos una cotización a la medida.

        <x-slot:actions>
            <x-ui.button :href="route('contact', ['equipo' => $product['name']])" variant="light" size="lg">Solicitar cotización</x-ui.button>
        </x-slot:actions>
    </x-sections.cta-banner>

</x-layouts.app>
