---
name: deflow
description: Standar kerja Development Imajiner untuk membangun website WordPress dari design Figma. Pakai saat user minta mulai project WordPress dari Figma, misalnya "mulai project dari Figma", "setup project WordPress baru", atau "deflow".
---

# Deflow

Menyiapkan WordPress lokal dengan standar Imajiner, lalu mengerjakan project mengikuti `AGENTS.md`.

File di folder skill ini:

- `AGENTS.md`: aturan dan alur 10 tahap.
- `settings.json`: deny edit ke core, plugin, dan Astra.
- `starter/imajiner-theme/`: starter child theme Astra.

## Syarat

- Posisi kerja di root WordPress (ada `wp-config.php`). Kalau bukan, minta user menyebut path root WordPress.
- `wp core version` berjalan.

## Langkah

1. Salin `AGENTS.md` dari folder skill ke root WordPress. Kalau sudah ada dan isinya berbeda, tanya dulu sebelum menimpa.
2. Buat `CLAUDE.md` di root WordPress berisi `@AGENTS.md`. Kalau file sudah ada, tambahkan baris itu jika belum ada.
3. Salin `settings.json` ke `.claude/settings.json`. Kalau sudah ada, gabungkan isi `permissions.deny` tanpa menghapus aturan lain.
4. Tanya: "Mau pakai child theme Astra (A) atau build theme sendiri tanpa Astra (B)?" Buat `docs/project.md` jika belum ada, lalu catat jawabannya.
5. Pasang theme. Kalau `wp-content/themes/imajiner-theme/` sudah ada, berhenti dan tanya user.
   - **A**: minta izin install Astra (`wp theme install astra`), salin `starter/imajiner-theme/` ke `wp-content/themes/imajiner-theme/`, lalu `wp theme activate imajiner-theme`.
   - **B**: salin starter yang sama, ubah sesuai `AGENTS.md` bagian "B. Theme sendiri", lalu aktifkan.
6. Lanjut ikuti `AGENTS.md` mulai tahap 1. Lewati langkah yang sudah selesai di atas.
