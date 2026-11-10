# 08 — Bangun halaman statis

Tujuan: setiap halaman tampil sesuai Figma desktop, dengan responsive dasar, tanpa animasi.

Kerjakan **satu halaman per putaran**. Setelah satu halaman selesai, laporkan dan tunggu approval.

## Sebelum menulis kode

1. Baca design context dan screenshot frame dari Figma MCP. Output MCP adalah referensi, bukan kode final.
2. Cek class yang sudah ada di `base.css`, `utilities.css`, dan `components.css`. Pakai ulang sebisa mungkin.
3. Cek komponen di `template-parts/components/`.

## Aturan markup

- Setiap blok konten adalah `<section class="section">` dengan heading di dalamnya. Section berlatar pakai `.section .section-fill`.
- Isi dibungkus `<div class="container">`.
- Satu h1 per halaman. Level heading berurutan.
- Card/item berdiri sendiri pakai `<article>` di dalam `<ul>`/`<li>`.
- Gambar: `wp_get_attachment_image( $id, 'large' )`. Alt dari media library.
- Semua output di-escape: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`.
- Field kosong tidak merender wrapper-nya:
  ```php
  <?php $title = imj_field( 'hero_title' ); ?>
  <?php if ( $title ) : ?>
  	<h1 class="text-4xl"><?php echo esc_html( $title ); ?></h1>
  <?php endif; ?>
  ```
- Tanpa inline style, tanpa nilai hardcode yang punya token, class kebab-case.
- Style baru: utamakan class reusable di `utilities.css` atau `components.css`. Class khusus section hanya jika benar-benar unik.

## Per metode render

### Template PHP

- File halaman: `page-{slug}.php`. CPT: `archive-{cpt}.php` dan `single-{cpt}.php`.
- Setiap section di `template-parts/sections/{nama}.php`, dipanggil `imj_section( 'hero' )`.
- Opsi A: tetap pakai `get_header()` / `get_footer()` Astra. Jangan buat `<main>` baru.

### ACF Blocks

- Satu folder per block: `blocks/{nama}/block.json` + `render.php`. Nama block `imj/{nama}`.
- `block.json` memakai `"acf": { "mode": "preview", "renderTemplate": "render.php" }`.
- Block otomatis terdaftar oleh `inc/blocks.php`.

### Elementor

- Gunakan container Elementor dengan HTML tag yang benar (section, article, header).
- Atur level heading di widget Heading sesuai struktur, bukan ukuran.
- Styling lewat class CSS global theme (field "CSS Classes"), bukan setting per widget.

## Halaman di opsi A

- Layout halaman full width/stretched supaya `.section-fill` bisa selebar layar.
- Kalau hero punya h1, sembunyikan title bawaan Astra agar tidak dobel h1.

## Selesai per halaman

Cek Definition of done di `AGENTS.md`. Update progress di `docs/project.md`, kirim ringkasan + susunan tablet/mobile untuk dikonfirmasi. Berhenti dan tunggu user.
