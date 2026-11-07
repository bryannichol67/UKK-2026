<?php
// Jalur lama dinonaktifkan: aturan revisi hanya ada di edit_wali_kelas.php
$id = (int) ($_GET["id"] ?? $_POST["id"] ?? 0);
header("Location: edit_wali_kelas.php?id=" . $id);
exit;
