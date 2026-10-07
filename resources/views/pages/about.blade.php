<x-layouts.app title="Quiénes somos">

    <x-sections.page-hero>Una empresa familiar mexicana,<br class="br-lg"> aliada de la construcción.</x-sections.page-hero>

    {{-- Nuestra historia --}}
    <x-ui.section class="about-story">
        <x-sections.split
            title="Nuestra historia"
            image="images/about/historia.jpg"
            image-alt="Equipo de Distribuidora Losos"
            reverse
            accent>
            <p>
                Nacimos en uno de los momentos más desafiantes de la historia reciente: diciembre de 2020, en
                plena pandemia global de COVID-19. Mientras el mundo se detenía, nosotros arrancamos
                motores. Distribuidora Losos es una empresa familiar mexicana que nació impulsada por el deseo
                de construir un legado y aportar valor real al sector de la construcción.
            </p>
            <p>
                Somos una empresa mexicana que combina pasión, compromiso y profesionalismo para ofrecer
                maquinaria de construcción de alta calidad, al alcance de quienes construyen sueños con sus
                propias manos. Apostamos por marcas líderes como Zoomlion y Manitou, porque sabemos que
                detrás de cada proyecto hay esfuerzo que merece herramientas confiables.
            </p>
        </x-sections.split>
    </x-ui.section>

    {{-- Misión y visión --}}
    <x-ui.section class="about-values">
        <div class="about-values__grid">
            <x-cards.info title="Misión" icon="shield-check">
                <p>
                    Apoyar el crecimiento de nuestros clientes, socios, colaboradores, accionistas y de toda la
                    sociedad. Lo hacemos a través de confianza, honestidad y servicio de excelencia,
                    acompañándote más allá de la venta.
                </p>
            </x-cards.info>

            <x-cards.info title="Visión" icon="shield-check">
                <p>
                    Para 2030 no solo queremos ser reconocidos como proveedores. Queremos ser tu primera opción,
                    tu socio de confianza, la empresa que realmente entiende lo que significa construir.
                </p>
            </x-cards.info>
        </div>
    </x-ui.section>

    {{-- Alianzas --}}
    <x-ui.section class="about-brands">
        <x-ui.section-heading eyebrow="Nuestras alianzas" title="Trabajamos con líderes mundiales" align="center" />

        <x-sections.brand-grid :brands="$brands" />
    </x-ui.section>

    <x-sections.cta-banner :title="config('losos.name')" align="center">
        {{ config('losos.tagline') }}
    </x-sections.cta-banner>

</x-layouts.app>
