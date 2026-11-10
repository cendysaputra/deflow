# Stack: WordPress

Berlaku bersama aturan umum di atas.

## Default

Tidak ditanyakan. Hanya berubah kalau user memintanya sendiri.

- WordPress lokal (LocalWP) + WP-CLI. Root project adalah folder berisi `wp-config.php`.
- Theme: child theme Astra di `wp-content/themes/{{PROJECT_SLUG}}-theme`.
- Konten: ACF. Pakai ACF yang sudah terpasang. Kalau belum ada, minta izin install ACF Free.
- Render: template PHP.
- WooCommerce hanya jika design memuat produk (izin dulu).
- Plugin lain: tanya sebelum install.

## Theme

- Astra dari WordPress.org, wajib tetap terpasang sebagai induk (izin sebelum install).
- `style.css`: Theme Name `{{PROJECT_NAME}} Theme`, Author `{{AUTHOR}}`, Version `1.0.0`, `Template: astra`, Text Domain `{{PROJECT_SLUG}}-theme`, `Update URI: false`.
- `screenshot.png`: minta logo klien, lalu buat gambar 1200×900. Kalau belum ada, pakai placeholder polos dari starter dan catat di pertanyaan terbuka.
- Global style dari Customizer Astra (Global Colors, Typography, Buttons, Container). `tokens.css` merujuk `var(--ast-global-color-N)`.
- `<header>`, `<main>`, `<footer>` site sudah dari Astra. Jangan dobel. Navigasi mobile pakai mobile header Astra.
- Halaman custom: layout full width/stretched. Sembunyikan title Astra jika hero punya h1.
- Ukuran heading per device diatur di Customizer Astra.

## Anti bentrok

- Slug `{{PROJECT_SLUG}}-theme`, Theme Name, dan Text Domain unik: belum ada di `wp theme list` dan tidak dipakai theme di WordPress.org (`wp theme search <slug>`). `Update URI: false` supaya tidak ditimpa theme lain dengan slug sama.
- Prefix wajib: function, hook, option, handle enqueue `{{prefix}}_` / `{{prefix}}-`, constant `{{PREFIX}}_`, CSS variable `--{{prefix}}-`. Jangan pakai `wp`, `ast`, `wc`, `acf`, `el`.
- PHP function dan ACF field name snake_case dengan prefix.
- Jangan ubah core (`wp-admin/`, `wp-includes/`, `wp-*.php`), file plugin, atau theme Astra. Override lewat child theme, hook/filter, dan Customizer.
- Jangan deklarasi ulang function/class milik WordPress, Astra, atau plugin.
- Jangan deregister asset Astra/plugin kecuali perlu dan sudah izin.
- Class CSS jangan pakai nama generik milik Astra/WooCommerce (`.button`, `.site-header`). Beri prefix `{{prefix}}-` jika bentrok.

## ACF

- CPT, taxonomy, options page, dan field group dibuat lewat ACF, bukan `register_post_type()` di kode.
  - Default: tulis JSON ke `acf-json/` di theme, user klik "Sync" di admin ACF.
  - Kalau ragu: beri checklist isian UI ACF ke user.
- Local JSON di `acf-json/` (diatur `inc/acf.php`).
- Konten berulang: Free → CPT; Pro → Repeater / Flexible Content.
- Data global: Pro → Options Page; Free → halaman privat slug `global`. Dibaca lewat `{{prefix}}_global()`.
- Field name dengan prefix section (`hero_title`). Key: `group_{{prefix}}_*`, `field_{{prefix}}_*`, `post_type_{{prefix}}_*`, `taxonomy_{{prefix}}_*`.
- Image return **ID** (render `wp_get_attachment_image()`), Link return **array**.
- Escape: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`.

## Isi theme

| File | Isi |
|---|---|
| `inc/helpers.php` | `{{prefix}}_asset_url()`, `{{prefix}}_asset_version()`, `{{prefix}}_field()`, `{{prefix}}_global()`, `{{prefix}}_component()`, `{{prefix}}_section()` |
| `inc/enqueue.php` | CSS (tokens → base → utilities → components) dan `main.js` (defer) |
| `inc/acf.php` | Path ACF Local JSON |
| `inc/blocks.php` | Register `blocks/*/block.json` (hanya jika user minta ACF Blocks) |
| `assets/css/` | `tokens.css`, `base.css` (`.section`, `.section-fill`, `.container`, focus), `utilities.css` (`.grid-2/3/4`, flex, stack, `.text-*`), `components.css` (btn, card, accordion, tabs) |
| `assets/js/main.js` | Init komponen via `data-*` |
| `template-parts/components/` | `button.php`, `accordion.php`, `tabs.php` |
| `template-parts/sections/` | Section halaman |

- Token layout: `--{{prefix}}-container`, `--{{prefix}}-gutter`, `--{{prefix}}-section-space`.
- CSS desktop-first: `@media (max-width: 921px)` dan `@media (max-width: 544px)`.
- Halaman: `page-{slug}.php` memanggil `{{prefix}}_section( 'nama' )`. CPT: `archive-{cpt}.php` dan `single-{cpt}.php`.

```php
{{prefix}}_component( 'button', array( 'link' => {{prefix}}_field( 'hero_link' ), 'class' => 'btn-outline' ) );
{{prefix}}_component( 'accordion', array( 'items' => $items, 'name' => 'faq', 'level' => 3 ) );
{{prefix}}_component( 'tabs', array( 'items' => $items, 'label' => 'Kategori' ) );
```

- `button`: `link` = ACF Link (`url`, `title`, `target`).
- `accordion`: `items` = `title` + `content`. Pakai `<details>`, jalan tanpa JS.
- `tabs`: `items` = `label` + `content`. Tanpa JS, semua panel tampil.

## Alur 10 tahap di WordPress

1. **Cek awal**: `wp core version`, `wp theme list`, `wp plugin list`, `wp option get siteurl`.
2. **Setup**: `wp theme install astra` (izin), pastikan theme `{{PROJECT_SLUG}}-theme` terpasang tanpa placeholder, `wp theme activate {{PROJECT_SLUG}}-theme`. Cek asset `{{prefix}}-*` termuat.
3. **Analisis design**: directory = CPT (archive + single). Produk = WooCommerce.
4. **Global style**: backup dulu `wp option get astra-settings --format=json > docs/backup/astra-settings-<tanggal>.json`, lalu isi Customizer dan `tokens.css`. Ubah option Astra via WP-CLI hanya jika key sudah pasti. Kalau ragu, beri checklist manual.
5. **Struktur**: install (izin) ACF `wp plugin install advanced-custom-fields --activate`, WooCommerce jika perlu. Halaman: `wp post create --post_type=page --post_status=publish --post_title="..." --post_name=slug`. CPT/taxonomy/options page via ACF. Menu: `wp menu create`, `wp menu item add-post`, `wp menu location assign`. Permalink `/%postname%/` dan front page (izin jika sudah terisi).
6. **Field**: satu field group per halaman / CPT / data global, dengan location rule yang sesuai.
7. **Konten**: gambar `wp media import <file> --alt="..." --porcelain`. Isi field pakai field key: `wp eval 'update_field( "field_{{prefix}}_hero_title", "...", <id> );'`. Global Pro pakai `"option"`.
8. **Build halaman**: `<section class="section">` (+ `.section-fill` untuk section berlatar) → `<div class="container">`.
9. **QA**: error PHP di `wp-content/debug.log`.
10. **Animasi**: durasi dan easing dari token `--{{prefix}}-duration` / `--{{prefix}}-ease`.
