{{-- Galería del producto: imagen principal + miniaturas (resources/js/modules/gallery.js) --}}
@props([
    'images' => [],
    'alt' => '',
])

@php($images = array_values(array_filter($images)))

<div {{ $attributes->class(['product-gallery']) }} data-gallery>
    <x-ui.media :src="$images[0] ?? null" :alt="$alt" fit="contain" loading="eager" class="product-gallery__main" data-gallery-main />

    @if (count($images) > 1)
        <ul class="product-gallery__thumbs" aria-label="Imágenes de {{ $alt }}">
            @foreach ($images as $image)
                @php($exists = file_exists(public_path($image)))
                <li>
                    <button type="button"
                            @class(['product-gallery__thumb', 'is-active' => $loop->first])
                            data-gallery-thumb
                            data-src="{{ $exists ? asset($image) : '' }}"
                            aria-label="Ver imagen {{ $loop->iteration }} de {{ $alt }}"
                            @if ($loop->first) aria-current="true" @endif>
                        <x-ui.media :src="$image" :alt="''" fit="contain" />
                    </button>
                </li>
            @endforeach
        </ul>
    @endif
</div>
