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

## WP-CLI di LocalWP

- Pakai **Open site shell** dari LocalWP. Shell itu sudah menyiapkan PHP, `wp`, dan koneksi database site.
- Kalau `wp` tidak ada di PATH (sering di Windows):
  1. Pakai PHP milik Local: `%LOCALAPPDATA%\Programs\Local\resources\extraResources\lightning-services\php-<versi>\bin\win64\php.exe` (macOS: `~/Library/Application Support/Local/lightning-services/php-<versi>/bin/darwin*/bin/php`).
  2. Jalankan `wp-cli.phar` dengan PHP tersebut. Minta izin sebelum mengunduh `wp-cli.phar`.
  3. Pastikan ekstensi `mysqli`, `gd`, `zip`, `intl` aktif: `php -m`. Kalau belum, aktifkan di `php.ini` yang dipakai (`php --ini`).
  4. Database Local tidak memakai port standar. Tanpa mengubah `wp-config.php`, atur di `php.ini` yang dipakai WP-CLI: `mysqli.default_port=<port>` (Windows) atau `mysqli.default_socket=<socket>` (macOS/Linux). Port dan socket ada di tab **Database** di LocalWP.
- Cek setup dengan `wp --info` dan `wp db check`.
- Tanpa ekstensi `gd`/`imagick`, ukuran turunan gambar (srcset) tidak terbentuk. Setelah ekstensi aktif: `wp media regenerate --yes` (backup dulu).

## Theme

- Astra dari WordPress.org, wajib tetap terpasang sebagai induk (izin sebelum install).
- `style.css`: Theme Name `{{PROJECT_NAME}} Theme`, Author `{{AUTHOR}}`, Version `1.0.0`, `Template: astra`, Text Domain `{{PROJECT_SLUG}}-theme`, `Update URI: false`.
- `screenshot.png`: minta logo klien, lalu buat gambar 1200×900. Kalau belum ada, pakai placeholder polos dari starter dan catat di pertanyaan terbuka.
- Global style dari Customizer Astra (Global Colors, Typography, Buttons, Container). `tokens.css` merujuk `var(--ast-global-color-N)` **tanpa nilai fallback**, supaya warna yang salah langsung terlihat.
- `<header>`, `<main>`, `<footer>` site sudah dari Astra. Jangan dobel. Navigasi mobile pakai mobile header Astra.
- Halaman custom: layout full width/stretched. Sembunyikan title Astra jika hero punya h1.
- Ukuran heading per device diatur di Customizer Astra.

### Palet aktif

Palet Astra bisa tertimpa diam-diam oleh demo/starter template yang pernah di-import. Di tahap 4:

1. Baca palet aktif: `wp option get astra-settings --format=json` → `global-color-palette.palette`.
2. Bandingkan setiap slot dengan warna Figma di tabel token mapping.
3. Kalau beda: backup, lalu perbaiki lewat Customizer (atau WP-CLI jika key pasti). Cek juga custom CSS Customizer (`wp option get theme_mods_{{PROJECT_SLUG}}-theme`) dan CSS dari plugin builder yang ikut ter-import.
4. Di browser, cek nilai `getComputedStyle(document.documentElement).getPropertyValue('--ast-global-color-0')` dan seterusnya.

## Anti bentrok

- Slug `{{PROJECT_SLUG}}-theme`, Theme Name, dan Text Domain unik: belum ada di `wp theme list` dan tidak dipakai theme di WordPress.org (`wp theme search <slug>`). `Update URI: false` supaya tidak ditimpa theme lain dengan slug sama.
- Prefix wajib: function, hook, option, handle enqueue `{{prefix}}_` / `{{prefix}}-`, constant `{{PREFIX}}_`, CSS variable `--{{prefix}}-`. Jangan pakai `wp`, `ast`, `wc`, `acf`, `el`.
- PHP function dan ACF field name snake_case dengan prefix.
- Jangan ubah core (`wp-admin/`, `wp-includes/`, `wp-*.php`), file plugin, atau theme Astra. Override lewat child theme, hook/filter, dan Customizer.
- Jangan deklarasi ulang function/class milik WordPress, Astra, atau plugin.
- Jangan deregister asset Astra/plugin kecuali perlu dan sudah izin.

### Class terlarang

Jangan dipakai sebagai class custom. Kalau butuh nama serupa, beri prefix `{{prefix}}-` (misalnya `.{{prefix}}-products`).

| Asal | Class |
|---|---|
| WordPress | `.page`, `.post`, `.entry-*`, `.widget*`, `.menu*`, `.sticky`, `.alignleft`, `.alignright`, `.aligncenter`, `.wp-*`, `.screen-reader-text` (hanya dipakai, tidak didefinisikan ulang) |
| Astra | `.ast-*`, `.site-*`, `.main-header-*`, `.button`, `.page-title` |
| WooCommerce | `.products`, `.product`, `.price`, `.woocommerce*`, `.cart*`, `.added_to_cart`, `.onsale`, `.star-rating` |
| Elementor dan builder | `.elementor*`, `.e-*`, `.fl-*`, `.et_pb_*` |

### Reset bawaan yang perlu diantisipasi

- Astra memberi margin dan `list-style` pada `ul`/`ol` di konten, serta margin pada `h1`–`h6`. Komponen yang memakai list atau heading menulis ulang margin dan padding di class komponennya sendiri.
- WooCommerce menambah aturan di `body.woocommerce-js` (misalnya margin `h2`). Uji setiap komponen di halaman dengan WooCommerce aktif.
- Cek QA di halaman biasa dan halaman WooCommerce (shop, kategori, produk).

### Plugin optimasi

- Cek `wp plugin list` untuk Perfmatters, WP Rocket, LiteSpeed Cache, Autoptimize, Flying Scripts, dan sejenisnya.
- Fitur "delay JS" menunda script sampai interaksi pertama, lalu memutar ulang klik itu. Akibatnya klik pertama bisa jalan dua kali (slider bergeser dua slide).
  - JS theme (`{{prefix}}-*`, Swiper, GLightbox) dikecualikan dari delay. Ubah setting plugin hanya dengan izin dan backup option-nya.
  - Inisialisasi komponen di starter sudah idempotent. Pertahankan pola itu di komponen baru.
- Combine/minify CSS dan JS bisa mengubah urutan load. QA dilakukan dengan plugin optimasi aktif, setelah cache dibersihkan.

## ACF

- CPT, taxonomy, options page, dan field group dibuat lewat ACF, bukan `register_post_type()` di kode.
  - Default: tulis JSON ke `acf-json/` di theme, user klik "Sync" di admin ACF.
  - Kalau ragu: beri checklist isian UI ACF ke user.
- Local JSON di `acf-json/` (diatur `inc/acf.php`).
- Konten berulang: Free → CPT; Pro → Repeater / Flexible Content.
- Data global: Pro → Options Page; Free → halaman privat slug `global`. Dibaca lewat `{{prefix}}_global()`.
- Field name dengan prefix section (`hero_title`). Key: `group_{{prefix}}_*`, `field_{{prefix}}_*`, `post_type_{{prefix}}_*`, `taxonomy_{{prefix}}_*`.
- Image return **ID** (render `wp_get_attachment_image()` dengan `sizes` sesuai lebar tampil), Link return **array**, Gallery return **ID array**.
- Escape: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`.

## WooCommerce

Pemetaan card di design:

| Card di design | Dipetakan ke | Data |
|---|---|---|
| Menautkan ke daftar produk (nama kategori, gambar, tanpa harga) | Term `product_cat` | `name`, `description`, gambar dari term meta `thumbnail_id`, link `get_term_link()` |
| Menampilkan harga, tombol beli/keranjang, atau rating | Produk | `wc_get_product()`, gambar produk, harga `get_price_html()` |
| Koleksi pilihan tanpa harga yang menautkan ke produk | Produk (pilih lewat field Relationship) | Sama seperti produk |

- Keputusan pemetaan dicatat di `docs/project.md`.
- Template WooCommerce di-override hanya lewat hook atau salinan di `woocommerce/` di theme, dan hanya jika perlu.

## Backup

Simpan di `backup/` (tidak masuk git), catat di `docs/project.md`.

| Sebelum | Perintah |
|---|---|
| Perubahan apa pun di database | `wp db export backup/<tanggal>-db.sql` |
| Ubah option (Astra, plugin, Customizer) | `wp option get <nama> --format=json > backup/<tanggal>-<nama>.json` |
| Ubah menu | `wp menu list --format=json` dan `wp menu item list <menu> --format=json` |
| Ganti media | Catat ID lama → ID baru, file lama disimpan di `backup/media/` |
| Regenerate ukuran gambar | `wp db export` dulu |

## Isi theme

| File | Isi |
|---|---|
| `inc/helpers.php` | `{{prefix}}_asset_url()`, `{{prefix}}_asset_version()`, `{{prefix}}_field()`, `{{prefix}}_global()`, `{{prefix}}_component()`, `{{prefix}}_section()` |
| `inc/enqueue.php` | CSS global, `main.js`, register library, `{{prefix}}_use( 'slider' \| 'marquee' \| 'lightbox' )` |
| `inc/acf.php` | Path ACF Local JSON |
| `inc/blocks.php` | Register `blocks/*/block.json` (hanya jika user minta ACF Blocks) |
| `assets/css/` | `tokens.css`, `base.css` (`.section`, `.section-fill`, `.container`, focus), `utilities.css` (`.grid-2/3/4`, flex, stack, `.text-*`), `components.css` |
| `assets/js/` | `main.js` (tabs), `slider.js`, `marquee.js`, `lightbox.js` |
| `assets/vendor/` | Swiper 14.3.0, GLightbox 3.3.1 |
| `template-parts/components/` | `button`, `accordion`, `tabs`, `slider`, `marquee`, `gallery` |
| `template-parts/sections/` | Section halaman |

- Token layout: `--{{prefix}}-container`, `--{{prefix}}-gutter`, `--{{prefix}}-section-space`, `--{{prefix}}-hero-height`, `--{{prefix}}-overlay`.
- CSS desktop-first: `@media (max-width: 921px)` dan `@media (max-width: 544px)`.
- Halaman: `page-{slug}.php` memanggil `{{prefix}}_section( 'nama' )`. CPT: `archive-{cpt}.php` dan `single-{cpt}.php`.
- Komponen yang memakai library memanggil `{{prefix}}_use()` sendiri. Kalau komponen itu ada di bagian atas halaman, panggil `{{prefix}}_use()` di template sebelum `get_header()` supaya CSS-nya masuk ke `<head>`.

```php
{{prefix}}_component( 'button', array( 'link' => {{prefix}}_field( 'hero_link' ), 'class' => 'btn-outline' ) );
{{prefix}}_component( 'accordion', array( 'items' => $items, 'name' => 'faq', 'level' => 3 ) );
{{prefix}}_component( 'tabs', array( 'items' => $items, 'label' => 'Kategori' ) );
{{prefix}}_component( 'slider', array( 'items' => $cards, 'part' => 'card-product', 'per_view' => array( 3, 2, 1 ), 'label' => 'Produk' ) );
{{prefix}}_component( 'marquee', array( 'items' => $logos, 'speed' => 5000, 'label' => 'Klien' ) );
{{prefix}}_component( 'gallery', array( 'images' => $ids, 'columns' => 3 ) );
```

- `button`: `link` = ACF Link (`url`, `title`, `target`).
- `accordion`: `items` = `title` + `content`. Pakai `<details>`, jalan tanpa JS.
- `tabs`: `items` = `label` + `content`. Tanpa JS, semua panel tampil.
- `slider`: `items` dirender satu per slide lewat komponen `part`. `per_view` = desktop, tablet, mobile. Tanpa JS jadi baris yang bisa di-scroll.
- `marquee`: `items` = `image` (ID) + `link` opsional. Klon untuk loop ditandai `aria-hidden`. Berhenti saat hover dan lewat tombol jeda (muncul saat fokus keyboard). Reduced motion dan tanpa JS: logo tampil statis.
- `gallery`: `images` = ID gambar. Klik membuka GLightbox, caption dari media library.

## Alur 10 tahap di WordPress

1. **Cek awal**: `wp core version`, `wp theme list`, `wp plugin list`, `wp option get siteurl`. Cek plugin optimasi dan demo yang pernah di-import. Mode audit: catat theme aktif, child theme, field group, CPT, dan menu yang sudah ada.
2. **Setup**: `wp theme install astra` (izin), pastikan theme `{{PROJECT_SLUG}}-theme` terpasang tanpa placeholder, `wp theme activate {{PROJECT_SLUG}}-theme`. Cek asset `{{prefix}}-*` termuat.
3. **Analisis design**: directory = CPT (archive + single). Produk = WooCommerce, pemetaan card sesuai tabel di atas.
4. **Global style**: backup `astra-settings`, cek palet aktif, lalu isi Customizer dan `tokens.css`. Ubah option Astra via WP-CLI hanya jika key sudah pasti. Kalau ragu, beri checklist manual.
5. **Struktur**: backup, install (izin) ACF `wp plugin install advanced-custom-fields --activate`, WooCommerce jika perlu. Halaman: `wp post create --post_type=page --post_status=publish --post_title="..." --post_name=slug`. CPT/taxonomy/options page via ACF. Menu: `wp menu create`, `wp menu item add-post`, `wp menu location assign`. Permalink `/%postname%/` dan front page (izin jika sudah terisi).
6. **Field**: satu field group per halaman / CPT / data global, dengan location rule yang sesuai.
7. **Konten**: backup, lalu gambar `wp media import <file> --title="..." --alt="..." --porcelain` (alt sesuai aturan umum). Cek ukuran turunan terbentuk (`wp post meta get <id> _wp_attachment_metadata`). Isi field pakai field key: `wp eval 'update_field( "field_{{prefix}}_hero_title", "...", <id> );'`. Global Pro pakai `"option"`.
8. **Build halaman**: `<section class="section">` (+ `.section-fill` untuk section berlatar) → `<div class="container">`.
9. **QA**: skrip `qa/` dengan plugin optimasi aktif dan cache dibersihkan. Error PHP di `wp-content/debug.log`.
10. **Animasi**: durasi dan easing dari token `--{{prefix}}-duration` / `--{{prefix}}-ease`.
