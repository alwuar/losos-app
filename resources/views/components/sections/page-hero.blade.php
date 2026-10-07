{{-- Título principal centrado de las páginas internas (el slot es el título) --}}
<section {{ $attributes->class(['page-hero']) }}>
    <div class="container">
        <h1 class="page-hero__title">{{ $slot }}</h1>
    </div>
</section>
