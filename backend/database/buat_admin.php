<?php
/**
 * Membuat (atau menaikkan) akun admin/guru lewat terminal.
 *
 *   php backend/database/buat_admin.php <username> "<Nama Lengkap>"
 *
 * Kata sandi akan ditanyakan. Jika username sudah ada, perannya dijadikan admin
 * dan kata sandinya diganti.
 */
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Hanya bisa dijalankan dari terminal.');
}
require_once __DIR__ . '/../includes/db.php';

$username = strtolower(trim($argv[1] ?? ''));
$nama     = trim($argv[2] ?? '');
if (!preg_match('/^[a-z0-9_.]{3,30}$/', $username) || $nama === '') {
    fwrite(STDERR, "Pemakaian: php buat_admin.php <username> \"<Nama Lengkap>\"\n");
    exit(1);
}

echo 'Kata sandi (minimal 8 karakter): ';
$stty = stripos(PHP_OS, 'WIN') === false;
if ($stty) { shell_exec('stty -echo'); }
$sandi = rtrim((string) fgets(STDIN), "\r\n");
if ($stty) { shell_exec('stty echo'); }
echo "\n";
if (strlen($sandi) < 8) {
    fwrite(STDERR, "Kata sandi terlalu pendek.\n");
    exit(1);
}

$pdo = db();
$st = $pdo->prepare(
    "INSERT INTO pengguna (nama, username, password_hash, role)
     VALUES (:n, :u, :p, 'admin')
     ON CONFLICT (lower(username))
     DO UPDATE SET role = 'admin', password_hash = EXCLUDED.password_hash, nama = EXCLUDED.nama"
);
$st->execute([':n' => $nama, ':u' => $username, ':p' => password_hash($sandi, PASSWORD_DEFAULT)]);
echo "Akun admin '$username' siap dipakai.\n";
