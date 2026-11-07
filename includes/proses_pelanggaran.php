<?php
// includes/proses_pelanggaran.php
// Fungsi bersama untuk tambah & edit catatan pelanggaran.

// Mengambil satu baris data berdasarkan id
function cari_satu($koneksi, $sql, $id)
{
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

// Mengambil data dari form POST
function data_dari_post()
{
    $status_boleh = ['belum', 'proses', 'selesai'];
    $status = strtolower(trim($_POST['status'] ?? 'belum'));

    return [
        'siswa_id'        => (int) ($_POST['siswa_id'] ?? 0),
        'tahun_ajaran_id' => (int) ($_POST['tahun_ajaran_id'] ?? 0),
        'kelas_id'        => (int) ($_POST['kelas_id'] ?? 0),
        'pelanggaran_id'  => (int) ($_POST['pelanggaran_id'] ?? 0),
        'guru_id'         => (int) ($_POST['guru_id'] ?? 0),
        'tanggal'         => $_POST['tanggal'] ?? '',
        'poin'            => max(0, (int) ($_POST['poin'] ?? 0)),
        'status'          => in_array($status, $status_boleh) ? $status : 'belum',
        'keterangan'      => trim($_POST['keterangan'] ?? ''),
        'tindakan'        => trim($_POST['tindakan'] ?? ''),
    ];
}

// Simpan (INSERT) atau ubah (UPDATE jika $id > 0)
// Mengembalikan true jika berhasil, atau teks error jika gagal.
function simpan_pelanggaran($koneksi, $v, $id = 0)
{
    // Nama siswa, kelas, pelanggaran, dan guru ikut disimpan di tabel,
    // jadi diambil dari database berdasarkan id yang dipilih.
    $siswa = cari_satu($koneksi, "SELECT nama FROM t_siswa WHERE id = ?", $v['siswa_id']);
    $kelas = cari_satu($koneksi, "SELECT nama FROM t_kelas WHERE id = ?", $v['kelas_id']);
    $pel   = cari_satu($koneksi, "SELECT nama, pelanggaran_kategori_id FROM t_pelanggaran WHERE id = ?", $v['pelanggaran_id']);
    $guru  = cari_satu($koneksi, "SELECT nama FROM t_guru WHERE id = ?", $v['guru_id']);

    if (!$siswa || !$kelas || !$pel || !$guru) {
        return 'Data siswa, kelas, pelanggaran, atau guru tidak valid.';
    }

    $nama_siswa  = $siswa['nama'];
    $nama_kelas  = $kelas['nama'];
    $nama_pel    = $pel['nama'];
    $kategori_id = (int) $pel['pelanggaran_kategori_id'];
    $nama_guru   = $guru['nama'];

    if ($id > 0) {
        $stmt = mysqli_prepare($koneksi,
            "UPDATE t_pelanggaran_siswa SET
                tahun_ajaran_id = ?, siswa_id = ?, nama_siswa = ?,
                kelas_id = ?, nama_kelas = ?,
                pelanggaran_id = ?, nama_pelanggaran = ?, pelanggaran_kategori_id = ?,
                guru_id = ?, nama_guru = ?,
                tanggal = ?, keterangan = ?, poin = ?, tindakan = ?, status = ?,
                updated_at = NOW()
             WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'iisisisiisssissi',
            $v['tahun_ajaran_id'], $v['siswa_id'], $nama_siswa,
            $v['kelas_id'], $nama_kelas,
            $v['pelanggaran_id'], $nama_pel, $kategori_id,
            $v['guru_id'], $nama_guru,
            $v['tanggal'], $v['keterangan'], $v['poin'], $v['tindakan'], $v['status'],
            $id);
    } else {
        $stmt = mysqli_prepare($koneksi,
            "INSERT INTO t_pelanggaran_siswa
                (tahun_ajaran_id, siswa_id, nama_siswa,
                 kelas_id, nama_kelas,
                 pelanggaran_id, nama_pelanggaran, pelanggaran_kategori_id,
                 guru_id, nama_guru,
                 tanggal, keterangan, poin, tindakan, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'iisisisiisssiss',
            $v['tahun_ajaran_id'], $v['siswa_id'], $nama_siswa,
            $v['kelas_id'], $nama_kelas,
            $v['pelanggaran_id'], $nama_pel, $kategori_id,
            $v['guru_id'], $nama_guru,
            $v['tanggal'], $v['keterangan'], $v['poin'], $v['tindakan'], $v['status']);
    }

    return mysqli_stmt_execute($stmt) ? true : 'Catatan pelanggaran gagal disimpan.';
}
