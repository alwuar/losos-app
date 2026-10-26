{{-- "Marcas aliadas": tira de logos que continúa fuera de pantalla (scroll horizontal) --}}
@props([
    'brands' => [],
    'title' => 'Marcas aliadas',
])

<div {{ $attributes->class(['brand-strip']) }}>
    <h2 class="brand-strip__title">{!! str_replace(' ', '<br>', e($title)) !!}</h2>

    <ul class="brand-strip__logos">
        @foreach ($brands as $brand)
            @php($hasLogo = ! empty($brand['logo']) && file_exists(public_path($brand['logo'])))
            <li class="brand-strip__logo">
                <x-ui.media :src="$hasLogo ? $brand['logo'] : null" :alt="$brand['name']" fit="contain" />
            </li>
        @endforeach
    </ul>
</div>
