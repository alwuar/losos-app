@props([
    'name',
    'label',
    'value' => null,
    'rows' => 3,
    'help' => null,
])

@php($id = 'field-'.str_replace(['[', ']', '.'], '-', $name))

<div {{ $attributes->only('class')->class(['form-field']) }}>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}"
        {{ $attributes->except('class')->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>{{ old($name, $value) }}</textarea>
    @if ($help)
        <div class="form-text">{{ $help }}</div>
    @endif
    <x-forms.error :name="$name" />
</div>
