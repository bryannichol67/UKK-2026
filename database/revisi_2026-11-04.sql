-- Jalankan sekali di database db_ukk_sql_2026 (phpMyAdmin > tab SQL).
-- Menyesuaikan data lama dengan 5 revisi terbaru.

-- ------------------------------------------------------------------
-- Revisi 1: NIS maksimal 15 digit, NISN maksimal 10 digit
-- Cek dulu: query ini harus kosong. Kalau ada baris, perbaiki datanya
-- sebelum menjalankan ALTER di bawah.
-- ------------------------------------------------------------------
SELECT id, nis, nisn FROM t_siswa
WHERE CHAR_LENGTH(nis) > 15 OR CHAR_LENGTH(nisn) > 10
   OR nis NOT REGEXP '^[0-9]+$' OR nisn NOT REGEXP '^[0-9]+$';

ALTER TABLE t_siswa
  MODIFY nis  varchar(15) DEFAULT NULL,
  MODIFY nisn varchar(10) NOT NULL;

-- ------------------------------------------------------------------
-- Revisi 3: hanya boleh ada satu tahun ajaran aktif
-- Di dump awal semua tahun ajaran berstatus aktif. Query ini
-- menyisakan satu saja: yang tanggal mulainya paling baru.
-- ------------------------------------------------------------------
UPDATE t_tahun_ajaran SET status_aktif = 0;

UPDATE t_tahun_ajaran SET status_aktif = 1
WHERE id = (
    SELECT id FROM (
        SELECT id FROM t_tahun_ajaran
        ORDER BY tanggal_mulai DESC, id DESC
        LIMIT 1
    ) AS terbaru
);

-- Cek hasil: harus tepat 1 baris
SELECT id, nama, tanggal_mulai, tanggal_selesai FROM t_tahun_ajaran WHERE status_aktif = 1;
