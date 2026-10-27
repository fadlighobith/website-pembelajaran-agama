<?php
/**
 * data/materi.php
 * Konten materi "Menjaga Privasi Digital".
 * Setiap bab bisa memiliki: isi (paragraf), poin_judul + poin (daftar),
 * tabel (kolom + baris), langkah (daftar bernomor), refleksi, dan dalil.
 */
return [
    [
        'id'     => 1,
        'menu'   => 'Pengenalan Privasi Digital',
        'judul'  => 'Pengertian Privasi Digital',
        'isi'    => [
            "Privasi digital adalah hak setiap individu untuk mengontrol informasi pribadinya di dunia maya: siapa yang boleh melihat, mengumpulkan, menyimpan, dan menggunakan data tersebut. Setiap kali kita membuat akun, mengunggah foto, atau menekan tombol “Setuju” pada sebuah aplikasi, sebenarnya kita sedang menitipkan sebagian diri kita ke dunia digital.",
            "Dalam Islam, menjaga privasi termasuk bagian dari akhlak mulia. Islam mengajarkan adab meminta izin sebelum memasuki rumah orang lain, melarang mencari-cari kesalahan orang lain (tajassus), dan memerintahkan kita menjaga amanah. Prinsip yang sama berlaku di ruang digital, karena “rumah” kita kini juga berupa akun media sosial, galeri foto, dan percakapan pribadi.",
            "Segala aktivitas online juga meninggalkan jejak digital, seperti unggahan, komentar, riwayat penelusuran, dan lokasi. Jejak ini sering kali sulit dihapus sepenuhnya, sehingga kita perlu berhati-hati sejak sebelum menekan tombol kirim.",
        ],
        'poin_judul' => 'Poin Penting',
        'poin'   => [
            "Privasi digital adalah hak mengontrol data pribadi kita di dunia maya.",
            "Privasi penting karena data yang bocor dapat disalahgunakan untuk penipuan, pencurian identitas, atau perundungan.",
            "Contoh data pribadi yang perlu dijaga: nama lengkap, alamat, nomor HP, NIK, foto, lokasi, dan kata sandi.",
        ],
        'tabel'  => [
            'judul'  => 'Privasi di dunia nyata dan dunia digital',
            'kolom'  => ['Di dunia nyata', 'Di dunia digital'],
            'baris'  => [
                ['Menutup dan mengunci pintu rumah', 'Mengunci akun dengan kata sandi yang kuat'],
                ['Tidak menceritakan rahasia kepada orang asing', 'Tidak membagikan data sensitif di ruang publik'],
                ['Meminta izin sebelum masuk ke rumah orang', 'Meminta izin sebelum memotret, menandai, atau menyebarkan foto orang lain'],
                ['Menutup tirai agar tidak diintip', 'Mengatur privasi akun dan mematikan lokasi pada unggahan'],
            ],
        ],
        'dalil'  => [
            'teks' => "Wahai orang-orang yang beriman, janganlah kamu memasuki rumah yang bukan rumahmu sebelum meminta izin dan memberi salam kepada penghuninya.",
            'ref'  => 'QS. An-Nur: 27',
        ],
    ],
    [
        'id'     => 2,
        'menu'   => 'Data dan Informasi Pribadi',
        'judul'  => 'Data dan Informasi Pribadi',
        'isi'    => [
            "Tidak semua data memiliki tingkat risiko yang sama. Memahami jenis data membantu kita menentukan mana yang boleh dibagikan secara terbuka, mana yang harus dibatasi, dan mana yang tidak boleh diberikan kepada siapa pun.",
            "Di Indonesia, pelindungan data pribadi diatur dalam Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi (UU PDP). Secara umum, pemilik data berhak mengetahui bagaimana datanya digunakan serta dapat meminta data tersebut diperbaiki atau dihapus. Sebaliknya, pihak yang mengelola data berkewajiban menjaganya.",
            "Dalam pandangan Islam, data pribadi orang lain yang sampai kepada kita adalah amanah. Jika kita menyimpan nomor HP, foto, atau cerita teman, maka kita bertanggung jawab untuk tidak menyalahgunakan dan tidak menyebarkannya tanpa izin.",
        ],
        'tabel'  => [
            'judul'  => 'Tingkat kehati-hatian berdasarkan jenis data',
            'kolom'  => ['Jenis data', 'Contoh', 'Kehati-hatian'],
            'baris'  => [
                ['Data umum', 'Nama panggilan, hobi, foto profil', 'Sedang'],
                ['Data pribadi', 'Nama lengkap, tanggal lahir, alamat, nomor HP, email', 'Tinggi'],
                ['Data sensitif', 'NIK, nomor rekening, kata sandi, kode OTP, data kesehatan, lokasi real-time', 'Sangat tinggi'],
                ['Data perilaku', 'Riwayat penelusuran, kebiasaan belanja, suka dan komentar', 'Tinggi (sering dikumpulkan diam-diam)'],
            ],
        ],
        'poin_judul' => 'Ingat Selalu',
        'poin'   => [
            "Kata sandi, PIN, dan kode OTP tidak boleh diberikan kepada siapa pun, termasuk yang mengaku petugas resmi.",
            "Sebelum mengisi formulir online, tanyakan: apakah data ini benar-benar diperlukan?",
            "Data orang lain yang kita simpan adalah amanah yang harus dijaga.",
        ],
        'dalil'  => [
            'teks' => "Sesungguhnya Allah menyuruh kamu menyampaikan amanah kepada yang berhak menerimanya.",
            'ref'  => 'QS. An-Nisa: 58',
        ],
    ],
    [
        'id'     => 3,
        'menu'   => 'Risiko di Dunia Maya',
        'judul'  => 'Risiko dan Masalah di Dunia Maya',
        'isi'    => [
            "Data yang bocor atau disalahgunakan dapat menimbulkan kerugian yang nyata, mulai dari kerugian uang, rusaknya nama baik, tekanan psikologis, hingga ancaman terhadap keselamatan diri. Masalah ini umumnya muncul karena kurang waspada, bukan karena teknologinya semata.",
            "Berikut ancaman yang paling sering dihadapi pelajar dan pengguna internet pada umumnya.",
        ],
        'tabel'  => [
            'judul'  => 'Ancaman umum di dunia maya',
            'kolom'  => ['Ancaman', 'Penjelasan', 'Contoh'],
            'baris'  => [
                ['Phishing', 'Tipuan agar korban memberikan data lewat tautan atau situs palsu', 'Pesan “paket tertahan, klik untuk konfirmasi” dari nomor tak dikenal'],
                ['Social engineering', 'Manipulasi psikologis agar korban sendiri menyerahkan informasi', 'Orang mengaku petugas dan meminta kode OTP'],
                ['Pencurian identitas', 'Data dipakai untuk berpura-pura menjadi kita', 'Akun atau pinjaman dibuat atas nama kita'],
                ['Doxing', 'Menyebarkan data pribadi orang lain untuk menekan atau mempermalukan', 'Alamat rumah seseorang disebar ketika sedang berselisih'],
                ['Malware dan spyware', 'Perangkat lunak berbahaya yang mencuri atau memata-matai data', 'Aplikasi bajakan atau file dari sumber tidak jelas'],
                ['Oversharing', 'Membagikan terlalu banyak informasi tentang diri sendiri', 'Mengunggah tiket atau kartu identitas lengkap dengan barcode'],
                ['Izin aplikasi berlebihan', 'Aplikasi meminta akses yang tidak berkaitan dengan fungsinya', 'Aplikasi senter meminta akses kontak dan lokasi'],
            ],
        ],
        'poin_judul' => 'Dampak yang Mungkin Terjadi',
        'poin'   => [
            "Kerugian finansial akibat penipuan atau pembobolan akun.",
            "Rusaknya nama baik karena foto atau percakapan pribadi tersebar.",
            "Tekanan mental akibat perundungan siber (cyberbullying).",
            "Ancaman keselamatan jika alamat dan lokasi diketahui orang yang berniat jahat.",
        ],
        'dalil'  => [
            'teks' => "Janganlah engkau mengikuti sesuatu yang tidak engkau ketahui. Sesungguhnya pendengaran, penglihatan, dan hati nurani, semuanya akan diminta pertanggungjawabannya.",
            'ref'  => 'QS. Al-Isra: 36',
        ],
    ],
    [
        'id'     => 4,
        'menu'   => 'Etika Digital dalam Islam',
        'judul'  => 'Etika Digital dalam Islam',
        'isi'    => [
            "Islam tidak hanya mengatur ibadah, tetapi juga adab bermuamalah, termasuk saat bermedia sosial. Setiap kata yang kita tulis dan bagikan tercatat dan akan dimintai pertanggungjawaban. Karena itu, jari kita di papan ketik sama pentingnya dengan lisan kita ketika berbicara.",
            "Menjaga privasi diri sendiri dan orang lain dapat dikaitkan dengan tujuan syariat untuk melindungi kehormatan, harta, dan keselamatan manusia. Enam prinsip berikut dapat menjadi pedoman sehari-hari.",
        ],
        'langkah' => [
            ['Amanah', 'Data, rahasia, dan kepercayaan yang diberikan orang lain wajib dijaga dan tidak boleh disalahgunakan (QS. An-Nisa: 58).'],
            ['Tabayyun', 'Periksa kebenaran berita sebelum mempercayai atau menyebarkannya (QS. Al-Hujurat: 6).'],
            ['Tidak Tajassus', 'Jangan mencari-cari kesalahan, membuka-buka data, atau menguntit akun orang lain (QS. Al-Hujurat: 12).'],
            ['Menutup Aib', 'Jangan menyebarkan kekurangan atau rahasia orang lain, karena Allah menutup aib orang yang menutup aib saudaranya (HR. Bukhari dan Muslim).'],
            ['Berkata Baik atau Diam', 'Gunakan kata-kata yang baik dan benar; jika tidak mampu, lebih baik diam (HR. Bukhari dan Muslim).'],
            ['Tidak Membahayakan', 'Setiap unggahan harus dipikirkan dampaknya agar tidak merugikan diri sendiri maupun orang lain (HR. Ibnu Majah).'],
        ],
        'poin_judul' => 'Penerapan Sehari-hari',
        'poin'   => [
            "Minta izin sebelum mengunggah atau menandai foto teman.",
            "Tidak menyebarkan tangkapan layar percakapan pribadi.",
            "Cek sumber informasi sebelum membagikannya ke grup.",
        ],
        'dalil'  => [
            'teks' => "Tidak ada suatu ucapan yang diucapkan melainkan di dekatnya ada malaikat pengawas yang selalu hadir.",
            'ref'  => 'QS. Qaf: 18',
        ],
    ],
    [
        'id'     => 5,
        'menu'   => 'Tips Menjaga Privasi',
        'judul'  => 'Tips Menjaga Privasi (Solusi)',
        'isi'    => [
            "Menjaga privasi adalah ikhtiar atau usaha yang dapat kita lakukan setiap hari. Langkah-langkah berikut sederhana, tetapi sangat membantu mengurangi risiko yang telah dibahas sebelumnya.",
        ],
        'langkah' => [
            ['Gunakan kata sandi kuat dan unik', 'Panjang minimal 12 karakter, kombinasi huruf, angka, dan simbol, serta tidak dipakai ulang di banyak akun. Pengelola kata sandi (password manager) dapat membantu.'],
            ['Aktifkan verifikasi dua langkah (2FA)', 'Meskipun kata sandi bocor, akun tetap lebih sulit dibobol. Jangan pernah membagikan kode verifikasi kepada siapa pun.'],
            ['Atur pengaturan privasi akun', 'Batasi siapa yang dapat melihat unggahan, matikan lokasi pada foto, dan tinjau daftar pengikut secara berkala.'],
            ['Waspada tautan dan pesan mencurigakan', 'Periksa pengirim dan alamat situs. Jika ragu, jangan klik, tutup pesan, lalu laporkan atau blokir.'],
            ['Perbarui aplikasi dan sistem', 'Pembaruan menutup celah keamanan. Pasang aplikasi hanya dari toko resmi.'],
            ['Hati-hati dengan Wi-Fi publik', 'Hindari transaksi perbankan atau login akun penting lewat jaringan terbuka.'],
            ['Batasi izin aplikasi', 'Berikan izin kamera, mikrofon, lokasi, dan kontak hanya jika sesuai kebutuhan aplikasi.'],
            ['THINK sebelum memposting', 'Pastikan unggahan Benar, Bermanfaat, Menginspirasi, Perlu, dan Baik. Coba latihannya di halaman THINK.'],
            ['Rutin merapikan jejak digital', 'Hapus akun yang tidak lagi dipakai dan tinjau unggahan lama yang sudah tidak pantas.'],
        ],
        'dalil'  => [
            'teks' => "Ikatlah (untamu), kemudian bertawakallah.",
            'ref'  => 'HR. Tirmidzi',
        ],
    ],
    [
        'id'     => 6,
        'menu'   => 'Kesimpulan',
        'judul'  => 'Kesimpulan',
        'isi'    => [
            "Privasi digital bukan hanya urusan teknis, tetapi juga urusan akhlak dan amanah. Data pribadi adalah titipan yang harus dijaga, baik data milik kita sendiri maupun data orang lain yang sampai kepada kita.",
            "Masalah seperti phishing, doxing, dan penyalahgunaan data dapat dicegah dengan kewaspadaan, kebiasaan digital yang sehat, dan adab bermedia sosial yang berlandaskan nilai-nilai Islam.",
        ],
        'poin_judul' => 'Rangkuman',
        'poin'   => [
            "Privasi digital adalah hak mengontrol data pribadi; menjaganya adalah bagian dari amanah.",
            "Ancaman utama: phishing, social engineering, pencurian identitas, doxing, malware, dan oversharing.",
            "Etika Islam: amanah, tabayyun, tidak tajassus, menutup aib, berkata baik, dan tidak membahayakan.",
            "Solusi praktis: kata sandi kuat, 2FA, atur privasi, waspada tautan, batasi izin aplikasi, dan THINK sebelum posting.",
        ],
        'refleksi' => [
            "Data apa saja milikku yang selama ini paling mudah terlihat orang lain?",
            "Pernahkah aku membagikan informasi tanpa memeriksa kebenarannya?",
            "Satu kebiasaan digital apa yang akan aku perbaiki mulai hari ini?",
        ],
        'dalil'  => [
            'teks' => "Wahai orang-orang yang beriman, janganlah kamu mengkhianati Allah dan Rasul, dan janganlah kamu mengkhianati amanah-amanah yang dipercayakan kepadamu, sedangkan kamu mengetahui.",
            'ref'  => 'QS. Al-Anfal: 27',
        ],
    ],
];
