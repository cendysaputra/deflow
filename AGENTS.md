# AGENTS.md — Standar Kerja Deflow

Aturan untuk semua agent yang mengubah design Figma (via Figma MCP) menjadi website. Bagian di bawah berlaku untuk semua stack. Aturan khusus stack ada di bagian stack setelah aturan umum ini.

## Konteks

- Figma hanya desktop. Koneksi Figma MCP sudah siap.
- Agent dijalankan dari root project.
- Status project ada di `docs/project.md`. Baca dulu sebelum kerja. Isinya: identitas project, stack, mode, halaman (frame Figma, slug, section, status), struktur konten, komponen, token mapping, pembulatan nilai, konten placeholder, backup, keputusan, pertanyaan terbuka, progress.

## Mode

- **Baru**: project masih kosong. Ikuti alur 10 tahap dari awal.
- **Audit**: kode atau theme sudah ada, tapi `AGENTS.md` / `docs/project.md` belum ada atau belum lengkap.
  1. Inventaris yang sudah ada: theme/kode, plugin/package, halaman, struktur konten, token, komponen.
  2. Bandingkan setiap halaman dengan Figma (layout, token, gambar, teks, responsive).
  3. Tulis daftar selisih di `docs/project.md` (halaman, bagian, selisih, prioritas, usulan perbaikan).
  4. Tunggu approval, lalu perbaiki per halaman mengikuti tahap 4–10.
  - Jangan menimpa kode yang sudah ada tanpa alasan di daftar selisih. Starter hanya dipakai untuk bagian yang belum ada.

## Cara kerja

- Ikuti alur 10 tahap secara berurutan.
- Akhir setiap tahap: update `docs/project.md`, laporkan singkat, lalu **berhenti dan tunggu user**.
- Revisi beruntun: kalau user memberi daftar revisi, kerjakan semuanya, lalu lapor sekali. Tetap berhenti di akhir tahap, sebelum aksi yang butuh izin, dan saat menemukan hal yang tidak jelas.
- Default stack tidak ditanyakan. Default hanya berubah kalau user memintanya sendiri.
- Pertanyaan ke user hanya: identitas project, link Figma, izin install, dan hal di design yang tidak jelas.
- Izin dulu sebelum: install package/plugin/library di luar daftar standar, menghapus konten, mengubah setting yang sudah terisi.

## Identitas project

Ditanyakan sekali di awal dan dicatat di `docs/project.md`. Di dokumen ini, `{{...}}` berarti nilai tersebut.

| Placeholder | Isi | Contoh |
|---|---|---|
| `{{PROJECT_NAME}}` | Nama project | `Nama Project` |
| `{{PROJECT_SLUG}}` | kebab-case dari nama project | `nama-project` |
| `{{AUTHOR}}` | Nama author | `Nama Studio` |
| `{{prefix}}` | 2–4 huruf kecil dari nama project | `np` |
| `{{PREFIX}}` | `{{prefix}}` huruf besar | `NP` |

- Prefix konsisten di semua file dan tidak sama dengan prefix milik framework, CMS, atau plugin.
- Setelah starter disalin, semua placeholder diganti. `grep -rnE '\{\{(PROJECT_NAME|PROJECT_SLUG|AUTHOR|PREFIX|prefix)\}\}'` di file hasil salinan harus kosong.

## Aturan wajib

1. Jangan ubah file milik pihak lain (core, vendor, plugin, theme induk). Override lewat mekanisme resmi stack.
2. Semua nilai (warna, spacing, font-size, radius, shadow) lewat token. Dilarang inline style dan nilai hardcode yang punya token. Nilai Figma di luar skala dibulatkan ke token terdekat dan dicatat.
3. CSS/JS global dan reusable: satu class atau komponen untuk banyak bagian. Cek yang sudah ada sebelum membuat yang baru.
4. Code bersih: tanpa duplikasi, tanpa kode mati, asset dimuat seperlunya.
5. Komentar hanya penanda 2–5 kata (`/* Accordion */`).
6. Class dan id custom hanya kebab-case (`.class-name`, `#id-name`).
   - Dilarang `class__name`, `class--name`, `class_name`, camelCase.
   - Variasi pakai class terpisah (`.card-large`). State `.is-open` / `.is-active`. Hook JS pakai `data-*`.
   - Class bawaan framework, CMS, library, dan plugin dibiarkan.
7. JS vanilla, plus library standar di bawah. Library lain hanya jika perlu dan sudah izin.
8. Halaman statis dulu. Lihat bagian "Animasi" untuk yang boleh sejak awal.
9. Jangan mengarang konten. Teks, gambar, dan urutan mengikuti Figma. Kalau tidak jelas, tanya.
10. Konten dari CMS, bukan hardcode. Output di-escape. Field kosong tidak merender wrapper-nya.

## Library standar

Boleh dipakai tanpa tanya. Versi dikunci, dimuat hanya di halaman yang memakainya.

| Kebutuhan | Library | Versi |
|---|---|---|
| Slider, carousel, marquee | Swiper | 14.3.0 |
| Lightbox gambar/video | GLightbox | 3.3.1 |

- Inisialisasi lewat atribut `data-*`, bukan class library.
- Slider: tombol prev/next berupa `<button>` dengan label, keyboard aktif, `a11y` Swiper aktif, tanpa autoplay kecuali ada di design.
- Inisialisasi idempotent: elemen yang sudah diinisialisasi ditandai, jadi init kedua tidak menggandakan listener.

## Konten placeholder

- Hanya jika user memintanya (misalnya duplikat produk untuk mengisi grid).
- Catat di `docs/project.md` tabel "Konten placeholder": lokasi, asal salinan, alasan, status hapus.
- Jangan pernah menulis teks baru sebagai placeholder. Pakai salinan konten Figma yang ada atau tanda jelas yang disetujui user.

## Animasi

| Jenis | Kapan boleh |
|---|---|
| Transisi state hover/focus/active (warna, background, border, shadow, maks 200ms) | Sejak awal. Bukan animasi. |
| Gerak yang ada di design atau diminta user (marquee, slider) | Sejak awal. Dicatat di "Keputusan". |
| Reveal saat scroll, parallax, efek masuk | Setelah halaman + responsive disetujui. |

- Hanya `transform` dan `opacity` untuk gerak. Hormati `prefers-reduced-motion`: gerak berhenti, konten tetap terbaca.
- Konten tetap tampil tanpa JS: state awal tersembunyi hanya berlaku setelah JS menambah class `.has-js` ke `<html>`.

## Aset gambar

- Ambil file asli dari Figma (`download_assets` / raw image dari node gambar), **bukan screenshot**.
- Export hanya isi gambar. Shape, mask, filter (grayscale, blur), dan opacity layer tidak ikut ter-export. Efek itu dibuat di CSS.
- Sebelum upload, cek:
  - Alpha: foto tidak boleh punya area transparan yang tidak disengaja.
  - Saturasi: foto berwarna tidak boleh jadi grayscale karena filter ikut ter-export.
  - Resolusi minimal 2× ukuran tampil di desktop.
- Baca fill di node gambar (gradient, overlay warna, opacity, crop/scale mode) dari design context Figma, lalu terapkan di CSS (overlay pakai pseudo-element dengan token, crop pakai `object-fit` + `object-position`).
- Setelah upload, pastikan ukuran turunan (srcset) terbentuk, dan atribut `sizes` sesuai lebar tampil dan crop.
- Alt text: ambil dari alt yang sudah ada di media library, lalu dari nama layer Figma kalau deskriptif. Kalau tidak ada, tanya user. Jangan menulis alt sendiri. Gambar dekoratif `alt=""`.

## Bentuk dan SVG

- SVG tidak boleh di-stretch (`preserveAspectRatio="none"` atau lebar/tinggi dipaksa beda rasio).
- Bentuk yang lebarnya berubah (tab bermask, sudut melengkung, sambungan) disusun dari potongan ukuran tetap + bagian tengah yang memanjang, dengan ukuran potongan dari token per breakpoint.
- Radius hanya di sisi yang ada di design. Sambungan antar potongan tidak boleh terlihat (cek zoom di QA).

## HTML semantik

- `<section>` untuk setiap blok konten (dengan heading), `<article>` untuk item mandiri (card, post, produk, testimoni).
- `<header>` / `<footer>` untuk kepala/kaki section atau article. `<nav>` dengan `aria-label` jika lebih dari satu. `<aside>` untuk konten pendukung.
- `<figure>` + `<figcaption>` untuk gambar berketerangan. `<ul>` / `<ol>` untuk list dan grid item. `<address>` untuk kontak. `<time datetime="">` untuk tanggal.
- `<div>` hanya wrapper layout tanpa makna.
- `<button>` untuk aksi, `<a>` untuk pindah halaman. Jangan pasang klik di `<div>`.
- Satu `<h1>` per halaman. Level heading tidak loncat dan mengikuti struktur, bukan ukuran visual.
- Landmark site-level (`<header>`, `<main>`, `<footer>`) hanya satu, plus skip link ke main content.
- Setiap input form punya `<label>`.

## Layout dan responsive

| | Desktop | Tablet ≤921px | Mobile ≤544px |
|---|---|---|---|
| Container | 1200px boxed | fluid | fluid |
| Padding kiri/kanan | 24px | 24px | 16px |
| Jarak antar section | 120px | 72px | 72px |

- Default ini wajib dan disimpan sebagai token.
- Desktop-first: hanya breakpoint 921px dan 544px, dengan `max-width`.
- Grid 4 → 2 → 1, 3 → 2 → 1, 2 → 1.
- Gambar + teks berdampingan ditumpuk di mobile.
- Ukuran heading turun per breakpoint.
- Tab list dengan banyak item boleh scroll horizontal.
- Target sentuh minimal 44px. Tidak boleh ada scroll horizontal di halaman.
- Susunan tablet/mobile ditunjukkan ke user untuk dikonfirmasi.

### Layar di atas 1200px

- Konten tetap di container 1200px.
- Full-bleed (selebar layar): background section, `.section-fill`, foto hero/banner, slider yang di design menyentuh tepi frame.
- Tinggi foto full-bleed tidak ikut membesar tanpa batas: pakai `clamp()` dengan nilai Figma sebagai titik tengah, dan `object-position` dari titik fokus gambar.
- Dicek di QA pada lebar 1920px.

### Keterbacaan tablet dan mobile

- Teks di atas foto: tambahkan overlay (token) atau pindahkan teks ke bawah foto sampai kontras minimal 4.5:1.
- CTA lebih dari satu: bertumpuk dan full-width di mobile.
- Menu mobile setinggi layar, scroll body dikunci saat terbuka, tombol tutup minimal 44px, bisa ditutup dengan Escape.
- Usulan susunan ini ditunjukkan ke user bersama susunan tablet/mobile.

## Backup

- Sebelum setiap perubahan database (option/setting, menu, penggantian media, import konten), buat backup di `backup/` dengan nama `<tanggal>-<isi>`.
- `backup/` tidak masuk git. Catat setiap backup di `docs/project.md` tabel "Backup" (file, isi, alasan).
- Perintah per stack ada di bagian stack.

## Alur 10 tahap

Perintah konkret tiap tahap ada di bagian stack.

1. **Cek awal**: cek environment, tentukan mode (baru/audit), buat `docs/project.md`, minta link Figma, list page dan frame (nama + node id).
2. **Setup**: pasang default stack dan starter. Pastikan halaman depan tanpa error dan asset termuat.
3. **Analisis design**: screenshot + metadata setiap frame. Klasifikasi halaman statis, directory (listing + detail), produk, komponen global (header/footer). Pecah halaman jadi section. Identifikasi komponen (accordion, tab, slider, marquee, lightbox, card, form) dan pakai ulang yang ada di starter. Catat fill di node gambar dan bentuk khusus. Catat pertanyaan.
4. **Global style**: baca font, warna, ukuran teks, padding, margin, gap, radius, shadow, button. Isi token dan tabel token mapping. Cek nilai yang benar-benar aktif di situs (bukan hanya file token).
5. **Struktur**: backup, install yang dibutuhkan (izin), lalu buat halaman, tipe konten, taxonomy, data global, dan menu.
6. **Field**: buat field per halaman, tipe konten, dan data global. Hanya untuk konten yang ada di Figma.
7. **Konten**: backup, isi teks persis Figma. Gambar mengikuti bagian "Aset gambar".
8. **Build halaman**: satu halaman per putaran, statis. Design context Figma MCP adalah referensi, bukan kode final. Laporkan dan tunggu approval per halaman.
9. **QA**: jalankan skrip di `qa/` (lihat bagian QA). Perbaiki semua temuan, ulangi sampai lolos.
10. **Animasi** (setelah approval): reveal/scroll sesuai bagian "Animasi". CSS + IntersectionObserver dulu.

## QA

Skrip Playwright ada di `qa/` (lihat `qa/README.md`). Install Playwright minta izin dulu. Hasil disimpan di `docs/qa/`.

| Cek | Skrip | Lolos jika |
|---|---|---|
| Posisi dan tinggi section vs metadata Figma di 1440px | `layout.mjs` | Selisih ≤ toleransi (default 8px) |
| Kecerahan per pita horizontal vs PNG Figma | `bands.mjs` | Selisih rata-rata per pita ≤ 8% |
| Screenshot 375, 544, 768, 921, 1200, 1440, 1920 × DPR 1, 1.5, 2, plus zoom ke divider, sudut, dan sambungan mask | `shots.mjs` | Dicek visual, tanpa celah atau garis |
| Scroll horizontal (375, 921, 1440, 1920), error console dan request gagal, satu h1, heading berurutan, alt, landmark, label form, target sentuh 44px, menu mobile (terbuka, kunci scroll, Escape), klik slider (geser tepat satu slide), reduced motion | `interact.mjs` | Semua cek `ok` |

Cek manual: isi alt sesuai aturan, kontras teks di atas foto, error server di log.

## Definition of done per halaman

- Desktop sesuai Figma (lolos `layout.mjs` dan `bands.mjs`). Tablet dan mobile rapi tanpa scroll horizontal. Lebar 1920 rapi.
- Konten dari CMS, bukan hardcode. Placeholder tercatat. Tidak ada nilai hardcode yang punya token.
- Gambar asli, resolusi cukup, srcset terbentuk, alt sesuai aturan.
- Semua class/id custom kebab-case.
- HTML semantik: satu h1, heading berurutan, section/article sesuai makna.
- Tidak ada error server/JS. Lolos `interact.mjs`. Animasi sesuai bagian "Animasi".
