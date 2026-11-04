<?php
$judul = 'Kelola Siswa';
$menu_aktif = 'kelola_siswa';
include 'layout/header.php';
?>

<div class="bi-panel">
  <h1 class="bi-title">Kelola Siswa</h1>
  <p class="bi-sub">Tambah, ubah, dan hapus data siswa.</p>

  <div class="row g-3">
    <div class="col-md-4"><div class="bi-stat"><div class="angka">120</div><div class="ket">Total siswa</div></div></div>
    <div class="col-md-4"><div class="bi-stat"><div class="angka">8</div><div class="ket">Kelas aktif</div></div></div>
    <div class="col-md-4"><div class="bi-stat"><div class="angka">14</div><div class="ket">Pelanggaran bulan ini</div></div></div>
  </div>
</div>

<div class="bi-panel">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h5 m-0">Daftar siswa</h2>
    <a href="tambah_siswa.php" class="btn btn-primary">Tambah siswa</a>
  </div>

  <div class="table-responsive">
    <table class="table bi-table">
      <thead><tr><th>NIS</th><th>Nama</th><th>Kelas</th><th>Poin</th><th class="text-end">Aksi</th></tr></thead>
      <tbody>
        <tr>
          <td>2026001</td><td>Contoh Siswa</td><td>X RPL 1</td>
          <td><span class="badge-poin">10</span></td>
          <td class="text-end">
            <a href="edit_siswa.php?id=1" class="btn btn-light btn-sm">Edit</a>
            <a href="#" class="btn btn-danger btn-sm">Hapus</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="bi-panel">
  <h2 class="h5 mb-3">Form contoh</h2>
  <form class="row g-3">
    <div class="col-md-6"><label class="form-label">Nama siswa</label><input class="form-control" placeholder="Nama lengkap"></div>
    <div class="col-md-6"><label class="form-label">Kelas</label>
      <select class="form-select"><option>X RPL 1</option><option>X RPL 2</option></select></div>
    <div class="col-12 text-center"><button type="button" class="btn btn-primary">Simpan</button></div>
  </form>
</div>

<?php include 'layout/footer.php'; ?>
