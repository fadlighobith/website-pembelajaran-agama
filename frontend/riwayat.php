<?php
/**
 * riwayat.php
 * Riwayat kuis milik pengguna yang sedang login.
 */
require_once __DIR__ . '/../backend/includes/auth.php';
require_once __DIR__ . '/../backend/includes/db.php';
wajib_login('Masuk dahulu untuk melihat riwayat kuismu.');

$uid = (int) pengguna_saat_ini()['id'];
$st = db()->prepare(
    "SELECT nilai, jumlah_benar, jumlah_soal,
            to_char(selesai AT TIME ZONE 'Asia/Jakarta', 'DD-MM-YYYY HH24:MI') AS waktu
     FROM percobaan_kuis
     WHERE pengguna_id = :u AND selesai IS NOT NULL
     ORDER BY selesai DESC"
);
$st->execute([':u' => $uid]);
$daftar = $st->fetchAll();
$terbaik = $daftar ? max(array_column($daftar, 'nilai')) : null;

$judul_halaman = 'Riwayat Kuis';
$menu_aktif    = 'akun';
include __DIR__ . '/includes/header.php';
?>

<section class="wadah tata-sempit bagian">
    <div class="kartu panel">
        <h1 class="judul-halaman">Riwayat Kuis Saya</h1>
        <?php if (!$daftar): ?>
            <p>Kamu belum menyelesaikan kuis.</p>
            <a class="tombol tombol-utama" href="kuis.php">Mulai Kuis <?= ikon('kanan', 16) ?></a>
        <?php else: ?>
            <p class="form-sub">Nilai terbaik: <strong><?= (int) $terbaik ?></strong> &middot; Percobaan: <strong><?= count($daftar) ?></strong></p>
            <div class="bungkus-tabel">
                <table class="tabel">
                    <thead><tr><th scope="col">Waktu</th><th scope="col">Benar</th><th scope="col">Nilai</th></tr></thead>
                    <tbody>
                    <?php foreach ($daftar as $d): ?>
                        <tr>
                            <td><?= e($d['waktu']) ?></td>
                            <td><?= (int) $d['jumlah_benar'] ?> / <?= (int) $d['jumlah_soal'] ?></td>
                            <td><span class="lencana <?= $d['nilai'] >= 70 ? 'baik' : ($d['nilai'] >= 50 ? 'cukup' : 'kurang') ?>"><?= (int) $d['nilai'] ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="hasil-aksi" style="max-width:260px"><a class="tombol tombol-utama" href="kuis.php"><?= ikon('ulang', 16) ?> Kerjakan Lagi</a></div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
