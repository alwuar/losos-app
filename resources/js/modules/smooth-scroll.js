import Lenis from 'lenis';
import 'lenis/dist/lenis.css';

/**
 * Scroll suave (Lenis) para el sitio público.
 *
 * Los enlaces a anclas de la misma página (#especificaciones, etc.) se
 * desplazan con la misma suavidad; el espacio del header lo descuenta
 * scroll-padding-top (scss/base/_root.scss).
 * Se desactiva si el usuario pidió reducir el movimiento.
 */
export function initSmoothScroll() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return null;
    }

    const lenis = new Lenis({
        autoRaf: true,
        lerp: 0.1,
    });

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href*="#"]');

        if (!link || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey) {
            return;
        }

        const url = new URL(link.href, window.location.href);
        const samePage = url.origin === window.location.origin
            && url.pathname === window.location.pathname
            && url.search === window.location.search;

        if (!samePage || url.hash.length < 2) {
            return;
        }

        const target = document.getElementById(decodeURIComponent(url.hash.slice(1)));

        if (!target) {
            return;
        }

        event.preventDefault();
        lenis.scrollTo(target);
        history.pushState(null, '', url.hash);
    });

    return lenis;
}
