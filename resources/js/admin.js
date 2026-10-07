import './fonts';
import 'bootstrap-icons/font/bootstrap-icons.css';

import { initRepeaters } from './admin/repeater';
import { initImagePreviews } from './admin/image-preview';
import { initDependentSelects } from './admin/dependent-select';
import { initConfirm } from './admin/confirm';

document.addEventListener('DOMContentLoaded', () => {
    initRepeaters();
    initImagePreviews();
    initDependentSelects();
    initConfirm();

    // Menú lateral en pantallas chicas
    document.querySelector('[data-admin-sidebar-toggle]')?.addEventListener('click', () => {
        document.body.classList.toggle('admin--sidebar-open');
    });
});
