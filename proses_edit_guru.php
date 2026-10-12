<?php
require_once 'cek_akses.php';
require_once 'config/koneksi.php';
require_once 'crud.php';
cek_role(['admin']);

$opsi = require 'opsi_guru.php';
proses_halaman($koneksi, 't_guru', $opsi, 'ubah');
