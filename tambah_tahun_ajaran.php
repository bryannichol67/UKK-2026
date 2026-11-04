<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$v = ['nama' => '', 'tanggal_mulai' => '', 'tanggal_selesai' => '', 'status_aktif' => 1];
$galat = [];

if (isset($_POST['simpan'])) {

    $v = [
        'nama'            => trim($_POST['nama'] ?? ''),
        'tanggal_mulai'   => trim($_POST['tanggal_mulai'] ?? ''),
        'tanggal_selesai' => trim($_POST['tanggal_selesai'] ?? ''),
        'status_aktif'    => (string) ($_POST['status_aktif'] ?? '1') === '0' ? 0 : 1,
    ];
    if ($v['nama'] === '')            { $galat['nama']            = 'Nama tahun ajaran wajib diisi.'; }
    if ($v['tanggal_mulai'] === '')   { $galat['tanggal_mulai']   = 'Tanggal mulai wajib diisi.'; }
    if ($v['tanggal_selesai'] === '') { $galat['tanggal_selesai'] = 'Tanggal selesai wajib diisi.'; }

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "INSERT INTO t_tahun_ajaran (nama, tanggal_mulai, tanggal_selesai, status_aktif) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'sssi', $v['nama'], $v['tanggal_mulai'], $v['tanggal_selesai'], $v['status_aktif']);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_tahun_ajaran.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data tahun ajaran gagal ditambahkan.';
        }
    }
}

$judul        = 'Tambah Tahun Ajaran';
$menu_aktif   = 'kelola_tahun_ajaran.php';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_tahun_ajaran.php';

include 'layout/tambah_bawah.php';
