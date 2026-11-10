# AGENTS.md — Standar Kerja Deflow

Aturan untuk semua agent yang mengubah design Figma (via Figma MCP) menjadi website WordPress.

## Konteks

- WordPress lokal (LocalWP) + WP-CLI. Agent dijalankan dari root WordPress (folder berisi `wp-config.php`).
- Figma hanya desktop. Koneksi Figma MCP sudah siap.
- Theme project: `wp-content/themes/deflow-theme`.
- Status project ada di `docs/project.md`. Baca dulu sebelum kerja. Isinya: pilihan (theme, render, ACF, WooCommerce, font), halaman (frame Figma, slug, ID, section, status), CPT/taxonomy, field group, komponen, token mapping, pembulatan nilai, keputusan, pertanyaan terbuka, progress.

## Cara kerja

- Ikuti alur 10 tahap di bawah secara berurutan.
- Akhir setiap tahap: update `docs/project.md`, laporkan singkat, lalu **berhenti dan tunggu user**.
- Tanya dulu sebelum: install theme/plugin/library, menghapus konten, mengubah setting yang sudah terisi.

## Pilihan awal

Ditanyakan di awal project dan dicatat di `docs/project.md`.

1. **Theme**: A. child theme Astra (default) atau B. theme sendiri tanpa Astra.
2. **Render halaman**: template PHP, ACF Blocks, atau Elementor.
3. **ACF**: cek `wp plugin list`. Kalau belum ada, tanya Free atau Pro.

Cek kecocokan:

- ACF Blocks, Repeater, Flexible Content, dan Options Page hanya ada di ACF Pro.
- Elementor adalah plugin (izin dulu). Elementor Free tidak punya dynamic tags ACF, jadi bahas solusinya dengan user.
- WooCommerce hanya jika design memuat produk.

| Render | Cara |
|---|---|
| Template PHP | `page-{slug}.php` memanggil `dfl_section( 'nama' )` dari `template-parts/sections/` |
| ACF Blocks | `blocks/{nama}/block.json` + `render.php`, nama `dfl/{nama}`, terdaftar otomatis oleh `inc/blocks.php` |
| Elementor | Container dengan HTML tag benar, styling lewat class CSS global theme |

## Theme

### A. Child theme Astra

- Astra dari WordPress.org, wajib tetap terpasang sebagai induk.
- `style.css`: Theme Name `Deflow Theme`, Description `Child theme dari Astra.`, Version `1.0.0`, `Template: astra`, `Update URI: false`.
- `screenshot.png`: pakai logo project dari user. Kalau belum ada, pakai placeholder polos dari starter.
- Global style dari Customizer Astra (Global Colors, Typography, Buttons, Container). `tokens.css` merujuk `var(--ast-global-color-N)`.
- `<header>`, `<main>`, `<footer>` site sudah dari Astra. Jangan dobel.
- Halaman custom: layout full width/stretched. Sembunyikan title Astra jika hero punya h1.

### B. Theme sendiri (standalone)

Salin starter yang sama, lalu ubah:

- `style.css`: hapus baris `Template`, Description `Theme standalone.`
- `inc/enqueue.php`: hapus dependensi `astra-theme-css`.
- `tokens.css`: nilai langsung tanpa `--ast-global-color`, tambah token font dan `--dfl-h1`…`--dfl-h6` dengan override per breakpoint, `@font-face` dengan file di `assets/fonts/`.
- `inc/setup.php` (load di `functions.php`): theme support `title-tag`, `post-thumbnails`, `custom-logo`, `html5`, `responsive-embeds`, `woocommerce` (jika aktif), dan menu `primary` + `footer`.
- `header.php` / `footer.php`: skip link ke `#main-content`, `<header>`, `<nav aria-label>`, `<main id="main-content">`, `<footer>`. Nav mobile dibangun sendiri (`<button aria-expanded>` + `data-*`, menu tetap tampil tanpa JS).
- `index.php`, `page.php`, `single.php`, `archive.php`, `404.php`: minimal dan semantik.
- `base.css`: reset, typography, `.screen-reader-text`, skip link.
- Aturan Customizer Astra tidak berlaku. Aturan lain tetap.

### Anti bentrok

- Slug `deflow-theme`, Theme Name, dan Text Domain unik. `Update URI: false` supaya tidak ditimpa theme lain dengan slug sama.
- Prefix wajib: function, constant, hook, option, handle enqueue `dfl_` / `DFL_` / `dfl-`. CSS variable `--dfl-`.
- Jangan deklarasi ulang function/class milik WordPress, Astra, atau plugin.
- Jangan deregister asset Astra/plugin kecuali perlu dan sudah izin.
- Class CSS jangan pakai nama generik milik Astra/WooCommerce (`.button`, `.site-header`). Beri prefix `dfl-` jika bentrok.

## Aturan wajib

1. Jangan ubah core WordPress (`wp-admin/`, `wp-includes/`, `wp-*.php`), file plugin, atau theme Astra. Override lewat child theme, hook/filter, dan Customizer.
2. Semua nilai (warna, spacing, font-size, radius, shadow) lewat CSS variable di `tokens.css`. Dilarang inline style.
3. CSS/JS global dan reusable: satu class untuk banyak bagian. Cek class di `base.css`, `utilities.css`, `components.css` sebelum membuat yang baru.
4. Code bersih: tanpa duplikasi, tanpa kode mati, asset dimuat seperlunya.
5. Komentar hanya penanda 2–5 kata (`/* Accordion */`).
6. Class dan id hanya kebab-case (`.class-name`, `#id-name`).
   - Dilarang `class__name`, `class--name`, `class_name`, camelCase.
   - Variasi pakai class terpisah (`.card-large`). State `.is-open` / `.is-active`. Hook JS pakai `data-*`.
   - Class bawaan WP/Astra/plugin dibiarkan. PHP function dan ACF field name tetap snake_case dengan prefix.
7. JS dan CSS vanilla. Library hanya jika perlu dan sudah izin.
8. Halaman statis dulu tanpa animasi. Animasi setelah halaman + responsive disetujui.
9. Jangan mengarang konten. Teks, gambar, dan urutan mengikuti Figma. Kalau tidak jelas, tanya.

## HTML semantik

- `<section>` untuk setiap blok konten (dengan heading), `<article>` untuk item mandiri (card, post, produk, testimoni).
- `<header>` / `<footer>` untuk kepala/kaki section atau article. `<nav>` dengan `aria-label` jika lebih dari satu. `<aside>` untuk konten pendukung.
- `<figure>` + `<figcaption>` untuk gambar berketerangan. `<ul>` / `<ol>` untuk list dan grid item. `<address>` untuk kontak. `<time datetime="">` untuk tanggal.
- `<div>` hanya wrapper layout tanpa makna.
- `<button>` untuk aksi, `<a>` untuk pindah halaman. Jangan pasang klik di `<div>`.
- Satu `<h1>` per halaman. Level heading tidak loncat dan mengikuti struktur, bukan ukuran visual (ukuran lewat `.text-*`).
- Gambar wajib alt (dekoratif `alt=""`). Setiap input form punya `<label>`.

## Layout dan responsive

| | Desktop | Tablet ≤921px | Mobile ≤544px |
|---|---|---|---|
| Container | 1200px boxed | fluid | fluid |
| Padding kiri/kanan | 24px | 24px | 16px |
| Jarak antar section | 120px | 72px | 72px |

- Default ini wajib. Nilainya ada di token `--dfl-container`, `--dfl-gutter`, `--dfl-section-space`.
- Desktop-first: `@media (max-width: 921px)` dan `@media (max-width: 544px)`.
- Grid 4 → 2 → 1, 3 → 2 → 1, 2 → 1 (`.grid-4`, `.grid-3`, `.grid-2`).
- Gambar + teks berdampingan ditumpuk di mobile.
- Ukuran heading per device: Customizer Astra (A) atau token per breakpoint (B).
- Navigasi mobile: mobile header Astra (A) atau dibangun sendiri (B).
- Tab list dengan banyak item boleh scroll horizontal.
- Target sentuh minimal 44px. Tidak boleh ada scroll horizontal di halaman.
- Susunan tablet/mobile ditunjukkan ke user untuk dikonfirmasi.

## ACF

- CPT, taxonomy, options page, dan field group dibuat lewat ACF, bukan `register_post_type()` di kode.
  - Default: tulis JSON ke `deflow-theme/acf-json/`, user klik "Sync" di admin ACF.
  - Kalau ragu: beri checklist isian UI ACF ke user.
- Local JSON di `deflow-theme/acf-json` (diatur `inc/acf.php`).
- Konten berulang: Free → CPT; Pro → Repeater / Flexible Content.
- Data global: Pro → Options Page; Free → halaman privat slug `global`. Dibaca lewat `dfl_global()`.
- Field name snake_case dengan prefix section (`hero_title`). Key: `group_dfl_*`, `field_dfl_*`, `post_type_dfl_*`, `taxonomy_dfl_*`.
- Image return **ID** (render `wp_get_attachment_image()`), Link return **array**.
- Output selalu di-escape. Field kosong tidak merender wrapper-nya.

## Isi theme

| File | Isi |
|---|---|
| `inc/helpers.php` | `dfl_asset_url()`, `dfl_asset_version()`, `dfl_field()`, `dfl_global()`, `dfl_component()`, `dfl_section()` |
| `inc/enqueue.php` | CSS (tokens → base → utilities → components) dan `main.js` (defer) |
| `inc/acf.php` | Path ACF Local JSON |
| `inc/blocks.php` | Register `blocks/*/block.json` |
| `assets/css/` | `tokens.css`, `base.css` (`.section`, `.section-fill`, `.container`, focus), `utilities.css` (grid, flex, stack, text), `components.css` (btn, card, accordion, tabs) |
| `assets/js/main.js` | Init komponen via `data-*` |
| `template-parts/components/` | `button.php`, `accordion.php`, `tabs.php` |

```php
dfl_component( 'button', array( 'link' => dfl_field( 'hero_link' ), 'class' => 'btn-outline' ) );
dfl_component( 'accordion', array( 'items' => $items, 'name' => 'faq', 'level' => 3 ) );
dfl_component( 'tabs', array( 'items' => $items, 'label' => 'Kategori' ) );
```

- `button`: `link` = ACF Link (`url`, `title`, `target`).
- `accordion`: `items` = `title` + `content`. Pakai `<details>`, jalan tanpa JS.
- `tabs`: `items` = `label` + `content`. Tanpa JS, semua panel tampil.

## Alur 10 tahap

### 1. Cek awal

- `wp core version`, `wp theme list`, `wp plugin list`, `wp option get siteurl`.
- Buat `docs/project.md` jika belum ada.
- Minta link Figma, list page dan frame (nama + node id) via Figma MCP.

### 2. Pilihan dan setup theme

- Tanya pilihan awal (theme, render, ACF, logo untuk `screenshot.png`). Cek kecocokan.
- A: `wp theme install astra` (izin), pasang `deflow-theme`, `wp theme activate deflow-theme`.
- B: pasang `deflow-theme` lalu ubah sesuai bagian B.
- Pastikan front page tanpa error PHP dan asset `dfl-*` termuat.

### 3. Analisis design

- Screenshot + metadata setiap frame.
- Klasifikasi: halaman statis, directory/CPT (archive + single), produk (WooCommerce), komponen global (header/footer).
- Pecah halaman jadi section. Identifikasi komponen: accordion, tab, slider, card, form. Pakai ulang komponen starter.
- Tentukan CPT/Repeater, taxonomy, data global. Catat pertanyaan.

### 4. Global style

- Baca font, font style, warna, ukuran teks, padding, margin, gap, radius, shadow, button.
- Isi `tokens.css` dan tabel token mapping. Nilai di luar skala dibulatkan ke token terdekat dan dicatat.
- A: backup dulu `wp option get astra-settings --format=json > docs/backup/astra-settings-<tanggal>.json`, lalu isi Customizer. Ubah via WP-CLI hanya jika key sudah pasti. Kalau ragu, beri checklist manual.
- B: semua di `tokens.css`, font di `assets/fonts/` (izin sebelum unduh).

### 5. Plugin dan struktur

- Install (izin): ACF Free `wp plugin install advanced-custom-fields --activate`, ACF Pro dari zip user, WooCommerce/Elementor jika perlu.
- Buat halaman dengan judul persis Figma: `wp post create --post_type=page --post_status=publish --post_title="..." --post_name=slug`.
- CPT/taxonomy/options page via ACF.
- Menu (`wp menu create`, `wp menu item add-post`, `wp menu location assign`).
- Permalink `/%postname%/` dan front page (izin jika sudah terisi).

### 6. Field group

- Satu group per halaman / CPT / data global, hanya untuk konten yang ada di Figma.
- Location rule sesuai halaman, CPT, options, atau block `dfl/{nama}`.

### 7. Input konten

- Teks persis Figma.
- Gambar di-export dari Figma, lalu `wp media import <file> --alt="..." --porcelain`.
- Isi field pakai field key: `wp eval 'update_field( "field_dfl_hero_title", "...", <id> );'`. Global Pro pakai `"option"`.
- ACF Blocks: data disimpan di atribut block dalam `post_content`.

### 8. Build halaman

- Satu halaman per putaran, statis, tanpa animasi.
- Design context Figma MCP adalah referensi, bukan kode final.
- `<section class="section">` (+ `.section-fill` untuk section berlatar) → `<div class="container">`.
- Pakai komponen dan class global yang ada. Laporkan dan tunggu approval per halaman.

### 9. QA

- Lebar 1440, 1200, 921, 768, 544, 375. Desktop dibandingkan dengan screenshot Figma.
- Tanpa scroll horizontal (`scrollWidth > clientWidth` harus `false`), target sentuh 44px, nav mobile bisa dipakai keyboard.
- Satu h1, heading berurutan, landmark tidak dobel, alt terisi, label form.
- Tanpa error PHP (`debug.log`) dan JS (console).

### 10. Animasi (setelah approval)

- CSS + IntersectionObserver dulu. Library hanya jika perlu dan sudah izin.
- Hanya `transform` dan `opacity`, durasi dan easing dari token `--dfl-duration` / `--dfl-ease`.
- Hormati `prefers-reduced-motion`.
- Konten tetap tampil tanpa JS: state awal tersembunyi hanya berlaku setelah JS menambah class `.has-js` ke `<html>`.

## Definition of done per halaman

- Desktop sesuai Figma. Tablet dan mobile rapi tanpa scroll horizontal.
- Konten dari ACF, bukan hardcode. Tidak ada nilai hardcode yang punya token.
- Semua class/id kebab-case.
- HTML semantik: satu h1, heading berurutan, section/article sesuai makna, alt terisi.
- Tidak ada error PHP/JS. Animasi hanya setelah approval.
