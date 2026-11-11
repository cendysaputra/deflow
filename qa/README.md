# QA Deflow

Skrip Playwright untuk tahap 9. Jalankan dari root project.

## Setup (sekali, minta izin dulu)

```bash
cd qa && npm install && npx playwright install chromium && cd ..
cp qa/config.example.json docs/qa/config.json
```

Isi `docs/qa/config.json`:

- `baseUrl`: URL situs lokal.
- `pages[].figma.sections`: `y` dan `height` setiap section dari metadata Figma (relatif ke frame), plus selector-nya di situs.
- `pages[].figma.png`: screenshot frame Figma dari Figma MCP (lebar sama dengan `figma.width`, skala 1×).
- `pages[].zoom`: selector yang perlu dilihat dekat (divider, sudut, sambungan mask).
- `menuToggle`: selector tombol menu mobile jika bukan `header button[aria-expanded]`.

## Menjalankan

```bash
node qa/layout.mjs docs/qa/config.json      # posisi dan tinggi section vs Figma
node qa/bands.mjs docs/qa/config.json       # kecerahan per pita vs PNG Figma
node qa/shots.mjs docs/qa/config.json       # screenshot semua lebar dan DPR, plus zoom
node qa/interact.mjs docs/qa/config.json    # scroll horizontal, error, semantik, menu, slider, reduced motion
```

Tambahkan nama halaman di akhir untuk satu halaman saja: `node qa/layout.mjs docs/qa/config.json home`.

Hasil ada di `docs/qa/` (`*.json` dan `shots/`). Exit code 1 jika ada yang gagal.
