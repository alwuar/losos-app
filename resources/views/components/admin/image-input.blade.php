{{--
    Subida de una imagen (o PDF) con vista previa de la actual y opción de quitarla.
    <x-admin.image-input name="image" label="Imagen" :current="$category->image" />
--}}
@props([
    'name',
    'label',
    'current' => null,
    'accept' => 'image/jpeg,image/png,image/webp',
    'help' => null,
    'removable' => true,
    'removeLabel' => 'Quitar imagen actual',
    'pdf' => false,
])

<div {{ $attributes->class(['form-field', 'image-input']) }} data-image-input>
    <label for="field-{{ $name }}" class="form-label">{{ $label }}</label>

    <div class="image-input__row">
        @unless ($pdf)
            <div class="image-input__preview" data-image-preview>
                @if ($current && file_exists(public_path($current)))
                    <img src="{{ asset($current) }}" alt="">
                @else
                    <i class="bi bi-image" aria-hidden="true"></i>
                @endif
            </div>
        @endunless

        <div class="image-input__controls">
            <input type="file" id="field-{{ $name }}" name="{{ $name }}" accept="{{ $accept }}"
                @class(['form-control', 'is-invalid' => $errors->has($name)])>

            @if ($help)
                <div class="form-text">{{ $help }}</div>
            @endif

            @if ($pdf && $current)
                <div class="form-text">
                    Actual: <a href="{{ asset($current) }}" target="_blank" rel="noopener">{{ basename($current) }}</a>
                </div>
            @endif

            @if ($current && $removable)
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="remove_{{ $name }}" value="1" id="remove-{{ $name }}">
                    <label class="form-check-label" for="remove-{{ $name }}">{{ $removeLabel }}</label>
                </div>
            @endif

            <x-forms.error :name="$name" />
        </div>
    </div>
</div>
