import Collapse from 'bootstrap/js/dist/collapse';

/**
 * Barra de navegación flotante.
 *  - En inicio (variante transparente) se vuelve más sólida al hacer scroll
 *    o cuando el menú móvil está abierto.
 *  - El menú móvil se cierra con Escape y la etiqueta del botón cambia.
 */
export function initHeader() {
    const header = document.querySelector('[data-site-header]');

    if (!header) {
        return;
    }

    const menu = header.querySelector('.navbar-collapse');
    const toggle = header.querySelector('.navbar-toggler');
    const isTransparent = header.classList.contains('site-header--transparent');

    const update = () => {
        const menuOpen = menu?.classList.contains('show') || menu?.classList.contains('collapsing');
        header.classList.toggle('is-scrolled', window.scrollY > 24 || Boolean(menuOpen));
    };

    if (isTransparent) {
        update();
        window.addEventListener('scroll', update, { passive: true });
    }

    menu?.addEventListener('show.bs.collapse', () => {
        header.classList.add('is-scrolled');
        toggle?.setAttribute('aria-label', 'Cerrar menú');
    });

    menu?.addEventListener('hidden.bs.collapse', () => {
        toggle?.setAttribute('aria-label', 'Abrir menú');

        if (isTransparent) {
            update();
        } else {
            header.classList.remove('is-scrolled');
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && menu?.classList.contains('show')) {
            Collapse.getOrCreateInstance(menu, { toggle: false }).hide();
            toggle?.focus();
        }
    });
}
