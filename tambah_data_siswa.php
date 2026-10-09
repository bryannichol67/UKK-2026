<?php
require_once 'cek_akses.php';
require_once 'koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_siswa.php';
halaman_form($koneksi, 't_siswa', $opsi, 'tambah');
