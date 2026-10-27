<?php
/**
 * register.php
 * Formulir pendaftaran siswa. Diproses oleh backend/api/register.php.
 */
require_once __DIR__ . '/../backend/includes/auth.php';

if (sudah_login()) {
    arahkan('index.php');
}
$next = tujuan_aman($_GET['next'] ?? '');
$lama = $_SESSION['lama'] ?? ['nama' => '', 'username' => '', 'kelas' => ''];
unset($_SESSION['lama']);

$judul_halaman = 'Daftar';
$menu_aktif    = 'akun';
include __DIR__ . '/includes/header.php';
?>

<section class="wadah tata-form bagian">
    <div class="kartu panel form-auth">
        <h1>Buat Akun</h1>
        <p class="form-sub">Daftar sebagai siswa untuk mengerjakan kuis. Akun guru/admin dibuat oleh pengelola.</p>

        <form method="post" action="../backend/api/register.php" autocomplete="on">
            <?= csrf_input() ?>
            <input type="hidden" name="next" value="<?= e($next) ?>">

            <div class="bidang">
                <label for="nama">Nama lengkap</label>
                <input type="text" id="nama" name="nama" required minlength="2" maxlength="100"
                       autocomplete="name" value="<?= e($lama['nama']) ?>">
            </div>
            <div class="bidang">
                <label for="kelas">Kelas <small>(opsional)</small></label>
                <input type="text" id="kelas" name="kelas" maxlength="20" placeholder="Contoh: XI IPA 2" value="<?= e($lama['kelas']) ?>">
            </div>
            <div class="bidang">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required pattern="[a-zA-Z0-9_.]{3,30}"
                       minlength="3" maxlength="30" autocomplete="username" autocapitalize="none" spellcheck="false"
                       value="<?= e($lama['username']) ?>">
                <small>3&ndash;30 karakter: huruf, angka, titik, atau garis bawah.</small>
            </div>
            <div class="bidang">
                <label for="password">Kata sandi</label>
                <input type="password" id="password" name="password" required minlength="8" maxlength="72" autocomplete="new-password">
                <small>Minimal 8 karakter.</small>
            </div>
            <div class="bidang">
                <label for="password2">Ulangi kata sandi</label>
                <input type="password" id="password2" name="password2" required minlength="8" maxlength="72" autocomplete="new-password">
            </div>
            <button type="submit" class="tombol tombol-utama tombol-penuh">Daftar <?= ikon('kanan', 16) ?></button>
        </form>

        <p class="form-bawah">Sudah punya akun? <a href="login.php<?= $next ? '?next=' . urlencode($next) : '' ?>">Masuk</a></p>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
