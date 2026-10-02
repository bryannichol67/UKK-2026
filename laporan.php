<?php
include "cek_akses.php";
cek_role(['admin', 'wali_kelas']);
include "koneksi.php";
include "crud.php";

$aksi = $_GET['aksi'] ?? '';

// ===== EKSPOR (CSV, bisa dibuka di Excel) =====
if ($aksi == 'ekspor') {
    $hasil = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_siswa");

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="laporan_pelanggaran_siswa_' . date('Ymd') . '.csv"');

    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF"); // BOM supaya karakter tampil benar di Excel

    $kolom = [];
    foreach (mysqli_fetch_fields($hasil) as $f) {
        $kolom[] = $f->name;
    }
    fputcsv($out, $kolom, ';');

    while ($baris = mysqli_fetch_row($hasil)) {
        fputcsv($out, $baris, ';');
    }
    fclose($out);
    exit;
}

// ===== CETAK (halaman bersih, langsung membuka dialog print) =====
if ($aksi == 'cetak') {
    $hasil = mysqli_query($koneksi, "SELECT * FROM t_pelanggaran_siswa");
    $fields = mysqli_fetch_fields($hasil);
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Pelanggaran Siswa</title>
</head>
<body onload="window.print()">

    <h2>Laporan Pelanggaran Siswa</h2>
    <p>Dicetak pada: <?php echo date('d-m-Y H:i'); ?></p>

    <table border="1" cellpadding="4" cellspacing="0">
        <tr>
            <?php foreach ($fields as $f) { ?>
                <th><?php echo htmlspecialchars($f->name); ?></th>
            <?php } ?>
        </tr>
        <?php while ($baris = mysqli_fetch_row($hasil)) { ?>
            <tr>
                <?php foreach ($baris as $nilai) { ?>
                    <td><?php echo htmlspecialchars((string)$nilai); ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>

</body>
</html>
    <?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Laporan</title>
</head>
<body>

    <h1>Laporan</h1>

    <p>
        <a href="laporan.php?aksi=cetak" target="_blank">Cetak</a> |
        <a href="laporan.php?aksi=ekspor">Ekspor (Excel/CSV)</a>
    </p>

    <?php crud($koneksi, "t_pelanggaran_siswa", ['readonly' => true]); ?>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>

</body>
</html>
