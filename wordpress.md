# Stack: WordPress

## Default

- LocalWP + WP-CLI. Child theme Astra di `wp-content/themes/{{PROJECT_SLUG}}-theme`, konten ACF (pakai yang terpasang, kalau belum ada install ACF Free), render template PHP. WooCommerce hanya jika ada produk.
- WP-CLI: pakai **Open site shell** di LocalWP. Kalau `wp` tidak ada (sering di Windows), pakai PHP milik Local dengan ekstensi `mysqli`, `gd`, `zip`, `intl`, dan set `mysqli.default_port` / `mysqli.default_socket` dari tab Database. Tanpa `gd`, srcset tidak terbentuk; setelah diperbaiki jalankan `wp media regenerate --yes`.

## Theme

- `style.css`: `{{PROJECT_NAME}} Theme`, Author `{{AUTHOR}}`, `Template: astra`, Text Domain `{{PROJECT_SLUG}}-theme`, `Update URI: false`. Slug belum dipakai di `wp theme list` dan WordPress.org.
- `screenshot.png` dari logo klien (minta ke user), kalau belum ada pakai placeholder.
- Global style dari Customizer Astra. `tokens.css` merujuk `var(--ast-global-color-N)` tanpa fallback.
- Palet bisa tertimpa demo import: di tahap 4 cek `global-color-palette` di `wp option get astra-settings --format=json` dan nilai `--ast-global-color-*` di browser.
- Header, main, footer, dan menu mobile dari Astra. Halaman custom: full width/stretched, title Astra disembunyikan jika hero punya h1.
- Prefix: function/hook/option/handle `{{prefix}}_` / `{{prefix}}-`, constant `{{PREFIX}}_`, CSS var `--{{prefix}}-`, ACF key `field_{{prefix}}_*`.

## Bentrok

- Jangan pakai class milik pihak lain: `.ast-*`, `.site-*`, `.button`, `.entry-*`, `.widget*`, `.menu*`, `.wp-*`, `.products`, `.product`, `.price`, `.woocommerce*`, `.elementor*`. Beri prefix `{{prefix}}-` jika butuh nama serupa.
- Astra dan WooCommerce (`.woocommerce-js`) mengubah margin `ul` dan heading: komponen menulis ulang margin/padding sendiri. Uji juga di halaman WooCommerce.
- Plugin optimasi (Perfmatters, WP Rocket, LiteSpeed, Autoptimize): JS theme dan library dikecualikan dari delay JS (izin), QA dengan plugin aktif.

## ACF dan WooCommerce

- CPT, taxonomy, options page, dan field group lewat ACF: tulis JSON ke `acf-json/`, user klik Sync. Bukan `register_post_type()`.
- Berulang: Free → CPT, Pro → Repeater. Data global: Pro → Options Page, Free → halaman privat `global` (baca lewat `{{prefix}}_global()`).
- Image return ID (`wp_get_attachment_image()` + `sizes`), Link return array.
- Card WooCommerce: tanpa harga dan menautkan ke daftar produk → `product_cat` (+ `thumbnail_id`); dengan harga/tombol beli → produk.

## Starter

- `inc/`: `helpers.php` (`{{prefix}}_field`, `_global`, `_component`, `_section`), `enqueue.php` (`{{prefix}}_use( 'slider' | 'marquee' | 'lightbox' )`), `acf.php`, `blocks.php`.
- `assets/css/`: `tokens`, `base` (`.section`, `.section-fill`, `.container`), `utilities` (`.grid-2/3/4`, flex, stack, `.text-*`), `components`. `assets/vendor/`: Swiper, GLightbox.
- Komponen di `template-parts/components/`, dipanggil `{{prefix}}_component( 'nama', $args )`:
  - `button` (`link` ACF), `accordion` (`items` title/content), `tabs` (`items` label/content)
  - `slider` (`items`, `part`, `per_view`), `marquee` (`items` image/link), `gallery` (`images` ID)
- Halaman: `page-{slug}.php` memanggil `{{prefix}}_section( 'nama' )`. Komponen library di atas halaman: panggil `{{prefix}}_use()` sebelum `get_header()`.

## Perintah per tahap

1. `wp core version`, `wp theme list`, `wp plugin list`.
2. `wp theme install astra` (izin), `wp theme activate {{PROJECT_SLUG}}-theme`.
4. Backup `astra-settings`, isi Customizer dan `tokens.css`. Ubah option via WP-CLI hanya jika key pasti, kalau ragu beri checklist.
5. `wp plugin install advanced-custom-fields --activate`, `wp post create --post_type=page ...`, `wp menu create`, permalink `/%postname%/`.
7. `wp media import <file> --alt="..." --porcelain`, `wp eval 'update_field( "field_{{prefix}}_...", "...", <id> );'`.
9. Log di `wp-content/debug.log`.

Backup: `wp db export backup/<tanggal>.sql`, option yang diubah `wp option get <nama> --format=json`, catat ID media lama → baru.
