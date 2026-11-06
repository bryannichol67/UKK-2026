<?php
session_start();
include "config/koneksi.php";
include_once "includes/helper.php";

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Cek hak akses admin
if ($_SESSION['role'] != "admin") {
    echo "Akses ditolak!";
    exit;
}

// Mengambil data jenis pelanggaran beserta nama kategorinya
$sql = "SELECT p.*, k.nama AS nama_kategori
        FROM t_pelanggaran p
        LEFT JOIN t_pelanggaran_kategori k ON p.pelanggaran_kategori_id = k.id
        ORDER BY p.id DESC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Jenis Pelanggaran</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <h1 class="mb-4">Kelola Jenis Pelanggaran</h1>

            <!-- Tombol Navigasi -->
            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>

                <a href="tambah_jenis_pelanggaran.php" class="btn btn-primary">
                    + Tambah Jenis Pelanggaran
                </a>
            </div>

            <!-- TABEL DATA JENIS PELANGGARAN -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelJenisPelanggaran"
                               class="table table-striped table-bordered table-hover align-middle w-100">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Kode</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Deskripsi</th>
                                    <th>Status Aktif</th>
                                    <th>Dibuat</th>
                                    <th>Diubah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php $no = 1; while ($row = mysqli_fetch_assoc($hasil)) { ?>

                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama_kategori'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($row['kode'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['nama'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['poin'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['deskripsi'] ?? '') ?></td>
                                    <td><?= badge_status($row['status_aktif']) ?></td>
                                    <td><?= htmlspecialchars($row['created_at'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['updated_at'] ?? '') ?></td>

                                    <td>
                                        <div class="d-flex gap-2">

                                            <a href="edit_jenis_pelanggaran.php?id=<?= urlencode($row['id']) ?>"
                                               class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <a href="hapus_jenis_pelanggaran.php?id=<?= urlencode($row['id']) ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus jenis pelanggaran ini?');">
                                                Hapus
                                            </a>

                                        </div>
                                    </td>
                                </tr>

                            <?php } ?>

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<!-- DataTables Bootstrap 5 -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Inisialisasi DataTables -->
<script>
$(document).ready(function () {

    $('#tabelJenisPelanggaran').DataTable({

        // Nomor urut mengikuti urutan & halaman yang sedang tampil
        drawCallback: function () {
            var api = this.api();
            var mulai = api.page.info().start;
            api.column(0, { page: 'current' }).nodes().each(function (sel, i) {
                sel.innerHTML = mulai + i + 1;
            });
        },

        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data jenis pelanggaran",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data jenis pelanggaran tidak ditemukan",
            emptyTable: "Belum ada data jenis pelanggaran",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        // Urutan mengikuti data terbaru (sesuai query)
        order: [],

        columnDefs: [
            { targets: 0, orderable: false, searchable: false },
            { targets: 9, orderable: false, searchable: false }
        ]

    });

});
</script>

</body>
</html>
