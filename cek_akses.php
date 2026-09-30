<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Belum login -> kembali ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/*
  Daftar menu sesuai use case.
  Format: [nama menu, file halaman, role yang boleh akses]
  Role yang tersedia: admin, guru, wali_kelas
  (wali_kelas = akun guru yang terdaftar aktif di t_wali_kelas)
*/
$daftar_menu = [
    ['Kelola Siswa',               'kelola_siswa.php',               ['admin']],
    ['Kelola Guru',                'kelola_guru.php',                ['admin']],
    ['Kelola Kelas',               'kelola_kelas.php',               ['admin']],
    ['Kelola Tahun Ajaran',        'kelola_tahun_ajaran.php',        ['admin']],
    ['Penempatan Siswa',           'penempatan_siswa.php',           ['admin']],
    ['Kelola Wali Kelas',          'kelola_wali_kelas.php',          ['admin']],
    ['Kelola Kategori Pelanggaran','kelola_kategori_pelanggaran.php',['admin']],
    ['Kelola Jenis Pelanggaran',   'kelola_jenis_pelanggaran.php',   ['admin']],
    ['Catatan Pelanggaran',        'catatan_pelanggaran.php',        ['guru']],
    ['Tindakan',                   'tindakan.php',                   ['guru']],
    ['Riwayat',                    'riwayat.php',                    ['guru']],
    ['Rekap Point',                'rekap_point.php',                ['guru']],
    ['Laporan',                    'laporan.php',                    ['admin', 'wali_kelas']],
    ['Cetak / Eksport',            'cetak_eksport.php',              ['admin']],
];

// Apakah user yang login punya salah satu role ini?
function punya_role($role_diizinkan) {
    if (in_array($_SESSION['role'], $role_diizinkan)) {
        return true;
    }
    if (in_array('wali_kelas', $role_diizinkan) && !empty($_SESSION['wali_kelas'])) {
        return true;
    }
    return false;
}

// Panggil di awal setiap halaman menu. Jika tidak berhak -> "Akses ditolak"
function cek_role($role_diizinkan) {
    if (!punya_role($role_diizinkan)) {
        http_response_code(403);
        echo "<!DOCTYPE html><html lang='id'><head><meta charset='UTF-8'><title>Akses Ditolak</title><link rel='stylesheet' href='style.css'></head><body>";
        echo "<h1>Akses ditolak</h1>";
        echo "<p>Role Anda (" . htmlspecialchars($_SESSION['role']) . ") tidak boleh membuka halaman ini.</p>";
        echo "<p><a href='dashboard.php'>Kembali ke Dashboard</a></p>";
        echo "</body></html>";
        exit;
    }
}
