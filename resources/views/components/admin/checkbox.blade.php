@props([
    'name',
    'label',
    'checked' => false,
])

<div {{ $attributes->class(['form-check form-switch']) }}>
    <input type="hidden" name="{{ $name }}" value="0">
    <input class="form-check-input" type="checkbox" role="switch" id="field-{{ $name }}" name="{{ $name }}" value="1" @checked(old($name, $checked))>
    <label class="form-check-label" for="field-{{ $name }}">{{ $label }}</label>
</div>
