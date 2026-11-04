<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$id = (int) ($_GET['id'] ?? 0);
$guru = ambil_satu($koneksi, "SELECT * FROM t_guru WHERE id = ?", 'i', $id);

if (!$guru) {
    header("Location: kelola_guru.php");
    exit;
}

// Nilai awal form = data lama
$v = [
    'nip'          => $guru['nip'] ?? '',
    'nama'         => $guru['nama'] ?? '',
    'email'        => $guru['email'] ?? '',
    'status_aktif' => (int) $guru['status_aktif'],
];
$galat = [];

// Proses update
if (isset($_POST['simpan'])) {

    $v = data_guru_dari_post($_POST);
    $galat = validasi_guru($koneksi, $v, $id);

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "UPDATE t_guru SET
                nip = ?, nama = ?, email = ?, status_aktif = ?, updated_at = NOW()
                WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'sssii',
                $v['nip'], $v['nama'], $v['email'], $v['status_aktif'], $id);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_guru.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data guru gagal disimpan.';
        }
    }
}

$judul        = 'Edit Guru';
$menu_aktif   = 'kelola_guru.php';
$deskripsi    = 'Perbarui formulir di bawah ini, lalu klik Simpan.';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_guru.php';

include 'layout/tambah_bawah.php';
