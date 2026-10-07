{{-- :options acepta ['valor' => 'Etiqueta'] o una lista simple ['A', 'B'] --}}
@props([
    'name',
    'label',
    'options' => [],
    'id' => null,
    'value' => null,
    'placeholder' => null,
])

@php
    $id ??= 'field-'.$name;
    $selected = old($name, $value);
    $isList = array_is_list($options);
@endphp

<div {{ $attributes->only('class')->class(['form-field']) }}>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <select
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $attributes->except('class')->class(['form-select', 'is-invalid' => $errors->has($name)]) }}
    >
        @if ($placeholder)
            <option value="" @selected(blank($selected))>{{ $placeholder }}</option>
        @endif

        @foreach ($options as $key => $option)
            @php($optionValue = $isList ? $option : $key)
            <option value="{{ $optionValue }}" @selected((string) $selected === (string) $optionValue)>{{ $option }}</option>
        @endforeach
    </select>
    <x-forms.error :name="$name" />
</div>
