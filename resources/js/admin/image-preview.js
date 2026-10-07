/**
 * Muestra la imagen elegida antes de guardar.
 */
export function initImagePreviews() {
    document.querySelectorAll('[data-image-input]').forEach((field) => {
        const input = field.querySelector('input[type="file"]');
        const preview = field.querySelector('[data-image-preview]');

        if (!input || !preview) {
            return;
        }

        input.addEventListener('change', () => {
            const [file] = input.files;
            if (!file || !file.type.startsWith('image/')) {
                return;
            }

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.alt = '';
            preview.replaceChildren(img);
        });
    });
}
