<?php
// layout/tambah_atas.php
// Pembungkus halaman "Tambah Data": sidebar + judul + kartu form.
// Dipasang di semua tambah_data_*.php. Pasangannya: layout/tambah_bawah.php
//
// Diisi oleh halaman sebelum file ini dipanggil:
//   $judul      judul halaman                          (mis. 'Tambah Siswa')
//   $menu_aktif menu sidebar yang ditandai aktif       (mis. 'kelola_siswa.php')
// Boleh diisi (opsional):
//   $deskripsi  kalimat di bawah judul
//   $lebar      true = kartu form lebih lebar (form 2 kolom)
$judul      = $judul ?? 'Tambah Data';
$menu_aktif = $menu_aktif ?? '';
$deskripsi  = $deskripsi ?? 'Lengkapi formulir di bawah ini, lalu klik Simpan.';
$lebar      = !empty($lebar);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($judul) ?></title>

    <!-- Bootstrap 5 (sama seperti halaman kelola_*) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Style halaman tambah data -->
    <link href="assets/css/tambah_data.css" rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php
        // sidebar.php menandai menu aktif dari nama file halaman. Halaman tambah
        // tidak ada di menu, jadi sementara dianggap sebagai halaman induknya.
        $php_self_asli = $_SERVER['PHP_SELF'];
        if ($menu_aktif !== '') { $_SERVER['PHP_SELF'] = $menu_aktif; }
        include 'layout/sidebar.php';
        $_SERVER['PHP_SELF'] = $php_self_asli;
        ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <div class="td-head">
                <h1><?= htmlspecialchars($judul) ?></h1>
                <p class="td-sub"><?= htmlspecialchars($deskripsi) ?></p>
            </div>

            <div class="td-card<?= $lebar ? ' td-lebar' : '' ?>">
