<?php
include "cek_akses.php";
cek_role(['admin']);
include "koneksi.php";
include "crud.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Penempatan Siswa</title>
</head>
<body>

    <h1>Penempatan Siswa</h1>
    <?php crud($koneksi, "t_kelas_siswa", []); ?>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>

</body>
</html>
