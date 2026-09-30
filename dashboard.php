<?php
include "cek_akses.php";
include "koneksi.php";

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
    </ul>

</body>
</html>
