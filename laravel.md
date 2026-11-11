# Stack: Laravel

Berlaku bersama aturan umum di atas.

## Default

Tidak ditanyakan. Hanya berubah kalau user memintanya sendiri.

- Laravel lokal (Herd/Sail) + artisan. Root project adalah folder berisi file `artisan`.
- CMS: Sunrice CMS (`sunrice/admin` + `sunrice/cms`, https://github.com/Digital-Citra-Kreatif/sunrice-cms).
- Styling: Tailwind v4 lewat Vite.
- Syarat: PHP 8.4 dan Laravel 13. Cek `php -v` dan `php artisan --version` dulu. Kalau tidak cocok, berhenti dan lapor.
- Tanya sebelum install package Composer/npm, kecuali library standar: `npm install swiper@14.3.0 glightbox@3.3.1 --save-exact`.

## Identitas

- `{{PROJECT_NAME}}` → `APP_NAME` di `.env`. `{{PROJECT_SLUG}}` → `name` di `composer.json` dan `package.json`. `{{AUTHOR}}` → `authors` di `composer.json`.
- `{{prefix}}` dipakai untuk nama custom yang bisa bentrok: helper PHP, config key, event JS, key storage.
- Jangan ubah `vendor/`, `public/vendor/`, dan `node_modules/`.

## Sunrice CMS

- Paket pre-1.0. **Sebelum menulis kode, baca docs di `vendor/sunrice/cms/docs/`** (`site.md`, `fields.md`, `helpers.md`, `structure.md`, `commands.md`). Jangan menebak API.
- Setup:
  1. Hapus route welcome (`Route::get('/', ...)`) di `routes/web.php`. Kalau tidak, homepage CMS tidak tampil.
  2. `php artisan sunrice:assets` (ulangi setiap install/update paket).
  3. `php artisan vendor:publish --tag=sunrice-cms-templates`.
- Struktur (blueprint, fieldset, collection, taxonomy, global, menu) dan konten (`terms`, `entries`, nilai global) ditulis di `docs/structure.json`:
  ```bash
  php artisan sunrice:import-structure docs/structure.json --dry-run
  php artisan sunrice:import-structure docs/structure.json
  ```
  - Format file mengikuti `structure.md`. Untuk contoh, export dulu: `php artisan sunrice:export-structure <file> --entries`.
  - Import hanya menambah konten. Entry, term, dan nilai global yang sudah ada tidak ditimpa.
  - Gambar harus sudah ada di media library sebelum import. Yang tidak ditemukan dikosongkan dan dilaporkan di dry run.
  - `--force` (menghapus field) hanya dengan izin user.
- Rename field hanya lewat `php artisan sunrice:rename-field {definition} {old} {new}`, supaya nilainya ikut pindah.
- Template di `resources/views/cms/` sesuai konvensi Sunrice (`collections/{handle}/show.blade.php`, `index.blade.php`, `{slug}.blade.php`, `taxonomies/...`). Layout di `cms/layout.blade.php`.
- Komponen reusable di `resources/views/components/`.
- Data: `$values['field'] ?? null` di template halaman, `Cms::entries()`, `Cms::global()`, `Cms::menu()`. Layout dan partial membaca halaman dari `cms_page()`.
- Output di-escape dengan `{{ }}`. Rich text sudah dibersihkan saat disimpan, jadi dicetak `{!! !!}`. Field `code` tidak dibersihkan, jangan dicetak mentah.
- Layout starter Sunrice memuat `public/cms/site.css`. Ganti dengan `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
- Gambar: ikuti aturan umum "Aset gambar". Upload ke media library Sunrice, alt diisi per bahasa di media library. Cara mencetak gambar responsif (srcset, ukuran) mengikuti `site.md` dan `fields.md`. Data media dipetakan dulu ke key komponen (`src`, `srcset`, `full`, `alt`, `caption`, `width`, `height`).

## Tailwind

- Token Figma ditulis di `@theme` pada `resources/css/app.css`: warna, font, ukuran teks, spacing, radius, shadow, container 1200, gutter 24/16, section space 120/72.
- Breakpoint desktop-first: varian `max-tablet:` (≤921px) dan `max-mobile:` (≤544px). Breakpoint bawaan Tailwind (`sm:`, `md:`, `lg:`) dimatikan dan tidak dipakai.
- Dilarang arbitrary value (`w-[123px]`, `text-[#333]`). Semua nilai lewat token. Kalau nilai belum ada, tambahkan token dulu.
- Warna, font, ukuran teks, radius, dan shadow bawaan Tailwind dimatikan. Hanya token project yang tersedia.
- Pola berulang (section, container, btn, card) jadi Blade component atau `@utility` di `app.css`, bukan class panjang yang di-copy.
- Class dan id custom (nama component, `@utility`, id) kebab-case. Class utility Tailwind dibiarkan.
- Hook JS pakai `data-*`.
- CSS library (Swiper, GLightbox) dimuat lewat JS dan tidak berada di layer, jadi menang dari utility Tailwind. Override untuk elemen library ditulis di bagian "Library overrides" di `app.css` (di luar `@layer`), dengan selector yang lebih spesifik dari CSS library.

## Isi starter

| File | Isi |
|---|---|
| `resources/css/app.css` | `@theme`, varian `max-tablet` / `max-mobile`, `@utility` `section`, `section-fill`, `container`, `btn`, `btn-outline`, override library |
| `resources/js/app.js` | Init tabs, lalu `import()` `slider.js`, `marquee.js`, `lightbox.js` hanya jika komponennya ada di halaman |
| `resources/js/slider.js`, `marquee.js`, `lightbox.js` | Init Swiper dan GLightbox |
| `resources/views/components/` | `button`, `accordion`, `tabs`, `slider`, `marquee`, `gallery` |

```blade
<x-button :link="$values['hero_link'] ?? null" variant="outline" />
<x-accordion :items="$items" name="faq" :level="3" />
<x-tabs :items="$items" label="Kategori" />
<x-slider label="Produk" :per-view="[3, 2, 1]">
    @foreach ($products as $product)
        <li class="swiper-slide"><x-card :entry="$product" /></li>
    @endforeach
</x-slider>
<x-marquee :items="$logos" label="Klien" :speed="5000" />
<x-gallery :images="$images" :columns="3" />
```

- `button`: `link` = field Link Sunrice (`url`, `label`, `new_tab`).
- `accordion`: `items` = `title` + `content`. Pakai `<details>`, jalan tanpa JS.
- `tabs`: `items` = `label` + `content`. Tanpa JS, semua panel tampil.
- `slider`: isi slide lewat slot, setiap slide `<li class="swiper-slide">`. `per-view` = desktop, tablet, mobile. Tanpa JS jadi baris yang bisa di-scroll.
- `marquee`: `items` = `src`, `alt`, `width`, `height`, `link` opsional. Klon untuk loop ditandai `aria-hidden`. Berhenti saat hover dan lewat tombol jeda (muncul saat fokus keyboard). Reduced motion dan tanpa JS: logo tampil statis.
- `gallery`: `images` = `src`, `full`, `alt`, `srcset` dan `caption` opsional. Klik membuka GLightbox.
- Grid: `grid grid-cols-4 max-tablet:grid-cols-2 max-mobile:grid-cols-1`.

## Backup

Simpan di `backup/` (tidak masuk git), catat di `docs/project.md`.

| Sebelum | Perintah |
|---|---|
| Import struktur atau konten | `php artisan sunrice:export-structure backup/<tanggal>-structure.json --entries --settings` |
| Perubahan database lain (migration, seeder, rename field) | Dump database dari Herd/Sail (`mysqldump` / `sail mysql`), plus export struktur |
| Ganti media | Catat media lama → baru, file lama disimpan di `backup/media/` |

## Alur 10 tahap di Laravel

1. **Cek awal**: `php -v`, `php artisan --version`, `composer show sunrice/cms`, `php artisan route:list`. Mode audit: `php artisan sunrice:export-structure docs/structure.json --entries` untuk melihat struktur yang sudah ada, lalu catat template di `resources/views/cms/` dan komponen yang sudah ada.
2. **Setup**: install `sunrice/cms` jika belum ada (izin), jalankan langkah setup Sunrice, salin starter, `npm install` (izin), `npm install swiper@14.3.0 glightbox@3.3.1 --save-exact`, lalu `npm run build`. Cek homepage tanpa error.
3. **Analisis design**: directory = collection (listing + entry). Kategori = taxonomy. Header/footer = global + menu.
4. **Global style**: isi `@theme` di `app.css`.
5. **Struktur**: backup, lalu tulis collection, taxonomy, global, dan menu di `docs/structure.json`.
6. **Field**: tulis blueprint dan fieldset di file yang sama, lalu dry run dan import.
7. **Konten**: backup, upload gambar ke media library (alt sesuai aturan umum), tulis `entries` dan nilai global di `docs/structure.json`, lalu dry run dan import.
8. **Build halaman**: template di `resources/views/cms/`. `<section class="section">` → `<div class="container">`.
9. **QA**: skrip `qa/` terhadap URL lokal (Herd/Sail). Error di `storage/logs/laravel.log`. `npm run build` tanpa error.
10. **Animasi**: durasi dan easing dari token `--duration-reveal` / `--ease-reveal`.
