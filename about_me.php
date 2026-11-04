
<?php
session_start();
include "config/koneksi.php";

// Data diri
$nama = "Julianda Dharma Pangestu";
$kelas = "XII RPL 1";
$sekolah = "SMK Muhammadiyah Tasikmalaya";
$jurusan = "Rekayasa Perangkat Lunak";
$hobi = "Berenang, Tidur, dan Makan";
$cita_cita = "Pengusaha";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Saya</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <?php include "layout/sidebar.php"; ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <!-- HEADER -->
            <div class="p-4 rounded-4 text-white shadow mb-4"
                 style="background: linear-gradient(135deg, #0d6efd, #20c997);">
                <h2 class="fw-bold">👨‍💻 Tentang Saya</h2>
                <p class="mb-0">Kenali diri saya, hobi, dan cita-cita saya.</p>
            </div>

            <!-- PROFIL -->
            <div class="card border-0 shadow-sm rounded-4 text-center mb-4">
                <div class="card-body p-4">

                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width: 100px; height: 100px; font-size: 45px;">
                        J
                    </div>

                    <h3 class="fw-bold"><?= htmlspecialchars($nama); ?></h3>

                    <p class="text-secondary">
                        <?= htmlspecialchars($kelas); ?> |
                        <?= htmlspecialchars($jurusan); ?>
                    </p>

                    <span class="badge bg-primary">Pelajar</span>
                    <span class="badge bg-success">Calon Pengusaha</span>

                    <p class="mt-3 mb-0">
                        "Terus berusaha, berani bermimpi, dan jangan menyerah."
                    </p>

                </div>
            </div>

            <!-- INFORMASI DIRI -->
            <h4 class="fw-bold mb-3">📋 Informasi Diri</h4>

            <div class="row g-3 mb-4">

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <h5>👤 Nama Lengkap</h5>
                            <p class="text-secondary mb-0">
                                <?= htmlspecialchars($nama); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <h5>🎓 Kelas</h5>
                            <p class="text-secondary mb-0">
                                <?= htmlspecialchars($kelas); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <h5>🏫 Sekolah</h5>
                            <p class="text-secondary mb-0">
                                <?= htmlspecialchars($sekolah); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <h5>💻 Jurusan</h5>
                            <p class="text-secondary mb-0">
                                <?= htmlspecialchars($jurusan); ?>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- HOBI DAN CITA-CITA -->
            <div class="row g-3 mb-4">

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <h4 class="fw-bold">🏊 Hobi Saya</h4>
                            <p class="text-secondary mb-0">
                                <?= htmlspecialchars($hobi); ?>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <h4 class="fw-bold">💼 Cita-Cita</h4>

                            <p class="text-secondary">
                                Saya bercita-cita menjadi
                                <strong class="text-primary">
                                    <?= htmlspecialchars($cita_cita); ?>
                                </strong>.
                            </p>

                            <p class="mb-0">
                                Saya ingin membangun usaha sendiri,
                                menjadi pribadi yang mandiri dan bertanggung jawab,
                                serta membuka peluang kerja bagi orang lain.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- CERITA SAYA -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold">🙋 Cerita Tentang Saya</h4>

                    <p class="text-secondary">
                        Halo! Saya <?= htmlspecialchars($nama); ?>,
                        siswa kelas <?= htmlspecialchars($kelas); ?>
                        di <?= htmlspecialchars($sekolah); ?>.
                        Saya mengambil jurusan Rekayasa Perangkat Lunak
                        dan sedang belajar tentang teknologi serta pembuatan website.
                    </p>

                    <p class="text-secondary mb-0">
                        Saya ingin terus menambah ilmu dan pengalaman
                        agar dapat mengembangkan usaha sendiri di masa depan.
                        Saya percaya bahwa kerja keras, disiplin, dan kemauan
                        untuk belajar merupakan langkah penting untuk meraih kesuksesan.
                    </p>
                </div>
            </div>

            <!-- TOMBOL KEMBALI -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <p class="text-secondary mb-0">
                    Terima kasih sudah berkunjung! 💙
                </p>

                <a href="dashboard.php" class="btn btn-primary rounded-pill px-4">
                    ← Kembali ke Dashboard
                </a>
            </div>

            <!-- FOOTER -->
            <footer class="text-center text-secondary border-top mt-4 pt-3">
                &copy; 2026 <?= htmlspecialchars($nama); ?> |
                XII RPL 1 💙
            </footer>

        </main>
    </div>
</div>

</body>
</html>
```