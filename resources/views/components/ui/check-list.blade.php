@props(['items' => []])

<ul {{ $attributes->merge(['data-reveal' => 'up'])->class(['check-list']) }}>
    @foreach ($items as $item)
        <li><i class="bi bi-check-lg" aria-hidden="true"></i>{{ $item }}</li>
    @endforeach
</ul>
