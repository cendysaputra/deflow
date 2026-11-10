# 05 — Plugin dan struktur konten

Tujuan: plugin terpasang, halaman dan struktur konten siap diisi field.

## Plugin (dengan izin)

- **ACF**:
  - Free: `wp plugin install advanced-custom-fields --activate`
  - Pro: minta file zip ke user, lalu `wp plugin install /path/acf-pro.zip --activate`. Lisensi diisi user.
- **WooCommerce** (hanya jika ada produk): `wp plugin install woocommerce --activate`. Setup wizard dan halaman Woo dibahas dengan user.
- **Elementor** (jika metode render Elementor): `wp plugin install elementor --activate`.
- Plugin lain: tanya dulu.

## Halaman

1. Buat halaman sesuai daftar di `docs/project.md`. Judul persis dari Figma:
   ```bash
   wp post create --post_type=page --post_status=publish --post_title="Judul" --post_name=slug --porcelain
   ```
2. Data global untuk ACF Free: buat halaman privat slug `global`.
3. Front page dan blog page (setting `show_on_front`, `page_on_front`, `page_for_posts`): tanya dulu sebelum mengubah.
4. Opsi A: setiap halaman custom diatur ke layout full width/stretched dan title disembunyikan jika hero Figma punya h1. Cek nama meta Astra di versi terpasang; kalau ragu, beri checklist ke user.

## CPT, taxonomy, options page

Dibuat lewat ACF, bukan `register_post_type()` di kode. Pilih salah satu:

- **Sync JSON (default)**: tulis definisi ke `imajiner-theme/acf-json/` dengan key `post_type_imj_*`, `taxonomy_imj_*`, `ui_options_page_imj_*`. Minta user klik "Sync" di admin ACF. Setelah sync, dikelola lewat UI ACF.
- **Checklist manual**: beri user daftar isian UI ACF (label, slug, supports, archive, taxonomy terkait).

Verifikasi:

```bash
wp post-type list --fields=name,label
wp taxonomy list --fields=name,label
```

## Menu dan permalink

1. Permalink: tanya dulu jika sudah terisi. Default `/%postname%/`:
   ```bash
   wp rewrite structure '/%postname%/' --hard
   ```
2. Buat menu sesuai Figma, lalu pasang ke lokasi yang ada:
   ```bash
   wp menu location list
   wp menu create "Primary"
   wp menu item add-post primary <page-id>
   wp menu location assign primary <location>
   ```

## Selesai

Update `docs/project.md` (plugin, halaman + ID, CPT/taxonomy, menu). Laporkan, berhenti, dan tunggu user.
