<?php
/**
 * data/simulasi.php
 * Skenario simulasi "Apa yang akan kamu lakukan?".
 * Skor tiap pilihan: 2 = terbaik, 1 = cukup, 0 = berisiko.
 */
return [
    [
        'judul'    => 'Tautan Hadiah',
        'situasi'  => 'Temanmu mengirim pesan berantai: “Dapat pulsa gratis Rp500.000! Klik tautan ini dan masukkan nomor HP serta kode yang dikirim lewat SMS.”',
        'pilihan'  => [
            ['teks' => 'Klik tautannya dan isi data, siapa tahu benar.', 'skor' => 0,
             'umpan' => 'Berisiko. Ini pola phishing dan kode SMS yang diminta kemungkinan besar adalah OTP. Jika diberikan, akunmu bisa diambil alih.'],
            ['teks' => 'Tanyakan dulu ke temanmu lewat jalur lain, lalu cek kebenarannya di situs resmi operator.', 'skor' => 2,
             'umpan' => 'Tepat. Inilah tabayyun: memeriksa sebelum percaya. Akun temanmu juga bisa saja sudah diretas.'],
            ['teks' => 'Abaikan saja, tetapi tidak memberi tahu siapa pun.', 'skor' => 1,
             'umpan' => 'Cukup aman untukmu, tetapi akan lebih baik jika kamu juga mengingatkan teman agar tidak ikut tertipu.'],
        ],
        'dalil'    => 'QS. Al-Hujurat: 6',
    ],
    [
        'judul'    => 'Foto Kartu Pelajar',
        'situasi'  => 'Kamu ingin mengunggah foto kartu pelajar baru ke story. Di kartu itu tertera nama lengkap, NISN, alamat, dan foto wajahmu.',
        'pilihan'  => [
            ['teks' => 'Unggah apa adanya agar terlihat jelas.', 'skor' => 0,
             'umpan' => 'Berisiko. Data lengkap di kartu dapat dipakai untuk penipuan atau pemalsuan identitas.'],
            ['teks' => 'Tutup atau blur nomor induk dan alamat, lalu atur story hanya untuk teman dekat.', 'skor' => 1,
             'umpan' => 'Sudah lebih baik. Meski begitu, pertimbangkan apakah unggahan ini benar-benar perlu.'],
            ['teks' => 'Tidak mengunggahnya; cukup bagikan foto suasana hari pertama sekolah.', 'skor' => 2,
             'umpan' => 'Terbaik. Kamu tetap bisa berbagi kebahagiaan tanpa membuka data identitas. Ini wujud “tidak membahayakan diri”.'],
        ],
        'dalil'    => 'HR. Ibnu Majah: Tidak boleh membahayakan diri sendiri dan orang lain',
    ],
    [
        'judul'    => 'Rahasia Teman',
        'situasi'  => 'Kamu bertengkar dengan sahabatmu. Kamu masih menyimpan tangkapan layar curhatannya yang sangat pribadi, dan kamu sedang kesal.',
        'pilihan'  => [
            ['teks' => 'Sebarkan ke grup kelas agar dia malu.', 'skor' => 0,
             'umpan' => 'Salah besar. Ini membuka aib dan mengkhianati amanah. Dampaknya bisa sangat melukai dan sulit ditarik kembali.'],
            ['teks' => 'Simpan rahasia itu, tenangkan diri, dan selesaikan masalah dengan berbicara langsung.', 'skor' => 2,
             'umpan' => 'Tepat. Pembicaraan pribadi adalah amanah, dan menutup aib saudara akan dibalas Allah dengan ditutupnya aibmu.'],
            ['teks' => 'Tidak menyebarkan, tetapi mengancam akan menyebarkannya.', 'skor' => 1,
             'umpan' => 'Memang belum tersebar, tetapi mengancam dengan rahasia orang lain tetap tidak dibenarkan dan merusak kepercayaan.'],
        ],
        'dalil'    => 'HR. Bukhari dan Muslim: menutupi aib sesama muslim',
    ],
    [
        'judul'    => 'Wi-Fi Kafe',
        'situasi'  => 'Kamu sedang di kafe dan perlu cepat mentransfer uang lewat aplikasi mobile banking. Wi-Fi kafe terbuka tanpa kata sandi.',
        'pilihan'  => [
            ['teks' => 'Langsung transfer lewat Wi-Fi kafe karena lebih cepat.', 'skor' => 0,
             'umpan' => 'Berisiko. Jaringan terbuka mudah disadap atau ditiru oleh pihak lain.'],
            ['teks' => 'Gunakan data seluler milikmu sendiri untuk bertransaksi.', 'skor' => 2,
             'umpan' => 'Tepat. Jaringan pribadi jauh lebih aman untuk transaksi keuangan.'],
            ['teks' => 'Pakai Wi-Fi kafe, tetapi setelah itu langsung ganti kata sandi.', 'skor' => 1,
             'umpan' => 'Mengganti sandi memang membantu, tetapi lebih baik mencegah daripada memperbaiki setelah data terlanjur terlihat.'],
        ],
        'dalil'    => 'HR. Tirmidzi: Ikatlah untamu, lalu bertawakallah',
    ],
    [
        'judul'    => 'Izin Aplikasi',
        'situasi'  => 'Kamu memasang aplikasi senter gratis. Aplikasi itu meminta izin mengakses kontak, lokasi, dan mikrofonmu.',
        'pilihan'  => [
            ['teks' => 'Izinkan semuanya agar aplikasi cepat bisa dipakai.', 'skor' => 0,
             'umpan' => 'Berisiko. Senter tidak membutuhkan kontak, lokasi, dan mikrofon. Data itu bisa dikumpulkan dan dijual.'],
            ['teks' => 'Tolak izin yang tidak diperlukan, atau cari aplikasi senter lain yang lebih sederhana.', 'skor' => 2,
             'umpan' => 'Tepat. Batasi izin sesuai kebutuhan. Data kontakmu juga berisi data orang lain yang menjadi amanahmu.'],
            ['teks' => 'Izinkan, tetapi nanti dihapus jika terasa mencurigakan.', 'skor' => 1,
             'umpan' => 'Kurang tepat, karena data bisa sudah terkirim sebelum kamu menghapusnya.'],
        ],
        'dalil'    => 'QS. An-Nisa: 58 (amanah)',
    ],
    [
        'judul'    => 'Kode OTP',
        'situasi'  => 'Seseorang mengaku dari layanan media sosial menelepon dan berkata akunmu bermasalah. Ia meminta kode 6 digit yang baru masuk ke ponselmu.',
        'pilihan'  => [
            ['teks' => 'Berikan kodenya agar akun tidak diblokir.', 'skor' => 0,
             'umpan' => 'Berisiko tinggi. Itu kode OTP. Pihak resmi tidak pernah memintanya, dan akunmu bisa langsung dibobol.'],
            ['teks' => 'Tutup telepon, jangan beri kode, lalu periksa keamanan akun lewat aplikasi resmi.', 'skor' => 2,
             'umpan' => 'Tepat. Rahasiakan OTP dari siapa pun, lalu aktifkan 2FA dan ganti kata sandi bila perlu.'],
            ['teks' => 'Tanya nama dan jabatannya dulu sebelum memutuskan.', 'skor' => 1,
             'umpan' => 'Bertanya itu baik, tetapi penipu mudah mengarang nama. Lebih aman langsung mengakhiri panggilan.'],
        ],
        'dalil'    => 'QS. Al-Isra: 36 (jangan mengikuti tanpa ilmu)',
    ],
];
