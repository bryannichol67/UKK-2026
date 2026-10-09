<?php
require_once 'cek_akses.php';
require_once 'koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_jenis_pelanggaran.php';
proses_halaman($koneksi, 't_pelanggaran', $opsi, 'tambah');
