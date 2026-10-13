<?php
// Fungsi CRUD umum: membaca struktur tabel otomatis, lalu menampilkan
// daftar data + form tambah/ubah + hapus. Dipakai oleh halaman menu.
//
// Opsi crud($k, $tabel, $opsi):
//   'readonly' => true                      hanya tampil data (tanpa form & aksi)
//   'sembunyi' => ['user_id']               kolom yang disembunyikan dari form & tabel
//   'label'    => ['nis' => 'NIS Siswa']    label manual (menimpa label otomatis)
//   'relasi'   => ['kolom_id' => ['t_tabel', 'kolom_yang_ditampilkan']]
//                                           atur manual kolom relasi (opsional,
//                                           biasanya terdeteksi otomatis)
//   'terpisah' => 'siswa'                   form tambah/ubah + prosesnya dipisah ke file:
//                                             tambah_data_siswa.php, proses_tambah_siswa.php,
//                                             edit_data_siswa.php,   proses_edit_siswa.php
//                                           (tanpa opsi ini, form tetap tampil di halaman yang sama)
//   'kembali'  => 'kelola_siswa.php'        halaman daftar data (wajib jika memakai 'terpisah')

// ============================================================
// GANTI CLASS SEMUA TABEL DI SINI (cukup di satu tempat ini).
// Contoh: 'tabel-data'  atau  'table table-striped' (Bootstrap)
// Pakai kutip satu di dalam, jangan kutip dua.
// ============================================================
if (!defined('KELAS_TABEL')) {
    define('KELAS_TABEL', 'table');
}
// Class header tabel. Bootstrap 4: 'thead-dark'. Bootstrap 5: 'table-dark'.
if (!defined('KELAS_HEADER')) {
    define('KELAS_HEADER', 'thead-dark');
}
// Alamat Bootstrap yang dipasang otomatis oleh crud() dan form.
// Isi '' kalau Bootstrap sudah dipasang sendiri di halaman.
if (!defined('BOOTSTRAP_CSS')) {
    define('BOOTSTRAP_CSS', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css');
}

// Memasang <link> Bootstrap satu kali saja per halaman.
function pasang_bootstrap() {
    static $sudah = false;
    if ($sudah || BOOTSTRAP_CSS === '') { return; }
    $sudah = true;
    echo "<link rel='stylesheet' href='" . BOOTSTRAP_CSS . "'>\n";
}

function nama_aman($s) { return str_replace('`', '``', $s); }

function mulai_sesi() {
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
}

// Nama file fitur terpisah, dibentuk dari opsi 'terpisah'
function nama_file_fitur($opsi, $jenis) {
    $n = $opsi['terpisah'] ?? '';
    $peta = [
        'tambah'        => "tambah_data_$n.php",
        'ubah'          => "edit_data_$n.php",
        'proses_tambah' => "proses_tambah_$n.php",
        'proses_ubah'   => "proses_edit_$n.php",
    ];
    return $peta[$jenis];
}

// Nama kolom database -> label tampilan.
// nis -> NIS, jenis_kelamin -> Jenis Kelamin, tahun_ajaran_id -> Tahun Ajaran
function label_kolom($nama, $kustom = []) {
    if (isset($kustom[$nama])) { return $kustom[$nama]; }
    $dasar = $nama;
    if ($nama !== 'id') {
        $dasar = preg_replace('/_id$/', '', $dasar);
        $dasar = preg_replace('/^id_/', '', $dasar);
    }
    $singkatan = ['id', 'nis', 'nisn', 'nip'];
    $kata = explode('_', $dasar);
    foreach ($kata as $i => $w) {
        $kata[$i] = in_array(strtolower($w), $singkatan) ? strtoupper($w) : ucfirst(strtolower($w));
    }
    return implode(' ', $kata);
}

// Pasangan teks untuk kolom tinyint(1): [teks untuk 1, teks untuk 0]
function teks_boolean($nama) {
    if (stripos($nama, 'aktif') !== false) { return ['Aktif', 'Tidak Aktif']; }
    return ['Ya', 'Tidak'];
}

// Pilih kolom yang paling cocok untuk ditampilkan dari tabel relasi
// (utamakan kolom yang namanya mengandung "nama", lalu kolom teks pertama).
function kolom_nama_tampil($k, $tabelRef) {
    $semua = [];
    $r = mysqli_query($k, "SHOW COLUMNS FROM `" . nama_aman($tabelRef) . "`");
    while ($c = mysqli_fetch_assoc($r)) { $semua[] = $c; }
    foreach ($semua as $c) {
        if (stripos($c['Field'], 'nama') !== false) { return $c['Field']; }
    }
    foreach ($semua as $c) {
        if (preg_match('/^(var)?char/i', $c['Type']) && stripos($c['Field'], 'pass') === false) { return $c['Field']; }
    }
    return 'id';
}

// Deteksi kolom relasi pada sebuah tabel, dari foreign key atau dari
// penamaan kolom *_id (tahun_ajaran_id -> t_tahun_ajaran).
// Hasil: ['kolom' => ['tabel' => ..., 'tampil' => ..., 'pilihan' => [id => teks]]]
function relasi_tabel($k, $tabel, $manual = []) {
    $hasil = [];

    // 1) dari foreign key
    try {
        $s = mysqli_prepare($k, "SELECT COLUMN_NAME, REFERENCED_TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND REFERENCED_TABLE_NAME IS NOT NULL");
        mysqli_stmt_bind_param($s, "s", $tabel);
        mysqli_stmt_execute($s);
        $q = mysqli_stmt_get_result($s);
        while ($row = mysqli_fetch_assoc($q)) {
            $hasil[$row['COLUMN_NAME']] = ['tabel' => $row['REFERENCED_TABLE_NAME'], 'tampil' => null];
        }
    } catch (Throwable $e) {}

    // 2) dari penamaan *_id, jika tabel t_<nama> ada
    try {
        $r = mysqli_query($k, "SHOW COLUMNS FROM `" . nama_aman($tabel) . "`");
        while ($c = mysqli_fetch_assoc($r)) {
            $n = $c['Field'];
            if (isset($hasil[$n]) || !preg_match('/^(.+)_id$/', $n, $m)) { continue; }
            $kandidat = 't_' . $m[1];
            $cek = mysqli_query($k, "SHOW TABLES LIKE '" . mysqli_real_escape_string($k, $kandidat) . "'");
            $baris = $cek ? mysqli_fetch_row($cek) : null;
            if ($baris && $baris[0] === $kandidat) {
                $hasil[$n] = ['tabel' => $kandidat, 'tampil' => null];
            }
        }
    } catch (Throwable $e) {}

    // 3) pengaturan manual
    foreach ($manual as $kol => $def) {
        $hasil[$kol] = ['tabel' => $def[0], 'tampil' => $def[1] ?? null];
    }

    // Isi daftar pilihan (id => teks) untuk tiap relasi
    foreach ($hasil as $kol => $info) {
        try {
            $tab = $info['tabel'];
            $tampil = $info['tampil'] ?? kolom_nama_tampil($k, $tab);
            $pil = [];
            $q = mysqli_query($k, "SELECT id, `" . nama_aman($tampil) . "` AS teks FROM `" . nama_aman($tab) . "` ORDER BY `" . nama_aman($tampil) . "` LIMIT 500");
            while ($row = mysqli_fetch_assoc($q)) { $pil[$row['id']] = (string)$row['teks']; }
            $hasil[$kol] = ['tabel' => $tab, 'tampil' => $tampil, 'pilihan' => $pil];
        } catch (Throwable $e) {
            unset($hasil[$kol]);
        }
    }
    return $hasil;
}

// Nilai dari database -> teks yang tampil di web.
// status_aktif 1 -> Aktif, 0 -> Tidak Aktif; tahun_ajaran_id 7 -> nama tahun ajarannya
function tampil_nilai($nama, $nilai, $tipe, $rel = []) {
    if ($nilai === null) { return ''; }
    if (isset($rel[$nama])) {
        return $rel[$nama]['pilihan'][$nilai] ?? (string)$nilai;
    }
    if ($tipe === 'tinyint(1)') {
        $teks = teks_boolean($nama);
        return ((string)$nilai === '1') ? $teks[0] : $teks[1];
    }
    return (string)$nilai;
}

// Ambil daftar tipe kolom: ['nama_kolom' => 'tipe', ...]
function tipe_kolom($k, $tabel) {
    $hasil = [];
    $r = mysqli_query($k, "SHOW COLUMNS FROM `" . nama_aman($tabel) . "`");
    while ($c = mysqli_fetch_assoc($r)) { $hasil[$c['Field']] = $c['Type']; }
    return $hasil;
}

// Baca struktur tabel: semua kolom, kolom yang jadi input form, dan relasinya
function siapkan_tabel($k, $tabel, $opsi) {
    $sembunyi = $opsi['sembunyi'] ?? [];
    $kolom = [];
    $r = mysqli_query($k, "SHOW COLUMNS FROM `$tabel`");
    while ($c = mysqli_fetch_assoc($r)) { $kolom[] = $c; }
    $rel = relasi_tabel($k, $tabel, $opsi['relasi'] ?? []);
    $input = array_filter($kolom, function ($c) use ($sembunyi) {
        return !in_array($c['Field'], array_merge(['id', 'created_at', 'updated_at'], $sembunyi));
    });
    return [$kolom, $input, $rel];
}

// PROSES: tambah / ubah / hapus data.
// $post berisi data yang dikirim form. Hasil: ['ok' => true/false, 'pesan' => '...']
function simpan_data($k, $tabel, $opsi, $aksi, $post) {
    try {
        if ($aksi === 'hapus') {
            $id = (int)($post['id'] ?? 0);
            $s = mysqli_prepare($k, "DELETE FROM `$tabel` WHERE id = ?");
            mysqli_stmt_bind_param($s, "i", $id);
            mysqli_stmt_execute($s);
            return ['ok' => true, 'pesan' => 'Data berhasil dihapus.'];
        }

        list($kolom, $input, $rel) = siapkan_tabel($k, $tabel, $opsi);
        $labelKustom = $opsi['label'] ?? [];

        // Apakah semua isian kosong? (pilihan Aktif/Tidak diabaikan karena selalu terisi)
        $kosong = true;
        foreach ($input as $c) {
            if ($c['Type'] === 'tinyint(1)') { continue; }
            if (trim((string)($post[$c['Field']] ?? '')) !== '') { $kosong = false; break; }
        }
        if ($kosong) {
            return ['ok' => false, 'pesan' => 'Kamu harus memasukkan data terlebih dahulu.'];
        }

        // Kolom relasi wajib (NOT NULL) yang belum dipilih
        foreach ($input as $c) {
            $n = $c['Field'];
            if (isset($rel[$n]) && $c['Null'] === 'NO' && trim((string)($post[$n] ?? '')) === '') {
                return ['ok' => false, 'pesan' => 'Pilih ' . label_kolom($n, $labelKustom) . ' terlebih dahulu.'];
            }
        }

        $f = []; $v = [];
        foreach ($input as $c) {
            $val = $post[$c['Field']] ?? '';
            if ($val === '' && $c['Null'] === 'YES') { $val = null; }
            $f[] = $c['Field']; $v[] = $val;
        }
        if ($aksi === 'tambah') {
            $sql = "INSERT INTO `$tabel` (`" . implode('`,`', $f) . "`) VALUES (" . implode(',', array_fill(0, count($f), '?')) . ")";
        } else {
            $sql = "UPDATE `$tabel` SET `" . implode('`=?,`', $f) . "`=? WHERE id = ?";
            $v[] = $post['id'] ?? 0;
        }
        $s = mysqli_prepare($k, $sql);
        mysqli_stmt_bind_param($s, str_repeat('s', count($v)), ...$v);
        mysqli_stmt_execute($s);
        return ['ok' => true, 'pesan' => 'Data berhasil disimpan.'];
    } catch (Throwable $e) {
        return ['ok' => false, 'pesan' => 'Gagal: ' . $e->getMessage()];
    }
}

// FORM: tampilkan form tambah/ubah. $nilai = isian awal (data lama / isian sebelumnya).
function tampil_form($k, $tabel, $opsi, $mode, $nilai = [], $id = null) {
    list($kolom, $input, $rel) = siapkan_tabel($k, $tabel, $opsi);
    $labelKustom = $opsi['label'] ?? [];
    $ubah = ($mode === 'ubah');
    $terpisah = !empty($opsi['terpisah']);
    $action = $terpisah ? nama_file_fitur($opsi, $ubah ? 'proses_ubah' : 'proses_tambah') : '';
    $batal = $terpisah ? ($opsi['kembali'] ?? '') : ($ubah ? basename($_SERVER['PHP_SELF']) : '');

    pasang_bootstrap();
    echo "<h3>" . ($ubah ? "Ubah data" : "Tambah data") . "</h3>";
    echo "<form method='POST' style='max-width:640px'" . ($action !== '' ? " action='" . htmlspecialchars($action) . "'" : "") . ">";
    echo "<input type='hidden' name='aksi' value='" . ($ubah ? 'ubah' : 'tambah') . "'>";
    if ($ubah && $id !== null) { echo "<input type='hidden' name='id' value='" . (int)$id . "'>"; }
    echo "<table class='" . KELAS_TABEL . "'>";
    foreach ($input as $c) {
        $n = $c['Field'];
        $t = $c['Type'];
        $val = $nilai[$n] ?? '';
        $v = htmlspecialchars((string)$val);
        echo "<tr><td>" . htmlspecialchars(label_kolom($n, $labelKustom)) . "</td><td>";
        if (isset($rel[$n])) {
            echo "<select class='form-control' name='$n'><option value=''>-- Pilih --</option>";
            foreach ($rel[$n]['pilihan'] as $idPil => $teksPil) {
                $dipilih = ((string)$val === (string)$idPil) ? ' selected' : '';
                echo "<option value='" . htmlspecialchars((string)$idPil) . "'$dipilih>" . htmlspecialchars($teksPil) . "</option>";
            }
            echo "</select>";
        } elseif ($t === 'tinyint(1)') {
            $sel = ((string)$val !== '') ? (string)$val : '1';
            $teks = teks_boolean($n);
            echo "<select class='form-control' name='$n'><option value='1'" . ($sel === '1' ? ' selected' : '') . ">" . $teks[0] . "</option><option value='0'" . ($sel === '0' ? ' selected' : '') . ">" . $teks[1] . "</option></select>";
        } elseif ($t === 'text') {
            echo "<textarea class='form-control' name='$n' rows='3'>$v</textarea>";
        } elseif ($t === 'date') {
            echo "<input class='form-control' type='date' name='$n' value='$v'>";
        } elseif (strpos($t, 'int') === 0) {
            echo "<input class='form-control' type='number' name='$n' value='$v'>";
        } else {
            echo "<input class='form-control' type='text' name='$n' value='$v'>";
        }
        echo "</td></tr>";
    }
    echo "</table><button type='submit' class='btn btn-primary'>Simpan</button>";
    if ($batal !== '') { echo " <a class='btn btn-secondary' href='" . htmlspecialchars($batal) . "'>Batal</a>"; }
    echo "</form>";
}

// HALAMAN FORM TERPISAH: dipakai di tambah_data_xxx.php dan edit_data_xxx.php
// $mode = 'tambah' atau 'ubah' (mode ubah membaca ?id=... dari URL)
function halaman_form($k, $tabel, $opsi, $mode) {
    mulai_sesi();
    pasang_bootstrap();
    $pesan = $_SESSION['pesan'] ?? '';
    $old = $_SESSION['old'] ?? null;
    unset($_SESSION['pesan'], $_SESSION['old']);

    $id = null;
    $nilai = [];
    if ($mode === 'ubah') {
        $id = (int)($_GET['id'] ?? 0);
        $s = mysqli_prepare($k, "SELECT * FROM `$tabel` WHERE id = ?");
        mysqli_stmt_bind_param($s, "i", $id);
        mysqli_stmt_execute($s);
        $nilai = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
        if (!$nilai) {
            echo "<p>Data tidak ditemukan.</p><a href='" . htmlspecialchars($opsi['kembali'] ?? '') . "'>Kembali</a>";
            return;
        }
    }
    if (is_array($old)) { $nilai = array_merge($nilai, $old); }

    if ($pesan !== '') { echo "<div class='alert alert-danger'>" . htmlspecialchars($pesan) . "</div>"; }
    tampil_form($k, $tabel, $opsi, $mode, $nilai, $id);
}

// HALAMAN PROSES TERPISAH: dipakai di proses_tambah_xxx.php dan proses_edit_xxx.php
// Tidak menampilkan apa-apa, hanya menyimpan lalu mengalihkan halaman.
function proses_halaman($k, $tabel, $opsi, $aksi) {
    mulai_sesi();
    $kembali = $opsi['kembali'] ?? 'index.php';
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: $kembali");
        exit;
    }
    $hasil = simpan_data($k, $tabel, $opsi, $aksi, $_POST);
    $_SESSION['pesan'] = $hasil['pesan'];
    if ($hasil['ok']) {
        header("Location: $kembali");
    } else {
        $_SESSION['old'] = $_POST;
        $balik = ($aksi === 'ubah')
            ? nama_file_fitur($opsi, 'ubah') . '?id=' . (int)($_POST['id'] ?? 0)
            : nama_file_fitur($opsi, 'tambah');
        header("Location: $balik");
    }
    exit;
}

function crud($k, $tabel, $opsi = []) {
    $readonly = !empty($opsi['readonly']);
    $terpisah = !empty($opsi['terpisah']);
    $labelKustom = $opsi['label'] ?? [];
    $sembunyi = $opsi['sembunyi'] ?? [];
    list($kolom, $input, $rel) = siapkan_tabel($k, $tabel, $opsi);
    $pesan = '';

    // Pesan dari halaman proses terpisah (setelah simpan)
    mulai_sesi();
    if (isset($_SESSION['pesan'])) {
        $pesan = $_SESSION['pesan'];
        unset($_SESSION['pesan']);
    }

    // Hapus selalu diproses di halaman daftar; tambah/ubah hanya jika form tidak dipisah
    if (!$readonly && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $aksi = $_POST['aksi'] ?? '';
        if ($aksi === 'hapus' || !$terpisah) {
            $pesan = simpan_data($k, $tabel, $opsi, $aksi, $_POST)['pesan'];
        }
    }

    // Mode ubah (hanya untuk form yang tidak dipisah): ambil data yang mau diedit
    $edit = null;
    if (!$readonly && !$terpisah && isset($_GET['ubah'])) {
        $s = mysqli_prepare($k, "SELECT * FROM `$tabel` WHERE id = ?");
        mysqli_stmt_bind_param($s, "i", $_GET['ubah']);
        mysqli_stmt_execute($s);
        $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
    }

    pasang_bootstrap();

    // Urutan sama seperti kelola_siswa.php: tautan "+ Tambah data", lalu pesan
    if (!$readonly && $terpisah) {
        echo "<p class='mb-3'><a class='btn btn-primary' href='" . htmlspecialchars(nama_file_fitur($opsi, 'tambah')) . "'>+ Tambah data</a></p>";
    }
    if ($pesan !== '') { echo "<div class='alert alert-info'>" . htmlspecialchars($pesan) . "</div>"; }
    if (!$readonly && !$terpisah) {
        tampil_form($k, $tabel, $opsi, $edit ? 'ubah' : 'tambah', $edit ?: [], $edit['id'] ?? null);
    }

    // Daftar data (maksimal 100 terbaru)
    $tampil = array_filter($kolom, function ($c) use ($sembunyi) {
        return !in_array($c['Field'], array_merge(['created_at', 'updated_at'], $sembunyi));
    });
    echo "<div class='table-responsive'><table class='" . KELAS_TABEL . "'><thead class='" . KELAS_HEADER . "'><tr><th>No</th>";
    foreach ($tampil as $c) { echo "<th>" . htmlspecialchars(label_kolom($c['Field'], $labelKustom)) . "</th>"; }
    if (!$readonly) { echo "<th>Aksi</th>"; }
    echo "</tr></thead><tbody>";
    $data = mysqli_query($k, "SELECT * FROM `$tabel` ORDER BY id DESC LIMIT 100");
    $no = 1;
    while ($row = mysqli_fetch_assoc($data)) {
        echo "<tr><td>" . $no++ . "</td>";
        foreach ($tampil as $c) {
            echo "<td>" . htmlspecialchars(tampil_nilai($c['Field'], $row[$c['Field']], $c['Type'], $rel)) . "</td>";
        }
        if (!$readonly) {
            $linkUbah = $terpisah
                ? htmlspecialchars(nama_file_fitur($opsi, 'ubah')) . "?id=" . (int)$row['id']
                : "?ubah=" . (int)$row['id'];
            // Urutan sama seperti kelola_siswa.php: tombol Hapus, lalu tautan Edit
            echo "<td>"
                . "<form method='POST' style='display:inline' onsubmit=\"return confirm('Hapus data ini?')\">"
                . "<input type='hidden' name='aksi' value='hapus'><input type='hidden' name='id' value='" . (int)$row['id'] . "'>"
                . "<button type='submit' class='btn btn-sm btn-danger'>Hapus</button></form> "
                . "<a class='btn btn-sm btn-warning' href='" . $linkUbah . "'>Edit</a></td>";
        }
        echo "</tr>";
    }
    if ($no === 1) { echo "<tr><td colspan='99'>Belum ada data.</td></tr>"; }
    echo "</tbody></table></div>";
}