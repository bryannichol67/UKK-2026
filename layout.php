<?php
// layout.php - sidebar menu yang SELALU tampil di semua halaman setelah login.
//
// Dipanggil otomatis dari cek_akses.php, jadi file halaman lain (kelola_*, tambah_*,
// edit_*, riwayat, laporan, dst.) tidak perlu diubah satu per satu. Hasil HTML halaman
// dibungkus: sidebar di kiri (tetap/fixed), isi halaman di kanan.
//
// CSS-nya berdiri sendiri (prefix "ls-"), jadi aman walau tiap halaman memakai
// versi Bootstrap yang berbeda.

// Halaman turunan (tambah/edit/proses) ikut menandai menu induknya sebagai aktif.
function layout_menu_aktif($file, $daftar) {
    $file = basename($file);
    foreach ($daftar as $m) {
        if ($m[1] === $file) { return $file; }
    }
    if (preg_match('/^(?:tambah_data|edit_data|proses_tambah|proses_edit)_(.+)\.php$/', $file, $x)) {
        foreach (["kelola_{$x[1]}.php", "{$x[1]}.php"] as $kandidat) {
            foreach ($daftar as $m) {
                if ($m[1] === $kandidat) { return $kandidat; }
            }
        }
    }
    return $file;
}

function layout_pasang() {
    global $daftar_menu;

    if (empty($_SESSION['user_id'])) { return; }

    // Halaman cetak / ekspor harus bersih, tanpa sidebar
    if (in_array($_GET['aksi'] ?? '', ['cetak', 'ekspor'], true)) { return; }

    // ---- Data menu dihitung sekarang (sesi masih pasti terbaca) ----
    $role  = $_SESSION['role'] ?? '';
    $nama  = (string) ($_SESSION['name'] ?? 'Pengguna');
    $label = ['admin' => 'Administrator', 'guru' => 'Guru', 'wali_kelas' => 'Wali Kelas'][$role] ?? ucfirst($role);
    if ($role === 'guru' && !empty($_SESSION['wali_kelas'])) { $label .= ' / Wali Kelas'; }

    $menu = [['Dashboard', 'dashboard.php']];
    foreach (($daftar_menu ?? []) as $m) {
        if (function_exists('punya_role') && punya_role($m[2])) {
            $menu[] = [$m[0], $m[1]];
        }
    }
    $aktif = layout_menu_aktif($_SERVER['PHP_SELF'], $menu);

    $nav = '';
    foreach ($menu as $m) {
        $nav .= '<a href="' . htmlspecialchars($m[1]) . '" class="ls-link' . ($aktif === $m[1] ? ' ls-aktif' : '') . '"'
              . ($aktif === $m[1] ? ' aria-current="page"' : '') . '>' . htmlspecialchars($m[0]) . '</a>';
    }

    $sidebar = '<button type="button" class="ls-toggle" aria-label="Buka menu" '
             . 'onclick="document.body.classList.toggle(\'ls-buka\')">&#9776;</button>'
             . '<div class="ls-overlay" onclick="document.body.classList.remove(\'ls-buka\')"></div>'
             . '<aside class="ls-sidebar">'
             . '<div class="ls-brand">Sistem Pelanggaran Siswa</div>'
             . '<div class="ls-user"><b>' . htmlspecialchars($nama) . '</b><small>' . htmlspecialchars($label) . '</small></div>'
             . '<nav class="ls-nav">' . $nav . '</nav>'
             . '<a href="logout.php" class="ls-link ls-keluar">Logout</a>'
             . '</aside>';

    $css = '<style id="ls-style">'
         . 'body.ls-body{margin:0}'
         . '.ls-sidebar{position:fixed;top:0;left:0;bottom:0;width:250px;z-index:1030;display:flex;flex-direction:column;'
         . 'background:#212529;color:#fff;overflow-y:auto;padding:16px 12px;box-sizing:border-box;font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif}'
         . '.ls-brand{font-size:1.15rem;font-weight:700;margin:0 6px 14px}'
         . '.ls-user{display:flex;flex-direction:column;margin:0 6px 14px;padding-bottom:14px;border-bottom:1px solid #495057;font-size:.9rem}'
         . '.ls-user small{color:#adb5bd}'
         . '.ls-nav{display:flex;flex-direction:column;gap:4px;flex:1}'
         . '.ls-link{display:block;padding:9px 12px;border-radius:6px;color:#fff;text-decoration:none;font-size:.95rem}'
         . '.ls-link:hover{background:#343a40;color:#fff;text-decoration:none}'
         . '.ls-link.ls-aktif{background:#0d6efd;color:#fff}'
         . '.ls-keluar{margin-top:12px;border-top:1px solid #495057;border-radius:0 0 6px 6px;color:#ff6b6b}'
         . '.ls-keluar:hover{color:#ff6b6b}'
         . '.ls-main{margin-left:250px;padding:24px;min-height:100vh;box-sizing:border-box}'
         . 'body.ls-body{background:#f4f6f9}'
         . '.ls-main h1,.ls-main h2{font-size:1.6rem;font-weight:700;color:#212529;margin:0 0 20px}'
         . '.ls-main .table-responsive{background:#fff;border-radius:10px;box-shadow:0 1px 3px rgba(0,0,0,.1);overflow:hidden}'
         . '.ls-main .table{margin-bottom:0;background:#fff}'
         . '.ls-main .table th,.ls-main .table td{vertical-align:middle;padding:12px 14px}'
         . '.ls-main .btn-sm{margin-right:4px}'
         . '.ls-main form{margin:0}'
         . '.ls-toggle,.ls-overlay{display:none}'
         . '@media(max-width:767.98px){'
         . '.ls-sidebar{transform:translateX(-100%);transition:transform .2s}'
         . 'body.ls-buka .ls-sidebar{transform:none}'
         . '.ls-main{margin-left:0;padding:64px 16px 24px}'
         . '.ls-toggle{display:block;position:fixed;top:10px;left:10px;z-index:1020;border:0;border-radius:6px;'
         . 'background:#212529;color:#fff;font-size:1.3rem;line-height:1;padding:8px 12px}'
         . 'body.ls-buka .ls-overlay{display:block;position:fixed;inset:0;z-index:1025;background:rgba(0,0,0,.45)}}'
         . '</style>';

    ob_start(function ($html) use ($sidebar, $css) {
        // Tidak ada isi (mis. redirect), bukan HTML (mis. CSV), atau sudah dibungkus -> biarkan apa adanya
        if (trim($html) === '' || strpos($html, 'ls-sidebar') !== false) { return $html; }
        foreach (headers_list() as $h) {
            if (stripos($h, 'Location:') === 0) { return $html; }
            if (stripos($h, 'Content-Type:') === 0 && stripos($h, 'text/html') === false) { return $html; }
        }

        if (preg_match('/<body([^>]*)>(.*)<\/body>/is', $html, $m, PREG_OFFSET_CAPTURE)) {
            // Halaman lengkap (punya <html>/<body>)
            $atribut = $m[1][0];
            if (preg_match('/class\s*=\s*(["\'])(.*?)\1/i', $atribut, $c)) {
                $atribut = str_replace($c[0], 'class=' . $c[1] . $c[2] . ' ls-body' . $c[1], $atribut);
            } else {
                $atribut .= ' class="ls-body"';
            }
            $baru = '<body' . $atribut . '>' . $sidebar . '<div class="ls-main">' . $m[2][0] . '</div></body>';
            $html = substr_replace($html, $baru, $m[0][1], strlen($m[0][0]));
            if (stripos($html, '</head>') !== false) {
                if (stripos($html, 'name="viewport"') === false && stripos($html, "name='viewport'") === false) {
                    $css = '<meta name="viewport" content="width=device-width, initial-scale=1">' . $css;
                }
                return preg_replace('/<\/head>/i', addcslashes($css, '\\$') . '</head>', $html, 1);
            }
            return $css . $html;
        }

        // Potongan HTML tanpa <body> (mis. halaman Kelola/tambah/edit) -> buat kerangka lengkap
        return '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8">'
             . '<meta name="viewport" content="width=device-width, initial-scale=1">'
             . '<title>Sistem Pelanggaran Siswa</title>' . $css . '</head>'
             . '<body class="ls-body">' . $sidebar . '<div class="ls-main">' . $html . '</div></body></html>';
    });
}

layout_pasang();
