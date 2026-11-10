---
name: deflow
description: Standar kerja development untuk membangun website dari design Figma di WordPress atau Laravel. Pakai saat user minta mulai project website dari Figma, misalnya "mulai project dari Figma", "setup project WordPress baru", "setup project Laravel baru", atau "deflow".
---

# Deflow

Menyiapkan project lokal dengan standar Deflow, lalu mengerjakannya mengikuti `AGENTS.md`.

File di folder skill ini (`<skill>`):

- `AGENTS.md`: aturan umum dan alur 10 tahap.
- `wordpress.md`, `laravel.md`: aturan khusus stack.
- `settings.json`: deny Edit dan Write ke file milik pihak lain.
- `starter/wordpress/`, `starter/laravel/`: starter per stack.

Pertanyaan ke user hanya: identitas project, link Figma, dan izin install. Default stack tidak ditanyakan.

## Langkah

1. **Deteksi stack** di folder kerja, jangan tanya user:
   - Ada `wp-config.php` → WordPress.
   - Ada file `artisan` → Laravel.
   - Tidak keduanya → berhenti dan tanya path project.
2. **Tanya identitas**: nama project, author, dan prefix (2–4 huruf). Turunkan `{{PROJECT_NAME}}`, `{{PROJECT_SLUG}}`, `{{AUTHOR}}`, `{{prefix}}`, `{{PREFIX}}` sesuai `AGENTS.md` bagian "Identitas project". Minta juga link Figma.
3. **Buat `AGENTS.md`** di root project dari gabungan aturan umum + file stack. Kalau sudah ada dan isinya berbeda, tanya dulu sebelum menimpa.
   ```bash
   cat <skill>/AGENTS.md <skill>/wordpress.md > AGENTS.md   # atau laravel.md
   ```
4. **Buat `CLAUDE.md`** berisi `@AGENTS.md`. Kalau file sudah ada, tambahkan baris itu jika belum ada.
5. **Salin `settings.json`** ke `.claude/settings.json`. Kalau sudah ada, gabungkan isi `permissions.deny` tanpa menghapus aturan lain.
6. **Salin starter**. Jangan timpa file yang sudah ada tanpa izin.
   - WordPress: `starter/wordpress/` → `wp-content/themes/{{PROJECT_SLUG}}-theme/`. Kalau folder itu sudah ada, berhenti dan tanya user.
   - Laravel: isi `starter/laravel/` → root project (`resources/css`, `resources/js`, `resources/views/components`). `app.css` dan `app.js` bawaan Laravel boleh diganti.
7. **Ganti placeholder** di file hasil salinan, lalu pastikan tidak ada yang tersisa:
   ```bash
   grep -rlIE '\{\{(PROJECT_NAME|PROJECT_SLUG|AUTHOR|PREFIX|prefix)\}\}' <folder> | xargs perl -pi -e 's/\{\{PROJECT_NAME\}\}/Nama Project/g; s/\{\{PROJECT_SLUG\}\}/nama-project/g; s/\{\{AUTHOR\}\}/Nama Studio/g; s/\{\{PREFIX\}\}/NP/g; s/\{\{prefix\}\}/np/g'
   grep -rnE '\{\{(PROJECT_NAME|PROJECT_SLUG|AUTHOR|PREFIX|prefix)\}\}' <folder>   # harus kosong
   ```
   `AGENTS.md` di root project tidak diganti. Nilainya dicatat di `docs/project.md`.
8. **Buat `docs/project.md`** jika belum ada. Catat stack, identitas project, dan link Figma.
9. **Lanjut ikuti `AGENTS.md`** mulai tahap 1. Lewati langkah yang sudah selesai di atas.
