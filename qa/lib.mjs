/* QA helpers */
import { mkdirSync, readFileSync, writeFileSync } from 'node:fs';
import { dirname, join, resolve } from 'node:path';
import { chromium } from 'playwright';

export const WIDTHS = [375, 544, 768, 921, 1200, 1440, 1920];
export const RATIOS = [1, 1.5, 2];

export const loadConfig = () => {
	const file = resolve(process.argv[2] || 'docs/qa/config.json');
	const config = JSON.parse(readFileSync(file, 'utf8'));
	config.out = resolve(config.out || 'docs/qa');
	config.tolerance ??= 8;
	config.bandHeight ??= 40;
	config.bandTolerance ??= 0.08;
	const only = process.argv[3];
	config.pages = config.pages.filter((page) => !only || page.name === only);
	return config;
};

export const launch = () => chromium.launch({ executablePath: process.env.QA_CHROMIUM || undefined });

export const open = async (browser, config, page, options = {}) => {
	const context = await browser.newContext({ viewport: { width: 1440, height: 900 }, ...options });
	const tab = await context.newPage();
	const errors = [];
	tab.on('pageerror', (error) => errors.push(`pageerror: ${error.message}`));
	tab.on('console', (message) => message.type() === 'error' && errors.push(`console: ${message.text()}`));
	tab.on('response', (response) => {
		const url = response.url();
		if (response.status() >= 400 && url.startsWith(config.baseUrl)) errors.push(`${response.status()}: ${url}`);
	});
	await tab.goto(new URL(page.path, config.baseUrl).href, { waitUntil: 'networkidle' });
	await tab.evaluate(() => document.fonts.ready);
	return { context, tab, errors };
};

export const settle = async (tab) => {
	await tab.evaluate(async () => {
		for (let y = 0; y < document.documentElement.scrollHeight; y += window.innerHeight) {
			window.scrollTo(0, y);
			await new Promise((done) => setTimeout(done, 100));
		}
		window.scrollTo(0, 0);
	});
	await tab.waitForLoadState('networkidle');
};

export const save = (config, name, results) => {
	mkdirSync(config.out, { recursive: true });
	const file = join(config.out, `${name}.json`);
	writeFileSync(file, JSON.stringify(results, null, 2));
	const failed = results.filter((result) => !result.ok);
	for (const result of results) console.log(`${result.ok ? 'ok  ' : 'FAIL'} ${result.page} ${result.check} ${result.detail ?? ''}`);
	console.log(`\n${results.length - failed.length}/${results.length} lolos. Laporan: ${file}`);
	process.exitCode = failed.length ? 1 : 0;
};

export const ensureDir = (file) => mkdirSync(dirname(file), { recursive: true });
