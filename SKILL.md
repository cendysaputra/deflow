---
name: deflow
description: Standar kerja development untuk membangun atau merevisi website dari design Figma di WordPress atau Laravel. Pakai saat user minta mulai project website dari Figma, merapikan project yang sudah berjalan agar sesuai Figma, misalnya "mulai project dari Figma", "setup project WordPress baru", "setup project Laravel baru", "audit project ini dengan Figma", atau "deflow".
---

# Deflow

Menyiapkan project lokal dengan standar Deflow, lalu mengerjakannya mengikuti `AGENTS.md`.

File di folder skill ini (`<skill>`):

- `AGENTS.md`: aturan umum, mode, dan alur 10 tahap.
- `wordpress.md`, `laravel.md`: aturan khusus stack.
- `settings.json`: deny Edit dan Write ke file milik pihak lain.
- `starter/wordpress/`, `starter/laravel/`: starter per stack.
- `qa/`: skrip Playwright untuk tahap 9.

Pertanyaan ke user hanya: identitas project, link Figma, dan izin install. Default stack tidak ditanyakan.

## Langkah

1. **Deteksi stack** di folder kerja, jangan tanya user:
   - Ada `wp-config.php` → WordPress.
   - Ada file `artisan` → Laravel.
   - Tidak keduanya → berhenti dan tanya path project.
2. **Deteksi mode**:
   - **Audit**: sudah ada kode project (WordPress: theme selain theme bawaan atau child theme aktif; Laravel: template di `resources/views/cms/` atau view selain `welcome`), tapi `AGENTS.md` / `docs/project.md` belum ada atau belum lengkap.
   - **Baru**: selain itu.
   - Kalau `docs/project.md` sudah lengkap, baca saja dan lanjutkan dari tahap terakhir.
3. **Identitas**:
   - Baru: tanya nama project, author, dan prefix (2–4 huruf).
   - Audit: baca dulu dari kode yang ada (header `style.css`, Text Domain, prefix function, `APP_NAME`, `composer.json`). Tanya hanya yang tidak ditemukan.
   - Turunkan `{{PROJECT_NAME}}`, `{{PROJECT_SLUG}}`, `{{AUTHOR}}`, `{{prefix}}`, `{{PREFIX}}` sesuai `AGENTS.md` bagian "Identitas project". Minta juga link Figma.
4. **Buat `AGENTS.md`** di root project dari gabungan aturan umum + file stack. Kalau sudah ada dan isinya berbeda, tanya dulu sebelum menimpa.
   ```bash
   cat <skill>/AGENTS.md <skill>/wordpress.md > AGENTS.md   # atau laravel.md
   ```
5. **Buat `CLAUDE.md`** berisi `@AGENTS.md`. Kalau file sudah ada, tambahkan baris itu jika belum ada.
6. **Salin `settings.json`** ke `.claude/settings.json`. Kalau sudah ada, gabungkan isi `permissions.deny` tanpa menghapus aturan lain.
7. **Salin starter**. Jangan timpa file yang sudah ada tanpa izin.
   - WordPress, mode baru: `starter/wordpress/` → `wp-content/themes/{{PROJECT_SLUG}}-theme/`. Kalau folder itu sudah ada, berhenti dan tanya user.
   - WordPress, mode audit: salin hanya file starter yang belum ada di theme (misalnya komponen dan `assets/vendor/`), setelah dicatat di daftar selisih dan disetujui.
   - Laravel: isi `starter/laravel/` → root project (`resources/css`, `resources/js`, `resources/views/components`). Mode baru: `app.css` dan `app.js` bawaan Laravel boleh diganti. Mode audit: gabungkan, jangan timpa.
8. **Ganti placeholder** di file hasil salinan, lalu pastikan tidak ada yang tersisa:
   ```bash
   grep -rlIE '\{\{(PROJECT_NAME|PROJECT_SLUG|AUTHOR|PREFIX|prefix)\}\}' <folder> | xargs perl -pi -e 's/\{\{PROJECT_NAME\}\}/Nama Project/g; s/\{\{PROJECT_SLUG\}\}/nama-project/g; s/\{\{AUTHOR\}\}/Nama Studio/g; s/\{\{PREFIX\}\}/NP/g; s/\{\{prefix\}\}/np/g'
   grep -rnE '\{\{(PROJECT_NAME|PROJECT_SLUG|AUTHOR|PREFIX|prefix)\}\}' <folder>   # harus kosong
   ```
   `AGENTS.md` di root project tidak diganti. Nilainya dicatat di `docs/project.md`. File di `assets/vendor/` tidak memakai placeholder dan tidak diubah.
9. **Salin `qa/`** ke root project (tanpa `node_modules`). Install Playwright minta izin dulu, saat tahap 9.
10. **Buat `docs/project.md`** jika belum ada. Catat stack, mode, identitas project, dan link Figma. Tambahkan `backup/` dan `qa/node_modules/` ke `.gitignore` project jika ada.
11. **Lanjut ikuti `AGENTS.md`** mulai tahap 1 (mode baru) atau bagian "Mode → Audit" (mode audit). Lewati langkah yang sudah selesai di atas.
