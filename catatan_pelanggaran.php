<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
require_once 'crud.php';
cek_role(['guru']);

$opsi = require 'opsi_catatan_pelanggaran.php';
mulai_sesi();
?>
<h2>Catatan Pelanggaran</h2>
<?php crud($koneksi, 't_pelanggaran_siswa', $opsi); ?>
