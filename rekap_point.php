<?php
include "cek_akses.php";
cek_role(['guru']);
include "koneksi.php";
$data = mysqli_query($koneksi, "SELECT nama_siswa, nama_kelas, COUNT(*) AS jumlah, SUM(poin) AS total_poin
    FROM t_pelanggaran_siswa GROUP BY siswa_id, nama_siswa, nama_kelas ORDER BY total_poin DESC LIMIT 100");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Rekap Point</title>
</head>
<body>

    <h1>Rekap Point</h1>
    <table class="tabel-data">
        <tr><th>No</th><th>Nama</th><th>Kelas</th><th>Jumlah Pelanggaran</th><th>Total Poin</th></tr>
        <?php $no = 1; while ($r = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($r['nama_siswa']); ?></td>
                <td><?php echo htmlspecialchars($r['nama_kelas']); ?></td>
                <td><?php echo $r['jumlah']; ?></td>
                <td><?php echo $r['total_poin']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>

</body>
</html>
