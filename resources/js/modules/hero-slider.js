import Carousel from 'bootstrap/js/dist/carousel';

/**
 * Slider del encabezado de Inicio (solo existe si hay 2 o más diapositivas).
 *
 * Avanza solo, se pausa con el mouse encima y se puede deslizar con el dedo.
 * Si el usuario pidió reducir el movimiento, no avanza solo.
 */
export function initHeroSlider() {
    document.querySelectorAll('[data-hero-slider]').forEach((element) => {
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        Carousel.getOrCreateInstance(element, {
            interval: reduceMotion ? false : Number(element.dataset.interval) || 6000,
            ride: reduceMotion ? false : 'carousel',
            pause: 'hover',
            touch: true,
            keyboard: true,
        });

        // Las demás imágenes se descargan cuando la página terminó de cargar,
        // así ya están listas cuando les toca aparecer.
        const loadRest = () => element.querySelectorAll('img[loading="lazy"]').forEach((image) => {
            image.loading = 'eager';
        });

        if (document.readyState === 'complete') {
            loadRest();
        } else {
            window.addEventListener('load', loadRest, { once: true });
        }
    });
}
