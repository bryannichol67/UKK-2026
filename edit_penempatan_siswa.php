<?php
// edit_penempatan_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';
include_once 'includes/helper.php';
cek_role(['admin']);

$id = (int) ($_GET['id'] ?? 0);

// Ambil data lama
$stmt = mysqli_prepare($koneksi, "SELECT * FROM t_kelas_siswa WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$row) {
    $_SESSION['pesan_error'] = 'Data penempatan tidak ditemukan.';
    header('Location: penempatan_siswa.php');
    exit;
}

$v = [
    'siswa_id'        => $row['siswa_id'],
    'tahun_ajaran_id' => $row['tahun_ajaran_id'],
    'kelas_id'        => $row['kelas_id'],
    'tanggal_mulai'   => $row['tanggal_mulai'],
    'tanggal_selesai' => ($row['tanggal_selesai'] == '0000-00-00') ? '' : $row['tanggal_selesai'],
    'status_aktif'    => $row['status_aktif'],
];
$error = '';

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v['siswa_id']        = (int) $_POST['siswa_id'];
    $v['tahun_ajaran_id'] = (int) $_POST['tahun_ajaran_id'];
    $v['kelas_id']        = (int) $_POST['kelas_id'];
    $v['tanggal_mulai']   = $_POST['tanggal_mulai'];
    $v['tanggal_selesai'] = $_POST['tanggal_selesai'];
    $v['status_aktif']    = (int) $_POST['status_aktif'];

    if ($v['tanggal_selesai'] < $v['tanggal_mulai']) {
        $error = 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.';
    } elseif (!tahun_ajaran_aktif($koneksi, $v['tahun_ajaran_id'])) {
        $error = 'Pilih tahun ajaran yang berstatus aktif.';
    } elseif ($v['status_aktif'] == 1 && siswa_sudah_ditempatkan($koneksi, $v['siswa_id'], $v['tahun_ajaran_id'], $id)) {
        $error = 'Siswa ini sudah ditempatkan ke sebuah kelas pada tahun ajaran tersebut.';
    } else {
        $stmt = mysqli_prepare($koneksi,
            "UPDATE t_kelas_siswa SET
                siswa_id = ?, tahun_ajaran_id = ?, kelas_id = ?,
                tanggal_mulai = ?, tanggal_selesai = ?, status_aktif = ?,
                updated_at = NOW()
             WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'iiissii',
            $v['siswa_id'], $v['tahun_ajaran_id'], $v['kelas_id'],
            $v['tanggal_mulai'], $v['tanggal_selesai'], $v['status_aktif'], $id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['pesan_sukses'] = 'Penempatan siswa berhasil diperbarui.';
            header('Location: penempatan_siswa.php');
            exit;
        }
        $error = 'Penempatan siswa gagal diperbarui.';
    }
}

// Pilihan dropdown: tahun ajaran hanya yang aktif. Siswa yang sudah ditempatkan
// pada tahun ajaran aktif (selain data yang sedang diedit ini) tidak ditampilkan.
$siswa = mysqli_query($koneksi, "SELECT id, nis, nama FROM t_siswa
    WHERE (status_aktif = 1 OR id = " . (int) $row['siswa_id'] . ")
    AND id NOT IN (SELECT siswa_id FROM t_kelas_siswa
                   WHERE status_aktif = 1 AND siswa_id IS NOT NULL AND id <> " . (int) $id . "
                   AND tahun_ajaran_id IN (SELECT id FROM t_tahun_ajaran WHERE status_aktif = 1))
    ORDER BY nama ASC");
$tahun = mysqli_query($koneksi, "SELECT id, nama FROM t_tahun_ajaran WHERE status_aktif = 1 ORDER BY id DESC");
// Pilihan kelas: semua data, supaya pilihan lama tetap muncul
$kelas = mysqli_query($koneksi, "SELECT id, nama, tingkat, jurusan FROM t_kelas ORDER BY nama ASC");

$label_tombol = 'Simpan Penempatan';
?>
<?php
$judul      = 'Edit Penempatan Siswa';
$menu_aktif = 'penempatan_siswa.php';
$deskripsi  = 'Tempatkan siswa ke kelas berdasarkan tahun ajaran.';
include 'layout/tambah_atas.php';
?>
<?php if ($error) { ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
<?php } ?>

<?php include 'layout/form_penempatan.php'; ?>

<?php include 'layout/tambah_bawah.php'; ?>
