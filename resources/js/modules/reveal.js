/**
 * Aparición de elementos al hacer scroll.
 *
 * Todo elemento con [data-reveal] aparece al entrar en pantalla y se oculta al
 * salir, en ambos sentidos. Los que entran juntos (una fila de tarjetas, por
 * ejemplo) lo hacen escalonados. Estilos en scss/components/_reveal.scss.
 */
const STAGGER_MS = 90;
const MAX_STAGGER = 6;

export function initReveal() {
    const items = document.querySelectorAll('[data-reveal]');

    if (!items.length) {
        return;
    }

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (reduceMotion || !('IntersectionObserver' in window)) {
        items.forEach((item) => item.classList.add('is-revealed'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        let order = 0;

        entries.forEach((entry) => {
            const item = entry.target;

            if (entry.isIntersecting) {
                item.style.setProperty('--reveal-delay', `${Math.min(order++, MAX_STAGGER) * STAGGER_MS}ms`);
                item.classList.add('is-revealed');
                return;
            }

            // Fuera de pantalla: se oculta y recuerda por dónde salió
            item.dataset.revealFrom = entry.boundingClientRect.top < 0 ? 'top' : 'bottom';
            item.classList.remove('is-revealed');
        });
    }, {
        rootMargin: '0px 0px -8% 0px',
        threshold: 0,
    });

    items.forEach((item) => observer.observe(item));
}
