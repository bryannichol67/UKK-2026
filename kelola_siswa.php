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
    <title>Kelola Siswa</title>
</head>
<body>

    <h1>Kelola Siswa</h1>
    <?php crud($koneksi, "t_siswa", []); ?>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>

</body>
</html>
