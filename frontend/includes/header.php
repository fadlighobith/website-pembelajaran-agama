<?php
/**
 * includes/header.php
 * Variabel yang bisa diisi dari halaman sebelum include:
 *   $judul_halaman  (string)  judul tab browser
 *   $menu_aktif     (string)  beranda | materi | dalil | aktivitas | kuis
 *   $body_atribut   (string)  atribut tambahan untuk <body> (opsional)
 */

require_once __DIR__ . '/../../backend/includes/auth.php';

if (!function_exists('e')) {
    /** Escape output agar aman dari XSS. */
    function e($teks)
    {
        return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('ikon')) {
    /** Ikon SVG sederhana (gaya garis). */
    function ikon($nama, $ukuran = 20)
    {
        $path = [
            'buku'     => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
            'perisai'  => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
            'gir'      => '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>',
            'kuis'     => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><circle cx="11.5" cy="14.5" r="2.5"/><path d="m13.3 16.3 2.2 2.2"/>',
            'cari'     => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
            'bulan'    => '<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>',
            'matahari' => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>',
            'kanan'    => '<path d="M5 12h14M12 5l7 7-7 7"/>',
            'kiri'     => '<path d="M19 12H5M12 19l-7-7 7-7"/>',
            'gembok'   => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
            'lampu'    => '<path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6M10 22h4"/>',
            'centang'  => '<path d="M20 6 9 17l-5-5"/>',
            'silang'   => '<path d="M18 6 6 18M6 6l12 12"/>',
            'menu'     => '<path d="M4 6h16M4 12h16M4 18h16"/>',
            'bumi'     => '<circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20z"/>',
            'pesan'    => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
            'pengguna' => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
            'piala'    => '<path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"/>',
            'bawah'    => '<path d="m6 9 6 6 6-6"/>',
            'bintang'  => '<path d="M12 2l2.4 3.3 4-.6.6 4 3.3 2.4-3.3 2.4-.6 4-4-.6L12 22l-2.4-3.3-4 .6-.6-4L1.7 12l3.3-2.4.6-4 4 .6z"/>',
            'ulang'    => '<path d="M3 12a9 9 0 0 1 15.5-6.2L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-15.5 6.2L3 16"/><path d="M3 21v-5h5"/>',
        ];
        $d = isset($path[$nama]) ? $path[$nama] : '';
        return '<svg class="ikon" width="' . (int) $ukuran . '" height="' . (int) $ukuran . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $d . '</svg>';
    }
}

if (!function_exists('logo_svg')) {
    function logo_svg()
    {
        return '<svg class="logo-svg" viewBox="0 0 40 40" aria-hidden="true">'
            . '<path d="M20 2.5c-6.2 5-11.5 8.4-11.5 16.7V36.5h23V19.2C31.5 10.9 26.2 7.5 20 2.5z" fill="#1d5a49"/>'
            . '<path d="M22.6 12.2a6.3 6.3 0 1 0 4.2 11 5.2 5.2 0 1 1-4.2-11z" fill="#f4efdc"/>'
            . '<rect x="16.2" y="25" width="7.6" height="6.4" rx="1.4" fill="#f4efdc"/>'
            . '<path d="M18 25v-1.8a2 2 0 0 1 4 0V25" fill="none" stroke="#f4efdc" stroke-width="1.4"/>'
            . '</svg>';
    }
}

if (!function_exists('daun_svg')) {
    /** Dekorasi daun (dipakai berulang di banner). */
    function daun_svg($kelas = '')
    {
        return '<svg class="daun ' . e($kelas) . '" viewBox="0 0 120 140" aria-hidden="true">'
            . '<path d="M60 138C58 100 60 60 62 8" fill="none" stroke="#4d7a68" stroke-width="2.2" stroke-linecap="round"/>'
            . '<path d="M61 100C34 96 16 74 14 48c28 2 46 22 47 52z" fill="#6f9a86"/>'
            . '<path d="M61 80c26-4 44-24 46-50-27 2-45 22-46 50z" fill="#8bb09c"/>'
            . '<path d="M61 56C44 50 34 34 34 14c18 2 29 18 27 42z" fill="#5d8a75"/>'
            . '<path d="M62 118c20-2 34-16 36-34-20 2-34 16-36 34z" fill="#7da590"/>'
            . '</svg>';
    }
}

if (!function_exists('seni_hero')) {
    /** Ilustrasi besar di beranda: jendela masjid, laptop bergembok, lentera. */
    function seni_hero()
    {
        return <<<'SVG'
<svg class="seni seni-hero" viewBox="0 0 520 340" role="img" aria-label="Ilustrasi laptop dengan gembok di depan jendela masjid dan bulan sabit">
  <defs>
    <linearGradient id="hgArch" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0" stop-color="#8fa898"/><stop offset="1" stop-color="#d4dfd2"/>
    </linearGradient>
    <linearGradient id="hgScreen" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="#4b8069"/><stop offset="1" stop-color="#2d5e4d"/>
    </linearGradient>
    <radialGradient id="hgGlow" cx="0.5" cy="0.5" r="0.5">
      <stop offset="0" stop-color="#ffe9a8" stop-opacity=".85"/><stop offset="1" stop-color="#ffe9a8" stop-opacity="0"/>
    </radialGradient>
  </defs>
  <!-- jendela lengkung -->
  <path d="M270 14C316 64 392 80 392 150V326H148V150C148 80 224 64 270 14Z" fill="url(#hgArch)"/>
  <path d="M270 34C310 76 372 92 372 152V326H168V152C168 92 230 76 270 34Z" fill="none" stroke="#f4efdc" stroke-opacity=".6" stroke-width="2"/>
  <!-- siluet masjid -->
  <g fill="#51796a" fill-opacity=".55">
    <rect x="188" y="206" width="9" height="120"/>
    <path d="M186 206l6.5-18 6.5 18z"/>
    <rect x="343" y="196" width="9" height="130"/>
    <path d="M341 196l6.5-18 6.5 18z"/>
    <path d="M222 326v-70c0-26 22-44 48-44s48 18 48 44v70z"/>
    <rect x="266" y="190" width="8" height="24"/>
    <circle cx="270" cy="186" r="4"/>
  </g>
  <!-- bulan sabit & bintang -->
  <path d="M256 92a36 36 0 1 0 30 58 30 30 0 1 1-30-58z" fill="#f6f0dc"/>
  <g fill="#f6f0dc">
    <path d="M318 98l2.4 6.2 6.4.3-5 4 1.8 6.3-5.6-3.6-5.6 3.6 1.8-6.3-5-4 6.4-.3z"/>
    <circle cx="214" cy="120" r="2.4"/><circle cx="330" cy="150" r="2"/><circle cx="232" cy="70" r="1.8"/>
  </g>
  <!-- laptop -->
  <ellipse cx="270" cy="322" rx="170" ry="12" fill="#2c5546" fill-opacity=".18"/>
  <rect x="164" y="196" width="212" height="122" rx="10" fill="#244d3f"/>
  <rect x="173" y="205" width="194" height="104" rx="5" fill="url(#hgScreen)"/>
  <path d="M120 318h300l-14 12H134z" fill="#355f50"/>
  <rect x="246" y="316" width="48" height="5" rx="2.5" fill="#1d4034"/>
  <!-- gembok -->
  <circle cx="270" cy="257" r="40" fill="url(#hgGlow)"/>
  <path d="M252 250v-10a18 18 0 0 1 36 0v10" fill="none" stroke="#f4efdc" stroke-width="7" stroke-linecap="round"/>
  <rect x="241" y="248" width="58" height="42" rx="9" fill="#f4efdc"/>
  <circle cx="270" cy="265" r="6" fill="#2d5e4d"/>
  <rect x="267" y="268" width="6" height="14" rx="3" fill="#2d5e4d"/>
  <!-- kartu melayang: perisai -->
  <g transform="translate(78 168)">
    <rect width="62" height="62" rx="12" fill="#e8ece1" stroke="#cdd8cb"/>
    <path d="M31 14l15 6v11c0 10-6.5 17-15 21-8.500-4-15-11-15-21V20z" fill="#3f7461"/>
    <path d="M24 31l5 5 9-10" fill="none" stroke="#f4efdc" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>
  </g>
  <!-- kartu melayang: profil -->
  <g transform="translate(404 206)">
    <rect width="92" height="52" rx="10" fill="#3f7461"/>
    <circle cx="22" cy="26" r="9" fill="#f4efdc"/>
    <path d="M10 44a12 10 0 0 1 24 0z" fill="#f4efdc"/>
    <rect x="42" y="16" width="38" height="5" rx="2.500" fill="#f4efdc" fill-opacity=".9"/>
    <rect x="42" y="27" width="30" height="5" rx="2.500" fill="#f4efdc" fill-opacity=".6"/>
    <rect x="42" y="38" width="22" height="5" rx="2.500" fill="#f4efdc" fill-opacity=".4"/>
  </g>
  <!-- kartu melayang: globe -->
  <g transform="translate(394 258)">
    <rect width="56" height="56" rx="12" fill="#3a6e5b"/>
    <circle cx="28" cy="28" r="15" fill="none" stroke="#f4efdc" stroke-width="2.4"/>
    <path d="M13 28h30M28 13c-7 8-7 22 0 30M28 13c7 8 7 22 0 30" fill="none" stroke="#f4efdc" stroke-width="2"/>
  </g>
  <!-- kartu melayang: pengguna -->
  <g transform="translate(112 116)">
    <rect width="54" height="54" rx="12" fill="#547f6d"/>
    <circle cx="27" cy="20" r="8" fill="#f4efdc"/>
    <path d="M12 44a15 12 0 0 1 30 0z" fill="#f4efdc"/>
  </g>
  <!-- lentera -->
  <g transform="translate(452 200)">
    <path d="M30 0v14" stroke="#3a3a35" stroke-width="3" stroke-linecap="round"/>
    <path d="M18 18h24l-3-6H21z" fill="#3a3a35"/>
    <path d="M18 18h24v6H18z" fill="#4a4a42"/>
    <path d="M20 24h20l5 36H15z" fill="#ffe3a0" fill-opacity=".9" stroke="#3a3a35" stroke-width="2.4"/>
    <path d="M30 24v36M23 24l-4 36M37 24l4 36" stroke="#3a3a35" stroke-width="1.6" fill="none"/>
    <rect x="12" y="60" width="36" height="8" rx="3" fill="#3a3a35"/>
    <ellipse cx="30" cy="44" rx="6" ry="9" fill="#fff4cc"/>
  </g>
  <!-- daun -->
  <g transform="translate(24 222) scale(.62)">
    <path d="M60 138C58 100 60 60 62 8" fill="none" stroke="#4d7a68" stroke-width="3" stroke-linecap="round"/>
    <path d="M61 100C34 96 16 74 14 48c28 2 46 22 47 52z" fill="#6f9a86"/>
    <path d="M61 80c26-4 44-24 46-50-27 2-45 22-46 50z" fill="#8bb09c"/>
    <path d="M61 56C44 50 34 34 34 14c18 2 29 18 27 42z" fill="#5d8a75"/>
  </g>
  <g transform="translate(110 250) scale(.5)">
    <path d="M60 138C58 100 60 60 62 8" fill="none" stroke="#4d7a68" stroke-width="3" stroke-linecap="round"/>
    <path d="M61 100C34 96 16 74 14 48c28 2 46 22 47 52z" fill="#7da590"/>
    <path d="M61 80c26-4 44-24 46-50-27 2-45 22-46 50z" fill="#9cbcaa"/>
  </g>
</svg>
SVG;
    }
}

if (!function_exists('seni_banner')) {
    /** Ilustrasi banner halaman dalam: masjid | quran | kuis. */
    function seni_banner($jenis = 'masjid')
    {
        if ($jenis === 'quran') {
            return <<<'SVG'
<svg class="seni seni-banner" viewBox="0 0 420 200" role="img" aria-label="Ilustrasi Al-Qur'an terbuka di atas rehal kayu">
  <defs>
    <linearGradient id="bqKayu" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#7a4a2b"/><stop offset="1" stop-color="#4f2f1b"/></linearGradient>
  </defs>
  <path d="M90 60 220 118 350 60V40L220 98 90 40z" fill="url(#bqKayu)"/>
  <path d="M90 54 220 112l130-58-6-12L220 98 96 42z" fill="#8a5a38"/>
  <path d="M110 40 215 92v50L110 92z" fill="#f4eed9" stroke="#d8cfae"/>
  <path d="M330 40 225 92v50l105-50z" fill="#fbf7e8" stroke="#d8cfae"/>
  <g stroke="#b9ad84" stroke-width="2" stroke-linecap="round">
    <path d="M124 54l76 36M124 64l76 36M124 74l76 36M124 84l76 36"/>
    <path d="M316 54l-76 36M316 64l-76 36M316 74l-76 36M316 84l-76 36"/>
  </g>
  <path d="M200 140l20 10 20-10 8 6-28 14-28-14z" fill="#6a4128"/>
  <path d="M170 160l50 22 50-22" fill="none" stroke="#4f2f1b" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
  <g transform="translate(340 60) scale(.9)">
    <path d="M60 138C58 100 60 60 62 8" fill="none" stroke="#4d7a68" stroke-width="2.4" stroke-linecap="round"/>
    <path d="M61 100C34 96 16 74 14 48c28 2 46 22 47 52z" fill="#6f9a86"/>
    <path d="M61 80c26-4 44-24 46-50-27 2-45 22-46 50z" fill="#8bb09c"/>
    <path d="M61 56C44 50 34 34 34 14c18 2 29 18 27 42z" fill="#5d8a75"/>
  </g>
</svg>
SVG;
        }

        if ($jenis === 'kuis') {
            return <<<'SVG'
<svg class="seni seni-banner" viewBox="0 0 420 200" role="img" aria-label="Ilustrasi siswa belajar dengan laptop dan perisai">
  <rect x="40" y="20" width="130" height="150" rx="12" fill="#f4efdc" stroke="#cdd8cb"/>
  <g fill="none" stroke="#8fae9e" stroke-width="3" stroke-linecap="round">
    <circle cx="66" cy="54" r="9"/><path d="m62 54 3 3 6-7"/>
    <circle cx="66" cy="88" r="9"/><path d="m62 88 3 3 6-7"/>
    <path d="M86 54h60M86 88h60M60 122h86M60 144h60"/>
  </g>
  <path d="M130 72c20-6 36 0 50 12-1 28-14 46-50 60-36-14-49-32-50-60 14-12 30-18 50-12z" fill="#3f7461" transform="translate(30 6)"/>
  <path d="M142 112l10 10 20-22" fill="none" stroke="#f4efdc" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
  <!-- siswa -->
  <rect x="236" y="106" width="120" height="70" rx="6" fill="#2f5f4f"/>
  <rect x="244" y="112" width="104" height="54" rx="3" fill="#4b8069"/>
  <path d="M222 176h148l-8 8H230z" fill="#355f50"/>
  <path d="M262 106c0-30 16-46 34-46s34 16 34 46z" fill="#f4efdc"/>
  <circle cx="296" cy="74" r="22" fill="#e9c9a8"/>
  <path d="M272 66c4-18 16-26 26-26s20 8 22 26c-8-6-16-8-24-8s-16 2-24 8z" fill="#2c2a28"/>
  <path d="M274 70h46v-6c-6-4-14-6-23-6s-17 2-23 6z" fill="#fbf7e8" stroke="#cfc8ac"/>
  <path d="M268 104c4-14 14-20 28-20s24 6 28 20z" fill="#fbf7e8"/>
  <g transform="translate(364 40) scale(.85)">
    <path d="M60 138C58 100 60 60 62 8" fill="none" stroke="#4d7a68" stroke-width="2.4" stroke-linecap="round"/>
    <path d="M61 100C34 96 16 74 14 48c28 2 46 22 47 52z" fill="#6f9a86"/>
    <path d="M61 80c26-4 44-24 46-50-27 2-45 22-46 50z" fill="#8bb09c"/>
    <path d="M61 56C44 50 34 34 34 14c18 2 29 18 27 42z" fill="#5d8a75"/>
  </g>
</svg>
SVG;
        }

        return <<<'SVG'
<svg class="seni seni-banner" viewBox="0 0 420 200" role="img" aria-label="Ilustrasi masjid dengan bulan sabit dan lentera">
  <defs>
    <linearGradient id="bmArch" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#9fb5a5"/><stop offset="1" stop-color="#d9e2d6"/></linearGradient>
  </defs>
  <path d="M230 4C270 40 330 52 330 108V200H130V108C130 52 190 40 230 4Z" fill="url(#bmArch)"/>
  <g fill="#51796a" fill-opacity=".5">
    <rect x="148" y="112" width="8" height="88"/><path d="M146 112l6-16 6 16z"/>
    <rect x="304" y="104" width="8" height="96"/><path d="M302 104l6-16 6 16z"/>
    <path d="M184 200v-52c0-20 17-34 36-34s36 14 36 34v52z"/>
    <rect x="216" y="92" width="7" height="20"/><circle cx="219.500" cy="88" r="4"/>
  </g>
  <path d="M214 38a26 26 0 1 0 22 42 22 22 0 1 1-22-42z" fill="#f6f0dc"/>
  <g fill="#f6f0dc"><circle cx="262" cy="52" r="2.200"/><circle cx="178" cy="66" r="1.800"/><circle cx="282" cy="86" r="1.600"/></g>
  <g transform="translate(20 70) scale(.9)">
    <path d="M60 138C58 100 60 60 62 8" fill="none" stroke="#4d7a68" stroke-width="2.4" stroke-linecap="round"/>
    <path d="M61 100C34 96 16 74 14 48c28 2 46 22 47 52z" fill="#6f9a86"/>
    <path d="M61 80c26-4 44-24 46-50-27 2-45 22-46 50z" fill="#8bb09c"/>
    <path d="M61 56C44 50 34 34 34 14c18 2 29 18 27 42z" fill="#5d8a75"/>
  </g>
  <g transform="translate(350 96) scale(.8)">
    <path d="M30 0v14" stroke="#3a3a35" stroke-width="3" stroke-linecap="round"/>
    <path d="M18 18h24l-3-6H21z" fill="#3a3a35"/>
    <path d="M20 24h20l5 36H15z" fill="#ffe3a0" fill-opacity=".9" stroke="#3a3a35" stroke-width="2.400"/>
    <path d="M30 24v36M23 24l-4 36M37 24l4 36" stroke="#3a3a35" stroke-width="1.600" fill="none"/>
    <rect x="12" y="60" width="36" height="8" rx="3" fill="#3a3a35"/>
  </g>
</svg>
SVG;
    }
}

if (!function_exists('seni_semangat')) {
    /** Ilustrasi kecil di panel hasil kuis. */
    function seni_semangat()
    {
        return <<<'SVG'
<svg class="seni seni-kecil" viewBox="0 0 200 170" role="img" aria-label="Ilustrasi jendela masjid dengan perisai dan daun">
  <path d="M100 10C122 34 154 42 154 78V160H46V78C46 42 78 34 100 10Z" fill="#dfe8dc" stroke="#b9cbbf" stroke-width="2"/>
  <path d="M100 52c14 5 26 5 34 2v22c0 18-12 30-34 38-22-8-34-20-34-38V54c8 3 20 3 34-2z" fill="#3f7461" transform="translate(0 6)"/>
  <circle cx="100" cy="84" r="12" fill="none" stroke="#f4efdc" stroke-width="3"/>
  <path d="M100 76v16M92 84h16" stroke="#f4efdc" stroke-width="3" stroke-linecap="round"/>
  <g transform="translate(6 76) scale(.5)">
    <path d="M60 138C58 100 60 60 62 8" fill="none" stroke="#4d7a68" stroke-width="3.500" stroke-linecap="round"/>
    <path d="M61 100C34 96 16 74 14 48c28 2 46 22 47 52z" fill="#6f9a86"/>
    <path d="M61 80c26-4 44-24 46-50-27 2-45 22-46 50z" fill="#8bb09c"/>
  </g>
  <g transform="translate(142 76) scale(.5)">
    <path d="M60 138C58 100 60 60 62 8" fill="none" stroke="#4d7a68" stroke-width="3.500" stroke-linecap="round"/>
    <path d="M61 100C34 96 16 74 14 48c28 2 46 22 47 52z" fill="#6f9a86"/>
    <path d="M61 80c26-4 44-24 46-50-27 2-45 22-46 50z" fill="#8bb09c"/>
  </g>
</svg>
SVG;
    }
}

$judul_halaman = isset($judul_halaman) ? $judul_halaman : 'Privasiku';
$menu_aktif    = isset($menu_aktif) ? $menu_aktif : '';
$body_atribut  = isset($body_atribut) ? $body_atribut : '';

$menu = [
    'beranda' => ['Beranda', 'index.php'],
    'materi'  => ['Materi', 'index.php?hal=materi'],
    'dalil'   => ['Al-Qur\'an & Hadis', 'dalil.php'],
];
$pengguna = pengguna_saat_ini();
$menu_aktivitas = [
    ['Simulasi Kasus', 'simulasi.php', 'pesan'],
    ['THINK Sebelum Posting', 'think.php', 'lampu'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Privasiku: belajar menjaga privasi digital dengan landasan Al-Qur'an dan hadis.">
    <title><?= e($judul_halaman) ?> | Privasiku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Lora:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        // Terapkan tema tersimpan sebelum halaman tampil agar tidak berkedip.
        try {
            var t = localStorage.getItem('amanah-tema');
            if (t === 'gelap' || (!t && window.matchMedia && matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-tema', 'gelap');
            }
        } catch (err) {}
    </script>
</head>
<body <?= $body_atribut ?>>
<a class="lompat" href="#konten">Lompat ke konten</a>

<header class="navbar" id="navbar">
    <div class="wadah navbar-isi">
        <a class="merek" href="index.php" aria-label="Privasiku, ke beranda">
            <?= logo_svg() ?>
            <span>Privasiku</span>
        </a>

        <nav class="menu" id="menu" aria-label="Navigasi utama">
            <?php foreach ($menu as $kunci => $m): ?>
                <a href="<?= e($m[1]) ?>" class="<?= $menu_aktif === $kunci ? 'aktif' : '' ?>"
                   <?= $menu_aktif === $kunci ? 'aria-current="page"' : '' ?>><?= e($m[0]) ?></a>
            <?php endforeach; ?>

            <div class="dropdown <?= $menu_aktif === 'aktivitas' ? 'aktif' : '' ?>">
                <button type="button" class="dropdown-tombol" aria-haspopup="true" aria-expanded="false">
                    Aktivitas <?= ikon('bawah', 14) ?>
                </button>
                <div class="dropdown-isi">
                    <?php foreach ($menu_aktivitas as $a): ?>
                        <a href="<?= e($a[1]) ?>"><?= ikon($a[2], 16) ?> <?= e($a[0]) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <a href="kuis.php" class="<?= $menu_aktif === 'kuis' ? 'aktif' : '' ?>"
               <?= $menu_aktif === 'kuis' ? 'aria-current="page"' : '' ?>>Kuis</a>
        </nav>

        <div class="aksi-nav">
            <?php if ($pengguna): ?>
                <div class="dropdown dropdown-akun <?= $menu_aktif === 'akun' ? 'aktif' : '' ?>">
                    <button type="button" class="dropdown-tombol tombol-akun" aria-haspopup="true" aria-expanded="false" aria-label="Menu akun">
                        <?= ikon('pengguna', 18) ?> <span class="nama-akun"><?= e(strtok($pengguna['nama'], ' ')) ?></span>
                        <?= ikon('bawah', 14) ?>
                    </button>
                    <div class="dropdown-isi">
                        <div class="akun-info">
                            <strong><?= e($pengguna['nama']) ?></strong>
                            <small><?= $pengguna['role'] === 'admin' ? 'Admin / Guru' : 'Siswa' ?><?= $pengguna['kelas'] ? ' &middot; ' . e($pengguna['kelas']) : '' ?></small>
                        </div>
                        <?php if ($pengguna['role'] === 'admin'): ?>
                            <a href="skor.php"><?= ikon('piala', 16) ?> Skor Siswa</a>
                        <?php endif; ?>
                        <a href="riwayat.php"><?= ikon('kuis', 16) ?> Riwayat Kuis Saya</a>
                        <form method="post" action="../backend/api/logout.php">
                            <?= csrf_input() ?>
                            <button type="submit" class="dropdown-keluar"><?= ikon('kanan', 16) ?> Keluar</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <a class="tombol tombol-garis tombol-kecil tombol-masuk" href="login.php">Masuk</a>
                <a class="tombol tombol-utama tombol-kecil tombol-daftar" href="register.php">Daftar</a>
            <?php endif; ?>
            <button type="button" class="tombol-ikon" id="tombolCari" aria-label="Cari materi atau dalil" title="Cari ( / )">
                <?= ikon('cari', 18) ?>
            </button>
            <button type="button" class="tombol-ikon" id="tombolTema" aria-label="Ganti mode terang atau gelap" title="Mode gelap">
                <span class="ikon-bulan"><?= ikon('bulan', 18) ?></span>
                <span class="ikon-matahari"><?= ikon('matahari', 18) ?></span>
            </button>
            <button type="button" class="tombol-ikon tombol-menu" id="tombolMenu" aria-label="Buka menu" aria-expanded="false" aria-controls="menu">
                <?= ikon('menu', 20) ?>
            </button>
        </div>
    </div>
</header>

<main id="konten">
<?= tampil_flash() ?>
