<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$id = (int) ($_GET['id'] ?? 0);
$tahun = ambil_satu($koneksi, "SELECT * FROM t_tahun_ajaran WHERE id = ?", 'i', $id);

if (!$tahun) {
    header("Location: kelola_tahun_ajaran.php");
    exit;
}

$v = [
    'nama'            => $tahun['nama'] ?? '',
    'tanggal_mulai'   => $tahun['tanggal_mulai'] ?? '',
    'tanggal_selesai' => $tahun['tanggal_selesai'] ?? '',
    'status_aktif'    => (int) $tahun['status_aktif'],
];
$galat = [];

if (isset($_POST['simpan'])) {

    $v = [
        'nama'            => trim($_POST['nama'] ?? ''),
        'tanggal_mulai'   => trim($_POST['tanggal_mulai'] ?? ''),
        'tanggal_selesai' => trim($_POST['tanggal_selesai'] ?? ''),
        'status_aktif'    => (string) ($_POST['status_aktif'] ?? '1') === '0' ? 0 : 1,
    ];
    if ($v['nama'] === '')            { $galat['nama']            = 'Nama tahun ajaran wajib diisi.'; }
    if ($v['tanggal_mulai'] === '')   { $galat['tanggal_mulai']   = 'Tanggal mulai wajib diisi.'; }
    if ($v['tanggal_selesai'] === '') { $galat['tanggal_selesai'] = 'Tanggal selesai wajib diisi.'; }

    // Tanggal minimal tahun 2000
    foreach (['tanggal_mulai' => 'Tanggal mulai', 'tanggal_selesai' => 'Tanggal selesai'] as $kolom => $label) {
        if (!isset($galat[$kolom])) {
            $pesan = validasi_tanggal($v[$kolom], $label);
            if ($pesan !== '') { $galat[$kolom] = $pesan; }
        }
    }

    // Hanya boleh ada satu tahun ajaran aktif
    if ($v['status_aktif'] === 1) {
        $aktif = tahun_aktif_lain($koneksi, $id);
        if ($aktif) { $galat['status_aktif'] = pesan_tahun_aktif_ganda($aktif); }
    }

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "UPDATE t_tahun_ajaran SET nama = ?, tanggal_mulai = ?, tanggal_selesai = ?, status_aktif = ?, updated_at = NOW() WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'sssii', $v['nama'], $v['tanggal_mulai'], $v['tanggal_selesai'], $v['status_aktif'], $id);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_tahun_ajaran.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data tahun ajaran gagal disimpan.';
        }
    }
}

$judul        = 'Edit Tahun Ajaran';
$menu_aktif   = 'kelola_tahun_ajaran.php';
$deskripsi    = 'Perbarui formulir di bawah ini, lalu klik Simpan.';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_tahun_ajaran.php';

include 'layout/tambah_bawah.php';
