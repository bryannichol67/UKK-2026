<?php
// hapus_penempatan_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';
cek_role(['admin']);

$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare($koneksi, "DELETE FROM t_kelas_siswa WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['pesan_sukses'] = 'Penempatan siswa berhasil dihapus.';
} else {
    $_SESSION['pesan_error'] = 'Penempatan siswa gagal dihapus.';
}

header('Location: penempatan_siswa.php');
exit;
