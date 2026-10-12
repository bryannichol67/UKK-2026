

<?php
include "cek_akses.php";
include "config/koneksi.php";

// Data kartu ringkasan
$jml_siswa       = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM t_siswa"))[0];
$jml_catatan     = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM t_pelanggaran_siswa"))[0];
$jml_pelanggaran = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM t_pelanggaran"))[0];

// Catatan bulan ini (maksimal 10 terbaru)
$catatan = mysqli_query($koneksi, "SELECT nama_siswa, nama_kelas, nama_pelanggaran
    FROM t_pelanggaran_siswa
    WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())
    ORDER BY tanggal DESC LIMIT 10");
?>



<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Dashboard</title>
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">
            <h4 class="text-white mb-4">
                My Website
            </h4>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link active">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_siswa.php" class="nav-link text-white">
                        Data Siswa
                    </a>
                </li>
                <li class="nav-item mb-2">  
                    <a href="kelola_guru.php" class="nav-link text-white">
                        Data Guru
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_kelas.php" class="nav-link text-white">
                        Kelas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="laporan.php" class="nav-link text-white">
                        Laporan
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_tahun_ajaran.php" class="nav-link text-white">
                        Tahun Ajaran
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="penempatan_siswa.php" class="nav-link text-white">
                        Penempatan Siswa
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_wali_kelas.php" class="nav-link text-white">
                        Wali Kelas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_kategori_pelanggaran.php" class="nav-link text-white">
                        Kategori Pelanggaran
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_jenis_pelanggaran.php" class="nav-link text-white">
                        Jenis-jenis Pelanggaran
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="pfrofile" class="nav-link text-white">
                        About Me
                    </a>
                </li>
                <hr class="text-secondary">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">
            <h2>Dashboard</h2>
            <p>
                Selamat datang di halaman dashboard.
            </p>
            <div class="row">
                <!-- CARD DATA SISWA -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                Data Siswa
                            </h5>
                            <h2>
                                120
                            </h2>
                        </div>
                    </div>
                </div>
                <!-- CARD DATA GURU -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                Data Guru
                            </h5>
                            <h2>
                                25
                            </h2>
                        </div>
                    </div>
                </div>
                <!-- CARD KELAS -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                Kelas
                            </h5>
                            <h2>
                             12
                          </h2>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
    <!-- <h2>Dashboard</h2>
    <p>
        Selamat datang,
        <?php echo $_SESSION['nama_user']; ?>
    </p>
    <p>
        Anda berhasil login.
    </p>
    <a href="logout.php">Logout</a>
</body>
</html>
 -->

<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard - Sistem Pelanggaran Siswa</title>
</head>
<body>

    <h1>Dashboard</h1>
    <p>Selamat datang, <b><?php echo htmlspecialchars($_SESSION['name']); ?></b> (<?php echo htmlspecialchars($_SESSION['role']); ?><?php echo !empty($_SESSION['wali_kelas']) ? ', wali kelas' : ''; ?>)</p>

    <div class="kartu-wrap">
        <div class="kartu kartu-siswa"><span>Siswa</span><b><?php echo number_format($jml_siswa, 0, ',', '.'); ?></b></div>
        <div class="kartu kartu-catatan"><span>Catatan</span><b><?php echo number_format($jml_catatan, 0, ',', '.'); ?></b></div>
        <div class="kartu kartu-pelanggaran"><span>Pelanggaran</span><b><?php echo number_format($jml_pelanggaran, 0, ',', '.'); ?></b></div>
    </div>

    <h2>Informasi catatan bulan ini</h2>
    <div class="tabel-wrap">
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Catatan</th>
            </tr>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($catatan)) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_pelanggaran']); ?></td>
                </tr>
            <?php } ?>
            <?php if ($no === 1) { ?>
                <tr><td colspan="4">Belum ada catatan bulan ini.</td></tr>
            <?php } ?>
        </table>
    </div>

    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>

        <?php foreach ($daftar_menu as $menu) { ?>
            <?php if (punya_role($menu[2])) { ?>
                <li><a href="<?php echo $menu[1]; ?>"><?php echo $menu[0]; ?></a></li>
            <?php } ?>
        <?php } ?>

        <li><a href="logout.php">Logout</a></li>
    </ul> -->

</body>
</html>
