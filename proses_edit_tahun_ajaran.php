<?php
// Jalur lama dinonaktifkan: aturan revisi hanya ada di edit_tahun_ajaran.php
$id = (int) ($_GET["id"] ?? $_POST["id"] ?? 0);
header("Location: edit_tahun_ajaran.php?id=" . $id);
exit;
