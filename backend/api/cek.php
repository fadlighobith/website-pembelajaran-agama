<?php
/**
 * backend/api/cek.php
 * Pemeriksa jawaban kuis (endpoint JSON, dipanggil oleh frontend/assets/js/kuis.js).
 *
 * Permintaan : POST application/json  {"id": 3, "jawaban": 1}
 *              header X-CSRF-Token wajib ada.
 * Tanggapan  : {"ok":true,"benar":true,"kunci":1,"penjelasan":"...","selesai":false}
 *              Saat soal terakhir dijawab: "selesai":true dan "nilai":80
 *
 * - Hanya untuk pengguna yang sudah login.
 * - Kunci jawaban hanya diketahui server.
 * - Setiap jawaban dan skor akhir disimpan ke PostgreSQL.
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

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
if (!sudah_login()) {
    balas(401, ['ok' => false, 'pesan' => 'Silakan login terlebih dahulu.']);
}
if (!csrf_valid($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '')) {
    balas(403, ['ok' => false, 'pesan' => 'Token keamanan tidak valid. Muat ulang halaman.']);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = $_POST;
}
$id      = isset($input['id']) ? filter_var($input['id'], FILTER_VALIDATE_INT) : false;
$jawaban = isset($input['jawaban']) ? filter_var($input['jawaban'], FILTER_VALIDATE_INT) : false;
if ($id === false || $jawaban === false) {
    balas(400, ['ok' => false, 'pesan' => 'Data tidak lengkap atau tidak valid.']);
}

// Cari soal.
$soal = null;
foreach (require __DIR__ . '/../data/soal.php' as $s) {
    if ((int) $s['id'] === $id) { $soal = $s; break; }
}
if ($soal === null) {
    balas(404, ['ok' => false, 'pesan' => 'Soal tidak ditemukan.']);
}
if ($jawaban < 0 || $jawaban >= count($soal['pilihan'])) {
    balas(400, ['ok' => false, 'pesan' => 'Pilihan jawaban tidak ada.']);
}

$uid = (int) $_SESSION['pengguna']['id'];
$pid = (int) ($_SESSION['kuis_percobaan'] ?? 0);
$benar = ($jawaban === (int) $soal['jawaban']);

$pdo = db();
$pdo->beginTransaction();
try {
    // Percobaan harus milik pengguna ini dan belum selesai.
    $st = $pdo->prepare('SELECT jumlah_soal FROM percobaan_kuis WHERE id = :p AND pengguna_id = :u AND selesai IS NULL FOR UPDATE');
    $st->execute([':p' => $pid, ':u' => $uid]);
    $total = $st->fetchColumn();
    if ($total === false) {
        $pdo->rollBack();
        balas(409, ['ok' => false, 'pesan' => 'Sesi kuis tidak ditemukan atau sudah berakhir. Muat ulang halaman kuis.']);
    }

    $st = $pdo->prepare('INSERT INTO jawaban_kuis (percobaan_id, soal_id, jawaban, benar) VALUES (:p, :s, :j, :b) ON CONFLICT (percobaan_id, soal_id) DO NOTHING');
    $st->bindValue(':p', $pid, PDO::PARAM_INT);
    $st->bindValue(':s', $id, PDO::PARAM_INT);
    $st->bindValue(':j', $jawaban, PDO::PARAM_INT);
    $st->bindValue(':b', $benar, PDO::PARAM_BOOL);
    $st->execute();
    if ($st->rowCount() === 0) {
        $pdo->rollBack();
        balas(409, ['ok' => false, 'pesan' => 'Soal ini sudah dijawab.']);
    }

    $st = $pdo->prepare('SELECT COUNT(*) AS dijawab, COUNT(*) FILTER (WHERE benar) AS jml_benar FROM jawaban_kuis WHERE percobaan_id = :p');
    $st->execute([':p' => $pid]);
    $r = $st->fetch();

    $hasil = [
        'ok'         => true,
        'benar'      => $benar,
        'kunci'      => (int) $soal['jawaban'],
        'penjelasan' => $soal['penjelasan'],
        'selesai'    => false,
    ];

    if ((int) $r['dijawab'] >= (int) $total) {
        $nilai = (int) round(((int) $r['jml_benar'] / (int) $total) * 100);
        $st = $pdo->prepare('UPDATE percobaan_kuis SET selesai = now(), jumlah_benar = :b, nilai = :n WHERE id = :p');
        $st->execute([':b' => (int) $r['jml_benar'], ':n' => $nilai, ':p' => $pid]);
        $hasil['selesai'] = true;
        $hasil['nilai']   = $nilai;
        unset($_SESSION['kuis_percobaan']);
    }
    $pdo->commit();
} catch (Throwable $ex) {
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    throw $ex;
}

balas(200, $hasil);
