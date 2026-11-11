/* Lightbox */
import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.min.css';

const root = document.documentElement;

if (!root.hasAttribute('data-lightbox-ready')) {
	root.setAttribute('data-lightbox-ready', '');
	GLightbox({ selector: '[data-lightbox]' });
}
