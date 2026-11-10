# 01 — Cek WordPress dan Figma

Tujuan: memastikan environment siap dan tahu isi design.

## Langkah

1. Pastikan posisi di root WordPress (ada `wp-config.php`).
2. Cek WordPress lokal:
   ```bash
   wp core version
   wp option get siteurl
   wp theme list
   wp plugin list
   ```
3. Siapkan file project:
   - Kalau `.gitignore` belum ada, salin `starter/gitignore` ke `.gitignore`.
   - Kalau `docs/project.md` belum ada, salin `templates/project.md` ke `docs/project.md`. Jangan timpa file yang sudah ada.
   - Kalau belum ada repo git, tawarkan `git init` ke user.
4. Minta link file Figma ke user kalau belum diberikan.
5. Cek koneksi Figma MCP, lalu list semua page dan frame top-level beserta node id-nya.
6. Isi `docs/project.md`:
   - Bagian "Project": nama, URL lokal, link Figma.
   - Bagian "Environment": versi WP, theme aktif, plugin terpasang.
   - Bagian "Halaman": satu baris per frame Figma (nama frame dan node id).

## Selesai

Laporkan ke user:

- Versi WP, theme dan plugin yang terpasang.
- Daftar page dan frame Figma.
- Hal yang belum jelas (frame duplikat, frame draft, dan sejenisnya).

Berhenti dan tunggu user.
