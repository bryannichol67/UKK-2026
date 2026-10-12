<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_siswa.php';
mulai_sesi();

// Pesan hasil dari halaman proses (tambah/edit)
$pesan = $_SESSION['pesan'] ?? '';
unset($_SESSION['pesan']);

// Proses hapus
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'hapus') {
    $pesan = simpan_data($koneksi, 't_siswa', $opsi, 'hapus', $_POST)['pesan'];
}

// Kolom yang dipakai sebagai nama kelas dideteksi otomatis dari tabel t_kelas
$kolomKelas = nama_aman(kolom_nama_tampil($koneksi, 't_kelas'));

// Kelas diambil dari data kelas_siswa terbaru milik tiap siswa
$data = mysqli_query($koneksi,
    "SELECT s.id, s.nisn, s.nama, s.jenis_kelamin, s.tanggal_lahir, k.`$kolomKelas` AS kelas
    FROM t_siswa s
    LEFT JOIN t_kelas_siswa ks ON ks.id = (SELECT MAX(id) FROM t_kelas_siswa WHERE siswa_id = s.id)
    LEFT JOIN t_kelas k ON k.id = ks.kelas_id
    ORDER BY s.id DESC
    LIMIT 100");

function h($v) { return htmlspecialchars((string) $v); }
?>
<p><a href="dashboard.php">&larr; Kembali ke Dashboard</a></p>

<h2>Data Siswa</h2>

<p><a href="tambah_data_siswa.php">+ Tambah data</a></p>

<?php if ($pesan !== ''): ?>
    <p><b><?= h($pesan) ?></b></p>
<?php endif; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<table class="table">
    <thead class="thead-dark">
    <tr>
        <th>No</th>
        <th>NISN</th>
        <th>Nama</th>
        <th>JK</th>
        <th>Kelas</th>
        <th>Tanggal Lahir</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= h($row['nisn']) ?></td>
            <td><?= h($row['nama']) ?></td>
            <td><?= h($row['jenis_kelamin']) ?></td>
            <td><?= h($row['kelas']) ?></td>
            <td><?= $row['tanggal_lahir'] ? h(date('d-m-Y', strtotime($row['tanggal_lahir']))) : '' ?></td>
            <td>
                <form method="post" style="display:inline" onsubmit="return confirm('Hapus data ini?')">
                    <input type="hidden" name="aksi" value="hapus">
                    <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                    <button type="submit">Hapus</button>
                </form>
                <a href="edit_data_siswa.php?id=<?= (int) $row['id'] ?>">Edit</a>
            </td>
        </tr>
    <?php endwhile; ?>
    <?php if ($no === 1): ?>
        <tr><td colspan="7">Belum ada data.</td></tr>
    <?php endif; ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</table>