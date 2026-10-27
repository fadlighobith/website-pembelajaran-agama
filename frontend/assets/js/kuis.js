/* ==========================================================
   Privasiku - kuis.js
   Alur: tampilkan soal -> pengguna memilih -> jawaban dikirim ke
   cek.php (POST JSON) -> tampilkan benar/salah + penjelasan.
   ========================================================== */
(function () {
  'use strict';

  var app = document.getElementById('kuisApp');
  var soal = window.SOAL_KUIS;
  if (!app || !soal || !soal.length) return;

  var urlCek = app.getAttribute('data-cek') || 'cek.php';
  var total = soal.length;
  var idx = 0;
  var jumlahBenar = 0;
  var terkunci = false;
  var riwayat = [];

  function $(id) { return document.getElementById(id); }
  function buat(tag, kelas, teks) {
    var el = document.createElement(tag);
    if (kelas) el.className = kelas;
    if (teks !== undefined) el.textContent = teks;
    return el;
  }
  function simpan(k, v) { try { localStorage.setItem(k, v); } catch (e) { /* abaikan */ } }
  function ambil(k) { try { return localStorage.getItem(k); } catch (e) { return null; } }

  var el = {
    nomor: $('kuisNomor'), bar: $('kuisBar'), barWadah: $('kuisBarWadah'), persen: $('kuisPersen'),
    tanya: $('kuisTanya'), pilihan: $('kuisPilihan'), umpan: $('kuisUmpan'),
    lanjut: $('kuisLanjut'), lanjutTeks: $('kuisLanjutTeks'),
    areaSoal: $('areaSoal'), areaTinjau: $('areaTinjau'), daftarTinjau: $('daftarTinjau'),
    hasilKosong: $('hasilKosong'), hasilIsi: $('hasilIsi'),
    skorAngka: $('skorAngka'), skorPredikat: $('skorPredikat'), skorDetail: $('skorDetail'),
    skorTerbaik: $('skorTerbaik'), ulang: $('kuisUlang')
  };

  function tampil() {
    var s = soal[idx];
    terkunci = false;

    var p = Math.round(((idx + 1) / total) * 100);
    el.nomor.textContent = 'Soal ' + (idx + 1) + ' dari ' + total;
    el.bar.style.width = p + '%';
    el.barWadah.setAttribute('aria-valuenow', String(p));
    el.persen.textContent = p + '%';

    el.tanya.textContent = (idx + 1) + '. ' + s.tanya;
    el.pilihan.innerHTML = '';
    s.pilihan.forEach(function (teks, i) {
      var b = buat('button', 'opsi');
      b.type = 'button';
      b.appendChild(buat('span', 'huruf', String.fromCharCode(65 + i)));
      b.appendChild(buat('span', '', teks));
      b.addEventListener('click', function () { jawab(i); });
      el.pilihan.appendChild(b);
    });

    el.umpan.hidden = true;
    el.umpan.className = 'umpan';
    el.lanjut.disabled = true;
    el.lanjutTeks.textContent = idx === total - 1 ? 'Selesai' : 'Selanjutnya';
  }

  function semuaOpsi() {
    return Array.prototype.slice.call(el.pilihan.querySelectorAll('.opsi'));
  }

  function tampilUmpan(kelas, judul, isi) {
    el.umpan.className = 'umpan ' + kelas;
    el.umpan.innerHTML = '';
    el.umpan.appendChild(buat('strong', '', judul));
    el.umpan.appendChild(document.createTextNode(isi));
    el.umpan.hidden = false;
  }

  function jawab(i) {
    if (terkunci) return;
    terkunci = true;
    var s = soal[idx];
    var opsi = semuaOpsi();
    opsi.forEach(function (o) { o.disabled = true; });

    fetch(urlCek, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ id: s.id, jawaban: i })
    })
      .then(function (r) {
        if (!r.ok) throw new Error('Status ' + r.status);
        return r.json();
      })
      .then(function (h) {
        if (!h || !h.ok) throw new Error('Tanggapan tidak valid');

        if (h.benar) {
          jumlahBenar++;
          opsi[i].classList.add('benar');
          tampilUmpan('benar', 'Benar!', ' ' + h.penjelasan);
        } else {
          opsi[i].classList.add('salah');
          if (opsi[h.kunci]) opsi[h.kunci].classList.add('benar');
          tampilUmpan('salah', 'Belum tepat.', ' Jawaban yang benar: ' +
            String.fromCharCode(65 + h.kunci) + '. ' + s.pilihan[h.kunci] + '. ' + h.penjelasan);
        }

        riwayat.push({
          tanya: s.tanya,
          benar: !!h.benar,
          dipilih: s.pilihan[i],
          kunci: s.pilihan[h.kunci]
        });
        el.lanjut.disabled = false;
        el.lanjut.focus();
      })
      .catch(function () {
        // Gagal menghubungi cek.php: buka kembali pilihan agar bisa dicoba lagi.
        terkunci = false;
        opsi.forEach(function (o) { o.disabled = false; });
        tampilUmpan('salah', 'Jawaban belum bisa diperiksa.',
          ' Pastikan halaman dibuka lewat server PHP (misalnya http://localhost/pai-jejak-digital/kuis.php), bukan dengan membuka file langsung.');
      });
  }

  function selesai() {
    var nilai = Math.round((jumlahBenar / total) * 100);
    var predikat;
    if (nilai >= 90) predikat = 'Luar biasa! Kamu penjaga amanah sejati.';
    else if (nilai >= 70) predikat = 'Bagus! Terus tingkatkan pemahamanmu.';
    else if (nilai >= 50) predikat = 'Cukup baik. Pelajari materi sekali lagi.';
    else predikat = 'Ayo belajar lagi, kamu pasti bisa!';

    var terbaik = parseInt(ambil('amanah-kuis-terbaik') || '0', 10) || 0;
    if (nilai > terbaik) {
      terbaik = nilai;
      simpan('amanah-kuis-terbaik', String(nilai));
    }

    el.skorAngka.textContent = nilai;
    el.skorPredikat.textContent = predikat;
    el.skorDetail.textContent = jumlahBenar + ' benar dari ' + total + ' soal';
    el.skorTerbaik.textContent = 'Skor terbaikmu: ' + terbaik;
    el.hasilKosong.hidden = true;
    el.hasilIsi.hidden = false;

    el.daftarTinjau.innerHTML = '';
    riwayat.forEach(function (r, n) {
      var li = document.createElement('li');
      li.appendChild(buat('span', 'status ' + (r.benar ? 'benar' : 'salah'), r.benar ? '✓' : '✗'));
      var isi = buat('div');
      isi.appendChild(buat('strong', '', (n + 1) + '. ' + r.tanya));
      var kecil = buat('small', '', r.benar ? 'Jawabanmu: ' + r.dipilih : 'Jawabanmu: ' + r.dipilih + ' | Benar: ' + r.kunci);
      isi.appendChild(kecil);
      li.appendChild(isi);
      el.daftarTinjau.appendChild(li);
    });

    el.areaSoal.hidden = true;
    el.areaTinjau.hidden = false;
    el.areaTinjau.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  el.lanjut.addEventListener('click', function () {
    if (idx < total - 1) {
      idx++;
      tampil();
    } else {
      selesai();
    }
  });

  // Muat ulang halaman supaya urutan soal diacak lagi oleh server.
  el.ulang.addEventListener('click', function () { window.location.reload(); });

  tampil();
})();
