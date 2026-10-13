<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_jenis_pelanggaran.php';
mulai_sesi();
?>
<h2>Kelola Jenis Pelanggaran</h2>



<?php crud($koneksi, 't_pelanggaran', $opsi); ?>


