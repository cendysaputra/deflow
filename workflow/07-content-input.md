# 07 — Input konten

Tujuan: semua field terisi persis seperti Figma.

## Aturan

- Teks disalin persis dari Figma, termasuk kapitalisasi dan tanda baca.
- Jangan mengarang teks atau gambar. Kalau ada yang kosong atau tidak jelas, catat dan tanya.
- Jangan menimpa konten yang sudah diisi user tanpa izin.

## Gambar

1. Export aset dari Figma MCP ke folder sementara di luar repo.
2. Import dan isi alt text (deskriptif, atau kosong untuk gambar dekoratif):
   ```bash
   wp media import /tmp/hero.webp --title="Hero" --alt="Deskripsi gambar" --porcelain
   ```
3. Simpan ID attachment untuk diisi ke field Image.

## Isi field

Pakai field key agar aman meski field belum pernah tersimpan:

```bash
wp eval 'update_field( "field_imj_hero_title", "Teks dari Figma", 12 );'
wp eval 'update_field( "field_imj_hero_image", 345, 12 );'
wp eval 'update_field( "field_imj_hero_link", array( "title" => "Label", "url" => "/kontak/", "target" => "" ), 12 );'
```

- Global ACF Pro: post id `"option"`. Global ACF Free: ID halaman `global`.
- Repeater: kirim array baris dengan sub field key.
- CPT: buat post dulu (`wp post create --post_type=...`), lalu isi field dan term (`wp post term set`).
- ACF Blocks: data disimpan di atribut block dalam `post_content`, bukan post meta. Tulis block markup lewat `wp post update <id> --post_content=...`.

## Verifikasi

```bash
wp eval 'var_dump( get_field( "hero_title", 12 ) );'
```

## Selesai

Update `docs/project.md` (konten terisi, aset, pertanyaan). Laporkan, berhenti, dan tunggu user.
