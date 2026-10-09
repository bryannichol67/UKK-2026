<?php
// Kerangka halaman (sidebar + topbar). Cara pakai di sebuah halaman:
//   $judul = 'Data Siswa';
//   include 'layout_atas.php';
//   ... isi halaman ...
//   include 'layout_bawah.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$judul     = $judul ?? '';
$menuAktif = $menuAktif ?? basename($_SERVER['PHP_SELF']);

// Role bisa satu (teks) atau banyak (array / dipisah koma)
$roles = $_SESSION['roles'] ?? ($_SESSION['role'] ?? []);
if (!is_array($roles)) { $roles = array_filter(array_map('trim', preg_split('/[,;]/', (string) $roles))); }

$namaUser = 'Pengguna';
foreach (['nama', 'nama_lengkap', 'nama_guru', 'nama_user', 'username'] as $kunci) {
    if (!empty($_SESSION[$kunci])) { $namaUser = $_SESSION[$kunci]; break; }
}

// [ikon, label, file, role yang boleh melihat (kosong = semua)]
$menu = [
    ['🏠', 'Dashboard',                   'dashboard.php',                   []],
    ['👥', 'Kelola Siswa',                'kelola_siswa.php',                ['admin']],
    ['👤', 'Kelola Guru',                 'kelola_guru.php',                 ['admin']],
    ['🏫', 'Kelola Kelas',                'kelola_kelas.php',                ['admin']],
    ['📅', 'Kelola Tahun Ajaran',         'kelola_tahun_ajaran.php',         ['admin']],
    ['🔀', 'Penempatan Siswa',            'penempatan_siswa.php',            ['admin']],
    ['🧑‍🏫', 'Kelola Wali Kelas',          'kelola_wali_kelas.php',           ['admin']],
    ['🗂️', 'Kategori Pelanggaran',        'kelola_kategori_pelanggaran.php', ['admin']],
    ['⚖️', 'Jenis Pelanggaran',           'kelola_jenis_pelanggaran.php',    ['admin']],
    ['✍️', 'Catatan Pelanggaran',         'catatan_pelanggaran.php',         ['guru']],
    ['🕘', 'Riwayat',                     'riwayat.php',                     []],
    ['❗', 'Rekap Point',                 'rekap_point.php',                 ['guru']],
    ['📄', 'Laporan',                     'laporan.php',                     ['admin', 'wali_kelas']],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($judul !== '' ? $judul : 'Bimbingan Insani') ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="logo"><img src="logo.png" alt="Bimbingan Insani"></div>
        <nav class="menu">
            <?php foreach ($menu as $m):
                if ($roles && $m[3] && !array_intersect($roles, $m[3])) { continue; } ?>
                <a href="<?= $m[2] ?>" class="<?= $menuAktif === $m[2] ? 'aktif' : '' ?>">
                    <span class="ikon"><?= $m[0] ?></span><?= htmlspecialchars($m[1]) ?>
                </a>
            <?php endforeach; ?>
        </nav>
        <a class="logout" href="logout.php">Logout</a>
    </aside>

    <main class="konten">
        <header class="topbar">
            <span>Selamat datang kembali !</span>
            <div class="user">
                <div class="avatar"><?= htmlspecialchars(strtoupper(substr($namaUser, 0, 1))) ?></div>
                <div>
                    <b><?= htmlspecialchars($namaUser) ?></b><br>
                    <small><?= htmlspecialchars(ucwords(str_replace('_', ' ', implode(', ', $roles)))) ?></small>
                </div>
            </div>
        </header>
        <?php if ($judul !== ''): ?>
            <h1 class="judul"><?= htmlspecialchars($judul) ?></h1>
        <?php endif; ?>
