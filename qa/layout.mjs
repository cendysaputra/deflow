/* Layout vs Figma */
import { launch, loadConfig, open, save, settle } from './lib.mjs';

const config = loadConfig();
const browser = await launch();
const results = [];

for (const page of config.pages) {
	const figma = page.figma ?? {};
	if (!figma.sections?.length) continue;

	const { context, tab } = await open(browser, config, page, { viewport: { width: figma.width ?? 1440, height: 900 } });
	await settle(tab);

	for (const section of figma.sections) {
		const box = await tab.evaluate((selector) => {
			const el = document.querySelector(selector);
			if (!el) return null;
			const rect = el.getBoundingClientRect();
			return { y: Math.round(rect.top + window.scrollY), height: Math.round(rect.height) };
		}, section.selector);

		if (!box) {
			results.push({ page: page.name, check: section.name, ok: false, detail: `selector ${section.selector} tidak ditemukan` });
			continue;
		}

		const dy = box.y - section.y;
		const dh = box.height - section.height;
		results.push({
			page: page.name,
			check: section.name,
			ok: Math.abs(dy) <= config.tolerance && Math.abs(dh) <= config.tolerance,
			detail: `y ${box.y} (figma ${section.y}, ${dy >= 0 ? '+' : ''}${dy}) tinggi ${box.height} (figma ${section.height}, ${dh >= 0 ? '+' : ''}${dh})`,
			site: box,
			figma: { y: section.y, height: section.height },
		});
	}

	await context.close();
}

await browser.close();
save(config, 'layout', results);
