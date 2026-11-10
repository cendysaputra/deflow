# 02 — Pilihan theme dan setup

Tujuan: menentukan theme, metode render, dan ACF, lalu memasang `imajiner-theme`.

## Pertanyaan ke user

Tanyakan dalam satu pesan:

1. "Mau pakai child theme Astra (A, default) atau build theme sendiri tanpa Astra (B)?"
2. "Metode render halaman: template PHP, ACF Blocks, atau Elementor?"
3. ACF: cek dulu dengan `wp plugin list` (slug `advanced-custom-fields` atau `advanced-custom-fields-pro`). Kalau belum ada, tanya: "Mau ACF Free atau Pro?"
4. "Ada file logo Imajiner untuk `screenshot.png`?" (opsi A dan B)

Cek kecocokan jawaban (lihat AGENTS.md bagian "Pertanyaan wajib"):

- ACF Blocks → wajib ACF Pro.
- Elementor → perlu izin install. Elementor Free tidak punya dynamic tags untuk ACF.
- ACF Free → konten berulang pakai CPT, data global pakai halaman privat `global`.

Catat semua jawaban di `docs/project.md` bagian "Pilihan".

## Setup opsi A (child theme Astra)

1. Minta izin install Astra, lalu:
   ```bash
   wp theme install astra --activate
   ```
2. Pastikan belum ada folder `wp-content/themes/imajiner-theme/`. Kalau sudah ada, berhenti dan tanya user.
3. Salin `starter/theme-child/` ke `wp-content/themes/imajiner-theme/`.
4. Kalau user memberi logo, buat `screenshot.png` 1200×900 dari logo tersebut. Kalau tidak, biarkan placeholder.
5. Aktifkan:
   ```bash
   wp theme activate imajiner-theme
   wp theme list
   ```

## Setup opsi B (standalone)

1. Pastikan belum ada folder `wp-content/themes/imajiner-theme/`.
2. Salin `starter/theme-standalone/` ke `wp-content/themes/imajiner-theme/`.
3. Ganti `screenshot.png` jika ada logo.
4. Aktifkan:
   ```bash
   wp theme activate imajiner-theme
   ```

## Verifikasi

- `wp theme list` menunjukkan `imajiner-theme` aktif (dan `astra` terpasang untuk A).
- Front page terbuka tanpa error PHP. Cek `wp-content/debug.log` jika `WP_DEBUG_LOG` aktif.
- CSS dan JS theme termuat (cek source halaman: handle `imj-tokens-css` dan `imj-main-js`).

## Selesai

Update `docs/project.md` (Pilihan, Status tahap, Keputusan). Laporkan singkat, lalu berhenti dan tunggu user.
