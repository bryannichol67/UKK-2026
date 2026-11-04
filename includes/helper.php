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

// Panjang maksimal NIS dan NISN (digit angka)
if (!defined('PANJANG_NIS')) {
    define('PANJANG_NIS', 15);
}
if (!defined('PANJANG_NISN')) {
    define('PANJANG_NISN', 10);
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

    // NIS maksimal 15 digit, NISN maksimal 10 digit, keduanya hanya angka
    if ($v['nis'] === '') {
        $galat['nis'] = 'NIS wajib diisi.';
    } elseif (!ctype_digit($v['nis'])) {
        $galat['nis'] = 'NIS hanya boleh berisi angka.';
    } elseif (strlen($v['nis']) > PANJANG_NIS) {
        $galat['nis'] = 'NIS maksimal ' . PANJANG_NIS . ' digit.';
    }

    if ($v['nisn'] === '') {
        $galat['nisn'] = 'NISN wajib diisi.';
    } elseif (!ctype_digit($v['nisn'])) {
        $galat['nisn'] = 'NISN hanya boleh berisi angka.';
    } elseif (strlen($v['nisn']) > PANJANG_NISN) {
        $galat['nisn'] = 'NISN maksimal ' . PANJANG_NISN . ' digit.';
    }
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
function html_status_select($nilai, $nama = 'status_aktif', $invalid = false)
{
    $n = ((string) $nilai === '0') ? '0' : '1';
    return '<select name="' . $nama . '" id="' . $nama . '" class="form-select' . ($invalid ? ' is-invalid' : '') . '">'
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

/* ------------------------------------------------------------------
   5. KELAS: tingkat & jurusan dipilih lewat dropdown
   ------------------------------------------------------------------ */
function daftar_tingkat() { return ['X', 'XI', 'XII']; }
function daftar_jurusan() { return ['RPL', 'TKJ', 'TKR', 'TSM', 'BD']; }

// Isi <option> dropdown. Nilai lama yang tidak ada di daftar tetap ditampilkan
// supaya data lama tidak hilang saat diedit.
function html_opsi(array $daftar, $nilai)
{
    $nilai = (string) $nilai;
    if ($nilai !== '' && !in_array($nilai, $daftar, true)) { $daftar[] = $nilai; }

    $html = '';
    foreach ($daftar as $d) {
        $html .= '<option value="' . htmlspecialchars($d) . '"' . ($d === $nilai ? ' selected' : '') . '>'
               . htmlspecialchars($d) . '</option>';
    }
    return $html;
}

// $asli = data kelas sebelum diedit (nilai lamanya boleh tetap dipakai)
function validasi_kelas(array $v, array $asli = [])
{
    $galat = [];

    if ($v['nama'] === '') { $galat['nama'] = 'Nama kelas wajib diisi.'; }

    foreach (['tingkat' => 'Tingkat', 'jurusan' => 'Jurusan'] as $kolom => $label) {
        $daftar = ($kolom === 'tingkat') ? daftar_tingkat() : daftar_jurusan();
        if (!empty($asli[$kolom])) { $daftar[] = $asli[$kolom]; }

        if ($v[$kolom] === '') {
            $galat[$kolom] = $label . ' wajib dipilih.';
        } elseif (!in_array($v[$kolom], $daftar, true)) {
            $galat[$kolom] = $label . ' tidak valid, pilih dari daftar.';
        }
    }
    return $galat;
}

/* ------------------------------------------------------------------
   6. TAHUN AJARAN: hanya boleh ada satu yang aktif
   ------------------------------------------------------------------ */
// Tahun ajaran LAIN yang sedang aktif ($id = tahun yang sedang diedit, 0 jika baru)
function tahun_aktif_lain($koneksi, $id = 0)
{
    return ambil_satu($koneksi,
        "SELECT id, nama FROM t_tahun_ajaran WHERE status_aktif = 1 AND id <> ? ORDER BY id LIMIT 1",
        'i', (int) $id);
}

function pesan_tahun_aktif_ganda(array $aktif)
{
    return 'Sudah ada tahun ajaran aktif (' . $aktif['nama'] . '). '
         . 'Nonaktifkan dulu tahun ajaran tersebut, atau ubah status ini menjadi Tidak Aktif.';
}

// Apakah $id adalah tahun ajaran yang berstatus aktif?
function tahun_ajaran_aktif($koneksi, $id)
{
    return (bool) ambil_satu($koneksi,
        "SELECT id FROM t_tahun_ajaran WHERE id = ? AND status_aktif = 1", 'i', (int) $id);
}

/* ------------------------------------------------------------------
   7. WALI KELAS: tahun ajaran harus aktif, kelas dan guru belum
      punya / jadi wali kelas pada tahun ajaran tersebut
   ------------------------------------------------------------------ */
function validasi_wali_kelas_unik($koneksi, array $v, $id = 0)
{
    $galat = [];

    if (!tahun_ajaran_aktif($koneksi, $v['tahun_ajaran_id'])) {
        $galat['tahun_ajaran_id'] = 'Pilih tahun ajaran yang berstatus aktif.';
        return $galat;
    }

    // Data berstatus Tidak Aktif tidak menghalangi kelas / guru lain
    if ((int) $v['status_aktif'] !== 1) { return $galat; }

    $kelas_ada = ambil_satu($koneksi,
        "SELECT id FROM t_wali_kelas WHERE status_aktif = 1 AND tahun_ajaran_id = ? AND kelas_id = ? AND id <> ? LIMIT 1",
        'iii', (int) $v['tahun_ajaran_id'], (int) $v['kelas_id'], (int) $id);
    if ($kelas_ada) { $galat['kelas_id'] = 'Kelas ini sudah memiliki wali kelas.'; }

    $guru_ada = ambil_satu($koneksi,
        "SELECT id FROM t_wali_kelas WHERE status_aktif = 1 AND tahun_ajaran_id = ? AND guru_id = ? AND id <> ? LIMIT 1",
        'iii', (int) $v['tahun_ajaran_id'], (int) $v['guru_id'], (int) $id);
    if ($guru_ada) { $galat['guru_id'] = 'Guru ini sudah menjadi wali kelas.'; }

    return $galat;
}

/* ------------------------------------------------------------------
   8. PENEMPATAN SISWA: satu siswa hanya satu kelas per tahun ajaran
   ------------------------------------------------------------------ */
// $id = id penempatan yang sedang diedit (0 jika baru)
function siswa_sudah_ditempatkan($koneksi, $siswa_id, $tahun_id, $id = 0)
{
    return (bool) ambil_satu($koneksi,
        "SELECT id FROM t_kelas_siswa WHERE status_aktif = 1 AND siswa_id = ? AND tahun_ajaran_id = ? AND id <> ? LIMIT 1",
        'iii', (int) $siswa_id, (int) $tahun_id, (int) $id);
}
