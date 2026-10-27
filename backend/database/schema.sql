-- Skema PostgreSQL untuk Privasiku
-- Jalankan:  psql -U postgres -d privasiku -f schema.sql

CREATE TABLE IF NOT EXISTS pengguna (
    id            BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nama          VARCHAR(100) NOT NULL,
    username      VARCHAR(30)  NOT NULL,
    kelas         VARCHAR(20),
    password_hash TEXT         NOT NULL,
    role          VARCHAR(10)  NOT NULL DEFAULT 'user' CHECK (role IN ('user', 'admin')),
    dibuat_pada   TIMESTAMPTZ  NOT NULL DEFAULT now()
);
-- username tidak peka huruf besar/kecil
CREATE UNIQUE INDEX IF NOT EXISTS ux_pengguna_username ON pengguna (lower(username));

CREATE TABLE IF NOT EXISTS percobaan_kuis (
    id           BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    pengguna_id  BIGINT      NOT NULL REFERENCES pengguna (id) ON DELETE CASCADE,
    mulai        TIMESTAMPTZ NOT NULL DEFAULT now(),
    selesai      TIMESTAMPTZ,
    jumlah_soal  INT         NOT NULL CHECK (jumlah_soal > 0),
    jumlah_benar INT         NOT NULL DEFAULT 0,
    nilai        INT         CHECK (nilai BETWEEN 0 AND 100)
);
CREATE INDEX IF NOT EXISTS ix_percobaan_pengguna ON percobaan_kuis (pengguna_id, selesai);

CREATE TABLE IF NOT EXISTS jawaban_kuis (
    id           BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    percobaan_id BIGINT      NOT NULL REFERENCES percobaan_kuis (id) ON DELETE CASCADE,
    soal_id      INT         NOT NULL,
    jawaban      INT         NOT NULL,
    benar        BOOLEAN     NOT NULL,
    dijawab_pada TIMESTAMPTZ NOT NULL DEFAULT now(),
    UNIQUE (percobaan_id, soal_id)
);
