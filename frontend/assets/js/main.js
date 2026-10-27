/* ==========================================================
   Privasiku - main.js
   Fitur umum: tema gelap, menu, pencarian, tab dalil,
   progres materi, simulasi kasus, dan latihan THINK.
   ========================================================== */
(function () {
  'use strict';

  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  function simpan(k, v) { try { localStorage.setItem(k, v); } catch (e) { /* abaikan */ } }
  function ambil(k) { try { return localStorage.getItem(k); } catch (e) { return null; } }

  function buat(tag, kelas, teks) {
    var el = document.createElement(tag);
    if (kelas) el.className = kelas;
    if (teks !== undefined) el.textContent = teks;
    return el;
  }

  /* ---------- Tema terang / gelap ---------- */
  var root = document.documentElement;
  var tombolTema = $('#tombolTema');
  if (tombolTema) {
    tombolTema.addEventListener('click', function () {
      if (root.getAttribute('data-tema') === 'gelap') {
        root.removeAttribute('data-tema');
        simpan('amanah-tema', 'terang');
      } else {
        root.setAttribute('data-tema', 'gelap');
        simpan('amanah-tema', 'gelap');
      }
    });
  }

  /* ---------- Menu mobile & dropdown ---------- */
  var tombolMenu = $('#tombolMenu');
  var menu = $('#menu');
  if (tombolMenu && menu) {
    tombolMenu.addEventListener('click', function () {
      var buka = menu.classList.toggle('terbuka');
      tombolMenu.setAttribute('aria-expanded', buka ? 'true' : 'false');
    });
  }
  $$('.dropdown-tombol').forEach(function (t) {
    t.addEventListener('click', function (e) {
      e.stopPropagation();
      var induk = t.parentNode;
      var buka = induk.classList.toggle('terbuka');
      t.setAttribute('aria-expanded', buka ? 'true' : 'false');
    });
  });
  document.addEventListener('click', function () {
    $$('.dropdown.terbuka').forEach(function (d) {
      d.classList.remove('terbuka');
      var t = $('.dropdown-tombol', d);
      if (t) t.setAttribute('aria-expanded', 'false');
    });
  });

  /* ---------- Pencarian ---------- */
  (function () {
    var latar = $('#cariLatar');
    var input = $('#cariInput');
    var hasil = $('#cariHasil');
    var tombolCari = $('#tombolCari');
    var tombolTutup = $('#cariTutup');
    if (!latar || !input || !hasil) return;

    function render(q) {
      q = q.trim().toLowerCase();
      hasil.innerHTML = '';
      if (!q) {
        hasil.appendChild(buat('li', 'kosong', 'Ketik kata kunci, misalnya “amanah”, “OTP”, atau “tabayyun”.'));
        return;
      }
      var data = window.INDEKS_CARI || [];
      var cocok = [];
      data.forEach(function (d) {
        var skor = 0;
        if (d.judul.toLowerCase().indexOf(q) !== -1) skor += 2;
        if (d.teks.toLowerCase().indexOf(q) !== -1) skor += 1;
        if (skor) cocok.push({ d: d, skor: skor });
      });
      cocok.sort(function (a, b) { return b.skor - a.skor; });
      cocok = cocok.slice(0, 8);

      if (!cocok.length) {
        hasil.appendChild(buat('li', 'kosong', 'Tidak ditemukan untuk “' + q + '”.'));
        return;
      }
      cocok.forEach(function (c) {
        var li = document.createElement('li');
        var a = document.createElement('a');
        a.href = c.d.url;
        var baris = buat('div');
        baris.appendChild(buat('span', 'tipe', c.d.tipe));
        baris.appendChild(buat('span', 'judul', c.d.judul));
        a.appendChild(baris);
        a.appendChild(buat('span', 'cuplikan', c.d.teks));
        li.appendChild(a);
        hasil.appendChild(li);
      });
    }

    function buka() {
      latar.hidden = false;
      document.body.style.overflow = 'hidden';
      input.value = '';
      render('');
      input.focus();
    }
    function tutup() {
      latar.hidden = true;
      document.body.style.overflow = '';
      if (tombolCari) tombolCari.focus();
    }

    if (tombolCari) tombolCari.addEventListener('click', buka);
    if (tombolTutup) tombolTutup.addEventListener('click', tutup);
    latar.addEventListener('click', function (e) { if (e.target === latar) tutup(); });
    input.addEventListener('input', function () { render(input.value); });
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        var a = $('a', hasil);
        if (a) window.location.href = a.href;
      }
    });

    document.addEventListener('keydown', function (e) {
      var tag = (document.activeElement && document.activeElement.tagName) || '';
      var mengetik = tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT';
      if (e.key === 'Escape' && !latar.hidden) { tutup(); return; }
      if ((e.key === '/' && !mengetik) || ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k')) {
        e.preventDefault();
        buka();
      }
    });
  })();

  /* ---------- Halaman Dalil: tab, filter tema, sorot ---------- */
  (function () {
    var tabs = $$('.tab-tombol');
    if (!tabs.length) return;
    var temaAktif = 'semua';
    var tabAktif = 'quran';

    function terapkanFilter() {
      $$('.tab-panel').forEach(function (panel) {
        var tampil = 0;
        $$('.dalil-baris', panel).forEach(function (b) {
          var cocok = temaAktif === 'semua' || b.getAttribute('data-tema') === temaAktif;
          b.classList.toggle('sembunyi', !cocok);
          if (cocok) tampil++;
        });
        var kosong = $('.kosong', panel);
        if (kosong) kosong.hidden = tampil !== 0;
      });
    }

    function pilihTab(nama) {
      tabAktif = nama;
      tabs.forEach(function (t) {
        t.setAttribute('aria-selected', t.getAttribute('data-tab') === nama ? 'true' : 'false');
      });
      $$('.tab-panel').forEach(function (p) {
        p.classList.toggle('aktif', p.id === 'panel-' + nama);
      });
    }

    tabs.forEach(function (t) {
      t.addEventListener('click', function () { pilihTab(t.getAttribute('data-tab')); });
      t.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
          var lain = tabs[tabAktif === 'quran' ? 1 : 0];
          pilihTab(lain.getAttribute('data-tab'));
          lain.focus();
        }
      });
    });

    $$('#chipTema .chip').forEach(function (c) {
      c.addEventListener('click', function () {
        temaAktif = c.getAttribute('data-tema');
        $$('#chipTema .chip').forEach(function (x) {
          x.setAttribute('aria-pressed', x === c ? 'true' : 'false');
        });
        terapkanFilter();
      });
    });

    // Tab awal dari ?tab=... atau #quran-3 / #hadis-2 (dari hasil pencarian)
    var params = new URLSearchParams(window.location.search);
    if (params.get('tab') === 'hadis') pilihTab('hadis');
    var m = /^#(quran|hadis)-(\d+)$/.exec(window.location.hash);
    if (m) {
      pilihTab(m[1]);
      var target = document.getElementById(m[1] + '-' + m[2]);
      if (target) {
        target.classList.add('sorot');
        setTimeout(function () { target.scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 150);
      }
    }
    terapkanFilter();
  })();

  /* ---------- Halaman Materi: progres belajar ---------- */
  (function () {
    var nomor = parseInt(document.body.getAttribute('data-bab'), 10);
    var total = parseInt(document.body.getAttribute('data-total-bab'), 10);
    if (!nomor || !total) return;

    var selesai = [];
    try { selesai = JSON.parse(ambil('amanah-bab') || '[]'); } catch (e) { selesai = []; }
    if (!Array.isArray(selesai)) selesai = [];
    if (selesai.indexOf(nomor) === -1) selesai.push(nomor);
    simpan('amanah-bab', JSON.stringify(selesai));

    $$('.daftar-bab a').forEach(function (a) {
      var n = parseInt(a.getAttribute('data-bab'), 10);
      if (selesai.indexOf(n) !== -1) a.classList.add('selesai');
    });
    var persen = Math.round((selesai.length / total) * 100);
    var bar = $('#barProgres');
    var teks = $('#teksProgres');
    if (bar) bar.style.width = persen + '%';
    if (teks) teks.textContent = 'Progres belajar: ' + selesai.length + ' dari ' + total + ' bab (' + persen + '%)';
  })();

  /* ---------- Simulasi kasus ---------- */
  (function () {
    var data = window.SKENARIO;
    if (!data || !data.length) return;

    var idx = 0, skor = 0, terjawab = false;
    var el = {
      nomor: $('#simNomor'), skor: $('#simSkor'), bar: $('#simBar'), judul: $('#simJudul'),
      situasi: $('#simSituasi'), pilihan: $('#simPilihan'), umpan: $('#simUmpan'),
      lanjut: $('#simLanjut'), lanjutTeks: $('#simLanjutTeks'),
      soal: $('#simulasiSoal'), akhir: $('#simulasiAkhir'),
      akhirAngka: $('#simAkhirAngka'), akhirJudul: $('#simAkhirJudul'), akhirPesan: $('#simAkhirPesan'),
      ulang: $('#simUlang')
    };
    var label = ['Berisiko', 'Cukup baik', 'Pilihan terbaik'];

    function tampil() {
      var k = data[idx];
      terjawab = false;
      el.nomor.textContent = 'Kasus ' + (idx + 1) + ' dari ' + data.length;
      el.skor.textContent = skor;
      el.bar.style.width = (idx / data.length * 100) + '%';
      el.judul.textContent = k.judul;
      el.situasi.textContent = k.situasi;
      el.pilihan.innerHTML = '';
      el.umpan.hidden = true;
      el.lanjut.disabled = true;
      el.lanjutTeks.textContent = idx === data.length - 1 ? 'Lihat Hasil' : 'Selanjutnya';

      k.pilihan.forEach(function (p, i) {
        var b = buat('button', 'opsi');
        b.type = 'button';
        b.appendChild(buat('span', 'huruf', String.fromCharCode(65 + i)));
        b.appendChild(buat('span', '', p.teks));
        b.addEventListener('click', function () { pilih(i); });
        el.pilihan.appendChild(b);
      });
    }

    function pilih(i) {
      if (terjawab) return;
      terjawab = true;
      var k = data[idx];
      var p = k.pilihan[i];
      skor += p.skor;
      el.skor.textContent = skor;

      $$('.opsi', el.pilihan).forEach(function (b, n) {
        b.disabled = true;
        if (n === i) b.classList.add('pil-skor-' + p.skor);
      });

      el.umpan.className = 'umpan skor-' + p.skor;
      el.umpan.innerHTML = '';
      el.umpan.appendChild(buat('strong', '', label[p.skor] + (p.skor === 2 ? ' (+2)' : p.skor === 1 ? ' (+1)' : ' (+0)')));
      el.umpan.appendChild(document.createTextNode(p.umpan));
      if (k.dalil) {
        el.umpan.appendChild(document.createElement('br'));
        el.umpan.appendChild(buat('small', '', 'Dalil terkait: ' + k.dalil));
      }
      el.umpan.hidden = false;
      el.lanjut.disabled = false;
      el.lanjut.focus();
    }

    function akhir() {
      var maks = data.length * 2;
      var persen = Math.round(skor / maks * 100);
      var level, pesan;
      if (persen >= 85) { level = 'Penjaga Amanah'; pesan = 'Luar biasa! Kamu cermat memilih tindakan dan menjaga data, baik milikmu maupun milik orang lain.'; }
      else if (persen >= 60) { level = 'Pengguna Bijak'; pesan = 'Bagus. Sebagian besar pilihanmu tepat. Pelajari lagi kasus yang masih berisiko agar semakin waspada.'; }
      else if (persen >= 35) { level = 'Perlu Lebih Waspada'; pesan = 'Kamu sudah punya dasar, tetapi masih ada kebiasaan yang berisiko. Baca ulang materi bab 3 sampai 5.'; }
      else { level = 'Mulai dari Dasar'; pesan = 'Tidak apa-apa, belajar adalah proses. Mulailah dari materi bab 1 lalu ulangi simulasi ini.'; }

      el.soal.hidden = true;
      el.akhir.hidden = false;
      el.akhirAngka.textContent = skor + '/' + maks;
      el.akhirJudul.textContent = level;
      el.akhirPesan.textContent = pesan;
      simpan('amanah-simulasi', String(persen));
    }

    el.lanjut.addEventListener('click', function () {
      if (idx < data.length - 1) { idx++; tampil(); } else { akhir(); }
    });
    el.ulang.addEventListener('click', function () {
      idx = 0; skor = 0;
      el.akhir.hidden = true;
      el.soal.hidden = false;
      tampil();
    });
    tampil();
  })();

  /* ---------- Latihan THINK ---------- */
  (function () {
    var app = $('#thinkApp');
    var kriteria = window.THINK_KRITERIA;
    if (!app || !kriteria) return;

    var kartu = $$('.think-kartu', app);
    var jawaban = kartu.map(function () { return null; });
    var hasil = $('#thinkHasil');
    var teks = $('#thinkTeks');

    function perbarui() {
      kartu.forEach(function (k, i) {
        k.classList.toggle('ya', jawaban[i] === true);
        k.classList.toggle('tidak', jawaban[i] === false);
        $('.tombol-ya', k).setAttribute('aria-pressed', jawaban[i] === true ? 'true' : 'false');
        $('.tombol-tidak', k).setAttribute('aria-pressed', jawaban[i] === false ? 'true' : 'false');
      });

      var belum = jawaban.filter(function (j) { return j === null; }).length;
      hasil.className = 'think-hasil';
      hasil.innerHTML = '';

      if (belum) {
        hasil.appendChild(buat('h3', '', 'Jawab kelima pertanyaan di atas'));
        hasil.appendChild(buat('p', '', 'Masih ada ' + belum + ' pertanyaan yang belum dijawab.'));
        return;
      }

      var gagal = [];
      jawaban.forEach(function (j, i) { if (!j) gagal.push(kriteria[i].huruf + ' (' + kriteria[i].nama + ')'); });

      if (gagal.length === 0) {
        hasil.classList.add('aman');
        hasil.appendChild(buat('h3', '', 'Lolos THINK. Bismillah, silakan diunggah'));
        hasil.appendChild(buat('p', '', 'Sebelum menekan tombol kirim, periksa sekali lagi bahwa tidak ada data sensitif seperti alamat, nomor, atau barcode yang ikut terlihat.'));
      } else if (gagal.length <= 2) {
        hasil.classList.add('tunda');
        hasil.appendChild(buat('h3', '', 'Pikirkan ulang dahulu'));
        hasil.appendChild(buat('p', '', 'Perbaiki bagian yang belum terpenuhi: ' + gagal.join(', ') + '. Setelah diperbaiki, nilai kembali unggahanmu.'));
      } else {
        hasil.classList.add('stop');
        hasil.appendChild(buat('h3', '', 'Sebaiknya jangan diunggah'));
        hasil.appendChild(buat('p', '', 'Unggahan ini belum memenuhi ' + gagal.length + ' kriteria: ' + gagal.join(', ') + '. Ingat pesan hadis: berkata baik atau diam.'));
      }
    }

    kartu.forEach(function (k, i) {
      $('.tombol-ya', k).addEventListener('click', function () { jawaban[i] = true; perbarui(); });
      $('.tombol-tidak', k).addEventListener('click', function () { jawaban[i] = false; perbarui(); });
    });

    $$('[data-contoh]', app).forEach(function (c) {
      c.addEventListener('click', function () {
        teks.value = c.getAttribute('data-contoh');
        teks.focus();
      });
    });

    $('#thinkReset').addEventListener('click', function () {
      jawaban = kartu.map(function () { return null; });
      teks.value = '';
      perbarui();
      teks.focus();
    });

    perbarui();
  })();
})();
