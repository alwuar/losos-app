{{-- Tabla de especificaciones agrupada: ['Motor' => ['Potencia' => '125 kW', ...], ...] --}}
@props(['groups' => []])

<div {{ $attributes->class(['spec-table']) }}>
    @foreach ($groups as $group => $rows)
        <section class="spec-table__group">
            <h3 class="spec-table__title">{{ $group }}</h3>

            <dl class="spec-table__rows">
                @foreach ($rows as $label => $value)
                    <div class="spec-table__row">
                        <dt>{{ $label }}</dt>
                        <dd>{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </section>
    @endforeach
</div>
