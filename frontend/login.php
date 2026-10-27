<?php
/**
 * login.php
 * Formulir masuk. Diproses oleh backend/api/login.php.
 */
require_once __DIR__ . '/../backend/includes/auth.php';

if (sudah_login()) {
    arahkan('index.php');
}
$next = tujuan_aman($_GET['next'] ?? '');

$judul_halaman = 'Masuk';
$menu_aktif    = 'akun';
include __DIR__ . '/includes/header.php';
?>

<section class="wadah tata-form bagian">
    <div class="kartu panel form-auth">
        <h1>Masuk</h1>
        <p class="form-sub">Masuk untuk mengerjakan kuis dan menyimpan skormu.</p>

        <form method="post" action="../backend/api/login.php" autocomplete="on">
            <?= csrf_input() ?>
            <input type="hidden" name="next" value="<?= e($next) ?>">

            <div class="bidang">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autocomplete="username"
                       autocapitalize="none" spellcheck="false" maxlength="30">
            </div>
            <div class="bidang">
                <label for="password">Kata sandi</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="tombol tombol-utama tombol-penuh">Masuk <?= ikon('kanan', 16) ?></button>
        </form>

        <p class="form-bawah">Belum punya akun? <a href="register.php<?= $next ? '?next=' . urlencode($next) : '' ?>">Daftar di sini</a></p>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
