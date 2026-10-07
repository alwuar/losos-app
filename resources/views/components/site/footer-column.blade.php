@props(['title'])

<div {{ $attributes->class(['site-footer__column']) }}>
    <h2 class="site-footer__title">{{ $title }}</h2>
    <ul class="site-footer__list">
        {{ $slot }}
    </ul>
</div>
