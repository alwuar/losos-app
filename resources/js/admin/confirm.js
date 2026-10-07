/**
 * Pide confirmación antes de enviar formularios peligrosos (eliminar).
 * <form data-confirm="¿Eliminar este producto?">
 */
export function initConfirm() {
    document.addEventListener('submit', (event) => {
        const message = event.target.dataset?.confirm;
        if (message && !window.confirm(message)) {
            event.preventDefault();
        }
    });
}
