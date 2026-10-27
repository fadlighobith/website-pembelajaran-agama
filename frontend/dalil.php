<?php
/**
 * dalil.php
 * Kumpulan ayat Al-Qur'an dan hadis (tab + filter tema).
 */
$data = require __DIR__ . '/data/dalil.php';

$judul_halaman = "Al-Qur'an & Hadis";
$menu_aktif    = 'dalil';

include __DIR__ . '/includes/header.php';

/** Cetak satu baris dalil (kartu Arab + kartu penjelasan). */
function baris_dalil($d, $prefiks, $no)
{
    ?>
    <div class="dalil-baris" id="<?= e($prefiks . '-' . $no) ?>" data-tema="<?= e($d['tema']) ?>">
        <div class="kartu dalil-arab">
            <div class="lingkar-bintang"><?= ikon('bintang', 28) ?></div>
            <div>
                <p class="teks-arab" lang="ar" dir="rtl"><?= e($d['arab']) ?></p>
                <p class="terjemah">“<?= e($d['terjemah']) ?>”</p>
                <div class="rujukan"><?= e($d['ref']) ?> <small>#<?= e($d['tema']) ?></small></div>
            </div>
        </div>
        <div class="kartu dalil-uraian">
            <strong>Penjelasan:</strong>
            <p><?= e($d['penjelasan']) ?></p>
        </div>
    </div>
    <?php
}
?>

<section class="pita banner">
    <div class="wadah banner-isi">
        <div class="muncul">
            <span class="lencana">Al-Qur'an &amp; Hadis</span>
            <h1>Petunjuk untuk<br>Dunia Digital yang Lebih Baik</h1>
            <p>Ayat-ayat Al-Qur'an dan hadis yang mengajarkan kita tentang pentingnya menjaga privasi, amanah, dan etika dalam menggunakan teknologi.</p>
        </div>
        <div><?= seni_banner('quran') ?></div>
    </div>
</section>

<section class="wadah bagian" style="padding-bottom:54px">
    <div class="tab-daftar" role="tablist" aria-label="Pilih jenis dalil">
        <button type="button" class="tab-tombol" role="tab" id="tab-quran" aria-controls="panel-quran" aria-selected="true" data-tab="quran">
            <?= ikon('bintang', 18) ?> Al-Qur'an
        </button>
        <button type="button" class="tab-tombol" role="tab" id="tab-hadis" aria-controls="panel-hadis" aria-selected="false" data-tab="hadis">
            <?= ikon('buku', 18) ?> Hadis
        </button>
    </div>

    <div class="chip-daftar" id="chipTema" role="group" aria-label="Filter berdasarkan tema">
        <button type="button" class="chip" data-tema="semua" aria-pressed="true">Semua</button>
        <?php foreach ($data['tema'] as $t): ?>
            <button type="button" class="chip" data-tema="<?= e($t) ?>" aria-pressed="false"><?= e($t) ?></button>
        <?php endforeach; ?>
    </div>

    <div class="tab-panel aktif" id="panel-quran" role="tabpanel" aria-labelledby="tab-quran">
        <?php foreach ($data['quran'] as $i => $d): ?>
            <?php baris_dalil($d, 'quran', $i + 1); ?>
        <?php endforeach; ?>
        <p class="kosong" hidden>Tidak ada dalil pada tema ini.</p>
    </div>

    <div class="tab-panel" id="panel-hadis" role="tabpanel" aria-labelledby="tab-hadis">
        <?php foreach ($data['hadis'] as $i => $d): ?>
            <?php baris_dalil($d, 'hadis', $i + 1); ?>
        <?php endforeach; ?>
        <p class="kosong" hidden>Tidak ada dalil pada tema ini.</p>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
