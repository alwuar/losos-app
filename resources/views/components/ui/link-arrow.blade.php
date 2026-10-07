@props(['href', 'light' => false])

<a href="{{ $href }}" {{ $attributes->class(['link-arrow', 'link-arrow--light' => $light]) }}>
    {{ $slot }}
    <i class="bi bi-arrow-right" aria-hidden="true"></i>
</a>
