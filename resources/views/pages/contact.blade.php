<x-layouts.app title="Contacto">

    <x-sections.page-hero class="contact-page__hero">Cuéntanos de tu proyecto</x-sections.page-hero>

    {{-- Datos + formulario --}}
    <x-ui.section class="contact-page">
        <div class="contact-page__layout">
            <x-contact.details class="contact-page__details" />

            <div class="contact-page__form">
                @if (session('status'))
                    <div class="alert alert-success" role="status">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" novalidate>
                    @csrf

                    <div class="row">
                        <x-forms.input class="col-md-6" name="first_name" label="Nombre" placeholder="Cecilia" autocomplete="given-name" required />
                        <x-forms.input class="col-md-6" name="last_name" label="Apellido" placeholder="Acevedo" autocomplete="family-name" required />
                        <x-forms.input class="col-md-6" name="email" type="email" label="Email" placeholder="cecy@example.com" autocomplete="email" required />
                        <x-forms.phone class="col-md-6" />
                        <x-forms.input class="col-md-6" name="company" label="Empresa" placeholder="Nombre de tu empresa" autocomplete="organization" />
                        <x-forms.select
                            class="col-md-6"
                            name="equipment"
                            label="¿Qué equipo necesitas?"
                            :options="$equipment"
                            :value="request('equipo')" />

                        <div class="col-12 contact-page__submit">
                            <x-ui.button type="submit" class="form-submit">Enviar</x-ui.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-ui.section>

    {{-- Ubicaciones --}}
    <x-ui.section class="contact-locations">
        <x-ui.section-heading eyebrow="Matriz" title="Nuestras ubicaciones" align="center" />

        <div class="contact-locations__grid">
            @foreach ($locations as $location)
                <x-cards.info :title="$location['name']" class="info-card--compact">
                    <address>{{ $location['full'] }}</address>
                </x-cards.info>
            @endforeach
        </div>
    </x-ui.section>

    <x-sections.cta-banner :title="config('losos.name')" align="center">
        {{ config('losos.tagline') }}
    </x-sections.cta-banner>

</x-layouts.app>
