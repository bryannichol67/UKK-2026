
<?php
include "config/koneksi.php";

// Email akun yang digunakan
$email = "user001@sekolah.test";

// Password baru
$password = password_hash("password", PASSWORD_DEFAULT);

// Perbarui password akun
$sql = "UPDATE t_users SET password='$password'
        WHERE email='$email'";

if (mysqli_query($koneksi, $sql)) {
    if (mysqli_affected_rows($koneksi) >= 0) {
        echo "Password berhasil diproses.<br>";
        echo "Email: user001@sekolah.test<br>";
        echo "Password: password";
    }
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>
