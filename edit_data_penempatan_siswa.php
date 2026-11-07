<?php
// Jalur lama dinonaktifkan: aturan revisi hanya ada di edit_penempatan_siswa.php
$id = (int) ($_GET["id"] ?? $_POST["id"] ?? 0);
header("Location: edit_penempatan_siswa.php?id=" . $id);
exit;
