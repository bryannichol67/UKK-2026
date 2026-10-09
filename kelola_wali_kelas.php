<?php
require_once 'cek_akses.php';
require_once 'koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_wali_kelas.php';
mulai_sesi();
?>
<p><a href="dashboard.php">&larr; Kembali ke Dashboard</a></p>

<h2>Kelola Wali Kelas</h2>
<?php crud($koneksi, 't_wali_kelas', $opsi); ?>
