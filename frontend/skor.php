<?php
/**
 * skor.php
 * Rekap skor kuis seluruh siswa. Hanya untuk admin/guru.
 *   skor.php             -> ringkasan per siswa (+ pencarian ?q=)
 *   skor.php?siswa=ID    -> detail percobaan dan jawaban satu siswa
 */
require_once __DIR__ . '/../backend/includes/auth.php';
require_once __DIR__ . '/../backend/includes/db.php';
wajib_admin();

$pdo  = db();
$bank = [];
foreach (require __DIR__ . '/../backend/data/soal.php' as $s) {
    $bank[(int) $s['id']] = $s;
}

$id_siswa = isset($_GET['siswa']) ? filter_var($_GET['siswa'], FILTER_VALIDATE_INT) : false;

if ($id_siswa) {
    /* ---------- Detail satu siswa ---------- */
    $st = $pdo->prepare("SELECT id, nama, username, kelas FROM pengguna WHERE id = :id AND role = 'user'");
    $st->execute([':id' => $id_siswa]);
    $siswa = $st->fetch();
    if (!$siswa) {
        flash('error', 'Siswa tidak ditemukan.');
        arahkan('skor.php');
    }

    $st = $pdo->prepare(
        "SELECT id, nilai, jumlah_benar, jumlah_soal,
                to_char(selesai AT TIME ZONE 'Asia/Jakarta', 'DD-MM-YYYY HH24:MI') AS waktu
         FROM percobaan_kuis WHERE pengguna_id = :id AND selesai IS NOT NULL ORDER BY selesai DESC"
    );
    $st->execute([':id' => $id_siswa]);
    $percobaan = $st->fetchAll();

    $jawaban = [];
    if ($percobaan) {
        $ids = implode(',', array_map('intval', array_column($percobaan, 'id')));
        foreach ($pdo->query("SELECT percobaan_id, soal_id, jawaban, benar FROM jawaban_kuis WHERE percobaan_id IN ($ids) ORDER BY id") as $r) {
            $jawaban[$r['percobaan_id']][] = $r;
        }
    }
    $judul_halaman = 'Skor ' . $siswa['nama'];
} else {
    /* ---------- Ringkasan semua siswa ---------- */
    $q = trim((string) ($_GET['q'] ?? ''));
    $sql = "SELECT p.id, p.nama, p.username, p.kelas,
                   COUNT(k.id) AS percobaan, MAX(k.nilai) AS terbaik, ROUND(AVG(k.nilai)) AS rata,
                   to_char(MAX(k.selesai) AT TIME ZONE 'Asia/Jakarta', 'DD-MM-YYYY HH24:MI') AS terakhir
            FROM pengguna p
            LEFT JOIN percobaan_kuis k ON k.pengguna_id = p.id AND k.selesai IS NOT NULL
            WHERE p.role = 'user'";
    $par = [];
    if ($q !== '') {
        $sql .= " AND (p.nama ILIKE :q OR p.username ILIKE :q OR COALESCE(p.kelas, '') ILIKE :q)";
        $par[':q'] = '%' . addcslashes($q, '%_\\') . '%';
    }
    $sql .= ' GROUP BY p.id ORDER BY p.nama';
    $st = $pdo->prepare($sql);
    $st->execute($par);
    $siswa_daftar = $st->fetchAll();

    $jml_siswa   = count($siswa_daftar);
    $sudah       = count(array_filter($siswa_daftar, function ($s) { return (int) $s['percobaan'] > 0; }));
    $rata_terbaik = $sudah ? round(array_sum(array_column($siswa_daftar, 'terbaik')) / $sudah) : 0;
    $judul_halaman = 'Skor Siswa';
}

$menu_aktif = 'akun';
include __DIR__ . '/includes/header.php';

function kelas_nilai($n)
{
    return $n >= 70 ? 'baik' : ($n >= 50 ? 'cukup' : 'kurang');
}
?>

<section class="wadah bagian skor-halaman">
<?php if ($id_siswa): ?>

    <p><a href="skor.php">&larr; Kembali ke daftar siswa</a></p>
    <h1 class="judul-halaman"><?= e($siswa['nama']) ?></h1>
    <p class="form-sub">@<?= e($siswa['username']) ?><?= $siswa['kelas'] ? ' &middot; ' . e($siswa['kelas']) : '' ?></p>

    <?php if (!$percobaan): ?>
        <div class="kartu panel"><p>Siswa ini belum menyelesaikan kuis.</p></div>
    <?php else: foreach ($percobaan as $p): ?>
        <details class="kartu panel percobaan">
            <summary>
                <span><?= e($p['waktu']) ?></span>
                <span><?= (int) $p['jumlah_benar'] ?> / <?= (int) $p['jumlah_soal'] ?> benar</span>
                <span class="lencana <?= kelas_nilai($p['nilai']) ?>"><?= (int) $p['nilai'] ?></span>
            </summary>
            <ul class="tinjau">
                <?php foreach (($jawaban[$p['id']] ?? []) as $n => $j):
                    $s = $bank[(int) $j['soal_id']] ?? null; ?>
                    <li>
                        <span class="status <?= $j['benar'] ? 'benar' : 'salah' ?>"><?= $j['benar'] ? '✓' : '✗' ?></span>
                        <div>
                            <strong><?= $n + 1 ?>. <?= e($s ? $s['tanya'] : 'Soal #' . $j['soal_id']) ?></strong>
                            <?php if ($s): ?>
                                <small>Dipilih: <?= e($s['pilihan'][(int) $j['jawaban']] ?? '-') ?><?= $j['benar'] ? '' : ' | Benar: ' . e($s['pilihan'][(int) $s['jawaban']]) ?></small>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </details>
    <?php endforeach; endif; ?>

<?php else: ?>

    <h1 class="judul-halaman">Skor Siswa</h1>
    <p class="form-sub">Rekap hasil kuis seluruh siswa yang terdaftar.</p>

    <div class="kisi-statistik">
        <div class="kartu stat"><strong><?= $jml_siswa ?></strong><span>Siswa<?= $q !== '' ? ' (hasil cari)' : '' ?></span></div>
        <div class="kartu stat"><strong><?= $sudah ?></strong><span>Sudah mengerjakan</span></div>
        <div class="kartu stat"><strong><?= $rata_terbaik ?></strong><span>Rata-rata nilai terbaik</span></div>
    </div>

    <div class="alat-skor">
        <form method="get" action="skor.php" class="cari-skor" role="search">
            <input type="search" name="q" value="<?= e($q) ?>" placeholder="Cari nama, username, atau kelas…" aria-label="Cari siswa">
            <button type="submit" class="tombol tombol-garis tombol-kecil">Cari</button>
            <?php if ($q !== ''): ?><a class="tombol tombol-garis tombol-kecil" href="skor.php">Reset</a><?php endif; ?>
        </form>
        <a class="tombol tombol-utama tombol-kecil" href="../backend/api/ekspor_skor.php">Unduh CSV</a>
    </div>

    <div class="kartu bungkus-tabel">
        <table class="tabel tabel-skor">
            <thead>
                <tr>
                    <th scope="col">Nama</th><th scope="col">Kelas</th><th scope="col">Percobaan</th>
                    <th scope="col">Terbaik</th><th scope="col">Rata-rata</th><th scope="col">Terakhir</th><th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$siswa_daftar): ?>
                <tr><td colspan="7">Tidak ada siswa yang cocok.</td></tr>
            <?php endif; ?>
            <?php foreach ($siswa_daftar as $s): ?>
                <tr>
                    <td><?= e($s['nama']) ?><br><small>@<?= e($s['username']) ?></small></td>
                    <td><?= e($s['kelas'] ?: '-') ?></td>
                    <td><?= (int) $s['percobaan'] ?></td>
                    <td><?= $s['terbaik'] !== null ? '<span class="lencana ' . kelas_nilai($s['terbaik']) . '">' . (int) $s['terbaik'] . '</span>' : '-' ?></td>
                    <td><?= $s['rata'] !== null ? (int) $s['rata'] : '-' ?></td>
                    <td><?= e($s['terakhir'] ?: 'Belum pernah') ?></td>
                    <td><?php if ((int) $s['percobaan'] > 0): ?><a href="skor.php?siswa=<?= (int) $s['id'] ?>">Detail</a><?php endif; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
