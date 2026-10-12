<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_wali_kelas.php';
proses_halaman($koneksi, 't_wali_kelas', $opsi, 'tambah');
