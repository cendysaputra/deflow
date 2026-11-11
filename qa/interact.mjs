/* Interaction and semantics */
import { join } from 'node:path';
import { ensureDir, launch, loadConfig, open, save, settle } from './lib.mjs';

const config = loadConfig();
const browser = await launch();
const results = [];
const push = (page, check, ok, detail) => results.push({ page: page.name, check, ok, detail });

const overflow = (tab) =>
	tab.evaluate(() => {
		const limit = document.documentElement.clientWidth;
		if (document.documentElement.scrollWidth <= limit) return [];
		return [...document.querySelectorAll('body *')]
			.filter((el) => el.getBoundingClientRect().right > limit + 1 && !el.closest('.swiper, [data-marquee], [aria-hidden="true"]'))
			.slice(0, 5)
			.map((el) => `${el.tagName.toLowerCase()}${el.id ? `#${el.id}` : ''}.${[...el.classList].join('.')}`);
	});

const semantics = (tab) =>
	tab.evaluate(() => {
		const headings = [...document.querySelectorAll('h1, h2, h3, h4, h5, h6')].filter((el) => el.offsetParent !== null);
		const skips = [];
		headings.reduce((prev, el) => {
			const level = Number(el.tagName[1]);
			if (prev && level > prev + 1) skips.push(`h${prev} → h${level} "${el.textContent.trim().slice(0, 30)}"`);
			return level;
		}, 0);
		const landmark = (tag) => [...document.querySelectorAll(tag)].filter((el) => !el.closest('article, section, aside, nav, main') || tag === 'main').length;
		const unlabeled = [...document.querySelectorAll('input, select, textarea')].filter(
			(el) => !['hidden', 'submit', 'button', 'reset', 'image'].includes(el.type) && !el.labels?.length && !el.getAttribute('aria-label') && !el.getAttribute('aria-labelledby'),
		);
		return {
			h1: document.querySelectorAll('h1').length,
			skips,
			noAlt: [...document.querySelectorAll('img:not([alt])')].map((img) => img.currentSrc || img.src).slice(0, 5),
			main: landmark('main'),
			header: landmark('header'),
			footer: landmark('footer'),
			unlabeled: unlabeled.map((el) => el.name || el.id || el.type).slice(0, 5),
			sectionsWithoutHeading: [...document.querySelectorAll('section')].filter((el) => !el.querySelector('h1, h2, h3, h4, h5, h6')).length,
		};
	});

const smallTargets = (tab) =>
	tab.evaluate(() =>
		[...document.querySelectorAll('button, [role="button"], nav a, .btn')]
			.filter((el) => {
				const rect = el.getBoundingClientRect();
				return rect.width > 1 && rect.height > 1 && (rect.width < 44 || rect.height < 44) && !el.closest('[aria-hidden="true"]');
			})
			.slice(0, 5)
			.map((el) => `${el.tagName.toLowerCase()} "${(el.getAttribute('aria-label') || el.textContent).trim().slice(0, 20)}"`),
	);

for (const page of config.pages) {
	for (const width of [375, 921, 1440, 1920]) {
		const { context, tab, errors } = await open(browser, config, page, { viewport: { width, height: 900 } });
		await settle(tab);
		const wide = await overflow(tab);
		push(page, `scroll horizontal ${width}`, wide.length === 0, wide.join(', ') || 'tidak ada');
		push(page, `error ${width}`, errors.length === 0, errors.join(' | ') || 'tidak ada');

		if (width === 375) {
			const small = await smallTargets(tab);
			push(page, 'target sentuh 44px', small.length === 0, small.join(', ') || 'semua cukup');
		}

		if (width === 1440) {
			const s = await semantics(tab);
			push(page, 'satu h1', s.h1 === 1, `${s.h1} h1`);
			push(page, 'heading berurutan', s.skips.length === 0, s.skips.join(', ') || 'urut');
			push(page, 'alt gambar', s.noAlt.length === 0, s.noAlt.join(', ') || 'semua punya alt');
			push(page, 'landmark', s.main === 1 && s.header === 1 && s.footer === 1, `main ${s.main}, header ${s.header}, footer ${s.footer}`);
			push(page, 'label form', s.unlabeled.length === 0, s.unlabeled.join(', ') || 'semua berlabel');
			push(page, 'section punya heading', s.sectionsWithoutHeading === 0, `${s.sectionsWithoutHeading} section tanpa heading`);
		}

		await context.close();
	}

	/* Mobile menu */
	{
		const { context, tab } = await open(browser, config, page, { viewport: { width: 375, height: 800 } });
		const selector = config.menuToggle || 'header button[aria-expanded]';
		const toggle = tab.locator(selector).filter({ visible: true }).first();
		if (await toggle.count()) {
			await toggle.click();
			await tab.waitForTimeout(500);
			const expanded = await toggle.getAttribute('aria-expanded');
			const file = join(config.out, 'shots', page.name, 'menu-open-375.png');
			ensureDir(file);
			await tab.screenshot({ path: file });
			const locked = await tab.evaluate(async () => {
				window.scrollTo(0, 400);
				await new Promise((done) => setTimeout(done, 100));
				return window.scrollY === 0;
			});
			push(page, 'menu mobile terbuka', expanded === 'true', `aria-expanded=${expanded}, screenshot ${file}`);
			push(page, 'menu mobile mengunci scroll', locked, locked ? 'body terkunci' : 'body masih bisa di-scroll');
			await tab.keyboard.press('Escape');
			await tab.waitForTimeout(300);
			const closed = (await toggle.getAttribute('aria-expanded')) === 'false';
			push(page, 'menu mobile tutup dengan Escape', closed, closed ? 'tertutup' : 'masih terbuka');
		} else {
			push(page, 'menu mobile', false, `tombol ${selector} tidak ditemukan (isi menuToggle di config)`);
		}
		await context.close();
	}

	/* Slider click */
	{
		const { context, tab } = await open(browser, config, page, { viewport: { width: 1440, height: 900 } });
		const count = await tab.locator('[data-slider]').count();
		for (let i = 0; i < count; i++) {
			const root = tab.locator('[data-slider]').nth(i);
			await root.scrollIntoViewIfNeeded();
			const ready = await root.evaluate((el) => Boolean(el.querySelector('.swiper')?.swiper));
			const before = await root.evaluate((el) => el.querySelector('.swiper')?.swiper?.activeIndex ?? 0);
			await root.locator('[data-slider-next]').click();
			await tab.waitForTimeout(1500);
			const after = await root.evaluate((el) => el.querySelector('.swiper')?.swiper?.activeIndex ?? null);
			if (after === null) {
				push(page, `slider ${i + 1}`, false, 'Swiper tidak terinisialisasi setelah klik');
				continue;
			}
			const note = ready ? '' : ' (Swiper aktif setelah interaksi pertama, cek plugin delay JS)';
			push(page, `slider ${i + 1} geser satu slide`, after - before === 1, `index ${before} → ${after}${note}`);
		}
		await context.close();
	}

	/* Reduced motion */
	{
		const { context, tab } = await open(browser, config, page, { viewport: { width: 1440, height: 900 }, reducedMotion: 'reduce' });
		await tab.waitForTimeout(1500);
		const moving = await tab.evaluate(() => {
			const infinite = document.getAnimations().filter((a) => a.playState === 'running' && a.effect?.getTiming().iterations === Infinity).length;
			const autoplay = [...document.querySelectorAll('.swiper')].filter((el) => el.swiper?.autoplay?.running).length;
			return infinite + autoplay;
		});
		push(page, 'reduced motion', moving === 0, moving ? `${moving} animasi masih berjalan` : 'gerak berhenti');
		await context.close();
	}
}

await browser.close();
save(config, 'interact', results);
