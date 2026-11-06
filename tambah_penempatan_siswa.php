<?php
// tambah_penempatan_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';
include_once 'includes/helper.php';
cek_role(['admin']);

// Nilai awal form
$v = [
    'siswa_id'        => '',
    'tahun_ajaran_id' => '',
    'kelas_id'        => '',
    'tanggal_mulai'   => '',
    'tanggal_selesai' => '',
    'status_aktif'    => 1,
];
$error = '';

// Proses simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v['siswa_id']        = (int) $_POST['siswa_id'];
    $v['tahun_ajaran_id'] = (int) $_POST['tahun_ajaran_id'];
    $v['kelas_id']        = (int) $_POST['kelas_id'];
    $v['tanggal_mulai']   = $_POST['tanggal_mulai'];
    $v['tanggal_selesai'] = $_POST['tanggal_selesai'];
    $v['status_aktif']    = (int) $_POST['status_aktif'];

    $error_tgl = validasi_tanggal($v['tanggal_mulai'], 'Tanggal mulai')
              ?: validasi_tanggal($v['tanggal_selesai'], 'Tanggal selesai');

    if ($error_tgl !== '') {
        $error = $error_tgl;
    } elseif ($v['tanggal_selesai'] < $v['tanggal_mulai']) {
        $error = 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.';
    } elseif (!tahun_ajaran_aktif($koneksi, $v['tahun_ajaran_id'])) {
        $error = 'Pilih tahun ajaran yang berstatus aktif.';
    } elseif ($v['status_aktif'] == 1 && siswa_sudah_ditempatkan($koneksi, $v['siswa_id'], $v['tahun_ajaran_id'])) {
        $error = 'Siswa ini sudah ditempatkan ke sebuah kelas pada tahun ajaran tersebut.';
    } else {
        $stmt = mysqli_prepare($koneksi,
            "INSERT INTO t_kelas_siswa
             (siswa_id, tahun_ajaran_id, kelas_id, tanggal_mulai, tanggal_selesai, status_aktif)
             VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'iiissi',
            $v['siswa_id'], $v['tahun_ajaran_id'], $v['kelas_id'],
            $v['tanggal_mulai'], $v['tanggal_selesai'], $v['status_aktif']);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['pesan_sukses'] = 'Penempatan siswa berhasil ditambahkan.';
            header('Location: penempatan_siswa.php');
            exit;
        }
        $error = 'Penempatan siswa gagal disimpan.';
    }
}

// Pilihan dropdown (hanya data aktif)
// Siswa yang sudah ditempatkan pada tahun ajaran aktif tidak ditampilkan lagi
$siswa = mysqli_query($koneksi, "SELECT id, nis, nama FROM t_siswa WHERE status_aktif = 1
    AND id NOT IN (SELECT siswa_id FROM t_kelas_siswa
                   WHERE status_aktif = 1 AND siswa_id IS NOT NULL
                   AND tahun_ajaran_id IN (SELECT id FROM t_tahun_ajaran WHERE status_aktif = 1))
    ORDER BY nama ASC");
$tahun = mysqli_query($koneksi, "SELECT id, nama FROM t_tahun_ajaran WHERE status_aktif = 1 ORDER BY id DESC");
$kelas = mysqli_query($koneksi, "SELECT id, nama, tingkat, jurusan FROM t_kelas WHERE status_aktif = 1 ORDER BY nama ASC");

$label_tombol = 'Simpan Penempatan';
?>
<?php
$judul      = 'Tambah Penempatan Siswa';
$menu_aktif = 'penempatan_siswa.php';
$deskripsi  = 'Tempatkan siswa ke kelas berdasarkan tahun ajaran.';
include 'layout/tambah_atas.php';
?>
<?php if ($error) { ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
<?php } ?>

<?php include 'layout/form_penempatan.php'; ?>

<?php include 'layout/tambah_bawah.php'; ?>
