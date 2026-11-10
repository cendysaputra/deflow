# 09 — QA responsive dan semantik

Tujuan: halaman rapi di semua lebar layar dan strukturnya benar.

## Lebar yang dicek

1440, 1200, 921, 768, 544, 375.

Pakai browser automation yang tersedia (Playwright, Chrome DevTools, dan sejenisnya). Kalau tidak ada, beri checklist ke user untuk dicek manual.

## Checklist

### Visual

- [ ] Desktop (1440 dan 1200) dibandingkan dengan screenshot Figma: spacing, ukuran teks, warna, urutan.
- [ ] Tablet (921, 768): grid turun kolom sesuai aturan, gambar tidak gepeng.
- [ ] Mobile (544, 375): gambar + teks ditumpuk, padding 16px.
- [ ] Tidak ada scroll horizontal:
  ```js
  document.documentElement.scrollWidth > document.documentElement.clientWidth
  ```
  Hasil harus `false`.
- [ ] Target sentuh minimal 44px.
- [ ] Navigasi mobile bisa dibuka, ditutup, dan dipakai dengan keyboard.

### Semantik

- [ ] Satu `<h1>`.
- [ ] Heading berurutan tanpa loncat level.
- [ ] Landmark: satu `<header>`, `<main>`, `<footer>` site-level.
- [ ] Setiap `<section>` punya heading.
- [ ] Semua `<img>` punya atribut `alt`.
- [ ] Input form punya `<label>`.
- [ ] `<nav>` lebih dari satu punya `aria-label`.

### Kode

- [ ] Tidak ada error PHP (`wp-content/debug.log`) dan error JS (console).
- [ ] Tidak ada inline style dan nilai hardcode yang punya token.
- [ ] Semua class/id kebab-case.
- [ ] Tidak ada CSS/JS duplikat atau kode mati.

## Selesai

Laporkan hasil per halaman (lulus / temuan + perbaikan). Update `docs/project.md`. Berhenti dan tunggu approval sebelum animasi.
