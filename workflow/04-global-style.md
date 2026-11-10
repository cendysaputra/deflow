# 04 — Global style

Tujuan: semua nilai visual Figma masuk ke token dan setting global.

## Baca dari Figma

Pakai variable/style definitions dan design context dari Figma MCP. Kumpulkan:

- Font family, weight, dan style yang dipakai.
- Font size dan line height per level (h1–h6, body, small).
- Warna: brand, heading, teks, background, border.
- Spacing: padding, margin, gap yang sering muncul.
- Radius dan shadow.
- Button: ukuran, padding, radius, warna, varian (solid, outline).

## Petakan ke token

- Isi `assets/css/tokens.css`. Gunakan skala yang ada; kalau nilai Figma di luar skala, bulatkan ke token terdekat dan catat di "Pembulatan nilai".
- Isi tabel "Token mapping" di `docs/project.md` (nilai Figma → token → sumber).
- Ukuran teks besar (`--imj-text-2xl` ke atas) dikecilkan di tablet/mobile lewat override breakpoint di `tokens.css`.

### Opsi A (Astra)

1. Backup setting Astra sebelum mengubah apa pun:
   ```bash
   mkdir -p docs/backup
   wp option get astra-settings --format=json > docs/backup/astra-settings-$(date +%Y%m%d-%H%M).json
   ```
2. Isi Customizer Astra sebagai sumber utama:
   - Global Colors (palette 0–8) sesuai mapping di `tokens.css`.
   - Typography: font body dan heading, ukuran h1–h6 per device.
   - Buttons.
   - Container: lebar konten efektif 1200px.
   - Load Google Fonts locally (Performance) jika font dari Google.
3. Mengubah via WP-CLI hanya jika nama key sudah dipastikan dari backup. Kalau ragu, beri checklist ke user untuk diisi manual di Customizer.
4. `tokens.css` merujuk `var(--ast-global-color-N)`, bukan hex.

### Opsi B (standalone)

1. Tulis semua nilai langsung di `tokens.css`.
2. Font: simpan file `.woff2` di `assets/fonts/`, tulis `@font-face` di `tokens.css` bagian `/* Fonts */`. Tanya dulu sebelum mengunduh font.
3. Ukuran heading h1–h6 lewat token `--imj-h1`…`--imj-h6` dengan override per breakpoint.

## Selesai

Laporkan token yang diisi, pembulatan, dan checklist manual (jika ada). Berhenti dan tunggu user.
