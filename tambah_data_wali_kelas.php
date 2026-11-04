<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
define('BOOTSTRAP_CSS', ''); // Bootstrap 5 sudah dipasang oleh layout/tambah_atas.php
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_wali_kelas.php';

$judul      = 'Tambah Wali Kelas';
$menu_aktif = 'kelola_wali_kelas.php';
include 'layout/tambah_atas.php';

halaman_form($koneksi, 't_wali_kelas', $opsi, 'tambah');

include 'layout/tambah_bawah.php';
