{{-- Marcas en filas centradas (5 por fila como en el diseño). Logo si existe; si no, el nombre. --}}
@props([
    'brands' => [],
    'perRow' => 5,
])

<div {{ $attributes->class(['brand-grid']) }}>
    @foreach (collect($brands)->chunk($perRow) as $row)
        <ul class="brand-grid__row list-unstyled mb-0">
            @foreach ($row as $brand)
                <li class="brand-grid__item">
                    @if (! empty($brand['logo']) && file_exists(public_path($brand['logo'])))
                        <img src="{{ asset($brand['logo']) }}" alt="{{ $brand['name'] }}" loading="lazy">
                    @else
                        {{ $brand['name'] }}
                    @endif
                </li>
            @endforeach
        </ul>
    @endforeach
</div>
