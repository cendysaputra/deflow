# 03 — Analisis design

Tujuan: memahami semua halaman dan komponen sebelum menulis kode.

## Langkah

1. Untuk setiap frame di `docs/project.md`, ambil screenshot dan metadata dari Figma MCP.
2. Klasifikasikan setiap frame:
   - **Halaman statis**: home, about, contact, dan sejenisnya.
   - **Directory/CPT**: daftar item dan detailnya (archive + single).
   - **Produk**: tanda butuh WooCommerce (harga, keranjang, checkout).
   - **Komponen global**: header, footer, CTA yang berulang di banyak halaman.
3. Pecah setiap halaman jadi section, urut dari atas ke bawah. Catat nama section (contoh `hero`, `features`, `faq`).
4. Identifikasi komponen yang dipakai: accordion, tab, slider, card, form, dan lainnya.
   - Cocokkan dengan komponen starter (`button`, `card`, `accordion`, `tabs`) dan pakai ulang.
   - Komponen baru (slider, form) dicatat. Kalau butuh library, tanya dulu.
5. Tentukan struktur konten:
   - Konten berulang → CPT (ACF Free) atau Repeater (ACF Pro).
   - Data global (kontak, sosmed) → Options Page (Pro) atau halaman `global` (Free).
   - Rencanakan taxonomy jika ada filter/kategori.
6. Kalau ada produk, catat bahwa WooCommerce dibutuhkan dan tanya user.
7. Kalau ada konten yang tidak jelas (teks terpotong, gambar hilang, frame mirip), catat sebagai pertanyaan.

## Output di docs/project.md

- Tabel "Halaman": tipe, slug, daftar section.
- Tabel "CPT / taxonomy".
- Bagian "Komponen".
- WooCommerce: ya/tidak.
- "Pertanyaan terbuka".

## Selesai

Laporkan klasifikasi, rencana CPT/repeater, dan pertanyaan. Berhenti dan tunggu user.
