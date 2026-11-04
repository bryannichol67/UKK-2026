<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
define('BOOTSTRAP_CSS', ''); // Bootstrap 5 sudah dipasang oleh layout/tambah_atas.php
require_once 'crud.php';
cek_role(['guru']);

$opsi = require 'opsi_catatan_pelanggaran.php';

$judul      = 'Tambah Catatan Pelanggaran';
$menu_aktif = 'catat_pelanggaran.php';
include 'layout/tambah_atas.php';

halaman_form($koneksi, 't_pelanggaran_siswa', $opsi, 'tambah');

include 'layout/tambah_bawah.php';
