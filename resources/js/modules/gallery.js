/**
 * Galería de producto: al dar clic en una miniatura cambia la imagen principal.
 */
export function initGalleries() {
    document.querySelectorAll('[data-gallery]').forEach((gallery) => {
        const main = gallery.querySelector('[data-gallery-main] img');
        const thumbs = gallery.querySelectorAll('[data-gallery-thumb]');

        thumbs.forEach((thumb) => {
            thumb.addEventListener('click', () => {
                if (main && thumb.dataset.src) {
                    main.src = thumb.dataset.src;
                }

                thumbs.forEach((item) => {
                    item.classList.toggle('is-active', item === thumb);
                    item.toggleAttribute('aria-current', item === thumb);
                });
            });
        });
    });
}
