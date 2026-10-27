<?php
/**
 * backend/api/ekspor_skor.php
 * Unduh rekap skor kuis (CSV). Hanya admin/guru.
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
wajib_admin();

/** Cegah CSV injection saat dibuka di Excel/Sheets. */
function sel($v)
{
    $v = (string) $v;
    return ($v !== '' && strpos("=+-@\t\r", $v[0]) !== false) ? "'" . $v : $v;
}

$baris = db()->query(
    "SELECT p.nama, p.username, COALESCE(p.kelas, '') AS kelas, k.nilai, k.jumlah_benar, k.jumlah_soal,
            to_char(k.selesai AT TIME ZONE 'Asia/Jakarta', 'YYYY-MM-DD HH24:MI') AS selesai
     FROM percobaan_kuis k JOIN pengguna p ON p.id = k.pengguna_id
     WHERE k.selesai IS NOT NULL
     ORDER BY p.nama, k.selesai"
)->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="skor-kuis-' . date('Ymd') . '.csv"');
$out = fopen('php://output', 'w');
fwrite($out, "\xEF\xBB\xBF"); // BOM agar Excel membaca UTF-8
fputcsv($out, ['Nama', 'Username', 'Kelas', 'Nilai', 'Benar', 'Jumlah Soal', 'Selesai (WIB)']);
foreach ($baris as $b) {
    fputcsv($out, [sel($b['nama']), sel($b['username']), sel($b['kelas']), $b['nilai'], $b['jumlah_benar'], $b['jumlah_soal'], $b['selesai']]);
}
fclose($out);
