<?php
/**
 * backend/api/register.php
 * Memproses pendaftaran akun baru. Akun baru selalu berperan "user" (siswa);
 * akun admin/guru dibuat lewat backend/database/buat_admin.php.
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    arahkan(url_frontend('register.php'));
}

$next    = tujuan_aman($_POST['next'] ?? '');
$kembali = url_frontend('register.php') . ($next ? '?next=' . urlencode($next) : '');

if (!csrf_valid($_POST['csrf'] ?? '')) {
    flash('error', 'Sesi formulir kedaluwarsa. Silakan coba lagi.');
    arahkan($kembali);
}

$nama     = trim((string) ($_POST['nama'] ?? ''));
$username = strtolower(trim((string) ($_POST['username'] ?? '')));
$kelas    = trim((string) ($_POST['kelas'] ?? ''));
$sandi    = (string) ($_POST['password'] ?? '');
$ulang    = (string) ($_POST['password2'] ?? '');

$_SESSION['lama'] = ['nama' => $nama, 'username' => $username, 'kelas' => $kelas];

$galat = [];
$panjang_nama = mb_strlen($nama, 'UTF-8');
if ($panjang_nama < 2 || $panjang_nama > 100) {
    $galat[] = 'Nama harus 2 sampai 100 karakter.';
}
if (!preg_match('/^[a-z0-9_.]{3,30}$/', $username)) {
    $galat[] = 'Username 3 sampai 30 karakter: huruf kecil, angka, titik, atau garis bawah.';
}
if (mb_strlen($kelas, 'UTF-8') > 20) {
    $galat[] = 'Kelas maksimal 20 karakter.';
}
if (strlen($sandi) < 8) {
    $galat[] = 'Kata sandi minimal 8 karakter.';
} elseif (strlen($sandi) > 72) {
    $galat[] = 'Kata sandi maksimal 72 karakter.';
}
if ($sandi !== $ulang) {
    $galat[] = 'Konfirmasi kata sandi tidak sama.';
}
if ($galat) {
    flash('error', implode(' ', $galat));
    arahkan($kembali);
}

try {
    $st = db()->prepare(
        "INSERT INTO pengguna (nama, username, kelas, password_hash, role)
         VALUES (:n, :u, :k, :p, 'user')
         RETURNING id, nama, username, kelas, role"
    );
    $st->execute([
        ':n' => $nama,
        ':u' => $username,
        ':k' => $kelas !== '' ? $kelas : null,
        ':p' => password_hash($sandi, PASSWORD_DEFAULT),
    ]);
    $baru = $st->fetch();
} catch (PDOException $ex) {
    if ($ex->getCode() === '23505') { // unique_violation
        flash('error', 'Username sudah dipakai. Coba username lain.');
        arahkan($kembali);
    }
    throw $ex;
}

unset($_SESSION['lama']);
masukkan_sesi($baru);
flash('sukses', 'Akun berhasil dibuat. Selamat belajar, ' . $baru['nama'] . '!');
arahkan(url_frontend($next !== '' ? $next : 'index.php'));
