/* Marquee */
(() => {
	if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

	const fill = (container, wrapper) => {
		const originals = [...wrapper.children];
		for (let i = 0; i < 10 && wrapper.scrollWidth < container.clientWidth * 2; i++) {
			originals.forEach((slide) => {
				const clone = slide.cloneNode(true);
				clone.setAttribute('aria-hidden', 'true');
				clone.querySelectorAll('a, button').forEach((el) => el.setAttribute('tabindex', '-1'));
				wrapper.append(clone);
			});
		}
	};

	const initMarquee = (root) => {
		const container = root.querySelector('.swiper');
		const wrapper = container?.querySelector('.swiper-wrapper');
		if (!wrapper || container.swiper) return;

		root.classList.add('is-ready');
		fill(container, wrapper);

		const swiper = new Swiper(container, {
			slidesPerView: 'auto',
			loop: true,
			speed: Number(root.dataset.speed) || 5000,
			allowTouchMove: false,
			autoplay: { delay: 0, disableOnInteraction: false, pauseOnMouseEnter: true },
		});

		const toggle = root.querySelector('[data-marquee-toggle]');
		if (!toggle) return;

		toggle.hidden = false;
		toggle.addEventListener('click', () => {
			const paused = toggle.getAttribute('aria-pressed') !== 'true';
			toggle.setAttribute('aria-pressed', String(paused));
			paused ? swiper.autoplay.stop() : swiper.autoplay.start();
		});
	};

	document.querySelectorAll('[data-marquee]').forEach(initMarquee);
})();
