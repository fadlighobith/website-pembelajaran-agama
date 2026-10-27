<?php
/**
 * kuis.php
 * Halaman kuis. Soal dikirim ke browser TANPA kunci jawaban;
 * jawaban diperiksa oleh cek.php melalui fetch (lihat assets/js/kuis.js).
 */
require_once __DIR__ . '/../backend/includes/auth.php';
require_once __DIR__ . '/../backend/includes/db.php';

// Kuis hanya untuk pengguna yang sudah masuk.
wajib_login('Silakan masuk atau daftar terlebih dahulu untuk mengerjakan kuis.');

$semua = require __DIR__ . '/../backend/data/soal.php';

// Acak urutan soal setiap kali halaman dibuka, lalu buang kunci jawaban.
shuffle($semua);
$soal_publik = array_map(function ($s) {
    return [
        'id'      => $s['id'],
        'tanya'   => $s['tanya'],
        'pilihan' => $s['pilihan'],
    ];
}, $semua);

// Mulai satu percobaan baru di database. Percobaan lama yang belum selesai dibuang.
$pdo = db();
$uid = (int) pengguna_saat_ini()['id'];
$pdo->prepare('DELETE FROM percobaan_kuis WHERE pengguna_id = :u AND selesai IS NULL')->execute([':u' => $uid]);
$st = $pdo->prepare('INSERT INTO percobaan_kuis (pengguna_id, jumlah_soal) VALUES (:u, :n) RETURNING id');
$st->execute([':u' => $uid, ':n' => count($soal_publik)]);
$_SESSION['kuis_percobaan'] = (int) $st->fetchColumn();

$st = $pdo->prepare('SELECT COALESCE(MAX(nilai), 0) FROM percobaan_kuis WHERE pengguna_id = :u AND selesai IS NOT NULL');
$st->execute([':u' => $uid]);
$nilai_terbaik = (int) $st->fetchColumn();

$judul_halaman = 'Kuis';
$menu_aktif    = 'kuis';
$js_tambahan   = ['kuis.js'];

include __DIR__ . '/includes/header.php';
?>

<section class="pita banner">
    <div class="wadah banner-isi">
        <div class="muncul">
            <h1>Uji Pemahamanmu</h1>
            <p>Kerjakan kuis singkat untuk menguji seberapa jauh kamu memahami materi yang telah dipelajari.</p>
        </div>
        <div><?= seni_banner('kuis') ?></div>
    </div>
</section>

<section class="wadah tata-kuis" id="kuisApp" data-cek="../backend/api/cek.php" data-csrf="<?= e(csrf_token()) ?>">
    <div class="kartu panel-kuis" id="panelSoal">
        <noscript><p>Kuis ini memerlukan JavaScript. Aktifkan JavaScript di browser kamu.</p></noscript>

        <div id="areaSoal">
            <div class="kuis-atas">
                <span id="kuisNomor">Soal 1 dari <?= count($soal_publik) ?></span>
                <div class="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" id="kuisBarWadah">
                    <span id="kuisBar"></span>
                </div>
                <span id="kuisPersen">0%</span>
            </div>

            <h2 class="tanya" id="kuisTanya"></h2>
            <div class="pilihan" id="kuisPilihan" role="group" aria-labelledby="kuisTanya"></div>
            <div class="umpan" id="kuisUmpan" role="status" aria-live="polite" hidden></div>

            <div class="kuis-bawah">
                <button type="button" class="tombol tombol-utama" id="kuisLanjut" disabled>
                    <span id="kuisLanjutTeks">Selanjutnya</span> <?= ikon('kanan', 16) ?>
                </button>
            </div>
        </div>

        <div id="areaTinjau" hidden>
            <h2 class="tanya">Tinjauan Jawabanmu</h2>
            <ul class="tinjau" id="daftarTinjau"></ul>
        </div>
    </div>

    <aside class="kartu panel-hasil" aria-label="Hasil kuis">
        <h2><?= ikon('piala', 22) ?> Hasil Kuis</h2>

        <div id="hasilKosong">
            <p class="petunjuk">Skor kamu akan muncul di sini setelah selesai mengerjakan kuis.</p>
            <?= seni_semangat() ?>
            <p class="semangat">Terus semangat!</p>
            <p class="semangat-sub">Ilmu adalah cahaya yang membimbing kita.</p>
        </div>

        <div id="hasilIsi" hidden>
            <div class="skor-besar" id="skorAngka">0</div>
            <div class="skor-pred" id="skorPredikat"></div>
            <p class="semangat-sub" id="skorDetail"></p>
            <p class="skor-terbaik" id="skorTerbaik"></p>
            <div class="hasil-aksi">
                <button type="button" class="tombol tombol-utama" id="kuisUlang"><?= ikon('ulang', 16) ?> Ulangi Kuis</button>
                <a class="tombol tombol-garis" href="index.php?hal=materi">Pelajari Materi Lagi</a>
            </div>
        </div>
    </aside>
</section>

<script>window.KUIS_TERBAIK = <?= $nilai_terbaik ?>;</script>
<script>window.SOAL_KUIS = <?= json_encode($soal_publik, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
