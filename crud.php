<?php
// Fungsi CRUD umum: membaca struktur tabel otomatis, lalu menampilkan
// daftar data + form tambah/ubah + hapus. Dipakai oleh halaman menu.
function crud($k, $tabel, $opsi = []) {
    $readonly = !empty($opsi['readonly']);
    $kolom = [];
    $r = mysqli_query($k, "SHOW COLUMNS FROM `$tabel`");
    while ($c = mysqli_fetch_assoc($r)) { $kolom[] = $c; }
    $input = array_filter($kolom, function ($c) {
        return !in_array($c['Field'], ['id', 'created_at', 'updated_at']);
    });
    $pesan = '';

    if (!$readonly && $_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $aksi = $_POST['aksi'] ?? '';
            if ($aksi === 'hapus') {
                $s = mysqli_prepare($k, "DELETE FROM `$tabel` WHERE id = ?");
                mysqli_stmt_bind_param($s, "i", $_POST['id']);
                mysqli_stmt_execute($s);
                $pesan = 'Data berhasil dihapus.';
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
            echo "<tr><td>" . htmlspecialchars($n) . "</td><td>";
            if ($t === 'tinyint(1)') {
                $sel = $edit ? (string)$val : '1';
                echo "<select name='$n'><option value='1'" . ($sel === '1' ? ' selected' : '') . ">Aktif / Ya</option><option value='0'" . ($sel === '0' ? ' selected' : '') . ">Tidak</option></select>";
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
    $tampil = array_filter($kolom, function ($c) {
        return !in_array($c['Field'], ['created_at', 'updated_at']);
    });
    echo "<h3>Daftar data</h3><div style='overflow-x:auto'><table class='tabel-data'><tr><th>No</th>";
    foreach ($tampil as $c) { echo "<th>" . htmlspecialchars($c['Field']) . "</th>"; }
    if (!$readonly) { echo "<th>Aksi</th>"; }
    echo "</tr>";
    $data = mysqli_query($k, "SELECT * FROM `$tabel` ORDER BY id DESC LIMIT 100");
    $no = 1;
    while ($row = mysqli_fetch_assoc($data)) {
        echo "<tr><td>" . $no++ . "</td>";
        foreach ($tampil as $c) { echo "<td>" . htmlspecialchars((string)$row[$c['Field']]) . "</td>"; }
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
