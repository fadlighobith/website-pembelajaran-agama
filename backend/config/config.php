<?php
/**
 * backend/config/config.php
 * Membaca pengaturan dari backend/.env (lihat .env.example).
 */

if (!function_exists('env')) {
    function env($kunci, $bawaan = null)
    {
        static $muat = null;
        if ($muat === null) {
            $muat = [];
            $berkas = __DIR__ . '/../.env';
            if (is_readable($berkas)) {
                $baca = parse_ini_file($berkas, false, INI_SCANNER_RAW);
                if (is_array($baca)) {
                    foreach ($baca as $k => $v) {
                        $muat[$k] = trim($v, " \t\"'");
                    }
                }
            }
        }
        if (isset($muat[$kunci])) {
            return $muat[$kunci];
        }
        $dari_os = getenv($kunci);
        return $dari_os !== false ? $dari_os : $bawaan;
    }
}

// Jangan tampilkan detail error ke pengunjung; catat saja ke log server.
ini_set('display_errors', env('APP_DEBUG', '0') === '1' ? '1' : '0');
ini_set('log_errors', '1');

// Penanganan error tak terduga (mis. database mati).
set_exception_handler(function ($ex) {
    error_log('[Privasiku] ' . $ex->getMessage());
    http_response_code(500);
    $api = strpos(str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? ''), '/api/') !== false;
    if ($api && strpos($_SERVER['SCRIPT_NAME'], 'cek.php') !== false) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'pesan' => 'Terjadi kesalahan pada server.']);
    } else {
        echo 'Terjadi kesalahan pada server. Pastikan database PostgreSQL sudah berjalan dan pengaturan backend/.env benar.';
    }
    exit;
});
