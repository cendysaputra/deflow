# Deflow — Standar Kerja Development

Template default untuk project website: design Figma (dibaca via Figma MCP) menjadi WordPress. Agent-neutral, bisa dipakai Claude Code, Codex, Cursor, atau agent lain yang membaca `AGENTS.md`.

## Memulai project baru

1. Buat site baru di LocalWP. Root WordPress ada di `~/Local Sites/<nama-site>/app/public`.
2. Salin seluruh isi repo ini ke root WordPress tersebut (sejajar dengan `wp-config.php`).
3. Buka shell site dari LocalWP ("Open site shell") supaya WP-CLI terhubung ke database site.
4. Jalankan agent dari root WordPress, lalu minta agent mulai dari tahap 01.

Agent akan menyalin `starter/gitignore` ke `.gitignore` dan `templates/project.md` ke `docs/project.md`, lalu mengikuti tahap di `workflow/`.

## Isi repo

```
AGENTS.md                  aturan utama
CLAUDE.md                  @AGENTS.md (untuk Claude Code)
workflow/                  01–10, satu file per tahap
templates/project.md       template status project
starter/gitignore          .gitignore untuk root WordPress
starter/theme-child/       starter opsi A (child theme Astra)
starter/theme-standalone/  starter opsi B (tanpa Astra)
.claude/                   opsional untuk Claude Code
```

## Tahap kerja

| # | File | Isi |
|---|---|---|
| 01 | `workflow/01-figma-check.md` | Cek WordPress, siapkan docs, cek Figma |
| 02 | `workflow/02-theme-setup.md` | Pilih theme, render method, ACF, lalu setup theme |
| 03 | `workflow/03-design-analysis.md` | Klasifikasi halaman dan komponen |
| 04 | `workflow/04-global-style.md` | Token dan setting global |
| 05 | `workflow/05-plugins-structure.md` | Plugin, pages, CPT/taxonomy, menu, permalink |
| 06 | `workflow/06-field-groups.md` | Field group ACF |
| 07 | `workflow/07-content-input.md` | Input konten ke field |
| 08 | `workflow/08-build-pages.md` | Bangun halaman statis |
| 09 | `workflow/09-qa-responsive.md` | QA responsive dan semantik |
| 10 | `workflow/10-animation.md` | Animasi setelah approval |

Di akhir setiap tahap agent berhenti dan menunggu persetujuan.

## Claude Code

- `CLAUDE.md` me-load `AGENTS.md`.
- `.claude/commands/` berisi slash command per tahap, misalnya `/01-figma-check`.
- `.claude/settings.json` menolak edit ke `wp-admin`, `wp-includes`, `wp-*.php`, `wp-content/plugins`, dan `wp-content/themes/astra`.

## Git di project

`starter/gitignore` hanya men-track:

- `AGENTS.md`, `CLAUDE.md`, `workflow/`, `docs/`, `.claude/`
- Folder theme project yang tercantum di `starter/gitignore`.

Core WordPress, plugin, uploads, `starter/`, dan `templates/` tidak masuk repo project.

