/**
 * Listas repetibles (specs, ventajas, grupos de la ficha técnica, tipos…).
 *
 * <div data-repeater data-placeholder="__INDEX__">
 *   <div data-repeater-items> …filas existentes con [data-repeater-item]… </div>
 *   <template data-repeater-template> …fila nueva usando __INDEX__ en los name… </template>
 *   <button data-repeater-add>
 * </div>
 *
 * Se pueden anidar (cada repetidor usa su propio placeholder).
 */
let counter = 0;

function ownRepeater(element) {
    return element.closest('[data-repeater]');
}

function addItem(repeater) {
    const template = repeater.querySelector(':scope > [data-repeater-template]');
    const items = repeater.querySelector(':scope > [data-repeater-items]');
    const placeholder = repeater.dataset.placeholder || '__INDEX__';
    const index = `n${Date.now()}${counter++}`;

    const wrapper = document.createElement('div');
    wrapper.innerHTML = template.innerHTML.replaceAll(placeholder, index).trim();
    const item = wrapper.firstElementChild;
    items.appendChild(item);
    item.querySelector('input, textarea, select')?.focus();
}

export function initRepeaters() {
    document.addEventListener('click', (event) => {
        const add = event.target.closest('[data-repeater-add]');
        if (add) {
            addItem(ownRepeater(add));
            return;
        }

        const control = event.target.closest('[data-repeater-remove], [data-repeater-up], [data-repeater-down]');
        if (!control) {
            return;
        }

        // El elemento a mover/quitar es el [data-repeater-item] más cercano al botón
        const item = control.closest('[data-repeater-item]');
        if (!item) {
            return;
        }

        if (control.hasAttribute('data-repeater-remove')) {
            item.remove();
        } else if (control.hasAttribute('data-repeater-up') && item.previousElementSibling) {
            item.parentNode.insertBefore(item, item.previousElementSibling);
        } else if (control.hasAttribute('data-repeater-down') && item.nextElementSibling) {
            item.parentNode.insertBefore(item.nextElementSibling, item);
        }
    });
}
