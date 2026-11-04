<?php
// tambah_catatan_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';
include 'includes/proses_pelanggaran.php';
cek_role(['guru', 'admin']);

// Nilai awal form
$v = [
    'siswa_id' => '', 'tahun_ajaran_id' => '', 'kelas_id' => '',
    'pelanggaran_id' => '', 'guru_id' => '',
    'tanggal' => date('Y-m-d'), 'poin' => '', 'status' => 'belum',
    'keterangan' => '', 'tindakan' => '',
];

// Jika yang login adalah guru, pilih otomatis sebagai guru pelapor
$guru_login = cari_satu($koneksi, "SELECT id FROM t_guru WHERE user_id = ?", (int) $_SESSION['user_id']);
if ($guru_login) {
    $v['guru_id'] = $guru_login['id'];
}

$error = '';

// Proses simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v = data_dari_post();
    $hasil = simpan_pelanggaran($koneksi, $v);

    if ($hasil === true) {
        $_SESSION['pesan_sukses'] = 'Catatan pelanggaran berhasil disimpan.';
        header('Location: catat_pelanggaran.php');
        exit;
    }
    $error = $hasil;
}

// Pilihan dropdown (hanya data aktif)
$siswa       = mysqli_query($koneksi, "SELECT id, nis, nama FROM t_siswa WHERE status_aktif = 1 ORDER BY nama ASC");
$tahun       = mysqli_query($koneksi, "SELECT id, nama FROM t_tahun_ajaran WHERE status_aktif = 1 ORDER BY id DESC");
$kelas       = mysqli_query($koneksi, "SELECT id, nama, tingkat, jurusan FROM t_kelas WHERE status_aktif = 1 ORDER BY nama ASC");
$pelanggaran = mysqli_query($koneksi, "SELECT id, nama, poin FROM t_pelanggaran WHERE status_aktif = 1 ORDER BY nama ASC");
$guru        = mysqli_query($koneksi, "SELECT id, nama FROM t_guru WHERE status_aktif = 1 ORDER BY nama ASC");

$label_tombol = 'Simpan Pelanggaran';
?>
<?php
$judul      = 'Catat Pelanggaran Siswa';
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
