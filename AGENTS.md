# AGENTS.md — Standar Kerja Development Imajiner

Aturan utama untuk semua agent (Claude Code, Codex, Cursor, dan lainnya) yang mengerjakan website WordPress dari design Figma.

## Konteks

- Input: design Figma (desktop saja), dibaca lewat Figma MCP. Koneksi MCP sudah siap.
- Output: website WordPress dengan theme `imajiner-theme` dan konten dari ACF.
- Environment: WordPress lokal (LocalWP) + WP-CLI. Agent dijalankan dari **root WordPress** (folder yang berisi `wp-config.php`).
- Kondisi awal setiap project: WordPress kosong. Belum ada Astra, child theme, ACF, atau plugin lain.

## Cara kerja

- Ikuti tahap di `workflow/` secara berurutan (`01` sampai `10`). Satu tahap per sesi kerja.
- Di akhir setiap tahap: update `docs/project.md`, laporkan singkat ke user, lalu **berhenti dan tunggu user**.
- `docs/project.md` adalah sumber status project. Baca file ini dulu sebelum mulai kerja. Kalau belum ada, mulai dari `workflow/01-figma-check.md`.
- Semua keputusan user dicatat di `docs/project.md` bagian "Keputusan".

## Struktur repo

| Path | Isi |
|---|---|
| `AGENTS.md` | Aturan ini |
| `workflow/` | Instruksi per tahap |
| `templates/project.md` | Template status project, disalin ke `docs/project.md` |
| `starter/theme-child/` | Starter opsi A (child theme Astra) |
| `starter/theme-standalone/` | Starter opsi B (tanpa Astra) |
| `starter/gitignore` | Disalin ke `.gitignore` di root WP |
| `docs/` | Dokumentasi project (dibuat saat project dimulai) |
| `wp-content/themes/imajiner-theme/` | Theme project (dibuat dari starter) |

## Pertanyaan wajib di awal project

Ditanyakan di tahap 02. Jawabannya dicatat di `docs/project.md`.

1. **Theme**: "Mau pakai child theme Astra atau build theme sendiri tanpa Astra?"
2. **Metode render halaman**: template PHP, ACF Blocks, atau Elementor.
3. **ACF**: cek dulu yang terpasang (`wp plugin list`). Kalau belum ada, tanya mau ACF Free atau Pro.

Cek kecocokan pilihan:

- ACF Blocks, Repeater, Flexible Content, dan Options Page **hanya ada di ACF Pro**.
- Elementor adalah plugin, jadi harus izin install dulu. Elementor Free tidak punya dynamic tags untuk ACF. Kalau konten harus dari ACF, bahas solusinya dengan user (Elementor Pro atau shortcode dari theme).
- Kalau ada pilihan yang tidak cocok, jelaskan ke user dan minta keputusan.

## Pilihan theme

Theme Imajiner belum ada di lokal. Agent membuatnya dari folder starter.

### A. Child theme Astra (default)

Langkah setup:

1. Install dan aktifkan theme Astra dari WordPress.org (**minta izin dulu**). Astra wajib tetap terpasang sebagai induk.
2. Salin `starter/theme-child/` ke `wp-content/themes/imajiner-theme/`.
3. Aktifkan `imajiner-theme`.

Catatan:

- Header `style.css`: Theme Name `Imajiner Theme`, Author `Imajiner`, Description `Child theme dari Astra.`, Version `1.0.0`, `Template: astra`, `Update URI: false`.
- `screenshot.png`: minta file logo Imajiner ke user. Kalau belum ada, pakai placeholder polos bawaan starter.
- Fitur Astra tetap dipakai: Customizer, header/footer builder, global color, typography.

### B. Theme sendiri (standalone, tanpa Astra)

Langkah setup:

1. Salin `starter/theme-standalone/` ke `wp-content/themes/imajiner-theme/`.
2. Aktifkan `imajiner-theme`. Astra tidak perlu diinstall.

Catatan:

- Header `style.css`: Theme Name `Imajiner Theme`, Author `Imajiner`, Version `1.0.0`, `Update URI: false`, tanpa baris `Template`.
- Global style, header, footer, dan responsive dibangun sendiri di theme.
- Token Figma ditulis langsung di `tokens.css` (tanpa rujukan `--ast-global-color`).
- Breakpoint tetap 921px dan 544px.
- Aturan Customizer Astra tidak berlaku. Aturan lain tetap berlaku.

## Metode render halaman

| Metode | Cara | Syarat |
|---|---|---|
| Template PHP | `page-{slug}.php` memanggil section di `template-parts/sections/` lewat `imj_section()` | ACF Free/Pro |
| ACF Blocks | Block di `blocks/{nama}/block.json` + `render.php`, otomatis terdaftar lewat `inc/blocks.php` | ACF Pro |
| Elementor | Layout di Elementor, class CSS global theme tetap dipakai | Izin install Elementor |

## Anti bentrok (A dan B)

- Slug folder `imajiner-theme`, Theme Name, dan Text Domain unik, tidak sama dengan theme di WordPress.org.
- Header `Update URI: false` supaya WordPress tidak menimpa theme dengan theme lain yang slug-nya sama.
- Semua function, constant, hook custom, option name, dan handle enqueue pakai prefix `imj_` / `IMJ_` / `imj-`.
- CSS custom property pakai prefix `--imj-`.
- Jangan deklarasi ulang function/class milik WordPress, Astra, atau plugin.
- Jangan deregister asset Astra/plugin kecuali perlu dan sudah izin.
- Class CSS tidak memakai nama generik yang sudah dipakai Astra/WooCommerce (contoh `.button`, `.site-header`). Cek dulu, beri prefix `imj-` jika bentrok.
- Opsi B: daftarkan theme support standar (title-tag, post-thumbnails, html5, menus, dan woocommerce jika dipakai). Sudah ada di `inc/setup.php`.

## Aturan wajib

1. Jangan ubah core WordPress (`wp-admin/`, `wp-includes/`, `wp-*.php`).
2. Jangan ubah file plugin (`wp-content/plugins/`).
3. Jangan ubah theme Astra. Override hanya lewat child theme, hook/filter, dan Customizer.
4. CSS/JS global dan reusable:
   - Semua nilai (warna, spacing, font-size, radius, shadow) lewat CSS variable di `tokens.css`.
   - Satu class untuk banyak bagian, bukan satu section satu CSS.
   - Cek class yang sudah ada (`base.css`, `utilities.css`, `components.css`) sebelum membuat yang baru.
   - Dilarang inline style (`style=""`), termasuk dari PHP.
5. Code bersih dan teroptimasi: tanpa duplikasi, tanpa kode mati, asset dimuat seperlunya.
6. Komentar hanya penanda 2–5 kata (contoh: `/* Accordion */`). Tanpa penjelasan panjang.
7. Naming class dan id hanya kebab-case: `.class-name`, `#id-name`.
   - Dilarang: `class__name`, `class--name`, `class_name`, camelCase.
   - Variasi pakai class terpisah (`.card-large`). State pakai `.is-open` / `.is-active`.
   - Hook JS pakai atribut `data-*`.
   - Class bawaan WP/Astra/plugin dibiarkan.
   - PHP function dan ACF field name tetap snake_case dengan prefix project.
8. Bangun halaman statis dulu tanpa animasi. Animasi setelah halaman + responsive disetujui.
9. Jangan mengarang konten. Semua teks, gambar, dan urutan mengikuti Figma. Kalau tidak jelas, tanya.
10. Tanya dulu sebelum: install theme/plugin/library, menghapus konten, mengubah setting yang sudah terisi.
11. HTML5 semantik di semua markup yang kita tulis (lihat bagian berikut).

## HTML semantik

- Pakai tag sesuai makna:
  - `<section>`: setiap blok konten halaman, dengan heading di dalamnya.
  - `<article>`: item yang berdiri sendiri (card CPT, post, produk, testimoni).
  - `<header>` / `<footer>`: kepala/kaki section atau article.
  - `<nav>`: navigasi. Beri `aria-label` jika ada lebih dari satu.
  - `<aside>`: konten pendukung (sidebar, info tambahan).
  - `<figure>` + `<figcaption>`: gambar dengan keterangan.
  - `<ul>` / `<ol>`: list dan grid item.
  - `<address>`: info kontak. `<time datetime="">`: tanggal.
- `<div>` hanya untuk wrapper layout tanpa makna (`.container`, grid wrapper).
- `<button>` untuk aksi, `<a>` untuk pindah halaman. Jangan pasang klik di `<div>`.
- Heading:
  - Satu `<h1>` per halaman.
  - Level tidak boleh loncat (h2 → h4).
  - Level mengikuti struktur konten, bukan ukuran visual. Ukuran diatur lewat class (`.text-*`).
- Landmark site-level:
  - Opsi A: `<header>`, `<main>`, `<footer>` site sudah dari Astra. Jangan dobel. Di dalam konten pakai `<section>` / `<article>`.
  - Opsi B: theme membuat sendiri `<header>`, `<main id="main-content">`, `<footer>`, plus skip link ke main content. Sudah ada di starter.
- Gambar wajib alt. Gambar dekoratif pakai `alt=""`.
- Form: setiap input punya `<label>`.

## Default layout

| | Desktop | Tablet ≤921px | Mobile ≤544px |
|---|---|---|---|
| Container | 1200px boxed | fluid | fluid |
| Padding kiri/kanan | 24px | 24px | 16px |
| Jarak antar section | 120px | 72px | 72px |

Breakpoint ditulis desktop-first: `@media (max-width: 921px)` dan `@media (max-width: 544px)`.

## Menyusun responsive (Figma hanya desktop)

- Grid: 4 kolom → 2 → 1, 3 → 2 → 1, 2 → 1 (class `.grid-4`, `.grid-3`, `.grid-2`).
- Gambar + teks berdampingan ditumpuk di mobile.
- Ukuran heading per device: Customizer Astra (A) atau token dengan override per breakpoint (B).
- Navigasi mobile: mobile header Astra (A) atau dibangun sendiri (B).
- Tab list dengan banyak item boleh scroll horizontal.
- Target sentuh minimal 44px (`--imj-touch`).
- Tidak boleh ada scroll horizontal di halaman.
- Susunan tablet/mobile ditunjukkan ke user untuk dikonfirmasi.

## Global style

- Opsi A: sumber utama Customizer Astra (Global Colors, Typography, Buttons, Container width). `tokens.css` merujuk `var(--ast-global-color-N)`.
- Opsi B: semua di `tokens.css`, termasuk `@font-face`.
- Font: diatur dari Astra (A) atau dari theme sendiri, file di `assets/fonts/` (B).
- Nilai Figma di luar skala dibulatkan ke token terdekat dan dicatat di `docs/project.md`.
- Mengubah option Astra via WP-CLI: backup dulu dan cek nama key yang benar. Kalau ragu, beri checklist ke user untuk diisi manual.

## ACF

- CPT, taxonomy, options page, dan field group dibuat **lewat ACF**, bukan `register_post_type()` di kode.
- ACF Local JSON aktif di `imajiner-theme/acf-json` (diatur di `inc/acf.php`).
- Konten berulang: ACF Free → CPT; ACF Pro → Repeater / Flexible Content / Options Page.
- Data global (kontak, sosmed, footer): ACF Pro → Options Page; ACF Free → halaman privat dengan slug `global`. Keduanya dibaca lewat `imj_global()`.
- Field name snake_case dengan prefix section (contoh `hero_title`).
- Key ACF pakai prefix project: `group_imj_*`, `field_imj_*`, `post_type_imj_*`, `taxonomy_imj_*`.
- Input data via WP-CLI:
  - Teks persis Figma.
  - Gambar di-export dari Figma, `wp media import`, alt text diisi.
- Output selalu di-escape. Field kosong tidak merender wrapper-nya.

## WooCommerce dan plugin lain

- WooCommerce hanya dipasang jika design memuat produk.
- Plugin lain belum ada standar. Pakai bawaan WordPress lokal dan tanya sebelum install apa pun.
- JS dan CSS vanilla. Library boleh jika perlu, tapi tanya dulu.

## Isi theme (dari starter)

| File | Isi |
|---|---|
| `functions.php` | Load file di `inc/` |
| `inc/helpers.php` | `imj_asset_url()`, `imj_asset_version()`, `imj_field()`, `imj_global()`, `imj_component()`, `imj_section()` |
| `inc/enqueue.php` | Enqueue CSS dan JS |
| `inc/acf.php` | Path ACF Local JSON |
| `inc/blocks.php` | Register `blocks/*/block.json` |
| `inc/setup.php` | Theme support dan menu (B saja) |
| `assets/css/tokens.css` | Semua token |
| `assets/css/base.css` | `.section`, `.section-fill`, `.container`, focus-visible |
| `assets/css/utilities.css` | Grid, flex, stack, text size |
| `assets/css/components.css` | Button, card, accordion, tabs |
| `assets/js/main.js` | Init komponen via `data-*` |
| `template-parts/components/` | `button.php`, `accordion.php`, `tabs.php` (+ `post-card.php` di B) |
| `template-parts/sections/` | Section halaman (metode template PHP) |

Komponen dipanggil lewat helper:

```php
imj_component( 'button', array( 'link' => imj_field( 'hero_link' ) ) );
imj_component( 'accordion', array( 'items' => $items, 'name' => 'faq' ) );
imj_component( 'tabs', array( 'items' => $items, 'label' => 'Kategori' ) );
```

- `button`: `link` = array ACF Link (`url`, `title`, `target`), `class` opsional (`btn-outline`).
- `accordion`: `items` = array `title` + `content`, `name` opsional (satu terbuka sekaligus), `level` heading (default 3). Pakai `<details>`, jalan tanpa JS.
- `tabs`: `items` = array `label` + `content`, `label` untuk `aria-label`. Tanpa JS, semua panel tampil.
- Data ACF dipetakan dulu ke key di atas sebelum dikirim ke komponen.

## Definition of done per halaman

- Desktop sesuai Figma.
- Tablet dan mobile rapi, tanpa scroll horizontal.
- Konten dari ACF, bukan hardcode.
- Tidak ada nilai hardcode yang punya token.
- Semua class/id kebab-case.
- HTML semantik: satu h1, heading berurutan, section/article sesuai makna, alt gambar terisi.
- Tidak ada error PHP/JS.
- Animasi hanya setelah approval.
