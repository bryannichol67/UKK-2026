<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

// Nilai awal form
$v = ['nip' => '', 'nama' => '', 'email' => '', 'status_aktif' => 1];
$galat = [];

// Proses simpan
if (isset($_POST['simpan'])) {

    $v = data_guru_dari_post($_POST);
    $galat = validasi_guru($koneksi, $v);

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "INSERT INTO t_guru
                (nip, nama, email, status_aktif, created_at, updated_at)
                VALUES (?, ?, ?, ?, NOW(), NOW())");
            mysqli_stmt_bind_param($stmt, 'sssi',
                $v['nip'], $v['nama'], $v['email'], $v['status_aktif']);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_guru.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data guru gagal ditambahkan.';
        }
    }
}

$judul        = 'Tambah Guru';
$menu_aktif   = 'kelola_guru.php';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_guru.php';

include 'layout/tambah_bawah.php';
