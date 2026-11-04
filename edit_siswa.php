<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$id = (int) ($_GET['id'] ?? 0);
$siswa = ambil_satu($koneksi, "SELECT * FROM t_siswa WHERE id = ?", 'i', $id);

if (!$siswa) {
    header("Location: kelola_siswa.php");
    exit;
}

// Nilai awal form = data lama
$v = [
    'nis'           => $siswa['nis'] ?? '',
    'nisn'          => $siswa['nisn'] ?? '',
    'nama'          => $siswa['nama'] ?? '',
    'jenis_kelamin' => $siswa['jenis_kelamin'] ?? '',
    'tanggal_lahir' => $siswa['tanggal_lahir'] ?? '',
    'alamat'        => $siswa['alamat'] ?? '',
    'status_aktif'  => (int) $siswa['status_aktif'],
];
$galat = [];

// Proses update
if (isset($_POST['simpan'])) {

    $v = data_siswa_dari_post($_POST);
    $galat = validasi_siswa($koneksi, $v, $id);

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "UPDATE t_siswa SET
                nis = ?, nisn = ?, nama = ?, jenis_kelamin = ?,
                tanggal_lahir = ?, alamat = ?, status_aktif = ?, updated_at = NOW()
                WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'ssssssii',
                $v['nis'], $v['nisn'], $v['nama'], $v['jenis_kelamin'],
                $v['tanggal_lahir'], $v['alamat'], $v['status_aktif'], $id);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_siswa.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data siswa gagal disimpan.';
        }
    }
}

$judul        = 'Edit Siswa';
$menu_aktif   = 'kelola_siswa.php';
$deskripsi    = 'Perbarui formulir di bawah ini, lalu klik Simpan.';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_siswa.php';

include 'layout/tambah_bawah.php';
