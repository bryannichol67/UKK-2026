<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggaran Siswa</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Wrapper utama menggunakan d-flex, min-vh-100, dan justify-content-center serta align-items-center agar presisi di tengah -->
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row w-100 justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <!-- Card Container dengan jarak padding yang rapi dan simetris -->
                <div class="card shadow border-0 rounded-4 p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Login Aplikasi</h3>
                        <p class="text-muted small">Pelanggaran Siswa</p>
                    </div>

                    <!-- Pesan Error -->
                    <?php if (isset($_SESSION['pesan_error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                            <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                            <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['pesan_error']); ?>
                    <?php endif; ?>

                    <!-- Form Login -->
                    <form action="proses_login.php" method="POST" autocomplete="off">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="nama@email.com" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="••••••••" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2 fw-semibold">Login</button>
                        </div>
                    </form>

                </div>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>