<?php
// includes/helper.php
// Fungsi bantu yang dipakai bersama oleh banyak halaman:
//   1. badge_status()        -> tampilan Aktif / Tidak Aktif yang SAMA di semua tabel
//   2. validasi_siswa()      -> aturan isian form siswa (tambah & edit)
//   3. validasi_guru()       -> aturan isian form guru (tambah & edit)
//   4. cek_identitas_unik()  -> NIS, NISN, dan NIP tidak boleh sama

// Batas tahun lahir siswa (tidak boleh lebih kecil dari tahun ini)
if (!defined('TAHUN_LAHIR_MIN')) {
    define('TAHUN_LAHIR_MIN', 2000);
}

/* ------------------------------------------------------------------
   1. BADGE STATUS (satu tempat supaya warnanya selalu konsisten)
      Aktif = hijau, Tidak Aktif = abu-abu.
      Merah tidak dipakai karena merah dipakai sebagai penanda tingkat
      pelanggaran.
   ------------------------------------------------------------------ */
function badge_status($nilai)
{
    if ((string) $nilai === '1') {
        return '<span class="badge bg-success">Aktif</span>';
    }
    return '<span class="badge bg-secondary">Tidak Aktif</span>';
}

/* ------------------------------------------------------------------
   2. NIS / NISN / NIP TIDAK BOLEH SAMA
      - Tidak boleh sama satu sama lain di dalam satu isian
        (mis. NIS sama dengan NISN).
      - Tidak boleh sama dengan NIS, NISN, atau NIP milik data lain,
        baik di tabel siswa maupun tabel guru.

      $isian   : ['nis' => '..', 'nisn' => '..', 'nip' => '..']
                 (isi hanya yang ada di form; yang kosong dilewati)
      $tabel   : 't_siswa' atau 't_guru'  (data yang sedang diedit)
      $id      : id data yang sedang diedit (0 jika data baru)

      Hasil    : ['nis' => 'pesan', 'nisn' => 'pesan', ...]
                 kosong = tidak ada masalah
   ------------------------------------------------------------------ */
function cek_identitas_unik($koneksi, array $isian, $tabel = '', $id = 0)
{
    $label  = ['nis' => 'NIS', 'nisn' => 'NISN', 'nip' => 'NIP'];
    $galat  = [];
    $nilai  = [];

    foreach ($isian as $kolom => $v) {
        $v = trim((string) $v);
        if ($v !== '') { $nilai[$kolom] = $v; }
    }

    // a) Sama satu sama lain di dalam isian yang sedang dikirim
    $kunci = array_keys($nilai);
    for ($i = 0; $i < count($kunci); $i++) {
        for ($j = $i + 1; $j < count($kunci); $j++) {
            $a = $kunci[$i];
            $b = $kunci[$j];
            if ($nilai[$a] === $nilai[$b]) {
                $galat[$b] = $label[$b] . ' tidak boleh sama dengan ' . $label[$a] . '.';
            }
        }
    }

    // b) Sama dengan NIS / NISN / NIP milik data lain
    $sumber = [
        ['t_siswa', 'nis',  'NIS'],
        ['t_siswa', 'nisn', 'NISN'],
        ['t_guru',  'nip',  'NIP'],
    ];
    foreach ($nilai as $kolom => $v) {
        if (isset($galat[$kolom])) { continue; }
        foreach ($sumber as $s) {
            list($t, $k, $nama) = $s;
            $sql = "SELECT id FROM `$t` WHERE `$k` = ?";
            $tipe = 's';
            $param = [$v];
            if ($t === $tabel && (int) $id > 0) {
                $sql .= " AND id <> ?";
                $tipe .= 'i';
                $param[] = (int) $id;
            }
            $sql .= " LIMIT 1";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, $tipe, ...$param);
            mysqli_stmt_execute($stmt);
            $hasil = mysqli_stmt_get_result($stmt);
            if ($hasil && mysqli_fetch_assoc($hasil)) {
                $galat[$kolom] = ($nama === $label[$kolom])
                    ? $label[$kolom] . ' ' . $v . ' sudah terdaftar.'
                    : $label[$kolom] . ' ' . $v . ' sudah dipakai sebagai ' . $nama . ' pada data lain.';
                break;
            }
        }
    }

    return $galat;
}

/* ------------------------------------------------------------------
   3. SISWA
   ------------------------------------------------------------------ */
function data_siswa_dari_post(array $post)
{
    return [
        'nis'           => trim($post['nis'] ?? ''),
        'nisn'          => trim($post['nisn'] ?? ''),
        'nama'          => trim($post['nama'] ?? ''),
        'jenis_kelamin' => $post['jenis_kelamin'] ?? '',
        'tanggal_lahir' => trim($post['tanggal_lahir'] ?? ''),
        'alamat'        => trim($post['alamat'] ?? ''),
        'status_aktif'  => (string) ($post['status_aktif'] ?? '1') === '0' ? 0 : 1,
    ];
}

function validasi_siswa($koneksi, array $v, $id = 0)
{
    $galat = [];

    if ($v['nis'] === '')  { $galat['nis']  = 'NIS wajib diisi.'; }
    if ($v['nisn'] === '') { $galat['nisn'] = 'NISN wajib diisi.'; }
    if ($v['nama'] === '') { $galat['nama'] = 'Nama wajib diisi.'; }
    if (!in_array($v['jenis_kelamin'], ['L', 'P'], true)) {
        $galat['jenis_kelamin'] = 'Pilih jenis kelamin.';
    }

    // Tanggal lahir: tahun minimal 2000 dan tidak boleh di masa depan
    $tgl = DateTime::createFromFormat('Y-m-d', $v['tanggal_lahir']);
    if ($v['tanggal_lahir'] === '') {
        $galat['tanggal_lahir'] = 'Tanggal lahir wajib diisi.';
    } elseif (!$tgl || $tgl->format('Y-m-d') !== $v['tanggal_lahir']) {
        $galat['tanggal_lahir'] = 'Format tanggal lahir tidak valid.';
    } elseif ((int) $tgl->format('Y') < TAHUN_LAHIR_MIN) {
        $galat['tanggal_lahir'] = 'Tahun lahir tidak boleh kurang dari ' . TAHUN_LAHIR_MIN . '.';
    } elseif ($v['tanggal_lahir'] > date('Y-m-d')) {
        $galat['tanggal_lahir'] = 'Tanggal lahir tidak boleh melebihi hari ini.';
    }

    // NIS / NISN tidak boleh sama dengan NIS / NISN / NIP lain
    $unik = cek_identitas_unik($koneksi, ['nis' => $v['nis'], 'nisn' => $v['nisn']], 't_siswa', $id);
    foreach ($unik as $kolom => $pesan) {
        if (!isset($galat[$kolom])) { $galat[$kolom] = $pesan; }
    }

    return $galat;
}

/* ------------------------------------------------------------------
   4. GURU
   ------------------------------------------------------------------ */
function data_guru_dari_post(array $post)
{
    return [
        'nip'          => trim($post['nip'] ?? ''),
        'nama'         => trim($post['nama'] ?? ''),
        'email'        => trim($post['email'] ?? ''),
        'status_aktif' => (string) ($post['status_aktif'] ?? '1') === '0' ? 0 : 1,
    ];
}

function validasi_guru($koneksi, array $v, $id = 0)
{
    $galat = [];

    if ($v['nip'] === '')  { $galat['nip']  = 'NIP wajib diisi.'; }
    if ($v['nama'] === '') { $galat['nama'] = 'Nama wajib diisi.'; }
    if ($v['email'] === '') {
        $galat['email'] = 'Email wajib diisi.';
    } elseif (!filter_var($v['email'], FILTER_VALIDATE_EMAIL)) {
        $galat['email'] = 'Format email tidak valid.';
    }

    // NIP tidak boleh sama dengan NIP / NIS / NISN lain
    $unik = cek_identitas_unik($koneksi, ['nip' => $v['nip']], 't_guru', $id);
    foreach ($unik as $kolom => $pesan) {
        if (!isset($galat[$kolom])) { $galat[$kolom] = $pesan; }
    }

    return $galat;
}

/* ------------------------------------------------------------------
   Potongan HTML kecil untuk form: kelas "is-invalid" + pesan error
   ------------------------------------------------------------------ */
function kelas_invalid(array $galat, $kolom)
{
    return isset($galat[$kolom]) ? ' is-invalid' : '';
}

function pesan_invalid(array $galat, $kolom)
{
    if (!isset($galat[$kolom])) { return ''; }
    return '<div class="invalid-feedback">' . htmlspecialchars($galat[$kolom]) . '</div>';
}

/* ------------------------------------------------------------------
   Pembantu form / query
   ------------------------------------------------------------------ */

// Pilihan Aktif / Tidak Aktif di form (sama di semua halaman tambah & edit)
function html_status_select($nilai, $nama = 'status_aktif')
{
    $n = ((string) $nilai === '0') ? '0' : '1';
    return '<select name="' . $nama . '" id="' . $nama . '" class="form-select">'
         . '<option value="1"' . ($n === '1' ? ' selected' : '') . '>Aktif</option>'
         . '<option value="0"' . ($n === '0' ? ' selected' : '') . '>Tidak Aktif</option>'
         . '</select>';
}

// Kotak pesan error di atas form
function html_alert_galat(array $galat)
{
    if (empty($galat)) { return ''; }
    $pesan = $galat['umum'] ?? 'Data belum bisa disimpan. Periksa kembali isian yang ditandai merah.';
    return '<div class="alert alert-danger">' . htmlspecialchars($pesan) . '</div>';
}

// Ambil banyak baris sekaligus (untuk isi dropdown)
function ambil_semua($koneksi, $sql, $tipe = '', ...$param)
{
    $stmt = mysqli_prepare($koneksi, $sql);
    if ($tipe !== '') { mysqli_stmt_bind_param($stmt, $tipe, ...$param); }
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
    $baris = [];
    while ($hasil && ($r = mysqli_fetch_assoc($hasil))) { $baris[] = $r; }
    return $baris;
}

// Ambil satu baris
function ambil_satu($koneksi, $sql, $tipe = '', ...$param)
{
    $semua = ambil_semua($koneksi, $sql, $tipe, ...$param);
    return $semua[0] ?? null;
}

// Cek login + admin (dipakai di halaman tambah & edit)
function wajib_admin()
{
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    if (($_SESSION['role'] ?? '') != "admin") {
        echo "Akses ditolak!";
        exit;
    }
}
