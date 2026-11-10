# 10 — Animasi

Hanya dikerjakan setelah halaman dan responsive disetujui user.

## Aturan

- CSS + IntersectionObserver dulu. Library (GSAP, Swiper, dan lainnya) hanya jika perlu dan sudah izin.
- Animasi hanya `transform` dan `opacity`.
- Hormati `prefers-reduced-motion`.
- Konten tetap tampil tanpa JS: state awal tersembunyi hanya berlaku setelah JS aktif.
- Durasi dan easing lewat token (`--imj-duration`, `--imj-ease`).
- Ikuti motion di Figma jika ada. Kalau tidak ada, usulkan dulu ke user.

## Pola reveal

Markup:

```html
<section class="section" data-animate>
```

CSS (`components.css`):

```css
/* Reveal */
@media (prefers-reduced-motion: no-preference) {
	.has-js [data-animate] {
		transition: opacity var(--imj-duration) var(--imj-ease), transform var(--imj-duration) var(--imj-ease);
	}

	.has-js [data-animate]:not(.is-visible) {
		opacity: 0;
		transform: translateY(var(--imj-space-6));
	}
}
```

JS (`main.js`):

```js
/* Reveal */
const initReveal = () => {
	const items = document.querySelectorAll('[data-animate]');
	if (!items.length || !('IntersectionObserver' in window)) return;

	document.documentElement.classList.add('has-js');

	const observer = new IntersectionObserver((entries) => {
		entries.forEach((entry) => {
			if (!entry.isIntersecting) return;
			entry.target.classList.add('is-visible');
			observer.unobserve(entry.target);
		});
	}, { threshold: 0.15 });

	items.forEach((item) => observer.observe(item));
};
```

## Selesai

Cek ulang QA tahap 09 (scroll horizontal, reduced motion, tanpa JS). Update `docs/project.md`. Laporkan, berhenti, dan tunggu user.
