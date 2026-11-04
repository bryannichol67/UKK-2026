<?php
// Memeriksa session login
include "includes/cek_session.php";

// Mengambil data pengguna
$nama  = $_SESSION['nama'] ?? $_SESSION['nama_lengkap'] ?? 'Pengguna';
$email = $_SESSION['email'] ?? '-';
$role  = $_SESSION['role'] ?? '-';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include "layout/sidebar.php"; ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-3">Dashboard</h2>

            <!-- Info pengguna -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <p class="mb-1">Selamat datang, <b><?= htmlspecialchars($nama); ?></b></p>
                    <p class="mb-1 text-muted">Email: <?= htmlspecialchars($email); ?></p>
                    <p class="mb-0 text-muted">Role: <span class="badge bg-primary"><?= htmlspecialchars($role); ?></span></p>
                </div>
            </div>

            <div class="row">
                <!-- CARD DATA SISWA -->
                <div class="col-12 col-md-4 mb-3">
                    <div class="card shadow-sm border-start border-primary border-4">
                        <div class="card-body">
                            <h6 class="text-muted">Data Siswa</h6>
                            <h2 class="mb-0">120</h2>
                        </div>
                    </div>
                </div>

                <!-- CARD DATA GURU -->
                <div class="col-12 col-md-4 mb-3">
                    <div class="card shadow-sm border-start border-success border-4">
                        <div class="card-body">
                            <h6 class="text-muted">Data Guru</h6>
                            <h2 class="mb-0">25</h2>
                        </div>
                    </div>
                </div>

                <!-- CARD KELAS -->
                <div class="col-12 col-md-4 mb-3">
                    <div class="card shadow-sm border-start border-warning border-4">
                        <div class="card-body">
                            <h6 class="text-muted">Kelas</h6>
                            <h2 class="mb-0">12</h2>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>

</body>
</html>
