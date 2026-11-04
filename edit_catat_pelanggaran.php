<?php
// edit_catat_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';
include 'includes/proses_pelanggaran.php';
cek_role(['guru', 'admin']);

$id = (int) ($_GET['id'] ?? 0);

// Ambil data lama
$row = cari_satu($koneksi, "SELECT * FROM t_pelanggaran_siswa WHERE id = ?", $id);

if (!$row) {
    $_SESSION['pesan_error'] = 'Catatan pelanggaran tidak ditemukan.';
    header('Location: catat_pelanggaran.php');
    exit;
}

$v = [
    'siswa_id'        => $row['siswa_id'],
    'tahun_ajaran_id' => $row['tahun_ajaran_id'],
    'kelas_id'        => $row['kelas_id'],
    'pelanggaran_id'  => $row['pelanggaran_id'],
    'guru_id'         => $row['guru_id'],
    'tanggal'         => $row['tanggal'],
    'poin'            => $row['poin'],
    'status'          => $row['status'],
    'keterangan'      => $row['keterangan'],
    'tindakan'        => $row['tindakan'],
];
$error = '';

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v = data_dari_post();
    $hasil = simpan_pelanggaran($koneksi, $v, $id);

    if ($hasil === true) {
        $_SESSION['pesan_sukses'] = 'Catatan pelanggaran berhasil diperbarui.';
        header('Location: catat_pelanggaran.php');
        exit;
    }
    $error = $hasil;
}

// Pilihan dropdown (semua data, supaya pilihan lama tetap muncul)
$siswa       = mysqli_query($koneksi, "SELECT id, nis, nama FROM t_siswa ORDER BY nama ASC");
$tahun       = mysqli_query($koneksi, "SELECT id, nama FROM t_tahun_ajaran ORDER BY id DESC");
$kelas       = mysqli_query($koneksi, "SELECT id, nama, tingkat, jurusan FROM t_kelas ORDER BY nama ASC");
$pelanggaran = mysqli_query($koneksi, "SELECT id, nama, poin FROM t_pelanggaran ORDER BY nama ASC");
$guru        = mysqli_query($koneksi, "SELECT id, nama FROM t_guru ORDER BY nama ASC");

$label_tombol = 'Simpan Pelanggaran';
?>
<?php
$judul      = 'Edit Catatan Pelanggaran Siswa';
$menu_aktif = 'catat_pelanggaran.php';
$deskripsi  = 'Isi data pelanggaran yang dilakukan siswa.';
$lebar      = true;
include 'layout/tambah_atas.php';
?>
<?php if ($error) { ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
<?php } ?>

<?php include 'layout/form_catat_pelanggaran.php'; ?>

<?php include 'layout/tambah_bawah.php'; ?>
