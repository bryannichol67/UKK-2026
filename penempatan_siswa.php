<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_penempatan_siswa.php';
mulai_sesi();
?>
<h2>Penempatan Siswa</h2>
<?php crud($koneksi, 't_kelas_siswa', $opsi); ?>
