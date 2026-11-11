/* Screenshots */
import { join } from 'node:path';
import { RATIOS, WIDTHS, ensureDir, launch, loadConfig, open, save, settle } from './lib.mjs';

const config = loadConfig();
const browser = await launch();
const results = [];

for (const page of config.pages) {
	for (const width of WIDTHS) {
		for (const ratio of RATIOS) {
			const full = ratio === 1 || [375, 1440].includes(width);
			const zoom = [375, 921, 1440].includes(width);
			if (!full && !zoom) continue;

			const { context, tab, errors } = await open(browser, config, page, {
				viewport: { width, height: 900 },
				deviceScaleFactor: ratio,
			});
			await settle(tab);
			const dir = join(config.out, 'shots', page.name);

			if (full) {
				const file = join(dir, `${width}@${ratio}x.png`);
				ensureDir(file);
				await tab.screenshot({ path: file, fullPage: true });
			}

			if (zoom) {
				for (const selector of page.zoom ?? []) {
					const items = await tab.locator(selector).all();
					for (const [index, item] of items.entries()) {
						const file = join(dir, 'zoom', `${selector.replace(/[^a-z0-9-]+/gi, '_')}-${index}-${width}@${ratio}x.png`);
						ensureDir(file);
						await item.scrollIntoViewIfNeeded();
						await item.screenshot({ path: file });
					}
				}
			}

			results.push({ page: page.name, check: `${width}@${ratio}x`, ok: errors.length === 0, detail: errors.join(' | ') || 'tersimpan' });
			await context.close();
		}
	}
}

await browser.close();
save(config, 'shots', results);
