<?php
/**
 * backend/api/login.php
 * Memproses form login (POST) lalu mengarahkan kembali ke frontend.
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    arahkan(url_frontend('login.php'));
}

$next    = tujuan_aman($_POST['next'] ?? '');
$kembali = url_frontend('login.php') . ($next ? '?next=' . urlencode($next) : '');

if (!csrf_valid($_POST['csrf'] ?? '')) {
    flash('error', 'Sesi formulir kedaluwarsa. Silakan coba lagi.');
    arahkan($kembali);
}

// Batasi percobaan beruntun: 5 kali gagal -> tunggu 60 detik.
$batas = $_SESSION['login_gagal'] ?? ['n' => 0, 't' => 0];
if ($batas['n'] >= 5 && time() - $batas['t'] < 60) {
    flash('error', 'Terlalu banyak percobaan gagal. Tunggu satu menit lalu coba lagi.');
    arahkan($kembali);
}

$username = strtolower(trim((string) ($_POST['username'] ?? '')));
$sandi    = (string) ($_POST['password'] ?? '');

$st = db()->prepare('SELECT id, nama, username, kelas, role, password_hash FROM pengguna WHERE lower(username) = :u');
$st->execute([':u' => $username]);
$baris = $st->fetch();

// Waktu respons dibuat mirip meski username tidak ada.
if ($baris) {
    $cocok = password_verify($sandi, $baris['password_hash']);
} else {
    password_hash($sandi, PASSWORD_DEFAULT);
    $cocok = false;
}

if (!$cocok) {
    $_SESSION['login_gagal'] = ['n' => $batas['n'] + 1, 't' => time()];
    flash('error', 'Username atau kata sandi salah.');
    arahkan($kembali);
}

unset($_SESSION['login_gagal']);
if (password_needs_rehash($baris['password_hash'], PASSWORD_DEFAULT)) {
    db()->prepare('UPDATE pengguna SET password_hash = :h WHERE id = :id')
        ->execute([':h' => password_hash($sandi, PASSWORD_DEFAULT), ':id' => $baris['id']]);
}

masukkan_sesi($baris);
flash('sukses', 'Selamat datang, ' . $baris['nama'] . '!');

if ($next === '' && $baris['role'] === 'admin') {
    $next = 'skor.php';
}
arahkan(url_frontend($next !== '' ? $next : 'index.php'));
