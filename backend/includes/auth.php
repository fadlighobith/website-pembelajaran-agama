<?php
/**
 * backend/includes/auth.php
 * Sesi, login, peran (admin/guru dan user/siswa), CSRF, dan pesan flash.
 */
require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_name('privasiku');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
}

if (!function_exists('e')) {
    function e($teks)
    {
        return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
    }
}

/* ---------- URL relatif ke halaman frontend ---------- */

/** Dari folder backend/api ke frontend, atau dari frontend ke frontend. */
function url_frontend($berkas)
{
    $skrip = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $dari_api = basename(dirname($skrip)) === 'api';
    return ($dari_api ? '../../frontend/' : '') . $berkas;
}

function arahkan($url)
{
    header('Location: ' . $url);
    exit;
}

/** Halaman tujuan setelah login: hanya nama berkas dari daftar putih. */
function tujuan_aman($next)
{
    $boleh = ['index.php', 'kuis.php', 'riwayat.php', 'skor.php', 'dalil.php', 'simulasi.php', 'think.php'];
    return in_array($next, $boleh, true) ? $next : '';
}

/* ---------- Pesan flash ---------- */

function flash($tipe, $pesan)
{
    $_SESSION['flash'][] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function tampil_flash()
{
    if (empty($_SESSION['flash'])) {
        return '';
    }
    $html = '';
    foreach ($_SESSION['flash'] as $f) {
        $html .= '<div class="wadah"><div class="peringatan ' . e($f['tipe']) . '" role="alert">' . e($f['pesan']) . '</div></div>';
    }
    unset($_SESSION['flash']);
    return $html;
}

/* ---------- CSRF ---------- */

function csrf_token()
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_input()
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_valid($token)
{
    return is_string($token) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

/* ---------- Pengguna & peran ---------- */

function pengguna_saat_ini()
{
    return isset($_SESSION['pengguna']) && is_array($_SESSION['pengguna']) ? $_SESSION['pengguna'] : null;
}

function sudah_login()
{
    return pengguna_saat_ini() !== null;
}

function adalah_admin()
{
    $p = pengguna_saat_ini();
    return $p !== null && $p['role'] === 'admin';
}

function masukkan_sesi(array $baris)
{
    session_regenerate_id(true);
    $_SESSION['pengguna'] = [
        'id'       => (int) $baris['id'],
        'nama'     => $baris['nama'],
        'username' => $baris['username'],
        'kelas'    => $baris['kelas'],
        'role'     => $baris['role'],
    ];
    csrf_token();
}

/** Wajib login. Dipanggil sebelum ada output HTML. */
function wajib_login($pesan = 'Silakan masuk terlebih dahulu.')
{
    if (sudah_login()) {
        return;
    }
    flash('info', $pesan);
    $skrip = basename($_SERVER['SCRIPT_NAME'] ?? '');
    $next  = tujuan_aman($skrip);
    arahkan(url_frontend('login.php') . ($next ? '?next=' . urlencode($next) : ''));
}

/** Wajib admin/guru. Peran diperiksa ulang ke database. */
function wajib_admin()
{
    wajib_login('Masuk dahulu untuk melihat halaman ini.');
    require_once __DIR__ . '/db.php';
    $st = db()->prepare('SELECT role FROM pengguna WHERE id = :id');
    $st->execute([':id' => $_SESSION['pengguna']['id']]);
    $role = $st->fetchColumn();
    if ($role !== 'admin') {
        flash('error', 'Halaman ini hanya untuk admin/guru.');
        arahkan(url_frontend('index.php'));
    }
    $_SESSION['pengguna']['role'] = $role;
}
