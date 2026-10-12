<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_penempatan_siswa.php';
halaman_form($koneksi, 't_kelas_siswa', $opsi, 'ubah');
