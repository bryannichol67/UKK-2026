<?php
require_once 'cek_akses.php';
require_once 'koneksi.php';
require_once 'crud.php';
cek_role(['guru']);

$opsi = require 'opsi_catatan_pelanggaran.php';
proses_halaman($koneksi, 't_pelanggaran_siswa', $opsi, 'ubah');
