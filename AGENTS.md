# AGENTS.md — Standar Kerja Deflow

Aturan untuk semua agent yang mengubah design Figma (via Figma MCP) menjadi website. Bagian di bawah berlaku untuk semua stack. Aturan khusus stack ada di bagian stack setelah aturan umum ini.

## Konteks

- Figma hanya desktop. Koneksi Figma MCP sudah siap.
- Agent dijalankan dari root project.
- Status project ada di `docs/project.md`. Baca dulu sebelum kerja. Isinya: identitas project, stack, halaman (frame Figma, slug, section, status), struktur konten, komponen, token mapping, pembulatan nilai, keputusan, pertanyaan terbuka, progress.

## Cara kerja

- Ikuti alur 10 tahap secara berurutan.
- Akhir setiap tahap: update `docs/project.md`, laporkan singkat, lalu **berhenti dan tunggu user**.
- Default stack tidak ditanyakan. Default hanya berubah kalau user memintanya sendiri.
- Pertanyaan ke user hanya: identitas project, link Figma, izin install, dan hal di design yang tidak jelas.
- Izin dulu sebelum: install package/plugin/library, menghapus konten, mengubah setting yang sudah terisi.

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
   - Class bawaan framework, CMS, dan plugin dibiarkan.
7. JS vanilla. Library hanya jika perlu dan sudah izin.
8. Halaman statis dulu tanpa animasi. Animasi setelah halaman + responsive disetujui.
9. Jangan mengarang konten. Teks, gambar, dan urutan mengikuti Figma. Kalau tidak jelas, tanya.
10. Konten dari CMS, bukan hardcode. Output di-escape. Field kosong tidak merender wrapper-nya.

## HTML semantik

- `<section>` untuk setiap blok konten (dengan heading), `<article>` untuk item mandiri (card, post, produk, testimoni).
- `<header>` / `<footer>` untuk kepala/kaki section atau article. `<nav>` dengan `aria-label` jika lebih dari satu. `<aside>` untuk konten pendukung.
- `<figure>` + `<figcaption>` untuk gambar berketerangan. `<ul>` / `<ol>` untuk list dan grid item. `<address>` untuk kontak. `<time datetime="">` untuk tanggal.
- `<div>` hanya wrapper layout tanpa makna.
- `<button>` untuk aksi, `<a>` untuk pindah halaman. Jangan pasang klik di `<div>`.
- Satu `<h1>` per halaman. Level heading tidak loncat dan mengikuti struktur, bukan ukuran visual.
- Landmark site-level (`<header>`, `<main>`, `<footer>`) hanya satu, plus skip link ke main content.
- Gambar wajib alt (dekoratif `alt=""`). Setiap input form punya `<label>`.

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

## Alur 10 tahap

Perintah konkret tiap tahap ada di bagian stack.

1. **Cek awal**: cek environment, buat `docs/project.md`, minta link Figma, list page dan frame (nama + node id).
2. **Setup**: pasang default stack dan starter. Pastikan halaman depan tanpa error dan asset termuat.
3. **Analisis design**: screenshot + metadata setiap frame. Klasifikasi halaman statis, directory (listing + detail), produk, komponen global (header/footer). Pecah halaman jadi section. Identifikasi komponen (accordion, tab, slider, card, form) dan pakai ulang yang ada di starter. Catat pertanyaan.
4. **Global style**: baca font, warna, ukuran teks, padding, margin, gap, radius, shadow, button. Isi token dan tabel token mapping.
5. **Struktur**: install yang dibutuhkan (izin), lalu buat halaman, tipe konten, taxonomy, data global, dan menu.
6. **Field**: buat field per halaman, tipe konten, dan data global. Hanya untuk konten yang ada di Figma.
7. **Konten**: isi teks persis Figma. Gambar di-export dari Figma dan alt diisi.
8. **Build halaman**: satu halaman per putaran, statis, tanpa animasi. Design context Figma MCP adalah referensi, bukan kode final. Laporkan dan tunggu approval per halaman.
9. **QA**: lebar 1440, 1200, 921, 768, 544, 375. Desktop dibandingkan dengan screenshot Figma. Tanpa scroll horizontal (`scrollWidth > clientWidth` harus `false`). Cek heading, landmark, alt, label form, error server dan console.
10. **Animasi** (setelah approval): CSS + IntersectionObserver dulu, library hanya jika perlu dan sudah izin. Hanya `transform` dan `opacity`. Hormati `prefers-reduced-motion`. Konten tetap tampil tanpa JS: state awal tersembunyi hanya berlaku setelah JS menambah class `.has-js` ke `<html>`.

## Definition of done per halaman

- Desktop sesuai Figma. Tablet dan mobile rapi tanpa scroll horizontal.
- Konten dari CMS, bukan hardcode. Tidak ada nilai hardcode yang punya token.
- Semua class/id custom kebab-case.
- HTML semantik: satu h1, heading berurutan, section/article sesuai makna, alt terisi.
- Tidak ada error server/JS. Animasi hanya setelah approval.
