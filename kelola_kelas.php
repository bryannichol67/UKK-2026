<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_kelas.php';
mulai_sesi();
?>
<h2>Kelola Kelas</h2>
<?php crud($koneksi, 't_kelas', $opsi); ?>



