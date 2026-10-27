<?php
/**
 * cek.php
 * Pemeriksa jawaban kuis (endpoint JSON, dipanggil oleh assets/js/kuis.js).
 *
 * Permintaan : POST application/json  {"id": 3, "jawaban": 1}
 * Tanggapan  : {"ok":true,"benar":true,"kunci":1,"penjelasan":"..."}
 *
 * Kunci jawaban hanya diketahui server, jadi tidak bisa dilihat lewat
 * "View Source" pada halaman kuis.
 */
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function balas($kode, $isi)
{
    http_response_code($kode);
    echo json_encode($isi, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    balas(405, ['ok' => false, 'pesan' => 'Gunakan metode POST.']);
}

// Terima JSON maupun form biasa.
$mentah = file_get_contents('php://input');
$input  = json_decode($mentah, true);
if (!is_array($input)) {
    $input = $_POST;
}

$id      = isset($input['id']) ? filter_var($input['id'], FILTER_VALIDATE_INT) : false;
$jawaban = isset($input['jawaban']) ? filter_var($input['jawaban'], FILTER_VALIDATE_INT) : false;

if ($id === false || $jawaban === false) {
    balas(400, ['ok' => false, 'pesan' => 'Data tidak lengkap atau tidak valid.']);
}

$bank = require __DIR__ . '/data/soal.php';
foreach ($bank as $s) {
    if ((int) $s['id'] === $id) {
        if ($jawaban < 0 || $jawaban >= count($s['pilihan'])) {
            balas(400, ['ok' => false, 'pesan' => 'Pilihan jawaban tidak ada.']);
        }
        balas(200, [
            'ok'         => true,
            'benar'      => ($jawaban === (int) $s['jawaban']),
            'kunci'      => (int) $s['jawaban'],
            'penjelasan' => $s['penjelasan'],
        ]);
    }
}

balas(404, ['ok' => false, 'pesan' => 'Soal tidak ditemukan.']);
