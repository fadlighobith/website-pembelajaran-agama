<?php
/**
 * data/soal.php
 * Bank soal kuis. 'jawaban' = nomor indeks pilihan yang benar (mulai dari 0).
 * Kunci jawaban TIDAK dikirim ke browser; pengecekan dilakukan oleh cek.php.
 */
return [
    [
        'id'       => 1,
        'tanya'    => 'Apa yang dimaksud dengan privasi digital?',
        'pilihan'  => [
            'Data yang bebas dibagikan kepada publik',
            'Penggunaan internet tanpa batas',
            'Akun media sosial yang aktif setiap hari',
            'Hak individu untuk mengontrol informasi pribadinya di dunia maya',
        ],
        'jawaban'  => 3,
        'penjelasan' => 'Privasi digital adalah hak kita untuk menentukan siapa yang boleh melihat, menyimpan, dan memakai data pribadi kita di dunia maya.',
    ],
    [
        'id'       => 2,
        'tanya'    => 'Manakah yang termasuk data sensitif yang tidak boleh dibagikan sembarangan?',
        'pilihan'  => [
            'Hobi dan warna favorit',
            'Nama panggilan',
            'NIK, kata sandi, dan kode OTP',
            'Nama grup kelas',
        ],
        'jawaban'  => 2,
        'penjelasan' => 'NIK, kata sandi, dan kode OTP dapat dipakai untuk mengambil alih akun atau identitas, sehingga harus dirahasiakan.',
    ],
    [
        'id'       => 3,
        'tanya'    => 'Kamu menerima pesan: “Selamat, kamu menang undian! Klik tautan ini dan isi data dirimu.” Apa tindakan yang paling tepat?',
        'pilihan'  => [
            'Klik tautan karena sayang jika hadiah terlewat',
            'Abaikan, jangan klik, lalu laporkan atau blokir pengirim',
            'Teruskan ke grup keluarga agar semua ikut menang',
            'Balas dengan mengirim foto KTP',
        ],
        'jawaban'  => 1,
        'penjelasan' => 'Pesan seperti ini ciri khas phishing. Menerapkan tabayyun berarti tidak langsung percaya, tidak mengklik, dan tidak menyebarkannya.',
    ],
    [
        'id'       => 4,
        'tanya'    => 'Ayat yang mengajarkan adab meminta izin sebelum memasuki rumah orang lain, dan dapat dikaitkan dengan privasi, adalah…',
        'pilihan'  => [
            'QS. Al-Ikhlas: 1',
            'QS. Al-Kautsar: 1',
            'QS. An-Nur: 27',
            'QS. Al-Ma’un: 1',
        ],
        'jawaban'  => 2,
        'penjelasan' => 'QS. An-Nur: 27 melarang memasuki rumah orang lain tanpa izin. Prinsipnya berlaku juga pada “ruang” digital seseorang.',
    ],
    [
        'id'       => 5,
        'tanya'    => 'Apa arti tabayyun dalam bermedia sosial?',
        'pilihan'  => [
            'Memeriksa kebenaran informasi sebelum mempercayai atau menyebarkannya',
            'Menyebarkan berita secepat mungkin',
            'Menghapus semua komentar orang lain',
            'Memblokir semua akun yang tidak dikenal',
        ],
        'jawaban'  => 0,
        'penjelasan' => 'Tabayyun berarti meneliti dan memastikan kebenaran suatu kabar, sebagaimana perintah dalam QS. Al-Hujurat: 6.',
    ],
    [
        'id'       => 6,
        'tanya'    => 'Seseorang yang mengaku petugas marketplace meminta kode OTP-mu “untuk verifikasi”. Sebaiknya kamu…',
        'pilihan'  => [
            'Memberikannya agar urusan cepat selesai',
            'Memberikannya jika ia terdengar sopan',
            'Mengunggahnya sebagai bukti',
            'Tidak memberikannya kepada siapa pun dan melapor lewat aplikasi resmi',
        ],
        'jawaban'  => 3,
        'penjelasan' => 'Kode OTP bersifat rahasia dan tidak pernah diminta oleh petugas resmi. Memberikannya dapat membuat akun dan uangmu diambil alih.',
    ],
    [
        'id'       => 7,
        'tanya'    => 'Sikap yang sesuai dengan hadis tentang menutupi aib sesama muslim adalah…',
        'pilihan'  => [
            'Menyebarkan tangkapan layar chat pribadi teman yang sedang berselisih denganmu',
            'Menyimpan rahasia teman dan tidak menyebarkan aibnya',
            'Menyindir teman lewat story tanpa menyebut nama',
            'Mengunggah kekurangan teman sebagai bahan candaan',
        ],
        'jawaban'  => 1,
        'penjelasan' => 'Hadis riwayat Bukhari dan Muslim menyebutkan bahwa Allah akan menutupi aib orang yang menutupi aib sesamanya.',
    ],
    [
        'id'       => 8,
        'tanya'    => 'Menyebarkan alamat rumah dan data pribadi seseorang untuk menekan atau mempermalukannya disebut…',
        'pilihan'  => [
            'Doxing',
            'Enkripsi',
            'Verifikasi dua langkah',
            'Backup data',
        ],
        'jawaban'  => 0,
        'penjelasan' => 'Doxing adalah penyebaran data pribadi orang lain tanpa izin untuk menekan atau mempermalukan. Perbuatan ini membahayakan dan dilarang dalam Islam.',
    ],
    [
        'id'       => 9,
        'tanya'    => 'Langkah yang paling tepat untuk memperkuat keamanan akun adalah…',
        'pilihan'  => [
            'Memakai satu kata sandi yang sama untuk semua akun',
            'Menuliskan kata sandi di bio agar tidak lupa',
            'Memakai kata sandi kuat dan unik serta mengaktifkan verifikasi dua langkah',
            'Mengganti kata sandi hanya jika sudah lupa',
        ],
        'jawaban'  => 2,
        'penjelasan' => 'Kata sandi yang kuat dan berbeda untuk tiap akun, ditambah 2FA, menjadi wujud ikhtiar menjaga amanah data kita.',
    ],
    [
        'id'       => 10,
        'tanya'    => 'Apa yang dimaksud dengan prinsip THINK sebelum memposting?',
        'pilihan'  => [
            'Dilarang memposting apa pun di media sosial',
            'Memeriksa apakah unggahan Benar, Bermanfaat, Menginspirasi, Perlu, dan Baik',
            'Nama aplikasi untuk mengenkripsi pesan',
            'Singkatan dari jumlah unggahan harian',
        ],
        'jawaban'  => 1,
        'penjelasan' => 'THINK adalah lima pertanyaan penyaring sebelum memposting: True, Helpful, Inspiring, Necessary, Kind.',
    ],
];
