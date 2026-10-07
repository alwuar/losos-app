/**
 * Header transparente sobre el hero: se vuelve sólido al hacer scroll
 * o cuando el menú móvil está abierto.
 */
export function initHeader() {
    const header = document.querySelector('[data-site-header]');

    if (!header) {
        return;
    }

    const menu = header.querySelector('.navbar-collapse');
    const isTransparent = header.classList.contains('site-header--transparent');

    const update = () => {
        const menuOpen = menu?.classList.contains('show') || menu?.classList.contains('collapsing');
        header.classList.toggle('is-scrolled', window.scrollY > 24 || Boolean(menuOpen));
    };

    if (isTransparent) {
        update();
        window.addEventListener('scroll', update, { passive: true });
        menu?.addEventListener('show.bs.collapse', () => header.classList.add('is-scrolled'));
        menu?.addEventListener('hidden.bs.collapse', update);
    }
}
