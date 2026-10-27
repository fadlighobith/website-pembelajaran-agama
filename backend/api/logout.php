<?php
/**
 * backend/api/logout.php
 * Keluar dari akun (POST + token CSRF).
 */
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_valid($_POST['csrf'] ?? '')) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $c = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $c['path'], $c['domain'], $c['secure'], $c['httponly']);
    }
    session_destroy();
    session_start();
    session_regenerate_id(true);
    flash('info', 'Kamu sudah keluar.');
}
arahkan(url_frontend('index.php'));
