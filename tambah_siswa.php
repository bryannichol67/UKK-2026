<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

// Nilai awal form
$v = [
    'nis' => '', 'nisn' => '', 'nama' => '', 'jenis_kelamin' => '',
    'tanggal_lahir' => '', 'alamat' => '', 'status_aktif' => 1,
];
$galat = [];

// Proses simpan
if (isset($_POST['simpan'])) {

    $v = data_siswa_dari_post($_POST);
    $galat = validasi_siswa($koneksi, $v);

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "INSERT INTO t_siswa
                (nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'ssssssi',
                $v['nis'], $v['nisn'], $v['nama'], $v['jenis_kelamin'],
                $v['tanggal_lahir'], $v['alamat'], $v['status_aktif']);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_siswa.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data siswa gagal ditambahkan.';
        }
    }
}

$judul        = 'Tambah Siswa';
$menu_aktif   = 'kelola_siswa.php';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_siswa.php';

include 'layout/tambah_bawah.php';
