<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_guru.php';
mulai_sesi();
?>
<h2>Kelola Guru</h2>


<?php crud($koneksi, 't_guru', $opsi); ?>

