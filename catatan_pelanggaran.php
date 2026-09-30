<?php
include "cek_akses.php";
cek_role(['guru']);
include "koneksi.php";
include "crud.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Catatan Pelanggaran</title>
</head>
<body>

    <h1>Catatan Pelanggaran</h1>
    <?php crud($koneksi, "t_pelanggaran_siswa", []); ?>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>

</body>
</html>
