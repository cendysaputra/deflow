# Deflow

Skill untuk membangun website WordPress dari design Figma (Astra child theme + ACF). Aturannya ada di `AGENTS.md`, jadi bisa dipakai Claude Code, Codex, Cursor, atau agent lain.

## Isi

```
SKILL.md        langkah setup project
AGENTS.md       aturan + alur 10 tahap
settings.json   blokir edit core WP, plugin, dan Astra (Claude Code)
starter/theme/  starter child theme dengan placeholder
```

## Install di lokal

Claude Code:

```bash
git clone https://github.com/cendysaputra/deflow.git ~/.claude/skills/deflow
```

Update: `git -C ~/.claude/skills/deflow pull`

Agent lain: clone di folder mana saja. Saat mulai project, minta agent membaca `SKILL.md` dari folder itu.

## Mulai project

1. Buat site di LocalWP, lalu buka **Open site shell**.
2. Jalankan agent dari root WordPress (`app/public`).
3. Minta: `Mulai project WordPress dari Figma <link>`.

Agent akan menanyakan nama project, author, prefix, dan pilihan theme. Setelah itu agent memasang theme dan mengikuti alur di `AGENTS.md`.
