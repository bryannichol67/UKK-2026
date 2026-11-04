<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$v = ['nama' => '', 'tingkat' => '', 'jurusan' => '', 'status_aktif' => 1];
$galat = [];

if (isset($_POST['simpan'])) {

    $v = [
        'nama'         => trim($_POST['nama'] ?? ''),
        'tingkat'      => trim($_POST['tingkat'] ?? ''),
        'jurusan'      => trim($_POST['jurusan'] ?? ''),
        'status_aktif' => (string) ($_POST['status_aktif'] ?? '1') === '0' ? 0 : 1,
    ];
    $galat = validasi_kelas($v);

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "INSERT INTO t_kelas (nama, tingkat, jurusan, status_aktif) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'sssi', $v['nama'], $v['tingkat'], $v['jurusan'], $v['status_aktif']);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_kelas.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data kelas gagal ditambahkan.';
        }
    }
}

$judul        = 'Tambah Kelas';
$menu_aktif   = 'kelola_kelas.php';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_kelas.php';

include 'layout/tambah_bawah.php';
