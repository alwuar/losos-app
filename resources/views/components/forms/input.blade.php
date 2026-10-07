@props([
    'name',
    'label',
    'type' => 'text',
    'id' => null,
    'value' => null,
    'help' => null,
])

@php($id ??= 'field-'.$name)

<div {{ $attributes->only('class')->class(['form-field']) }}>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->except('class')->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
    >
    @if ($help)
        <div class="form-text">{{ $help }}</div>
    @endif
    <x-forms.error :name="$name" />
</div>
