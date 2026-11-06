<?php
// penempatan_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';
include_once 'includes/helper.php';
cek_role(['admin']);

// Ambil data penempatan siswa
$sql = "SELECT
            ks.id,
            s.nis,
            s.nama AS nama_siswa,
            ta.nama AS tahun_ajaran,
            k.nama AS nama_kelas,
            k.tingkat,
            k.jurusan,
            ks.tanggal_mulai,
            ks.tanggal_selesai,
            ks.status_aktif
        FROM t_kelas_siswa ks
        LEFT JOIN t_siswa s ON ks.siswa_id = s.id
        LEFT JOIN t_tahun_ajaran ta ON ks.tahun_ajaran_id = ta.id
        LEFT JOIN t_kelas k ON ks.kelas_id = k.id
        ORDER BY ks.id DESC";

$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Penempatan Siswa</title>

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

            <h1 class="mb-4">Penempatan Siswa</h1>

            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>
                <a href="tambah_penempatan_siswa.php" class="btn btn-primary">
                    + Tambah Penempatan
                </a>
            </div>

            <!-- Pesan sukses -->
            <?php if (isset($_SESSION['pesan_sukses'])) { ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['pesan_sukses']); ?>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['pesan_sukses']); ?>
            <?php } ?>

            <!-- Pesan error -->
            <?php if (isset($_SESSION['pesan_error'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['pesan_error']); ?>
            <?php } ?>

            <!-- TABEL DATA PENEMPATAN -->
            <div class="card shadow-sm">

                <div class="card-body">
                    <div class="table-responsive">

                        <table id="tabelPenempatan"
                               class="table table-striped table-bordered table-hover align-middle w-100">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Jurusan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($hasil)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>

                                        <td>
                                            <?= htmlspecialchars($row['nis'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['tahun_ajaran'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_kelas'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['tingkat'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['jurusan'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['tanggal_mulai'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= ($row['tanggal_selesai'] && $row['tanggal_selesai'] != '0000-00-00')
                                                ? htmlspecialchars($row['tanggal_selesai']) : '-'; ?>
                                        </td>

                                        <td>
                                            <?= badge_status($row['status_aktif']) ?>
                                        </td>

                                        <td class="text-center text-nowrap">
                                            <a href="edit_penempatan_siswa.php?id=<?= (int) $row['id']; ?>"
                                               class="btn btn-warning btn-sm">
                                                Edit
                                            </a>
                                            <a href="hapus_penempatan_siswa.php?id=<?= (int) $row['id']; ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus penempatan ini?');">
                                                Hapus
                                            </a>
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

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Pengaturan DataTables -->
<script>
$(document).ready(function () {
    $('#tabelPenempatan').DataTable({
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
            infoEmpty: "Tidak ada data penempatan siswa",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data penempatan siswa tidak ditemukan",
            emptyTable: "Belum ada data penempatan siswa",
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
            { targets: -1, orderable: false, searchable: false }
        ]
    });
});
</script>

</body>
</html>