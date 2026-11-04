<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
define('BOOTSTRAP_CSS', ''); // Bootstrap 5 sudah dipasang oleh layout/tambah_atas.php
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_penempatan_siswa.php';

$judul      = 'Tambah Penempatan Siswa';
$menu_aktif = 'penempatan_siswa.php';
include 'layout/tambah_atas.php';

halaman_form($koneksi, 't_kelas_siswa', $opsi, 'tambah');

include 'layout/tambah_bawah.php';
