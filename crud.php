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

function nama_aman($s) { return str_replace('`', '``', $s); }

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

function crud($k, $tabel, $opsi = []) {
    $readonly = !empty($opsi['readonly']);
    $labelKustom = $opsi['label'] ?? [];
    $sembunyi = $opsi['sembunyi'] ?? [];
    $kolom = [];
    $r = mysqli_query($k, "SHOW COLUMNS FROM `$tabel`");
    while ($c = mysqli_fetch_assoc($r)) { $kolom[] = $c; }
    $rel = relasi_tabel($k, $tabel, $opsi['relasi'] ?? []);
    $input = array_filter($kolom, function ($c) use ($sembunyi) {
        return !in_array($c['Field'], array_merge(['id', 'created_at', 'updated_at'], $sembunyi));
    });
    $pesan = '';

    if (!$readonly && $_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $aksi = $_POST['aksi'] ?? '';

            // Apakah semua isian kosong? (pilihan Aktif/Tidak diabaikan karena selalu terisi)
            $kosong = true;
            foreach ($input as $c) {
                if ($c['Type'] === 'tinyint(1)') { continue; }
                if (trim((string)($_POST[$c['Field']] ?? '')) !== '') { $kosong = false; break; }
            }

            // Kolom relasi wajib (NOT NULL) yang belum dipilih
            $belumPilih = '';
            foreach ($input as $c) {
                $n = $c['Field'];
                if (isset($rel[$n]) && $c['Null'] === 'NO' && trim((string)($_POST[$n] ?? '')) === '') {
                    $belumPilih = label_kolom($n, $labelKustom);
                    break;
                }
            }

            if ($aksi === 'hapus') {
                $s = mysqli_prepare($k, "DELETE FROM `$tabel` WHERE id = ?");
                mysqli_stmt_bind_param($s, "i", $_POST['id']);
                mysqli_stmt_execute($s);
                $pesan = 'Data berhasil dihapus.';
            } elseif ($kosong) {
                $pesan = 'Kamu harus memasukkan data terlebih dahulu.';
            } elseif ($belumPilih !== '') {
                $pesan = 'Pilih ' . $belumPilih . ' terlebih dahulu.';
            } else {
                $f = []; $v = [];
                foreach ($input as $c) {
                    $val = $_POST[$c['Field']] ?? '';
                    if ($val === '' && $c['Null'] === 'YES') { $val = null; }
                    $f[] = $c['Field']; $v[] = $val;
                }
                if ($aksi === 'tambah') {
                    $sql = "INSERT INTO `$tabel` (`" . implode('`,`', $f) . "`) VALUES (" . implode(',', array_fill(0, count($f), '?')) . ")";
                } else {
                    $sql = "UPDATE `$tabel` SET `" . implode('`=?,`', $f) . "`=? WHERE id = ?";
                    $v[] = $_POST['id'];
                }
                $s = mysqli_prepare($k, $sql);
                mysqli_stmt_bind_param($s, str_repeat('s', count($v)), ...$v);
                mysqli_stmt_execute($s);
                $pesan = 'Data berhasil disimpan.';
            }
        } catch (Throwable $e) {
            $pesan = 'Gagal: ' . $e->getMessage();
        }
    }

    // Mode ubah: ambil data yang mau diedit
    $edit = null;
    if (!$readonly && isset($_GET['ubah'])) {
        $s = mysqli_prepare($k, "SELECT * FROM `$tabel` WHERE id = ?");
        mysqli_stmt_bind_param($s, "i", $_GET['ubah']);
        mysqli_stmt_execute($s);
        $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
    }

    if ($pesan !== '') { echo "<p><b>" . htmlspecialchars($pesan) . "</b></p>"; }

    if (!$readonly) {
        echo "<h3>" . ($edit ? "Ubah data" : "Tambah data") . "</h3>";
        echo "<form method='POST'><input type='hidden' name='aksi' value='" . ($edit ? 'ubah' : 'tambah') . "'>";
        if ($edit) { echo "<input type='hidden' name='id' value='" . (int)$edit['id'] . "'>"; }
        echo "<table class='tabel-data'>";
        foreach ($input as $c) {
            $n = $c['Field'];
            $t = $c['Type'];
            $val = $edit ? $edit[$n] : '';
            $v = htmlspecialchars((string)$val);
            echo "<tr><td>" . htmlspecialchars(label_kolom($n, $labelKustom)) . "</td><td>";
            if (isset($rel[$n])) {
                echo "<select name='$n'><option value=''>-- Pilih --</option>";
                foreach ($rel[$n]['pilihan'] as $idPil => $teksPil) {
                    $dipilih = ((string)$val === (string)$idPil) ? ' selected' : '';
                    echo "<option value='" . htmlspecialchars((string)$idPil) . "'$dipilih>" . htmlspecialchars($teksPil) . "</option>";
                }
                echo "</select>";
            } elseif ($t === 'tinyint(1)') {
                $sel = $edit ? (string)$val : '1';
                $teks = teks_boolean($n);
                echo "<select name='$n'><option value='1'" . ($sel === '1' ? ' selected' : '') . ">" . $teks[0] . "</option><option value='0'" . ($sel === '0' ? ' selected' : '') . ">" . $teks[1] . "</option></select>";
            } elseif ($t === 'text') {
                echo "<textarea name='$n' rows='3' cols='30'>$v</textarea>";
            } elseif ($t === 'date') {
                echo "<input type='date' name='$n' value='$v'>";
            } elseif (strpos($t, 'int') === 0) {
                echo "<input type='number' name='$n' value='$v'>";
            } else {
                echo "<input type='text' name='$n' value='$v'>";
            }
            echo "</td></tr>";
        }
        echo "</table><button type='submit'>Simpan</button>";
        if ($edit) { echo " <a href='" . basename($_SERVER['PHP_SELF']) . "'>Batal</a>"; }
        echo "</form>";
    }

    // Daftar data (maksimal 100 terbaru)
    $tampil = array_filter($kolom, function ($c) use ($sembunyi) {
        return !in_array($c['Field'], array_merge(['created_at', 'updated_at'], $sembunyi));
    });
    echo "<h3>Daftar data</h3><div style='overflow-x:auto'><table class='tabel-data'><tr><th>No</th>";
    foreach ($tampil as $c) { echo "<th>" . htmlspecialchars(label_kolom($c['Field'], $labelKustom)) . "</th>"; }
    if (!$readonly) { echo "<th>Aksi</th>"; }
    echo "</tr>";
    $data = mysqli_query($k, "SELECT * FROM `$tabel` ORDER BY id DESC LIMIT 100");
    $no = 1;
    while ($row = mysqli_fetch_assoc($data)) {
        echo "<tr><td>" . $no++ . "</td>";
        foreach ($tampil as $c) {
            echo "<td>" . htmlspecialchars(tampil_nilai($c['Field'], $row[$c['Field']], $c['Type'], $rel)) . "</td>";
        }
        if (!$readonly) {
            echo "<td><a href='?ubah=" . (int)$row['id'] . "'>Ubah</a> "
                . "<form method='POST' style='display:inline' onsubmit=\"return confirm('Hapus data ini?')\">"
                . "<input type='hidden' name='aksi' value='hapus'><input type='hidden' name='id' value='" . (int)$row['id'] . "'>"
                . "<button type='submit'>Hapus</button></form></td>";
        }
        echo "</tr>";
    }
    if ($no === 1) { echo "<tr><td colspan='99'>Belum ada data.</td></tr>"; }
    echo "</table></div>";
}