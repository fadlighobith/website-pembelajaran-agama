<?php
/**
 * simulasi.php
 * Simulasi kasus "Apa yang akan kamu lakukan?". Logika ada di assets/js/main.js.
 */
$skenario = require __DIR__ . '/../backend/data/simulasi.php';

$judul_halaman = 'Simulasi Kasus';
$menu_aktif    = 'aktivitas';

include __DIR__ . '/includes/header.php';
?>

<section class="pita banner">
    <div class="wadah banner-isi">
        <div class="muncul">
            <h1>Apa yang Akan<br>Kamu Lakukan?</h1>
            <p>Hadapi situasi nyata di dunia maya, pilih tindakanmu, lalu lihat dampak dan dalil yang berkaitan.</p>
        </div>
        <div><?= seni_banner('masjid') ?></div>
    </div>
</section>

<section class="wadah tata-sempit bagian" id="simulasiApp">
    <div class="kartu panel" id="simulasiPanel">
        <noscript><p>Simulasi ini memerlukan JavaScript.</p></noscript>

        <div id="simulasiSoal">
            <div class="skor-baris">
                <span id="simNomor">Kasus 1 dari <?= count($skenario) ?></span>
                <span>Skor Amanah: <strong id="simSkor">0</strong></span>
            </div>
            <div class="bar"><span id="simBar"></span></div>

            <h2 id="simJudul" style="margin-top:20px"></h2>
            <p class="situasi" id="simSituasi"></p>
            <div class="pilihan" id="simPilihan" role="group" aria-labelledby="simJudul"></div>
            <div class="umpan" id="simUmpan" role="status" aria-live="polite" hidden></div>

            <div class="kuis-bawah">
                <button type="button" class="tombol tombol-utama" id="simLanjut" disabled>
                    <span id="simLanjutTeks">Selanjutnya</span> <?= ikon('kanan', 16) ?>
                </button>
            </div>
        </div>

        <div id="simulasiAkhir" hidden style="text-align:center">
            <div class="skor-besar" id="simAkhirAngka">0</div>
            <div class="skor-pred" id="simAkhirJudul"></div>
            <p id="simAkhirPesan" style="max-width:52ch;margin-inline:auto"></p>
            <div class="hasil-aksi" style="max-width:320px;margin-inline:auto">
                <button type="button" class="tombol tombol-utama" id="simUlang"><?= ikon('ulang', 16) ?> Ulangi Simulasi</button>
                <a class="tombol tombol-garis" href="think.php">Latihan THINK</a>
            </div>
        </div>
    </div>
</section>

<script>window.SKENARIO = <?= json_encode($skenario, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
