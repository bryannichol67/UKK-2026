<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_ukk_sql_2026";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
