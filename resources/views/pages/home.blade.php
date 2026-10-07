<x-layouts.app header="transparent">

    <x-sections.hero image="images/home/hero.jpg">
        <x-slot:title>Donde la confianza se<br class="br-lg"> convierte en construcción.</x-slot:title>

        Maquinaria de construcción nueva, de las marcas líderes del mundo, respaldada
        por una empresa familiar mexicana que te acompaña más allá de la venta.

        <x-slot:actions>
            <x-ui.button :href="route('products.index')" size="lg">Ver catálogo</x-ui.button>
            <x-ui.button :href="route('contact')" variant="outline-light" size="lg">Contáctanos</x-ui.button>
        </x-slot:actions>
    </x-sections.hero>

    {{-- Marcas aliadas --}}
    <x-ui.section class="home-brands">
        <x-sections.brand-strip :brands="$brands" />
    </x-ui.section>

    {{-- Por qué Losos --}}
    <x-ui.section class="home-why">
        <x-ui.section-heading eyebrow="Por qué Losos" title="Más que proveedores, somos aliados." align="center" />

        <div class="feature-row feature-row--scroll">
            @foreach ($features as $feature)
                <x-cards.feature :title="$feature['title']">{{ $feature['text'] }}</x-cards.feature>
            @endforeach
        </div>
    </x-ui.section>

    {{-- Línea de productos --}}
    <x-ui.section class="home-products">
        <x-ui.section-heading eyebrow="Que vendemos" title="Linea de productos" uppercase />

        <div class="home-products__grid">
            @foreach ($categories as $category)
                <x-cards.category
                    :title="$category['card_title'] ?? $category['name']"
                    :label="$category['label']"
                    :image="$category['image']"
                    :href="route('products.index', $category['slug'])">
                    {{ $category['excerpt'] }}
                </x-cards.category>
            @endforeach
        </div>
    </x-ui.section>

    {{-- Servicios adicionales --}}
    <x-ui.section class="home-services">
        <x-ui.section-heading eyebrow="Atención especializada" title="Servicios adicionales" align="center" />

        <div class="feature-row">
            @foreach ($services as $service)
                <x-cards.feature
                    tone="navy"
                    :title="$service['title']"
                    :href="route('services').'#'.$service['slug']">
                    {{ $service['excerpt'] }}
                </x-cards.feature>
            @endforeach
        </div>
    </x-ui.section>

    <x-sections.cta-banner title="Más que proveedores, somos aliados.">
        Para 2030 queremos ser tu primera opción, tu socio de confianza. Cuéntanos tu proyecto.
    </x-sections.cta-banner>

</x-layouts.app>
