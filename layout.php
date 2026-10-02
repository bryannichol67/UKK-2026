<?php
// layout.php - membungkus setiap halaman dengan sidebar + topbar (sesuai desain).
// Dipanggil sekali dari cek_akses.php, jadi file halaman lain tidak perlu diubah.

function ikon_menu($file) {
    $p = [
        'dashboard'  => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/>',
        'siswa'      => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.9"/><path d="M16 3.1a4 4 0 0 1 0 7.8"/>',
        'guru'       => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'catatan'    => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
        'riwayat'    => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        'rekap'      => '<path d="M18 20V10M12 20V4M6 20v-6"/>',
        'laporan'    => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8"/>',
        'kelas'      => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>',
    ];
    foreach ($p as $kunci => $isi) {
        if (strpos($file, $kunci) !== false) { return $isi; }
    }
    return $p['kelas'];
}

ob_start(function ($html) {
    global $daftar_menu;
    // Lewati jika belum login, bukan halaman HTML, atau tanpa style.css (mis. halaman cetak)
    if (empty($_SESSION['role']) || stripos($html, '<body') === false || strpos($html, 'style.css') === false) {
        return $html;
    }

    $role  = $_SESSION['role'];
    $nama  = htmlspecialchars($_SESSION['name'] ?? '');
    $label = ['admin' => 'Administrator', 'guru' => 'Guru', 'wali_kelas' => 'Wali Kelas'][$role] ?? ucfirst($role);
    if ($role === 'guru' && !empty($_SESSION['wali_kelas'])) { $label .= ' / Wali Kelas'; }

    $aktif = basename($_SERVER['PHP_SELF']);
    if ($aktif === 'tindakan.php') { $aktif = 'catatan_pelanggaran.php'; } // Tindakan bagian dari Catatan

    $menu = [['Dashboard', 'dashboard.php']];
    foreach (($daftar_menu ?? []) as $m) {
        if (function_exists('punya_role') && punya_role($m[2]) && $m[1] !== 'tindakan.php') {
            $menu[] = [$m[0], $m[1]];
        }
    }

    $nav = '';
    foreach ($menu as $m) {
        $nav .= '<a href="' . $m[1] . '"' . ($aktif === $m[1] ? ' class="aktif"' : '') . '>'
              . '<svg viewBox="0 0 24 24" aria-hidden="true">' . ikon_menu($m[1]) . '</svg>'
              . '<span>' . htmlspecialchars($m[0]) . '</span></a>';
    }

    // Logo placeholder: ganti blok .logo-gambar dengan <img src="logo.png"> jika punya logo sendiri
    $sisi = '<aside class="sisi"><div class="logo"><div class="logo-gambar">SP</div>'
          . '<b>Sistem Pelanggaran Siswa</b></div><nav class="nav">' . $nav . '</nav>'
          . '<a class="keluar" href="logout.php"><svg viewBox="0 0 24 24" aria-hidden="true">'
          . '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg><span>Logout</span></a></aside>';

    $atas = '<header class="topbar"><span>Selamat datang kembali!</span><div class="akun">'
          . '<div class="avatar">' . strtoupper(substr($nama, 0, 1)) . '</div>'
          . '<div><b>' . $nama . '</b><small>' . htmlspecialchars($label) . '</small></div></div></header>';

    return preg_replace_callback('/<body([^>]*)>(.*)<\/body>/is', function ($m) use ($sisi, $atas) {
        return '<body' . $m[1] . '><div class="app">' . $sisi . '<div class="isi">' . $atas
             . '<main>' . $m[2] . '</main></div></div></body>';
    }, $html, 1);
});
