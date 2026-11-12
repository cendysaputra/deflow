# Stack: Laravel

## Default

- Herd/Sail + artisan, PHP 8.4, Laravel 13. Cek `php -v` dan `php artisan --version`, berhenti kalau tidak cocok.
- CMS: Sunrice CMS (`sunrice/admin` + `sunrice/cms`). Styling: Tailwind v4 lewat Vite.
- Library standar: `npm install swiper@14.3.0 glightbox@3.3.1 --save-exact`. Package lain izin dulu.
- Identitas: `{{PROJECT_NAME}}` → `APP_NAME`, `{{PROJECT_SLUG}}` → nama di `composer.json`/`package.json`, `{{prefix}}` untuk helper, config key, dan event custom.

## Sunrice CMS

- Pre-1.0: **baca `vendor/sunrice/cms/docs/` dulu** (`site`, `fields`, `helpers`, `structure`, `commands`). Jangan menebak API.
- Setup: hapus route welcome di `routes/web.php`, `php artisan sunrice:assets`, `php artisan vendor:publish --tag=sunrice-cms-templates`. Ganti `public/cms/site.css` di layout dengan `@vite(...)`.
- Struktur dan konten di `docs/structure.json`, lalu `php artisan sunrice:import-structure docs/structure.json --dry-run`, baru import. Import hanya menambah. Gambar harus sudah ada di media library. `--force` hanya dengan izin.
- Rename field hanya lewat `sunrice:rename-field`.
- Template di `resources/views/cms/` sesuai konvensi Sunrice, komponen di `resources/views/components/`.
- Data: `$values['field'] ?? null`, `Cms::entries()`, `Cms::global()`, `Cms::menu()`, `cms_page()` di layout. Escape dengan `{{ }}`; rich text dicetak `{!! !!}`; field `code` tidak pernah mentah.
- Backup sebelum import: `php artisan sunrice:export-structure backup/<tanggal>.json --entries --settings`, plus dump database untuk perubahan lain.

## Tailwind

- Token Figma di `@theme` pada `resources/css/app.css`. Warna, font, teks, radius, dan shadow bawaan dimatikan.
- Breakpoint hanya `max-tablet:` (≤921) dan `max-mobile:` (≤544). Tanpa `sm:`/`md:`/`lg:`.
- Tanpa arbitrary value (`w-[123px]`). Nilai baru jadi token dulu.
- Pola berulang jadi Blade component atau `@utility`. Nama custom kebab-case.
- CSS Swiper/GLightbox tidak berada di layer, jadi override-nya ditulis di luar `@layer` dengan selector lebih spesifik.

## Starter

- `app.css`: `@theme`, varian breakpoint, `@utility` `section`, `section-fill`, `container`, `btn`, `btn-outline`.
- `app.js`: tabs, lalu `import()` `slider.js` / `marquee.js` / `lightbox.js` hanya jika komponennya ada.
- Komponen: `<x-button :link>`, `<x-accordion :items>`, `<x-tabs :items>`, `<x-slider :per-view>` (slide lewat slot `<li class="swiper-slide">`), `<x-marquee :items>` (src/alt/link), `<x-gallery :images>` (src/full/alt).

## Perintah per tahap

1. `composer show sunrice/cms`, `php artisan route:list`. Audit: `sunrice:export-structure` untuk melihat struktur yang ada.
2. Install `sunrice/cms` (izin), setup Sunrice, salin starter, `npm install`, `npm run build`.
3. Listing + detail = collection, kategori = taxonomy, header/footer = global + menu.
5–7. Tulis collection, taxonomy, global, menu, blueprint, dan entries di `docs/structure.json`, dry run, import.
9. Log di `storage/logs/laravel.log`, `npm run build` tanpa error.
