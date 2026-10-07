/**
 * Filtra un <select> según el valor de otro (tipos de equipo según la categoría).
 *
 * <select data-depends-on="#field-category_id">
 *   <option data-parent="3">…</option>
 */
export function initDependentSelects() {
    document.querySelectorAll('[data-depends-on]').forEach((select) => {
        const parent = document.querySelector(select.dataset.dependsOn);
        if (!parent) {
            return;
        }

        const sync = () => {
            let selectedVisible = false;

            select.querySelectorAll('option[data-parent]').forEach((option) => {
                const visible = option.dataset.parent === parent.value;
                option.hidden = !visible;
                option.disabled = !visible;
                if (visible && option.selected) {
                    selectedVisible = true;
                }
            });

            if (!selectedVisible) {
                select.value = '';
            }
        };

        parent.addEventListener('change', sync);
        sync();
    });
}
