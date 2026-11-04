<?php
session_start();
include "config/koneksi.php";
include "includes/helper.php";

wajib_admin();

$id = (int) ($_GET['id'] ?? 0);
$wali = ambil_satu($koneksi, "SELECT * FROM t_wali_kelas WHERE id = ?", 'i', $id);

if (!$wali) {
    header("Location: kelola_wali_kelas.php");
    exit;
}

$v = [
    'tahun_ajaran_id' => $wali['tahun_ajaran_id'],
    'kelas_id'        => $wali['kelas_id'],
    'guru_id'         => $wali['guru_id'],
    'tanggal_mulai'   => $wali['tanggal_mulai'] ?? '',
    'tanggal_selesai' => $wali['tanggal_selesai'] ?? '',
    'status_aktif'    => (int) $wali['status_aktif'],
];
$galat = [];

if (isset($_POST['simpan'])) {

    $v = [
        'tahun_ajaran_id' => (int) ($_POST['tahun_ajaran_id'] ?? 0) ?: '',
        'kelas_id'        => (int) ($_POST['kelas_id'] ?? 0) ?: '',
        'guru_id'         => (int) ($_POST['guru_id'] ?? 0) ?: '',
        'tanggal_mulai'   => trim($_POST['tanggal_mulai'] ?? ''),
        'tanggal_selesai' => trim($_POST['tanggal_selesai'] ?? ''),
        'status_aktif'    => (string) ($_POST['status_aktif'] ?? '1') === '0' ? 0 : 1,
    ];
    if ($v['tahun_ajaran_id'] === '')  { $galat['tahun_ajaran_id'] = 'Pilih tahun ajaran.'; }
    if ($v['kelas_id'] === '')         { $galat['kelas_id']        = 'Pilih kelas.'; }
    if ($v['guru_id'] === '')          { $galat['guru_id']         = 'Pilih guru.'; }
    if ($v['tanggal_mulai'] === '')    { $galat['tanggal_mulai']   = 'Tanggal mulai wajib diisi.'; }
    if ($v['tanggal_selesai'] === '')  { $galat['tanggal_selesai'] = 'Tanggal selesai wajib diisi.'; }

    if (empty($galat)) {
        try {
            $stmt = mysqli_prepare($koneksi, "UPDATE t_wali_kelas SET
                tahun_ajaran_id = ?, kelas_id = ?, guru_id = ?,
                tanggal_mulai = ?, tanggal_selesai = ?, status_aktif = ?, updated_at = NOW()
                WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'iiissii',
                $v['tahun_ajaran_id'], $v['kelas_id'], $v['guru_id'],
                $v['tanggal_mulai'], $v['tanggal_selesai'], $v['status_aktif'], $id);
            mysqli_stmt_execute($stmt);

            header("Location: kelola_wali_kelas.php");
            exit;
        } catch (Throwable $e) {
            $galat['umum'] = 'Data wali kelas gagal disimpan.';
        }
    }
}

// Pilihan dropdown (data aktif + pilihan yang sedang tersimpan, supaya tidak hilang)
$daftar_tahun = ambil_semua($koneksi, "SELECT * FROM t_tahun_ajaran WHERE status_aktif = 1 OR id = ? ORDER BY id DESC", 'i', (int) $wali['tahun_ajaran_id']);
$daftar_kelas = ambil_semua($koneksi, "SELECT * FROM t_kelas WHERE status_aktif = 1 OR id = ? ORDER BY nama ASC", 'i', (int) $wali['kelas_id']);
$daftar_guru  = ambil_semua($koneksi, "SELECT * FROM t_guru WHERE status_aktif = 1 OR id = ? ORDER BY nama ASC", 'i', (int) $wali['guru_id']);

$judul        = 'Edit Wali Kelas';
$menu_aktif   = 'kelola_wali_kelas.php';
$deskripsi    = 'Perbarui formulir di bawah ini, lalu klik Simpan.';
$label_tombol = 'Simpan';
include 'layout/tambah_atas.php';

include 'layout/form_wali_kelas.php';

include 'layout/tambah_bawah.php';
