<?php
session_start();
require_once "config/koneksi.php";

// Pastikan form login dikirim dengan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

// Ambil input dari form
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Periksa input kosong
if ($email === '' || $password === '') {
    $_SESSION['pesan_error'] = "Email dan password wajib diisi.";
    header("Location: login.php");
    exit;
}

// Cari akun berdasarkan email
$sql = "SELECT id, name, email, password, role
        FROM t_users
        WHERE email = ?
        LIMIT 1";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    $_SESSION['pesan_error'] = "Terjadi kesalahan sistem.";
    header("Location: login.php");
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

mysqli_stmt_bind_result(
    $stmt,
    $id,
    $nama,
    $email_db,
    $password_db,
    $role
);

// Periksa apakah akun ditemukan
if (!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);

    $_SESSION['pesan_error'] = "Email atau password salah.";
    header("Location: login.php");
    exit;
}

mysqli_stmt_close($stmt);

// Verifikasi password
if (!password_verify($password, $password_db)) {
    $_SESSION['pesan_error'] = "Email atau password salah.";
    header("Location: login.php");
    exit;
}

// Normalisasi role
$role = strtolower(trim($role));

// Batasi role yang diperbolehkan
if (!in_array($role, ['admin', 'guru'], true)) {
    $_SESSION['pesan_error'] = "Role akun tidak diizinkan.";
    header("Location: login.php");
    exit;
}

// Buat session baru setelah login berhasil
session_regenerate_id(true);

$_SESSION['login'] = true;
$_SESSION['user_id'] = $id;
$_SESSION['nama'] = $nama;
$_SESSION['email'] = $email_db;
$_SESSION['role'] = $role;

// Cek apakah guru ini sedang menjadi wali kelas (tahun ajaran aktif)
$_SESSION['is_wali_kelas'] = false;
unset($_SESSION['guru_id'], $_SESSION['kelas_wali_id']);

if ($role === 'guru') {
    $sql_wali = "SELECT g.id AS guru_id, wk.kelas_id
                 FROM t_guru g
                 JOIN t_wali_kelas wk ON wk.guru_id = g.id AND wk.status_aktif = 1
                 JOIN t_tahun_ajaran ta ON ta.id = wk.tahun_ajaran_id AND ta.status_aktif = 1
                 WHERE g.user_id = ?
                 LIMIT 1";
    $stmt_wali = mysqli_prepare($koneksi, $sql_wali);
    if ($stmt_wali) {
        mysqli_stmt_bind_param($stmt_wali, "i", $id);
        mysqli_stmt_execute($stmt_wali);
        mysqli_stmt_bind_result($stmt_wali, $guru_id, $kelas_wali_id);
        if (mysqli_stmt_fetch($stmt_wali)) {
            $_SESSION['is_wali_kelas'] = true;
            $_SESSION['guru_id'] = $guru_id;
            $_SESSION['kelas_wali_id'] = $kelas_wali_id;
        }
        mysqli_stmt_close($stmt_wali);
    }
}

// Arahkan sesuai role
if ($role === 'admin') {
    header("Location: dashboard.php");
    exit;
}

if ($role === 'guru') {
    header("Location: dashboard.php");
    exit;
}
?>
