import './fonts';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/js/dist/collapse';

import { initHeader } from './modules/header';
import { initGalleries } from './modules/gallery';

document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initGalleries();
});
