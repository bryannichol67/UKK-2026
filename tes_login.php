<?php
require_once "config/koneksi.php";

$r = mysqli_query($koneksi, "SELECT DATABASE() AS db");
echo "Database yang dipakai: " . mysqli_fetch_assoc($r)['db'] . "<br>";

$email = "user006@sekolah.test";
$pass  = "password";

$stmt = mysqli_prepare($koneksi, "SELECT password FROM t_users WHERE email = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $hash);

if (!mysqli_stmt_fetch($stmt)) {
    echo "Email TIDAK ditemukan";
} else {
    echo "Email ditemukan<br>";
    echo "password_verify: " . (password_verify($pass, $hash) ? "COCOK" : "TIDAK COCOK");
}