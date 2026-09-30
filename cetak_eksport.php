<?php
include "cek_akses.php";
cek_role(['admin']);
include "koneksi.php";

// Eksport CSV (bisa dibuka di Excel)
if (isset($_GET['csv'])) {
    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=catatan_pelanggaran.csv");
    $out = fopen("php://output", "w");
    fputcsv($out, ['Tanggal', 'Nama Siswa', 'Kelas', 'Pelanggaran', 'Poin', 'Tindakan', 'Guru']);
    $q = mysqli_query($koneksi, "SELECT tanggal, nama_siswa, nama_kelas, nama_pelanggaran, poin, tindakan, nama_guru FROM t_pelanggaran_siswa ORDER BY tanggal DESC");
    while ($r = mysqli_fetch_row($q)) { fputcsv($out, $r); }
    exit;
}
$data = mysqli_query($koneksi, "SELECT tanggal, nama_siswa, nama_kelas, nama_pelanggaran, poin FROM t_pelanggaran_siswa ORDER BY tanggal DESC LIMIT 100");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Cetak / Eksport</title>
</head>
<body>

    <h1>Cetak / Eksport</h1>
    <p>
        <button onclick="window.print()">Cetak</button>
        <a href="cetak_eksport.php?csv=1">Download CSV</a>
    </p>
    <table class="tabel-data">
        <tr><th>Tanggal</th><th>Nama</th><th>Kelas</th><th>Pelanggaran</th><th>Poin</th></tr>
        <?php while ($r = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?php echo $r['tanggal']; ?></td>
                <td><?php echo htmlspecialchars($r['nama_siswa']); ?></td>
                <td><?php echo htmlspecialchars($r['nama_kelas']); ?></td>
                <td><?php echo htmlspecialchars($r['nama_pelanggaran']); ?></td>
                <td><?php echo $r['poin']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>

</body>
</html>
