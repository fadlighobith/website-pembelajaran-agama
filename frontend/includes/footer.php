<?php
/**
 * includes/footer.php
 * Variabel opsional:
 *   $js_tambahan (array) nama file JS tambahan di assets/js/, misalnya ['kuis.js']
 */
$js_tambahan = isset($js_tambahan) ? $js_tambahan : [];

// Indeks pencarian (judul + potongan teks) dibuat dari file data.
$indeks = [];
$data_materi = require __DIR__ . '/../data/materi.php';
foreach ($data_materi as $bab) {
    $indeks[] = [
        'tipe'  => 'Materi',
        'judul' => $bab['id'] . '. ' . $bab['judul'],
        'teks'  => strip_tags(implode(' ', $bab['isi'])),
        'url'   => 'index.php?hal=materi&bab=' . $bab['id'],
    ];
}
$data_dalil = require __DIR__ . '/../data/dalil.php';
foreach ($data_dalil['quran'] as $i => $d) {
    $indeks[] = [
        'tipe'  => "Al-Qur'an",
        'judul' => $d['ref'],
        'teks'  => $d['terjemah'] . ' ' . $d['penjelasan'],
        'url'   => 'dalil.php?tab=quran#quran-' . ($i + 1),
    ];
}
foreach ($data_dalil['hadis'] as $i => $d) {
    $indeks[] = [
        'tipe'  => 'Hadis',
        'judul' => $d['ref'],
        'teks'  => $d['terjemah'] . ' ' . $d['penjelasan'],
        'url'   => 'dalil.php?tab=hadis#hadis-' . ($i + 1),
    ];
}
$indeks[] = ['tipe' => 'Aktivitas', 'judul' => 'Simulasi Kasus', 'teks' => 'Latihan memilih tindakan pada situasi nyata di dunia maya.', 'url' => 'simulasi.php'];
$indeks[] = ['tipe' => 'Aktivitas', 'judul' => 'THINK Sebelum Posting', 'teks' => 'Periksa unggahan: benar, bermanfaat, menginspirasi, perlu, baik.', 'url' => 'think.php'];
$indeks[] = ['tipe' => 'Kuis', 'judul' => 'Kuis Privasi Digital', 'teks' => 'Uji pemahamanmu dengan soal pilihan ganda.', 'url' => 'kuis.php'];
?>
</main>

<footer class="kaki">
    <div class="wadah kaki-isi">
        <div class="kaki-merek">
            <?= logo_svg() ?>
            <div>
                <strong>AmanahNet</strong>
                <p>Media belajar Pendidikan Agama Islam: menjaga privasi digital sebagai amanah.</p>
            </div>
        </div>
        <ul class="kaki-tautan">
            <li><a href="index.php?hal=materi">Materi</a></li>
            <li><a href="dalil.php">Al-Qur'an &amp; Hadis</a></li>
            <li><a href="simulasi.php">Simulasi</a></li>
            <li><a href="think.php">THINK</a></li>
            <li><a href="kuis.php">Kuis</a></li>
        </ul>
    </div>
    <p class="kaki-hak">&copy; <?= date('Y') ?> AmanahNet. Terjemahan ayat dan hadis ditulis ringkas; periksa kembali ke sumber asli.</p>
</footer>

<!-- Jendela pencarian -->
<div class="cari-latar" id="cariLatar" hidden>
    <div class="cari-kotak" role="dialog" aria-modal="true" aria-label="Pencarian">
        <div class="cari-baris">
            <?= ikon('cari', 18) ?>
            <input type="search" id="cariInput" placeholder="Cari materi, ayat, atau hadis…" autocomplete="off" aria-label="Kata kunci pencarian">
            <button type="button" class="cari-tutup" id="cariTutup" aria-label="Tutup pencarian"><?= ikon('silang', 18) ?></button>
        </div>
        <ul class="cari-hasil" id="cariHasil" aria-live="polite"></ul>
        <p class="cari-bantu">Tekan <kbd>/</kbd> untuk membuka, <kbd>Esc</kbd> untuk menutup.</p>
    </div>
</div>

<script>window.INDEKS_CARI = <?= json_encode($indeks, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script>
<script src="assets/js/main.js"></script>
<?php foreach ($js_tambahan as $berkas): ?>
<script src="assets/js/<?= e($berkas) ?>"></script>
<?php endforeach; ?>
</body>
</html>
