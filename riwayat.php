<?php
include "cek_akses.php";
cek_role(['guru']);
include "config/koneksi.php";
include "crud.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Riwayat</title>
</head>
<body>

<h2>Riwayat</h2>
<?php crud($koneksi, 't_pelanggaran_siswa', ['readonly' => true]); ?>

</body>
</html>
