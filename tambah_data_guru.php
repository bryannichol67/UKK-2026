<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
define('BOOTSTRAP_CSS', ''); // Bootstrap 5 sudah dipasang oleh layout/tambah_atas.php
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_guru.php';

$judul      = 'Tambah Guru';
$menu_aktif = 'kelola_guru.php';
include 'layout/tambah_atas.php';

halaman_form($koneksi, 't_guru', $opsi, 'tambah');

include 'layout/tambah_bawah.php';
