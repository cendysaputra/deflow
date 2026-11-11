/* Brightness bands vs Figma */
import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';
import { launch, loadConfig, open, save, settle } from './lib.mjs';

const config = loadConfig();
const browser = await launch();
const results = [];

const measure = (tab, a, b, bandHeight) =>
	tab.evaluate(
		async ({ a, b, bandHeight }) => {
			const load = (src) =>
				new Promise((done, fail) => {
					const image = new Image();
					image.onload = () => done(image);
					image.onerror = fail;
					image.src = src;
				});
			const [site, figma] = await Promise.all([load(a), load(b)]);
			const width = Math.min(site.width, figma.width);
			const lumas = (image) => {
				const height = Math.round((image.height * width) / image.width);
				const canvas = new OffscreenCanvas(width, height);
				const ctx = canvas.getContext('2d');
				ctx.drawImage(image, 0, 0, width, height);
				const data = ctx.getImageData(0, 0, width, height).data;
				const bands = [];
				for (let top = 0; top < height; top += bandHeight) {
					let sum = 0;
					let count = 0;
					for (let y = top; y < Math.min(top + bandHeight, height); y++) {
						for (let x = 0; x < width; x += 2) {
							const i = (y * width + x) * 4;
							sum += 0.2126 * data[i] + 0.7152 * data[i + 1] + 0.0722 * data[i + 2];
							count++;
						}
					}
					bands.push(sum / count / 255);
				}
				return { height, bands };
			};
			return { site: lumas(site), figma: lumas(figma) };
		},
		{ a, b, bandHeight },
	);

for (const page of config.pages) {
	const figma = page.figma ?? {};
	if (!figma.png) continue;

	const { context, tab } = await open(browser, config, page, { viewport: { width: figma.width ?? 1440, height: 900 } });
	await settle(tab);
	const shot = await tab.screenshot({ fullPage: true });
	const png = readFileSync(resolve(figma.png));
	const { site, figma: design } = await measure(
		tab,
		`data:image/png;base64,${shot.toString('base64')}`,
		`data:image/png;base64,${png.toString('base64')}`,
		config.bandHeight,
	);

	results.push({
		page: page.name,
		check: 'tinggi halaman',
		ok: Math.abs(site.height - design.height) <= config.tolerance,
		detail: `${site.height}px (figma ${design.height}px)`,
	});

	const count = Math.min(site.bands.length, design.bands.length);
	for (let i = 0; i < count; i++) {
		const diff = Math.abs(site.bands[i] - design.bands[i]);
		if (diff <= config.bandTolerance) continue;
		const top = i * config.bandHeight;
		results.push({
			page: page.name,
			check: `pita ${top}-${top + config.bandHeight}px`,
			ok: false,
			detail: `kecerahan situs ${(site.bands[i] * 100).toFixed(0)}% vs figma ${(design.bands[i] * 100).toFixed(0)}%`,
		});
	}

	if (!results.some((result) => result.page === page.name && result.check.startsWith('pita'))) {
		results.push({ page: page.name, check: 'pita kecerahan', ok: true, detail: `${count} pita dalam toleransi` });
	}

	await context.close();
}

await browser.close();
save(config, 'bands', results);
