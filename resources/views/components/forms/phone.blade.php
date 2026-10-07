{{-- Teléfono con selector de lada --}}
@props([
    'name' => 'phone',
    'codeName' => 'phone_code',
    'label' => 'Teléfono',
    'codes' => ['+52' => 'MX', '+1' => 'US'],
    'default' => '+52',
    'placeholder' => '999 123 4567',
])

<div {{ $attributes->class(['form-field', 'phone-field']) }}>
    <label for="field-{{ $name }}" class="form-label">{{ $label }}</label>
    <div class="input-group has-validation">
        <select name="{{ $codeName }}" class="form-select phone-field__code" aria-label="Lada">
            @foreach ($codes as $code => $country)
                <option value="{{ $code }}" @selected(old($codeName, $default) === $code)>{{ $country }}</option>
            @endforeach
        </select>
        <input
            type="tel"
            id="field-{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name) }}"
            placeholder="{{ $placeholder }}"
            autocomplete="tel-national"
            @class(['form-control', 'is-invalid' => $errors->has($name)])
        >
        <x-forms.error :name="$name" />
    </div>
</div>
