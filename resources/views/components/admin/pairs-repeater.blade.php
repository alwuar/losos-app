{{--
    Lista editable de pares etiqueta / valor (specs, datos destacados, filas de la ficha técnica).
    name="highlights" → highlights[0][label], highlights[0][value]…
--}}
@props([
    'name',
    'rows' => [],
    'labelPlaceholder' => 'Dato (ej. Peso operativo)',
    'valuePlaceholder' => 'Valor (ej. 21,500 kg)',
    'addLabel' => 'Agregar dato',
    'placeholder' => '__INDEX__',
])

<div {{ $attributes->class(['repeater']) }} data-repeater data-placeholder="{{ $placeholder }}">
    <div class="repeater__items" data-repeater-items>
        @foreach (array_values($rows ?? []) as $i => $row)
            <div class="repeater__row" data-repeater-item>
                <input type="text" name="{{ $name }}[{{ $i }}][label]" value="{{ $row['label'] ?? '' }}" class="form-control" placeholder="{{ $labelPlaceholder }}">
                <input type="text" name="{{ $name }}[{{ $i }}][value]" value="{{ $row['value'] ?? '' }}" class="form-control" placeholder="{{ $valuePlaceholder }}">
                <x-admin.repeater-controls />
            </div>
        @endforeach
    </div>

    <template data-repeater-template>
        <div class="repeater__row" data-repeater-item>
            <input type="text" name="{{ $name }}[{{ $placeholder }}][label]" class="form-control" placeholder="{{ $labelPlaceholder }}">
            <input type="text" name="{{ $name }}[{{ $placeholder }}][value]" class="form-control" placeholder="{{ $valuePlaceholder }}">
            <x-admin.repeater-controls />
        </div>
    </template>

    <button type="button" class="btn btn-sm btn-outline-secondary" data-repeater-add>
        <i class="bi bi-plus-lg" aria-hidden="true"></i> {{ $addLabel }}
    </button>
</div>
