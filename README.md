# Privasiku (PAI Jejak Digital)

Media belajar privasi digital dengan login, kuis tersimpan di PostgreSQL, dan rekap skor untuk guru.

## Struktur

```
pai-jejak-digital/
├── index.php                  -> mengarahkan ke frontend/
├── frontend/                  (tampilan)
│   ├── index.php  dalil.php  simulasi.php  think.php
│   ├── kuis.php               (wajib login)
│   ├── login.php  register.php
│   ├── riwayat.php            (riwayat kuis milik sendiri)
│   ├── skor.php               (khusus admin/guru)
│   ├── includes/header.php  footer.php
│   └── assets/css/style.css   assets/js/main.js  kuis.js
└── backend/                   (logika & data)
    ├── api/    cek.php  login.php  register.php  logout.php  ekspor_skor.php
    ├── includes/  auth.php (sesi, peran, CSRF)  db.php (PDO PostgreSQL)
    ├── config/    config.php (membaca .env)
    ├── data/      materi, dalil, soal, simulasi, think
    ├── database/  schema.sql  buat_admin.php
    └── .env.example
```

## Cara menjalankan

1. Syarat: PHP 8.0+ dengan ekstensi `pdo_pgsql`, serta PostgreSQL.
2. Buat database dan tabel:
   ```bash
   createdb -U postgres privasiku
   psql -U postgres -d privasiku -f backend/database/schema.sql
   ```
3. Salin `backend/.env.example` menjadi `backend/.env`, lalu isi `DB_USER` dan `DB_PASS`.
4. Buat akun admin/guru (kata sandi ditanyakan di terminal):
   ```bash
   php backend/database/buat_admin.php bu_guru "Ibu Guru PAI"
   ```
5. Jalankan:
   ```bash
   php -S localhost:8000
   ```
   lalu buka http://localhost:8000. Dengan XAMPP/Apache, taruh folder di `htdocs` dan buka `/pai-jejak-digital/`.

## Peran

| Peran | Cara dibuat | Hak akses |
|---|---|---|
| user (siswa) | daftar sendiri di `register.php` | semua materi, kuis, riwayat sendiri |
| admin (guru) | `buat_admin.php` | semuanya + `skor.php` (skor semua siswa, detail jawaban, unduh CSV) |

## Alur kuis

- `kuis.php` mengalihkan ke login bila belum masuk. Setelah login, pengguna kembali ke kuis.
- Setiap membuka kuis dibuat satu baris di `percobaan_kuis`. Tiap jawaban dikirim ke `backend/api/cek.php`, diperiksa server, dan disimpan di `jawaban_kuis`.
- Nilai akhir dihitung dan disimpan server setelah soal terakhir dijawab, bukan oleh browser.

## Keamanan

- Kata sandi disimpan dengan `password_hash` (bcrypt), query memakai prepared statement, output di-escape.
- Token CSRF di semua formulir dan di `cek.php`; cookie sesi `HttpOnly` + `SameSite=Lax`; login dibatasi 5 kali gagal per menit.
- `backend/.htaccess` menolak akses langsung ke semua file backend kecuali `api/`. Pada Nginx, blokir sendiri path `/backend/` selain `/backend/api/`. Untuk produksi, sebaiknya jadikan `frontend/` sebagai document root dan taruh `backend/` di luar web root.
- Jangan unggah `backend/.env` ke GitHub (sudah ada di `.gitignore`).
