<?php
// Memeriksa session login
include "includes/cek_session.php";
include "config/koneksi.php";

// Mengambil data pengguna
$nama  = $_SESSION['nama'] ?? $_SESSION['nama_lengkap'] ?? 'Pengguna';
$email = $_SESSION['email'] ?? '-';
$role  = $_SESSION['role'] ?? '-';

// Mengambil satu angka dari query COUNT/SUM
function ambil_angka($koneksi, $sql)
{
    $hasil = mysqli_query($koneksi, $sql);
    $baris = $hasil ? mysqli_fetch_row($hasil) : null;
    return (int) ($baris[0] ?? 0);
}

$is_wali  = ($role === 'guru' && !empty($_SESSION['is_wali_kelas']));
$kelas_id = (int) ($_SESSION['kelas_wali_id'] ?? 0);

// Kartu statistik sesuai role: [judul, angka, warna bootstrap]
$kartu = [];
$judul_info = '';

if ($role === 'admin') {
    $kartu[] = ['Data Siswa',        ambil_angka($koneksi, "SELECT COUNT(*) FROM t_siswa"), 'primary'];
    $kartu[] = ['Data Guru',         ambil_angka($koneksi, "SELECT COUNT(*) FROM t_guru"), 'success'];
    $kartu[] = ['Data Kelas',        ambil_angka($koneksi, "SELECT COUNT(*) FROM t_kelas"), 'warning'];
    $kartu[] = ['Wali Kelas Aktif',  ambil_angka($koneksi, "SELECT COUNT(*) FROM t_wali_kelas WHERE status_aktif = 1"), 'info'];
    $kartu[] = ['Total Pelanggaran', ambil_angka($koneksi, "SELECT COUNT(*) FROM t_pelanggaran_siswa"), 'danger'];
    $kartu[] = ['Total Poin',        ambil_angka($koneksi, "SELECT COALESCE(SUM(poin),0) FROM t_pelanggaran_siswa"), 'secondary'];
} elseif ($is_wali && $kelas_id > 0) {
    // Wali kelas: data hanya untuk kelas yang dia pegang
    $res = mysqli_query($koneksi, "SELECT nama FROM t_kelas WHERE id = $kelas_id LIMIT 1");
    $row = $res ? mysqli_fetch_assoc($res) : null;
    $judul_info = 'Kelas yang Anda walikan: ' . ($row['nama'] ?? '-');
    $kartu[] = ['Siswa di Kelas',    ambil_angka($koneksi, "SELECT COUNT(*) FROM t_kelas_siswa WHERE kelas_id = $kelas_id AND status_aktif = 1"), 'primary'];
    $kartu[] = ['Total Pelanggaran', ambil_angka($koneksi, "SELECT COUNT(*) FROM t_pelanggaran_siswa WHERE kelas_id = $kelas_id"), 'danger'];
    $kartu[] = ['Total Poin',        ambil_angka($koneksi, "SELECT COALESCE(SUM(poin),0) FROM t_pelanggaran_siswa WHERE kelas_id = $kelas_id"), 'warning'];
    $kartu[] = ['Belum Ada Tindakan', ambil_angka($koneksi, "SELECT COUNT(*) FROM t_pelanggaran_siswa WHERE kelas_id = $kelas_id AND TRIM(tindakan) = ''"), 'secondary'];
} else {
    // Guru biasa: ringkasan seluruh pelanggaran
    $kartu[] = ['Total Pelanggaran',  ambil_angka($koneksi, "SELECT COUNT(*) FROM t_pelanggaran_siswa"), 'danger'];
    $kartu[] = ['Total Poin',         ambil_angka($koneksi, "SELECT COALESCE(SUM(poin),0) FROM t_pelanggaran_siswa"), 'warning'];
    $kartu[] = ['Belum Ada Tindakan', ambil_angka($koneksi, "SELECT COUNT(*) FROM t_pelanggaran_siswa WHERE TRIM(tindakan) = ''"), 'secondary'];
}

// Guru yang sekaligus wali kelas
$label_role = ($role === 'guru' && !empty($_SESSION['is_wali_kelas']))
    ? 'guru (wali kelas)'
    : $role;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include "layout/sidebar.php"; ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-3">Dashboard</h2>

            <!-- Info pengguna -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <p class="mb-1">Selamat datang, <b><?= htmlspecialchars($nama); ?></b></p>
                    <p class="mb-1 text-muted">Email: <?= htmlspecialchars($email); ?></p>
                    <p class="mb-0 text-muted">Role: <span class="badge bg-primary"><?= htmlspecialchars($label_role); ?></span></p>
                </div>
            </div>

            <?php if ($judul_info !== '') { ?>
                <p class="text-muted"><?= htmlspecialchars($judul_info); ?></p>
            <?php } ?>

            <div class="row">
                <?php foreach ($kartu as $k) { ?>
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card shadow-sm border-start border-<?= $k[2]; ?> border-4">
                            <div class="card-body">
                                <h6 class="text-muted"><?= htmlspecialchars($k[0]); ?></h6>
                                <h2 class="mb-0"><?= number_format($k[1], 0, ',', '.'); ?></h2>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </main>

    </div>
</div>

</body>
</html>
