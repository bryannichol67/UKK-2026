<?php
require_once 'cek_akses.php';
require_once 'koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_penempatan_siswa.php';
mulai_sesi();
?>
<p><a href="dashboard.php">&larr; Kembali ke Dashboard</a></p>

<h2>Penempatan Siswa</h2>
<?php crud($koneksi, 't_kelas_siswa', $opsi); ?>
