---
name: deflow
description: Standar kerja development untuk membangun website WordPress dari design Figma. Pakai saat user minta mulai project WordPress dari Figma, misalnya "mulai project dari Figma", "setup project WordPress baru", atau "deflow".
---

# Deflow

Menyiapkan WordPress lokal dengan standar Deflow, lalu mengerjakan project mengikuti `AGENTS.md`.

File di folder skill ini:

- `AGENTS.md`: aturan dan alur 10 tahap.
- `settings.json`: deny edit ke core, plugin, dan Astra.
- `starter/theme/`: starter child theme Astra.

## Syarat

- Posisi kerja di root WordPress (ada `wp-config.php`). Kalau bukan, minta user menyebut path root WordPress.
- `wp core version` berjalan.

## Langkah

1. Tanya nama project, author, dan prefix (2–4 huruf). Turunkan `{{THEME_NAME}}`, `{{THEME_SLUG}}`, `{{AUTHOR}}`, `{{prefix}}`, `{{PREFIX}}`, lalu cek bentrok sesuai `AGENTS.md` bagian "Identitas project". Minta juga logo klien untuk `screenshot.png`.
2. Salin `AGENTS.md` dari folder skill ke root WordPress. Kalau sudah ada dan isinya berbeda, tanya dulu sebelum menimpa.
3. Buat `CLAUDE.md` di root WordPress berisi `@AGENTS.md`. Kalau file sudah ada, tambahkan baris itu jika belum ada.
4. Salin `settings.json` ke `.claude/settings.json`. Kalau sudah ada, gabungkan isi `permissions.deny` tanpa menghapus aturan lain.
5. Tanya: "Mau pakai child theme Astra (A) atau build theme sendiri tanpa Astra (B)?" Buat `docs/project.md` jika belum ada, lalu catat jawaban ini dan identitas project.
6. Pasang theme. Kalau `wp-content/themes/{{THEME_SLUG}}/` sudah ada, berhenti dan tanya user.
   - Salin `starter/theme/` ke `wp-content/themes/{{THEME_SLUG}}/`, lalu ganti semua placeholder dengan perintah di `AGENTS.md` bagian "Identitas project".
   - Pastikan tidak ada placeholder tersisa: `grep -rn '{{' wp-content/themes/{{THEME_SLUG}}` harus kosong.
   - Ganti `screenshot.png` dengan logo klien jika sudah ada.
   - **A**: minta izin install Astra (`wp theme install astra`), lalu `wp theme activate {{THEME_SLUG}}`.
   - **B**: ubah sesuai `AGENTS.md` bagian "B. Theme sendiri", lalu aktifkan.
7. Lanjut ikuti `AGENTS.md` mulai tahap 1. Lewati langkah yang sudah selesai di atas.
