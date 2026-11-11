/* Slider */
(() => {
	const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	const readGap = (root) => parseFloat(getComputedStyle(root).getPropertyValue('--{{prefix}}-slider-gap')) || 0;

	const initSlider = (root) => {
		const container = root.querySelector('.swiper');
		if (!container || container.swiper) return;

		const [desktop = 3, tablet = 2, mobile = 1] = (root.dataset.perView || '').split(',').map(Number).filter(Boolean);
		const prev = root.querySelector('[data-slider-prev]');
		const next = root.querySelector('[data-slider-next]');

		root.classList.add('is-ready');

		new Swiper(container, {
			slidesPerView: mobile,
			spaceBetween: readGap(root),
			speed: reduce ? 0 : 400,
			watchOverflow: true,
			breakpoints: {
				545: { slidesPerView: tablet },
				922: { slidesPerView: desktop },
			},
			navigation: { prevEl: prev, nextEl: next },
			pagination: { el: root.querySelector('[data-slider-progress]'), type: 'progressbar' },
			keyboard: { enabled: true, onlyInViewport: true },
			a11y: {
				enabled: true,
				prevSlideMessage: prev?.getAttribute('aria-label') || '',
				nextSlideMessage: next?.getAttribute('aria-label') || '',
				containerRoleDescriptionMessage: 'carousel',
				itemRoleDescriptionMessage: 'slide',
			},
			on: {
				resize(swiper) {
					swiper.params.spaceBetween = readGap(root);
					swiper.update();
				},
			},
		});
	};

	document.querySelectorAll('[data-slider]').forEach(initSlider);
})();
