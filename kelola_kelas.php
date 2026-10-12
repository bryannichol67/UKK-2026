<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_kelas.php';
mulai_sesi();
?>
<p><a href="dashboard.php">&larr; Kembali ke Dashboard</a></p>

<h2>Kelola Kelas</h2>
<?php crud($koneksi, 't_kelas', $opsi); ?>



