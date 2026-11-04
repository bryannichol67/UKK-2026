<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$id = (int) ($_GET['id'] ?? 0);
$kelas = ambil_satu($koneksi, "SELECT * FROM t_kelas WHERE id = ?", 'i', $id);

if (!$kelas) {
    header("Location: kelola_kelas.php");
    exit;
}

$v = [
    'nama'         => $kelas['nama'] ?? '',
    'tingkat'      => $kelas['tingkat'] ?? '',
    'jurusan'      => $kelas['jurusan'] ?? '',
    'status_aktif' => (int) $kelas['status_aktif'],
];
$galat = [];

if (isset($_POST['simpan'])) {

    $v = [
        'nama'         => trim($_POST['nama'] ?? ''),
        'tingkat'      => trim($_POST['tingkat'] ?? ''),
        'jurusan'      => trim($_POST['jurusan'] ?? ''),
        'status_aktif' => (string) ($_POST['status_aktif'] ?? '1') === '0' ? 0 : 1,
    ];
    $galat = validasi_kelas($v, $kelas);

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "UPDATE t_kelas SET nama = ?, tingkat = ?, jurusan = ?, status_aktif = ?, updated_at = NOW() WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'sssii', $v['nama'], $v['tingkat'], $v['jurusan'], $v['status_aktif'], $id);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_kelas.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data kelas gagal disimpan.';
        }
    }
}

$judul        = 'Edit Kelas';
$menu_aktif   = 'kelola_kelas.php';
$deskripsi    = 'Perbarui formulir di bawah ini, lalu klik Simpan.';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_kelas.php';

include 'layout/tambah_bawah.php';
