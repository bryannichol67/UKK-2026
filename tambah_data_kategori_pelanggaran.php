<?php
require_once 'cek_akses.php';
require_once 'koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_kategori_pelanggaran.php';
halaman_form($koneksi, 't_pelanggaran_kategori', $opsi, 'tambah');
