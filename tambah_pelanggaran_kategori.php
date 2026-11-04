<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$v = ['nama' => '', 'deskripsi' => '', 'status_aktif' => 1];
$galat = [];

if (isset($_POST['simpan'])) {

    $v = [
        'nama'         => trim($_POST['nama'] ?? ''),
        'deskripsi'    => trim($_POST['deskripsi'] ?? ''),
        'status_aktif' => (string) ($_POST['status_aktif'] ?? '1') === '0' ? 0 : 1,
    ];
    if ($v['nama'] === '') { $galat['nama'] = 'Nama kategori wajib diisi.'; }

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "INSERT INTO t_pelanggaran_kategori (nama, deskripsi, status_aktif) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'ssi', $v['nama'], $v['deskripsi'], $v['status_aktif']);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_pelanggaran_kategori.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data kategori pelanggaran gagal ditambahkan.';
        }
    }
}

$judul        = 'Tambah Kategori Pelanggaran';
$menu_aktif   = 'kelola_pelanggaran_kategori.php';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_pelanggaran_kategori.php';

include 'layout/tambah_bawah.php';
