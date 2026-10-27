<?php
/**
 * backend/includes/db.php
 * Koneksi PostgreSQL memakai PDO (ekstensi pdo_pgsql).
 * Pakai: $pdo = db();
 */
require_once __DIR__ . '/../config/config.php';

function db()
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }
    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        env('DB_HOST', 'localhost'),
        env('DB_PORT', '5432'),
        env('DB_NAME', 'privasiku')
    );
    try {
        $pdo = new PDO($dsn, env('DB_USER', 'postgres'), env('DB_PASS', ''), [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $ex) {
        // Pesan asli bisa memuat kata sandi, jadi jangan diteruskan.
        throw new RuntimeException('Koneksi database gagal (kode ' . $ex->getCode() . ').');
    }
    return $pdo;
}
