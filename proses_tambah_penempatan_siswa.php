<?php
require_once 'cek_akses.php';
require_once 'koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_penempatan_siswa.php';
proses_halaman($koneksi, 't_kelas_siswa', $opsi, 'tambah');
