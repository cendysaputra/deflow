---
name: deflow
description: Standar kerja untuk membangun atau merevisi website dari design Figma di WordPress atau Laravel. Pakai saat user minta mulai project dari Figma, setup project WordPress/Laravel baru, mengaudit project yang sudah ada terhadap Figma, atau menyebut "deflow".
---

# Deflow

Isi skill (`<skill>`): `AGENTS.md` (aturan umum), `wordpress.md`, `laravel.md`, `settings.json`, `starter/wordpress/`, `starter/laravel/`, `qa/`.

## Langkah

1. **Stack**: ada `wp-config.php` → WordPress, ada `artisan` → Laravel. Selain itu tanya path project. Jangan tanya stack.
2. **Mode**: kalau `docs/project.md` sudah lengkap, lanjutkan dari tahap terakhir. Kalau kode project sudah ada → audit. Selain itu → baru.
3. **Identitas**: tanya nama project, author, prefix (audit: baca dulu dari kode yang ada). Minta link Figma.
4. **Pasang aturan** di root project (tanya dulu kalau file sudah ada dan berbeda):
   ```bash
   cat <skill>/AGENTS.md <skill>/wordpress.md > AGENTS.md   # atau laravel.md
   echo '@AGENTS.md' > CLAUDE.md
   mkdir -p .claude && cp <skill>/settings.json .claude/settings.json
   cp -r <skill>/qa qa
   ```
5. **Salin starter** tanpa menimpa file yang ada:
   - WordPress: `starter/wordpress/` → `wp-content/themes/{{PROJECT_SLUG}}-theme/`.
   - Laravel: `starter/laravel/resources/` → `resources/`.
   - Audit: hanya bagian yang belum ada dan sudah disetujui.
6. **Ganti placeholder** di folder hasil salinan, lalu pastikan kosong:
   ```bash
   grep -rlIE '\{\{(PROJECT_NAME|PROJECT_SLUG|AUTHOR|PREFIX|prefix)\}\}' <folder> | xargs perl -pi -e 's/\{\{PROJECT_NAME\}\}/Nama Project/g; s/\{\{PROJECT_SLUG\}\}/nama-project/g; s/\{\{AUTHOR\}\}/Nama Studio/g; s/\{\{PREFIX\}\}/NP/g; s/\{\{prefix\}\}/np/g'
   grep -rnE '\{\{(PROJECT_NAME|PROJECT_SLUG|AUTHOR|PREFIX|prefix)\}\}' <folder>
   ```
7. **Buat `docs/project.md`** (stack, mode, identitas, link Figma). Tambahkan `backup/` dan `qa/node_modules/` ke `.gitignore`.
8. Lanjut ikuti `AGENTS.md`.
