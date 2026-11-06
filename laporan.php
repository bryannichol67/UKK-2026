<?php
session_start();
include "config/koneksi.php";
include_once "includes/helper.php";

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Mengambil data laporan pelanggaran siswa.
// Kolom "Jenis Pelanggaran" diambil dari tabel jenis pelanggaran (t_pelanggaran),
// sama persis dengan yang tampil di halaman Kelola Jenis Pelanggaran.
$sql = "SELECT
            ps.id,
            s.nis,
            s.nama,
            p.nama AS pelanggaran
        FROM t_pelanggaran_siswa ps
        JOIN t_siswa s ON ps.siswa_id = s.id
        JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id
        ORDER BY ps.id DESC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Pelanggaran Siswa</title>

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

            <h1 class="mb-4">Laporan Pelanggaran Siswa</h1>

            <!-- Tombol Navigasi dan Laporan -->
            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>

                <a href="cetak_laporan.php" target="_blank" class="btn btn-primary">
                    Cetak Laporan
                </a>

                <a href="export_laporan.php" class="btn btn-success">
                    Export Excel
                </a>
            </div>

            <!-- TABEL LAPORAN -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelLaporan"
                               class="table table-striped table-bordered table-hover align-middle w-100">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Jenis Pelanggaran</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php $no = 1; while ($hasil && ($row = mysqli_fetch_assoc($hasil))) { ?>

                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nis'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['nama'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['pelanggaran'] ?? '') ?></td>
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

    $('#tabelLaporan').DataTable({

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
            infoEmpty: "Tidak ada data laporan pelanggaran",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data laporan pelanggaran tidak ditemukan",
            emptyTable: "Belum ada data laporan pelanggaran",

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
            { targets: 0, orderable: false, searchable: false }
        ]

    });

});
</script>

</body>
</html>
