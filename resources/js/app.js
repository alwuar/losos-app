import './fonts';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/js/dist/collapse';

import { initHeader } from './modules/header';
import { initGalleries } from './modules/gallery';
import { initReveal } from './modules/reveal';
import { initSmoothScroll } from './modules/smooth-scroll';

document.addEventListener('DOMContentLoaded', () => {
    initSmoothScroll();
    initHeader();
    initGalleries();
    initReveal();
});
