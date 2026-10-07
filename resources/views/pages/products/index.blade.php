<x-layouts.app title="Productos">

    <x-sections.page-hero>Maquinaria de construcción nueva de<br class="br-lg"> última generación.</x-sections.page-hero>

    {{-- Categorías + beneficios --}}
    <x-ui.section variant="surface" class="products-intro">
        <p class="products-intro__lead">
            Trabajamos con las mejores marcas del sector, como Zoomlion y Manitou, para ofrecerte equipos
            robustos, duraderos y con un rendimiento superior.
        </p>

        <div class="products-intro__tabs">
            @foreach ($categories as $item)
                <x-cards.category-tab
                    :title="$item['name']"
                    :href="route('products.index', $item['slug'])"
                    :active="$item['slug'] === $category['slug']">
                    {{ $item['summary'] }}
                </x-cards.category-tab>
            @endforeach
        </div>

        <div class="products-intro__benefits">
            <div>
                <x-ui.eyebrow>Beneficios</x-ui.eyebrow>
                <h2 class="products-intro__title">{{ $category['name'] }}</h2>
                <p class="products-intro__text">{{ $category['description'] }}</p>
            </div>

            <x-ui.check-list :items="$category['benefits']" />
        </div>
    </x-ui.section>

    {{-- Listado --}}
    <x-ui.section id="catalogo" class="products-catalog">
        <x-ui.filter-pills
            :items="$category['types']"
            :active="$type"
            :url="fn ($slug) => route('products.index', [$category['slug'], 'tipo' => $slug]).'#catalogo'"
            label="Tipo de equipo" />

        @if ($products->isEmpty())
            <div class="products-empty">
                Muy pronto agregaremos equipos en esta categoría.
                <x-ui.link-arrow :href="route('contact')" class="ms-1">Pregúntanos por disponibilidad</x-ui.link-arrow>
            </div>
        @else
            <div class="products-catalog__grid">
                @foreach ($products as $product)
                    <x-cards.product :product="$product" />
                @endforeach
            </div>
        @endif
    </x-ui.section>

</x-layouts.app>
