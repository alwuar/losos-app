@props([
    'label' => 'Hablar x WhatsApp',
    'message' => config('losos.contact.whatsapp_message'),
])

@php($href = 'https://wa.me/'.config('losos.contact.whatsapp').'?text='.rawurlencode($message))

<x-ui.button :href="$href" target="_blank" rel="noopener" {{ $attributes }}>
    <i class="bi bi-whatsapp d-lg-none" aria-hidden="true"></i>
    {{ $label }}
</x-ui.button>
