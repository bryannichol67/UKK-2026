<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$id = (int) ($_GET['id'] ?? 0);
$kategori = ambil_satu($koneksi, "SELECT * FROM t_pelanggaran_kategori WHERE id = ?", 'i', $id);

if (!$kategori) {
    header("Location: kelola_pelanggaran_kategori.php");
    exit;
}

$v = [
    'nama'         => $kategori['nama'] ?? '',
    'deskripsi'    => $kategori['deskripsi'] ?? '',
    'status_aktif' => (int) $kategori['status_aktif'],
];
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
            $stmt = mysqli_prepare($koneksi, "UPDATE t_pelanggaran_kategori SET nama = ?, deskripsi = ?, status_aktif = ?, updated_at = NOW() WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'ssii', $v['nama'], $v['deskripsi'], $v['status_aktif'], $id);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_pelanggaran_kategori.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data kategori pelanggaran gagal disimpan.';
        }
    }
}

$judul        = 'Edit Kategori Pelanggaran';
$menu_aktif   = 'kelola_pelanggaran_kategori.php';
$deskripsi    = 'Perbarui formulir di bawah ini, lalu klik Simpan.';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_pelanggaran_kategori.php';

include 'layout/tambah_bawah.php';
