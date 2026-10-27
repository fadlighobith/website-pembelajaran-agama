# AmanahNet: Menjaga Privasi Digital (PAI)

Web interaktif bertema **menjaga privasi digital** dengan landasan Al-Qur'an dan hadis.
Dibuat dengan PHP (tanpa database) + HTML, CSS, dan JavaScript biasa.

## Fitur

| Halaman | Isi |
|---|---|
| `index.php` | Beranda, serta **Materi** lewat `index.php?hal=materi&bab=1..6` (penjelasan, masalah, solusi, kesimpulan) |
| `dalil.php` | Ayat Al-Qur'an dan hadis (tab, filter tema, teks Arab, terjemah, penjelasan) |
| `kuis.php` | Kuis 10 soal pilihan ganda; soal diacak, jawaban diperiksa oleh `cek.php` |
| `cek.php` | Endpoint JSON pemeriksa jawaban kuis (kunci jawaban tidak dikirim ke browser) |
| `simulasi.php` | Simulasi 6 kasus nyata dengan skor "Skor Amanah" |
| `think.php` | Latihan THINK (Benar, Bermanfaat, Menginspirasi, Perlu, Baik) sebelum memposting |

Fitur tambahan: mode gelap, pencarian cepat (tekan `/`), progres belajar tersimpan di browser, dan tampilan responsif.

## Struktur Folder

```
pai-jejak-digital/
├── assets/
│   ├── css/style.css
│   └── js/
│       ├── main.js      (tema, menu, pencarian, dalil, simulasi, THINK)
│       └── kuis.js      (alur kuis)
├── data/
│   ├── dalil.php        (ayat & hadis)
│   ├── materi.php       (6 bab materi)
│   ├── simulasi.php     (skenario simulasi)
│   ├── soal.php         (bank soal + kunci jawaban)
│   └── think.php        (kriteria THINK + contoh)
├── includes/
│   ├── header.php       (navbar, ikon, ilustrasi SVG)
│   └── footer.php       (footer, pencarian, pemuat JS)
├── cek.php
├── dalil.php
├── index.php
├── kuis.php
├── simulasi.php
├── think.php
└── README.md
```

## Cara Menjalankan

**Opsi 1: XAMPP / Laragon**
1. Salin folder `pai-jejak-digital` ke `htdocs` (XAMPP) atau `www` (Laragon).
2. Jalankan Apache.
3. Buka `http://localhost/pai-jejak-digital/`.

**Opsi 2: server bawaan PHP** (butuh PHP 7.4 atau lebih baru)
```bash
cd pai-jejak-digital
php -S localhost:8000
```
Lalu buka `http://localhost:8000`.

> Halaman harus dibuka lewat server PHP. Jika file dibuka langsung dari folder (`file://`), kuis tidak bisa memeriksa jawaban.

## Cara Mengubah Isi

Semua konten ada di folder `data/` berupa array PHP, jadi tidak perlu mengubah halaman:

- **Tambah soal kuis**: tambahkan blok baru di `data/soal.php` (`id` harus unik, `jawaban` = nomor pilihan benar mulai dari 0).
- **Tambah dalil**: tambahkan blok di `data/dalil.php` pada `quran` atau `hadis`. Tema baru juga didaftarkan di `tema`.
- **Ubah materi**: edit `data/materi.php`. Setiap bab dapat berisi `isi`, `tabel`, `langkah`, `poin`, `refleksi`, dan `dalil`.
- **Ubah warna**: variabel warna ada di bagian `:root` pada `assets/css/style.css`.

## Catatan Penting

- Teks Arab dan terjemahan ditulis ringkas untuk keperluan belajar. **Cocokkan kembali dengan mushaf dan kitab hadis, atau konsultasikan dengan guru PAI**, sebelum dikumpulkan atau dipublikasikan.
- Font (Lora, Poppins, Amiri) dimuat dari Google Fonts. Jika offline, tampilan memakai font cadangan sistem.
