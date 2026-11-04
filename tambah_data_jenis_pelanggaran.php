<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
define('BOOTSTRAP_CSS', ''); // Bootstrap 5 sudah dipasang oleh layout/tambah_atas.php
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_jenis_pelanggaran.php';

$judul      = 'Tambah Jenis Pelanggaran';
$menu_aktif = 'kelola_jenis_pelanggaran.php';
include 'layout/tambah_atas.php';

halaman_form($koneksi, 't_pelanggaran', $opsi, 'tambah');

include 'layout/tambah_bawah.php';
