<?php
// layout/sidebar.php
// Layar besar  : sidebar tetap di kiri
// Layar kecil  : top bar dengan ikon hamburger (☰) di kiri, menu geser dari kiri
$current_page = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'] ?? '';
$nama_user = $_SESSION['nama'] ?? $_SESSION['nama_lengkap'] ?? 'Pengguna';

// Daftar menu per role: 'file.php' => ['Label', 'ikon bootstrap-icons']
$daftar_menu = [
    'admin' => [
        'dashboard.php'                   => ['Dashboard', 'speedometer2'],
        'kelola_siswa.php'                => ['Data Siswa', 'mortarboard'],
        'kelola_guru.php'                 => ['Data Guru', 'person-badge'],
        'kelola_kelas.php'                => ['Data Kelas', 'door-open'],
        'kelola_tahun_ajaran.php'         => ['Data Tahun Ajaran', 'calendar3'],
        'kelola_wali_kelas.php'           => ['Data Wali Kelas', 'person-workspace'],
        'penempatan_siswa.php'            => ['Penempatan Siswa', 'diagram-3'],
        'kelola_pelanggaran_kategori.php' => ['Kategori Pelanggaran', 'tags'],
        'kelola_jenis_pelanggaran.php'    => ['Jenis Pelanggaran', 'list-check'],
        'Laporan.php'                     => ['Laporan', 'file-earmark-text'],
        'about_me.php'                    => ['About Me', 'person-circle'],
    ],
    'guru' => [
        'dashboard.php'         => ['Dashboard', 'speedometer2'],
        'catat_pelanggaran.php' => ['Catat Pelanggaran', 'pencil-square'],
        'tindakan.php'          => ['Tindakan', 'clipboard-check'],
        'riwayat.php'           => ['Riwayat', 'clock-history'],
        'rekap_poin.php'        => ['Rekap Poin', 'bar-chart'],
    ],
];

$menu = $daftar_menu[$role] ?? [];

// Mencetak daftar menu (dipakai desktop & mobile)
if (!function_exists("cetak_menu")) { function cetak_menu($menu, $current_page, $nama_user, $role)
{
    echo '<ul class="nav nav-pills flex-column gap-1">';
    foreach ($menu as $file => $item) {
        $aktif = (strcasecmp($current_page, $file) === 0) ? 'active' : '';
        echo '<li class="nav-item"><a href="' . $file . '" class="nav-link ' . $aktif . '">'
           . '<i class="bi bi-' . $item[1] . '"></i><span>' . $item[0] . '</span></a></li>';
    }
    echo '<li><hr class="sb-hr"></li>';
    echo '<li class="nav-item"><a href="logout.php" class="nav-link sb-logout">'
       . '<i class="bi bi-box-arrow-right"></i><span>Logout</span></a></li>';
    echo '</ul>';

    // Kartu pengguna
    $inisial = strtoupper(mb_substr(trim($nama_user), 0, 1));
    echo '<div class="sb-user d-flex align-items-center gap-2 mt-4">'
       . '<div class="sb-avatar">' . htmlspecialchars($inisial) . '</div>'
       . '<div class="overflow-hidden">'
       . '<div class="sb-user-name text-truncate">' . htmlspecialchars($nama_user) . '</div>'
       . '<div class="sb-user-role text-capitalize">' . htmlspecialchars($role) . '</div>'
       . '</div></div>';
} }

// Logo + nama aplikasi
if (!function_exists("cetak_brand")) { function cetak_brand()
{
    echo '<div class="sb-brand d-flex align-items-center gap-2">'
       . '<span class="sb-logo"><i class="bi bi-shield-check"></i></span>'
       . '<span>Pelanggaran Siswa</span></div>';
} }

if (!empty($menu)) {
?>
<!-- Font & ikon -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
    /* ===== Tema umum ===== */
    :root {
        --bs-primary: #4f46e5;
        --bs-primary-rgb: 79, 70, 229;
        --bs-body-font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        --sb-dark: #0f172a;
        --sb-dark-2: #1e293b;
    }
    body { background: #f1f5f9; color: #334155; font-family: var(--bs-body-font-family); }

    /* ===== Sidebar desktop ===== */
    .sb-desktop {
        position: sticky; top: 0; height: 100vh; overflow-y: auto;
        background: linear-gradient(180deg, var(--sb-dark-2), var(--sb-dark));
        box-shadow: 2px 0 12px rgba(15, 23, 42, .15);
    }
    .sb-desktop::-webkit-scrollbar, .sb-drawer::-webkit-scrollbar { width: 6px; }
    .sb-desktop::-webkit-scrollbar-thumb, .sb-drawer::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 6px; }

    .sb-brand { color: #fff; font-weight: 700; font-size: 1.05rem; letter-spacing: .2px; }
    .sb-logo {
        width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
        display: inline-flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; font-size: 1.05rem;
        box-shadow: 0 4px 10px rgba(99, 102, 241, .45);
    }

    /* Link menu (desktop & drawer) */
    .sb-desktop .nav-link, .sb-drawer .nav-link {
        display: flex; align-items: center; gap: .7rem;
        color: #94a3b8; font-size: .92rem; font-weight: 500;
        padding: .6rem .8rem; border-radius: .7rem; transition: all .15s ease;
    }
    .sb-desktop .nav-link i, .sb-drawer .nav-link i { font-size: 1.05rem; }
    .sb-desktop .nav-link:hover, .sb-drawer .nav-link:hover {
        background: rgba(255,255,255,.07); color: #fff; transform: translateX(2px);
    }
    .sb-desktop .nav-link.active, .sb-drawer .nav-link.active {
        background: rgba(99, 102, 241, .2); color: #fff;
        box-shadow: inset 3px 0 0 #818cf8;
    }
    .sb-desktop .nav-link.active i, .sb-drawer .nav-link.active i { color: #a5b4fc; }
    .sb-logout { color: #f87171 !important; }
    .sb-logout:hover { background: rgba(248, 113, 113, .12) !important; color: #fca5a5 !important; }
    .sb-hr { border: 0; border-top: 1px solid rgba(255,255,255,.1); margin: .6rem 0; opacity: 1; }

    /* Kartu pengguna */
    .sb-user { background: rgba(255,255,255,.06); border-radius: .8rem; padding: .65rem .75rem; }
    .sb-avatar {
        width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; font-weight: 600;
    }
    .sb-user-name { color: #fff; font-size: .88rem; font-weight: 600; }
    .sb-user-role { color: #94a3b8; font-size: .75rem; }

    /* ===== Top bar mobile ===== */
    .sb-top { background: var(--sb-dark); z-index: 1040; box-shadow: 0 2px 10px rgba(15, 23, 42, .3); }
    .sb-burger, .sb-close {
        border: 0; background: transparent; color: #fff; line-height: 1;
        padding: .45rem; border-radius: 50%; transition: .15s;
    }
    .sb-burger:hover, .sb-close:hover { background: rgba(255,255,255,.14); }

    /* ===== Drawer mobile ===== */
    .sb-backdrop {
        position: fixed; inset: 0; background: rgba(15, 23, 42, .55); backdrop-filter: blur(2px);
        z-index: 1050; opacity: 0; visibility: hidden; transition: opacity .25s;
    }
    .sb-backdrop.show { opacity: 1; visibility: visible; }
    .sb-drawer {
        position: fixed; top: 0; left: 0; bottom: 0; width: 280px; max-width: 85vw;
        background: linear-gradient(180deg, var(--sb-dark-2), var(--sb-dark));
        z-index: 1060; overflow-y: auto;
        transform: translateX(-100%); transition: transform .25s ease;
    }
    .sb-drawer.show { transform: translateX(0); box-shadow: 8px 0 30px rgba(0,0,0,.35); }

    /* ===== Konten (semua halaman) ===== */
    main { animation: sbFade .35s ease; }
    @keyframes sbFade { from { opacity: 0; } to { opacity: 1; } }

    main h1, main h2, main h3 { color: #0f172a; font-weight: 700; letter-spacing: -.01em; }
    main h1 { font-size: 1.75rem; }
    main h2 { font-size: 1.5rem; }

    /* Card */
    main .card {
        border: 0; border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .06), 0 4px 14px rgba(15, 23, 42, .05);
        transition: transform .15s ease, box-shadow .15s ease;
    }
    main .card:hover { box-shadow: 0 2px 6px rgba(15, 23, 42, .08), 0 8px 22px rgba(15, 23, 42, .08); }
    main .card-header { background: transparent; border-bottom: 1px solid #e2e8f0; font-weight: 600; }

    /* Tabel */
    main .table { --bs-table-bg: #fff; --bs-border-color: #e2e8f0; }
    main .table thead th {
        background: #f8fafc; color: #64748b; font-size: .75rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: .05em; white-space: nowrap;
        border-bottom: 1px solid #e2e8f0;
    }
    main .table td { vertical-align: middle; font-size: .92rem; }
    main .table-hover > tbody > tr:hover > * { --bs-table-bg-state: #f8fafc; }
    main .table-responsive { border-radius: .8rem; box-shadow: 0 1px 3px rgba(15, 23, 42, .06); background: #fff; }

    /* Tombol */
    main .btn { border-radius: .6rem; font-weight: 500; transition: all .15s ease; }
    main .btn:not(:disabled):hover { transform: translateY(-1px); }
    .btn-primary {
        --bs-btn-bg: #4f46e5; --bs-btn-border-color: #4f46e5;
        --bs-btn-hover-bg: #4338ca; --bs-btn-hover-border-color: #4338ca;
        --bs-btn-active-bg: #3730a3; --bs-btn-active-border-color: #3730a3;
        --bs-btn-disabled-bg: #4f46e5; --bs-btn-disabled-border-color: #4f46e5;
        --bs-btn-focus-shadow-rgb: 99, 102, 241;
    }
    main .btn-secondary {
        --bs-btn-bg: #e2e8f0; --bs-btn-border-color: #e2e8f0; --bs-btn-color: #334155;
        --bs-btn-hover-bg: #cbd5e1; --bs-btn-hover-border-color: #cbd5e1; --bs-btn-hover-color: #0f172a;
        --bs-btn-active-bg: #cbd5e1; --bs-btn-active-border-color: #cbd5e1; --bs-btn-active-color: #0f172a;
    }

    /* Form */
    main .form-control, main .form-select { border-radius: .6rem; border-color: #cbd5e1; }
    main .form-control:focus, main .form-select:focus {
        border-color: #818cf8; box-shadow: 0 0 0 .25rem rgba(99, 102, 241, .18);
    }
    main .form-label { font-weight: 500; color: #475569; }

    /* Lain-lain */
    main .badge { font-weight: 500; border-radius: .5rem; }
    main .alert { border: 0; border-radius: .8rem; }
    .modal-content { border: 0; border-radius: 1rem; }
</style>

<!-- SIDEBAR (layar besar) -->
<div class="d-none d-md-block col-md-3 col-lg-2 sb-desktop p-3">
    <div class="mb-4"><?php cetak_brand(); ?></div>
    <?php cetak_menu($menu, $current_page, $nama_user, $role); ?>
</div>

<!-- TOP BAR (layar kecil): hamburger di kiri + nama aplikasi -->
<div class="col-12 d-md-none sticky-top sb-top px-3 py-2 d-flex align-items-center gap-2">
    <button type="button" id="sbBurger" class="sb-burger" aria-label="Buka menu">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
        </svg>
    </button>
    <?php cetak_brand(); ?>
</div>

<!-- DRAWER (geser dari kiri) + latar gelap -->
<div id="sbBackdrop" class="sb-backdrop d-md-none"></div>
<div id="sbDrawer" class="sb-drawer d-md-none p-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <?php cetak_brand(); ?>
        <button type="button" id="sbClose" class="sb-close" aria-label="Tutup menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </button>
    </div>
    <?php cetak_menu($menu, $current_page, $nama_user, $role); ?>
</div>

<script>
    (function () {
        var drawer   = document.getElementById('sbDrawer');
        var backdrop = document.getElementById('sbBackdrop');

        function buka()  { drawer.classList.add('show');    backdrop.classList.add('show'); }
        function tutup() { drawer.classList.remove('show'); backdrop.classList.remove('show'); }

        document.getElementById('sbBurger').addEventListener('click', buka);
        document.getElementById('sbClose').addEventListener('click', tutup);
        backdrop.addEventListener('click', tutup);
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') tutup(); });
    })();
</script>
<?php
}
