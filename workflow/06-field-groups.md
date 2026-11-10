# 06 — Field group ACF

Tujuan: setiap konten di Figma punya field yang tepat.

## Aturan

- Satu field group per halaman atau per CPT. Data global satu group sendiri.
- Field name snake_case dengan prefix section: `hero_title`, `hero_image`, `faq_items`.
- Key pakai prefix project: `group_imj_home`, `field_imj_hero_title`.
- Tipe field:
  - Teks pendek: Text. Paragraf: Textarea. Teks berformat: WYSIWYG.
  - Gambar: Image, return format **ID** (dirender lewat `wp_get_attachment_image()` agar alt dan srcset ikut).
  - Tombol/link: Link, return format **array** (dipakai `imj_component( 'button' )`).
  - Konten berulang: Repeater (Pro) atau CPT (Free).
- Location rule:
  - Halaman: Page == judul halaman.
  - CPT: Post Type == nama CPT.
  - Global: Options Page (Pro) atau Page == Global (Free).
  - ACF Blocks: Block == `imj/{nama}`.
- Hanya buat field untuk konten yang ada di Figma.

## Cara membuat

Sama seperti CPT di tahap 05:

- **Sync JSON (default)**: tulis `group_imj_*.json` di `imajiner-theme/acf-json/`, lalu user klik "Sync" di ACF → Field Groups.
- **Checklist manual**: daftar field per group untuk diisi user di UI ACF.

Setelah sync, cek file JSON terbarui oleh ACF (`modified` berubah) dan field muncul di editor halaman.

## Selesai

Update `docs/project.md` (daftar field group dan lokasi). Laporkan, berhenti, dan tunggu user.
