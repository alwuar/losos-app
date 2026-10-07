@props(['links' => config('losos.social')])

@php
    $icons = [
        'facebook' => ['icon' => 'bi-facebook', 'label' => 'Facebook'],
        'instagram' => ['icon' => 'bi-instagram', 'label' => 'Instagram'],
    ];
@endphp

<ul {{ $attributes->class(['social-links']) }}>
    @foreach ($links as $network => $url)
        @continue(! isset($icons[$network]))
        <li>
            <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ $icons[$network]['label'] }}">
                <i class="bi {{ $icons[$network]['icon'] }}" aria-hidden="true"></i>
            </a>
        </li>
    @endforeach
</ul>
