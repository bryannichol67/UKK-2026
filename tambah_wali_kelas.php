<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$v = [
    'tahun_ajaran_id' => '', 'kelas_id' => '', 'guru_id' => '',
    'tanggal_mulai' => '', 'tanggal_selesai' => '', 'status_aktif' => 1,
];
$galat = [];

if (isset($_POST['simpan'])) {

    $v = [
        'tahun_ajaran_id' => (int) ($_POST['tahun_ajaran_id'] ?? 0) ?: '',
        'kelas_id'        => (int) ($_POST['kelas_id'] ?? 0) ?: '',
        'guru_id'         => (int) ($_POST['guru_id'] ?? 0) ?: '',
        'tanggal_mulai'   => trim($_POST['tanggal_mulai'] ?? ''),
        'tanggal_selesai' => trim($_POST['tanggal_selesai'] ?? ''),
        'status_aktif'    => (string) ($_POST['status_aktif'] ?? '1') === '0' ? 0 : 1,
    ];
    if ($v['tahun_ajaran_id'] === '')  { $galat['tahun_ajaran_id'] = 'Pilih tahun ajaran.'; }
    if ($v['kelas_id'] === '')         { $galat['kelas_id']        = 'Pilih kelas.'; }
    if ($v['guru_id'] === '')          { $galat['guru_id']         = 'Pilih guru.'; }
    if ($v['tanggal_mulai'] === '')    { $galat['tanggal_mulai']   = 'Tanggal mulai wajib diisi.'; }
    if ($v['tanggal_selesai'] === '')  { $galat['tanggal_selesai'] = 'Tanggal selesai wajib diisi.'; }

    // Tanggal minimal tahun 2000
    foreach (['tanggal_mulai' => 'Tanggal mulai', 'tanggal_selesai' => 'Tanggal selesai'] as $kolom => $label) {
        if (!isset($galat[$kolom])) {
            $pesan = validasi_tanggal($v[$kolom], $label);
            if ($pesan !== '') { $galat[$kolom] = $pesan; }
        }
    }

    // Tahun ajaran harus aktif; kelas dan guru belum menjadi wali kelas
    if (empty($galat)) {
        $galat = validasi_wali_kelas_unik($koneksi, $v);
    }

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "INSERT INTO t_wali_kelas
                (tahun_ajaran_id, kelas_id, guru_id, tanggal_mulai, tanggal_selesai, status_aktif)
                VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'iiissi',
                $v['tahun_ajaran_id'], $v['kelas_id'], $v['guru_id'],
                $v['tanggal_mulai'], $v['tanggal_selesai'], $v['status_aktif']);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_wali_kelas.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data wali kelas gagal ditambahkan.';
        }
    }
}

// Pilihan dropdown (hanya data aktif)
$daftar_tahun = ambil_semua($koneksi, "SELECT * FROM t_tahun_ajaran WHERE status_aktif = 1 ORDER BY id DESC");
// Kelas yang sudah punya wali kelas dan guru yang sudah menjadi wali kelas tidak ditampilkan
$daftar_kelas = ambil_semua($koneksi, "SELECT * FROM t_kelas WHERE status_aktif = 1
    AND id NOT IN (SELECT kelas_id FROM t_wali_kelas
                   WHERE status_aktif = 1 AND kelas_id IS NOT NULL
                   AND tahun_ajaran_id IN (SELECT id FROM t_tahun_ajaran WHERE status_aktif = 1))
    ORDER BY nama ASC");
$daftar_guru  = ambil_semua($koneksi, "SELECT * FROM t_guru WHERE status_aktif = 1
    AND id NOT IN (SELECT guru_id FROM t_wali_kelas
                   WHERE status_aktif = 1 AND guru_id IS NOT NULL
                   AND tahun_ajaran_id IN (SELECT id FROM t_tahun_ajaran WHERE status_aktif = 1))
    ORDER BY nama ASC");

$judul        = 'Tambah Wali Kelas';
$menu_aktif   = 'kelola_wali_kelas.php';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_wali_kelas.php';

include 'layout/tambah_bawah.php';
