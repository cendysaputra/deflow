/* Lightbox */
(() => {
	const root = document.documentElement;
	if (root.hasAttribute('data-lightbox-ready') || !document.querySelector('[data-lightbox]')) return;

	root.setAttribute('data-lightbox-ready', '');
	GLightbox({ selector: '[data-lightbox]' });
})();
