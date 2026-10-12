<?php
session_start();
include "config/koneksi.php";

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email === "" || $password === "") {
        $error = "Email dan password wajib diisi.";
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT id, name, email, password, role FROM t_users WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $user  = mysqli_fetch_assoc($hasil);

        // Password di t_users disimpan dalam bentuk hash bcrypt
        $cocok = false;
        if ($user) {
            $cocok = password_verify($password, $user['password']);
        }

        if ($cocok) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['email']   = $user['email'];
            $_SESSION['role']    = $user['role'];

            // Guru yang terdaftar aktif di t_wali_kelas dianggap juga wali kelas
            $_SESSION['wali_kelas'] = false;
            if ($user['role'] === 'guru') {
                $cek = mysqli_prepare($koneksi, "SELECT 1 FROM t_wali_kelas w JOIN t_guru g ON g.id = w.guru_id WHERE g.user_id = ? AND w.status_aktif = 1 LIMIT 1");
                mysqli_stmt_bind_param($cek, "i", $user['id']);
                mysqli_stmt_execute($cek);
                $_SESSION['wali_kelas'] = mysqli_num_rows(mysqli_stmt_get_result($cek)) > 0;
            }
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Email atau password salah.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Login - Sistem Pelanggaran Siswa</title>
</head>
<body>

    <h1>Sistem Pelanggaran Siswa</h1>
    <h2>Login</h2>

    <?php if ($error !== "") { ?>
        <p><b><?php echo htmlspecialchars($error); ?></b></p>
    <?php } ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<form method="POST" action="login.php">
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
    
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>


    <!-- <form method="POST" action="login.php">
        <table>
            <tr>
                <td><label for="email">Email</label></td>
                <td>:</td>
                <td><input type="email" name="email" id="email" required></td>
            </tr>
            <tr>
                <td><label for="password">Password</label></td>
                <td>:</td>
                <td><input type="password" name="password" id="password" required></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><button type="submit">Login</button></td>
            </tr>
        </table>
    </form> -->

</body>
</html>
