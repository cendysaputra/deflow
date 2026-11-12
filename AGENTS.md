# AGENTS.md — Standar Kerja Deflow

Aturan agent untuk mengubah design Figma (desktop saja, via Figma MCP) menjadi website. Aturan stack ada setelah bagian ini.

## Cara kerja

- Status project di `docs/project.md`: identitas, stack, mode, halaman, struktur konten, token mapping, placeholder, backup, keputusan, pertanyaan, progress. Baca sebelum kerja, update di akhir setiap tahap.
- Ikuti alur 10 tahap. Akhir tahap: lapor singkat, lalu **berhenti dan tunggu user**. Daftar revisi dari user dikerjakan sekaligus dan dilaporkan sekali.
- Mode **audit** (kode sudah ada): inventaris, bandingkan dengan Figma, tulis daftar selisih + prioritas di `docs/project.md`, tunggu approval, lalu perbaiki per halaman. Jangan menimpa kode tanpa alasan di daftar selisih.
- Default stack tidak ditanyakan. Pertanyaan ke user hanya: identitas project, link Figma, izin, dan hal di design yang tidak jelas.
- Izin dulu sebelum: install di luar library standar, menghapus konten, mengubah setting yang sudah terisi.
- Backup sebelum setiap perubahan database ke `backup/<tanggal>-<isi>` (tidak masuk git), catat di `docs/project.md`.

## Identitas project

`{{PROJECT_NAME}}` (Nama Project), `{{PROJECT_SLUG}}` (nama-project), `{{AUTHOR}}`, `{{prefix}}` (2–4 huruf kecil, mis. `np`), `{{PREFIX}}` (huruf besar). Prefix tidak boleh sama dengan milik framework, CMS, atau plugin.

## Aturan kode

1. Jangan ubah file pihak lain (core, vendor, plugin, theme induk).
2. Semua nilai lewat token. Tanpa inline style. Nilai Figma di luar skala dibulatkan ke token terdekat dan dicatat.
3. Reusable: cek class/komponen yang ada sebelum membuat baru. Tanpa duplikasi dan kode mati. Asset dimuat seperlunya.
4. Class dan id custom kebab-case (`.card-large`, `.is-open`). Dilarang `__`, `--`, `_`, camelCase. Hook JS pakai `data-*`. Class bawaan pihak lain dibiarkan.
5. Komentar hanya penanda 2–5 kata.
6. JS vanilla. Library standar boleh tanpa tanya: **Swiper 14.3.0** (slider, marquee) dan **GLightbox 3.3.1** (lightbox), dimuat hanya di halaman yang memakainya, init lewat `data-*` dan idempotent.
7. Konten dari CMS, persis Figma. Jangan mengarang teks, gambar, atau alt. Placeholder hanya jika diminta user, salin dari konten Figma, dan dicatat.
8. Output di-escape. Field kosong tidak merender wrapper-nya.

## HTML

- `<section>` + heading untuk setiap blok, `<article>` untuk item mandiri, `<ul>`/`<ol>` untuk grid item, `<figure>`, `<address>`, `<time>` sesuai makna. `<div>` hanya wrapper layout.
- `<button>` untuk aksi, `<a>` untuk pindah halaman.
- Satu `<h1>`, level heading tidak loncat. Satu `<header>`, `<main>`, `<footer>` site plus skip link.
- Setiap input punya `<label>`. `<nav>` lebih dari satu diberi `aria-label`.

## Layout

| | Desktop | Tablet ≤921px | Mobile ≤544px |
|---|---|---|---|
| Container | 1200px | fluid | fluid |
| Padding kiri/kanan | 24px | 24px | 16px |
| Jarak section | 120px | 72px | 72px |

- Desktop-first, hanya breakpoint 921 dan 544 (`max-width`). Grid 4→2→1, 3→2→1, 2→1. Gambar + teks ditumpuk di mobile.
- Di atas 1200px konten tetap 1200. Background, foto hero, dan slider yang menyentuh tepi frame dibuat full-bleed, tinggi foto pakai `clamp()` + `object-position`.
- Tablet/mobile: target sentuh ≥44px, tanpa scroll horizontal, teks di atas foto diberi overlay sampai kontras ≥4.5:1, CTA bertumpuk, menu mobile setinggi layar (scroll dikunci, tutup dengan Escape). Tunjukkan susunannya ke user.

## Gambar

- Ambil file asli dari node gambar Figma, bukan screenshot. Shape, mask, filter, dan opacity dibuat di CSS, tidak ikut ter-export.
- Cek sebelum upload: tanpa transparansi tak disengaja, tidak jadi grayscale, resolusi ≥2× ukuran tampil.
- Fill di node gambar (gradient, overlay, crop) diterapkan di CSS.
- Pastikan srcset terbentuk dan `sizes` sesuai lebar tampil.
- Alt: dari media library atau nama layer Figma yang deskriptif. Selain itu tanya. Dekoratif `alt=""`.
- SVG tidak di-stretch. Bentuk yang lebarnya berubah disusun dari potongan ukuran tetap. Radius hanya di sisi yang ada di design.

## Animasi

- Transisi hover/focus (≤200ms) dan gerak yang ada di design atau diminta user (marquee, slider): boleh sejak awal.
- Reveal saat scroll dan efek masuk: setelah halaman + responsive disetujui.
- Hanya `transform`/`opacity`. Hormati `prefers-reduced-motion`. Konten tetap tampil tanpa JS (state tersembunyi hanya di bawah `.has-js`).

## Alur 10 tahap

1. **Cek awal**: environment, mode, `docs/project.md`, link Figma, daftar frame + node id.
2. **Setup**: pasang stack dan starter, halaman depan tanpa error.
3. **Analisis**: pecah setiap frame jadi section dan komponen. Tentukan halaman statis, listing + detail, produk, header/footer. Catat pertanyaan.
4. **Global style**: isi token dari Figma, cek nilai yang benar-benar aktif di situs.
5. **Struktur**: halaman, tipe konten, taxonomy, data global, menu.
6. **Field**: hanya untuk konten yang ada di Figma.
7. **Konten**: teks persis Figma, gambar sesuai aturan di atas.
8. **Build**: satu halaman per putaran, lapor dan tunggu approval. Design context MCP hanya referensi.
9. **QA**: jalankan `qa/` (lihat `qa/README.md`) sampai lolos, plus cek manual alt, kontras, dan log server.
10. **Animasi**: reveal/scroll setelah approval.

## Selesai per halaman

Lolos `qa/` (layout, kecerahan, interaksi), rapi di 375–1920, konten dari CMS, tanpa nilai hardcode, tanpa error server/JS.
