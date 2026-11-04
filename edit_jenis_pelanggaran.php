<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$id = (int) ($_GET['id'] ?? 0);
$jenis = ambil_satu($koneksi, "SELECT * FROM t_pelanggaran WHERE id = ?", 'i', $id);

if (!$jenis) {
    header("Location: kelola_jenis_pelanggaran.php");
    exit;
}

$v = [
    'pelanggaran_kategori_id' => $jenis['pelanggaran_kategori_id'],
    'kode'         => $jenis['kode'] ?? '',
    'nama'         => $jenis['nama'] ?? '',
    'poin'         => (string) $jenis['poin'],
    'deskripsi'    => $jenis['deskripsi'] ?? '',
    'status_aktif' => (int) $jenis['status_aktif'],
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
            $stmt = mysqli_prepare($koneksi, "UPDATE t_pelanggaran SET
                pelanggaran_kategori_id = ?, kode = ?, nama = ?, poin = ?,
                deskripsi = ?, status_aktif = ?, updated_at = NOW()
                WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'issisii',
                $v['pelanggaran_kategori_id'], $v['kode'], $v['nama'],
                $poin, $v['deskripsi'], $v['status_aktif'], $id);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_jenis_pelanggaran.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data jenis pelanggaran gagal disimpan.';
        }
    }
}

// Pilihan kategori (yang aktif + kategori yang sedang tersimpan)
$daftar_kategori = ambil_semua($koneksi,
    "SELECT id, nama FROM t_pelanggaran_kategori WHERE status_aktif = 1 OR id = ? ORDER BY nama ASC",
    'i', (int) $jenis['pelanggaran_kategori_id']);

$judul        = 'Edit Jenis Pelanggaran';
$menu_aktif   = 'kelola_jenis_pelanggaran.php';
$deskripsi    = 'Perbarui formulir di bawah ini, lalu klik Simpan.';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_jenis_pelanggaran.php';

include 'layout/tambah_bawah.php';
