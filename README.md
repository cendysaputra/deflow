# Deflow

Skill standar kerja Development Imajiner: design Figma → WordPress (Astra child theme + ACF).

## Isi

```
SKILL.md                  langkah setup project
AGENTS.md                 aturan + alur 10 tahap
settings.json             deny edit core, plugin, Astra
starter/imajiner-theme/   starter child theme Astra
```

## Install skill

Claude Code (semua project):

```bash
git clone https://github.com/cendysaputra/deflow.git ~/.claude/skills/deflow
```

Hanya untuk satu project: clone ke `.claude/skills/deflow` di root WordPress.

Agent lain: salin `AGENTS.md` ke root WordPress dan jalankan langkah di `SKILL.md` secara manual.

## Mulai project

1. Buat site baru di LocalWP, lalu buka "Open site shell" (root WordPress di `app/public`).
2. Jalankan agent dari root WordPress.
3. Minta: "Mulai project WordPress dari Figma <link Figma>".
4. Skill menyalin `AGENTS.md`, membuat `CLAUDE.md` dan `.claude/settings.json`, menanyakan pilihan theme, memasang `imajiner-theme`, lalu lanjut ke alur 10 tahap.
