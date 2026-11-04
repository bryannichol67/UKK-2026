<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$v = [
    'pelanggaran_kategori_id' => '', 'kode' => '', 'nama' => '',
    'poin' => '', 'deskripsi' => '', 'status_aktif' => 1,
];
$galat = [];

if (isset($_POST['simpan'])) {

    $v = [
        'pelanggaran_kategori_id' => (int) ($_POST['pelanggaran_kategori_id'] ?? 0) ?: '',
        'kode'         => trim($_POST['kode'] ?? ''),
        'nama'         => trim($_POST['nama'] ?? ''),
        'poin'         => trim($_POST['poin'] ?? ''),
        'deskripsi'    => trim($_POST['deskripsi'] ?? ''),
        'status_aktif' => (string) ($_POST['status_aktif'] ?? '1') === '0' ? 0 : 1,
    ];
    if ($v['pelanggaran_kategori_id'] === '') { $galat['pelanggaran_kategori_id'] = 'Pilih kategori pelanggaran.'; }
    if ($v['kode'] === '') { $galat['kode'] = 'Kode wajib diisi.'; }
    if ($v['nama'] === '') { $galat['nama'] = 'Nama pelanggaran wajib diisi.'; }
    if ($v['poin'] === '' || !ctype_digit($v['poin'])) { $galat['poin'] = 'Poin wajib diisi dengan angka 0 atau lebih.'; }

    if (empty($galat)) {
        try {
            $poin = (int) $v['poin'];
            $stmt = mysqli_prepare($koneksi, "INSERT INTO t_pelanggaran
                (pelanggaran_kategori_id, kode, nama, poin, deskripsi, status_aktif)
                VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'issisi',
                $v['pelanggaran_kategori_id'], $v['kode'], $v['nama'],
                $poin, $v['deskripsi'], $v['status_aktif']);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_jenis_pelanggaran.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data jenis pelanggaran gagal ditambahkan.';
        }
    }
}

// Pilihan kategori (hanya yang aktif)
$daftar_kategori = ambil_semua($koneksi, "SELECT id, nama FROM t_pelanggaran_kategori WHERE status_aktif = 1 ORDER BY nama ASC");

$judul        = 'Tambah Jenis Pelanggaran';
$menu_aktif   = 'kelola_jenis_pelanggaran.php';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_jenis_pelanggaran.php';

include 'layout/tambah_bawah.php';
