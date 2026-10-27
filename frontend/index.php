<?php
/**
 * index.php
 * Beranda (default) dan halaman Materi (?hal=materi&bab=1..6).
 */
$hal    = (isset($_GET['hal']) && $_GET['hal'] === 'materi') ? 'materi' : 'beranda';
$materi = require __DIR__ . '/../backend/data/materi.php';

if ($hal === 'materi') {
    $total = count($materi);
    $nomor = isset($_GET['bab']) ? (int) $_GET['bab'] : 1;
    if ($nomor < 1 || $nomor > $total) {
        $nomor = 1;
    }
    $bab = $materi[$nomor - 1];

    $judul_halaman = $bab['judul'] . ' - Materi';
    $menu_aktif    = 'materi';
    $body_atribut  = 'data-bab="' . (int) $nomor . '" data-total-bab="' . (int) $total . '"';
} else {
    $judul_halaman = 'Jaga Jejak Digital, Raih Keberkahan';
    $menu_aktif    = 'beranda';

    // Satu hadis acak untuk ditampilkan di bagian kutipan.
    $dalil  = require __DIR__ . '/../backend/data/dalil.php';
    $acak   = $dalil['hadis'][array_rand($dalil['hadis'])];
}

include __DIR__ . '/includes/header.php';
?>

<?php if ($hal === 'beranda'): ?>

    <section class="pita hero">
        <div class="wadah hero-isi">
            <div class="muncul">
                <h1>Jaga Jejak Digital, <span>Raih Keberkahan</span></h1>
                <p>Kelola privasi digital dengan bijak, karena setiap data adalah amanah yang harus dijaga, di dunia dan di akhirat.</p>
                <div class="hero-tombol">
                    <a class="tombol tombol-utama" href="index.php?hal=materi">Mulai Belajar <?= ikon('kanan', 16) ?></a>
                    <a class="tombol tombol-garis" href="#jelajah">Jelajahi Materi</a>
                </div>
            </div>
            <div class="muncul" style="animation-delay:.12s">
                <?= seni_hero() ?>
            </div>
        </div>
    </section>

    <section class="bagian" id="jelajah">
        <div class="wadah">
            <h2 class="bagian-judul">Jelajahi Pembelajaran</h2>
            <div class="kisi-kartu">
                <a class="kartu kartu-menu" href="index.php?hal=materi&amp;bab=1">
                    <span class="ikon-besar"><?= ikon('buku', 24) ?></span>
                    <h3>Konsep Privasi Digital</h3>
                    <p>Pahami dasar-dasar privasi di dunia digital.</p>
                    <span class="panah"><?= ikon('kanan', 14) ?></span>
                </a>
                <a class="kartu kartu-menu" href="index.php?hal=materi&amp;bab=3">
                    <span class="ikon-besar"><?= ikon('perisai', 24) ?></span>
                    <h3>Dampak &amp; Risiko</h3>
                    <p>Ketahui ancaman yang bisa mengintai data pribadimu.</p>
                    <span class="panah"><?= ikon('kanan', 14) ?></span>
                </a>
                <a class="kartu kartu-menu" href="index.php?hal=materi&amp;bab=4">
                    <span class="ikon-besar"><?= ikon('gir', 24) ?></span>
                    <h3>Etika &amp; Islam</h3>
                    <p>Jaga privasi, wujudkan akhlak di era digital.</p>
                    <span class="panah"><?= ikon('kanan', 14) ?></span>
                </a>
                <a class="kartu kartu-menu" href="kuis.php">
                    <span class="ikon-besar"><?= ikon('kuis', 24) ?></span>
                    <h3>Kuis</h3>
                    <p>Uji pemahamanmu dengan soal interaktif.</p>
                    <span class="panah"><?= ikon('kanan', 14) ?></span>
                </a>
            </div>
        </div>
    </section>

    <section class="bagian" style="padding-top:0">
        <div class="wadah">
            <h2 class="bagian-judul">Aktivitas Interaktif</h2>
            <div class="kisi-kartu tiga">
                <a class="kartu kartu-menu" href="dalil.php">
                    <span class="ikon-besar"><?= ikon('bintang', 24) ?></span>
                    <h3>Al-Qur'an &amp; Hadis</h3>
                    <p>Dalil tentang amanah, tabayyun, dan adab bermedia.</p>
                    <span class="panah"><?= ikon('kanan', 14) ?></span>
                </a>
                <a class="kartu kartu-menu" href="simulasi.php">
                    <span class="ikon-besar"><?= ikon('pesan', 24) ?></span>
                    <h3>Simulasi Kasus</h3>
                    <p>Pilih tindakanmu pada situasi nyata di dunia maya.</p>
                    <span class="panah"><?= ikon('kanan', 14) ?></span>
                </a>
                <a class="kartu kartu-menu" href="think.php">
                    <span class="ikon-besar"><?= ikon('lampu', 24) ?></span>
                    <h3>THINK Sebelum Posting</h3>
                    <p>Saring unggahanmu dengan lima pertanyaan sederhana.</p>
                    <span class="panah"><?= ikon('kanan', 14) ?></span>
                </a>
            </div>

            <figure class="kutipan" style="margin-left:0;margin-right:0">
                <span class="tanda" aria-hidden="true">“</span>
                <div>
                    <q><?= e($acak['terjemah']) ?></q>
                    <cite>&mdash; <?= e($acak['ref']) ?></cite>
                </div>
                <span class="tanda" aria-hidden="true">”</span>
            </figure>
        </div>
    </section>

<?php else: ?>

    <section class="pita banner">
        <div class="wadah banner-isi">
            <div class="muncul">
                <h1>Kenali, Pahami, Jaga</h1>
                <p>Pelajari materi yang disusun secara sederhana dan mudah dipahami, agar kamu bisa lebih bijak dalam menggunakan teknologi.</p>
            </div>
            <div><?= seni_banner('masjid') ?></div>
        </div>
    </section>

    <section class="wadah tata-materi">
        <aside class="kartu samping" aria-label="Daftar bab">
            <ul class="daftar-bab">
                <?php foreach ($materi as $b): ?>
                    <li>
                        <a href="index.php?hal=materi&amp;bab=<?= (int) $b['id'] ?>"
                           data-bab="<?= (int) $b['id'] ?>"
                           class="<?= $b['id'] === $nomor ? 'aktif' : '' ?>"
                           <?= $b['id'] === $nomor ? 'aria-current="page"' : '' ?>>
                            <span class="no-bab"><?= str_pad((string) $b['id'], 2, '0', STR_PAD_LEFT) ?></span>
                            <?= e($b['menu']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="progres-materi">
                <span id="teksProgres">Progres belajar</span>
                <div class="bar"><span id="barProgres"></span></div>
            </div>
        </aside>

        <article class="kartu isi-materi muncul">
            <div class="judul-bab">
                <?= ikon('buku', 26) ?>
                <h2><?= (int) $bab['id'] ?>. <?= e($bab['judul']) ?></h2>
            </div>
            <?php foreach ($bab['isi'] as $paragraf): ?>
                <p><?= e($paragraf) ?></p>
            <?php endforeach; ?>

            <?php if (!empty($bab['tabel'])): ?>
                <div class="bungkus-tabel">
                    <h3><?= e($bab['tabel']['judul']) ?></h3>
                    <table class="tabel">
                        <thead>
                            <tr>
                                <?php foreach ($bab['tabel']['kolom'] as $kolom): ?>
                                    <th scope="col"><?= e($kolom) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bab['tabel']['baris'] as $baris): ?>
                                <tr>
                                    <?php foreach ($baris as $sel): ?>
                                        <td><?= e($sel) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if (!empty($bab['langkah'])): ?>
                <ol class="langkah">
                    <?php foreach ($bab['langkah'] as $l): ?>
                        <li><strong><?= e($l[0]) ?></strong><span><?= e($l[1]) ?></span></li>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>

            <?php if (!empty($bab['poin'])): ?>
                <div class="kotak-poin">
                    <div class="ikon-lampu"><?= ikon('lampu', 38) ?></div>
                    <div>
                        <h3><?= e($bab['poin_judul']) ?>:</h3>
                        <ul>
                            <?php foreach ($bab['poin'] as $p): ?>
                                <li><?= e($p) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($bab['refleksi'])): ?>
                <div class="refleksi">
                    <h3>Renungkan</h3>
                    <ul>
                        <?php foreach ($bab['refleksi'] as $r): ?>
                            <li><?= e($r) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($bab['dalil'])): ?>
                <figure class="kotak-dalil" style="margin-inline:0">
                    <span class="tanda" aria-hidden="true">“</span>
                    <q><?= e($bab['dalil']['teks']) ?></q>
                    <cite>(<?= e($bab['dalil']['ref']) ?>)</cite>
                </figure>
            <?php endif; ?>

            <div class="navigasi-bab">
                <?php if ($nomor > 1): ?>
                    <a class="tombol tombol-garis" href="index.php?hal=materi&amp;bab=<?= $nomor - 1 ?>"><?= ikon('kiri', 16) ?> Sebelumnya</a>
                <?php else: ?>
                    <span></span>
                <?php endif; ?>

                <?php if ($nomor < $total): ?>
                    <a class="tombol tombol-utama" href="index.php?hal=materi&amp;bab=<?= $nomor + 1 ?>">Selanjutnya <?= ikon('kanan', 16) ?></a>
                <?php else: ?>
                    <a class="tombol tombol-utama" href="kuis.php">Kerjakan Kuis <?= ikon('kanan', 16) ?></a>
                <?php endif; ?>
            </div>
        </article>
    </section>

<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
