<x-layouts.app title="Servicios" class="page--services">

    <x-sections.page-hero>Te acompañamos más allá<br class="br-lg"> de la venta.</x-sections.page-hero>

    @foreach ($services as $service)
        <x-ui.section
            :id="$service['slug']"
            :variant="$loop->even ? 'navy' : 'default'"
            :class="'service-block'.($loop->first ? ' service-block--first' : '').($loop->last ? ' service-block--last' : '')">
            <x-sections.split
                :eyebrow="$service['number'].' — '.$service['label']"
                :title="$service['title']"
                :image="$service['image']"
                :reverse="$loop->even">
                <p>{{ $service['description'] }}</p>

                @isset($service['brand'])
                    <span class="brand-tag">{{ $service['brand'] }}</span>
                @endisset

                @isset($service['cta'])
                    <x-slot:actions>
                        <x-ui.link-arrow :href="route('contact', ['servicio' => $service['slug']])">
                            {{ $service['cta'] }}
                        </x-ui.link-arrow>
                    </x-slot:actions>
                @endisset
            </x-sections.split>
        </x-ui.section>
    @endforeach

    <x-sections.cta-banner title="¿Necesitas asesoría para tu proyecto?" compact />

</x-layouts.app>
