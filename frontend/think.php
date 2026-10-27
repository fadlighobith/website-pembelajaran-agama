<?php
/**
 * think.php
 * Latihan "THINK sebelum posting": 5 pertanyaan penyaring unggahan.
 * Logika penilaian ada di assets/js/main.js.
 */
$think = require __DIR__ . '/data/think.php';

$judul_halaman = 'THINK Sebelum Posting';
$menu_aktif    = 'aktivitas';

include __DIR__ . '/includes/header.php';
?>

<section class="pita banner">
    <div class="wadah banner-isi">
        <div class="muncul">
            <span class="lencana">Aktivitas</span>
            <h1>THINK Sebelum<br>Memposting</h1>
            <p>Tulis rencana unggahanmu, lalu saring dengan lima pertanyaan berikut agar jejak digitalmu membawa kebaikan.</p>
        </div>
        <div><?= seni_banner('quran') ?></div>
    </div>
</section>

<section class="wadah tata-sempit bagian" id="thinkApp">
    <div class="kartu panel">
        <label for="thinkTeks"><strong>Apa yang ingin kamu unggah?</strong></label>
        <textarea id="thinkTeks" class="think-area" placeholder="Contoh: foto tiket konser lengkap dengan barcode…" style="margin-top:8px"></textarea>

        <div class="contoh-daftar" aria-label="Contoh unggahan">
            <?php foreach ($think['contoh'] as $c): ?>
                <button type="button" class="chip" data-contoh="<?= e($c) ?>"><?= e($c) ?></button>
            <?php endforeach; ?>
        </div>

        <div class="think-kisi">
            <?php foreach ($think['kriteria'] as $i => $k): ?>
                <div class="think-kartu" data-indeks="<?= $i ?>">
                    <div class="think-huruf" aria-hidden="true"><?= e($k['huruf']) ?></div>
                    <div>
                        <h3><?= e($k['nama']) ?> <span style="font-weight:400;color:var(--teks-lembut)">(<?= e($k['inggris']) ?>)</span></h3>
                        <p><?= e($k['tanya']) ?></p>
                        <span class="dalil-mini"><?= e($k['arti']) ?> (<?= e($k['dalil']) ?>)</span>
                    </div>
                    <div class="think-pilih" role="group" aria-label="Jawaban untuk <?= e($k['nama']) ?>">
                        <button type="button" class="tombol-ya" aria-pressed="false">Ya</button>
                        <button type="button" class="tombol-tidak" aria-pressed="false">Tidak</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="think-hasil" id="thinkHasil" role="status" aria-live="polite">
            <h3>Jawab kelima pertanyaan di atas</h3>
            <p>Hasil penilaian akan muncul di sini.</p>
        </div>

        <div class="hasil-aksi" style="grid-template-columns:repeat(auto-fit,minmax(180px,1fr))">
            <button type="button" class="tombol tombol-garis" id="thinkReset"><?= ikon('ulang', 16) ?> Mulai Lagi</button>
            <a class="tombol tombol-utama" href="kuis.php">Lanjut ke Kuis <?= ikon('kanan', 16) ?></a>
        </div>
    </div>
</section>

<script>window.THINK_KRITERIA = <?= json_encode(array_map(function ($k) {
    return ['huruf' => $k['huruf'], 'nama' => $k['nama']];
}, $think['kriteria']), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
