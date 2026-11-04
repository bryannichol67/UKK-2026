<?php
// layout/form_siswa.php
// Form dipakai bersama oleh tambah_siswa.php dan edit_siswa.php,
// sehingga tampilan tambah & edit selalu sama.
// Variabel: $v (nilai form), $galat (error per kolom), $label_tombol
$galat = $galat ?? [];
$label_tombol = $label_tombol ?? 'Simpan';
$tgl_min = TAHUN_LAHIR_MIN . '-01-01';
$tgl_max = date('Y-m-d');
?>
<?= html_alert_galat($galat); ?>

<form method="POST" id="formSiswa">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nis" class="form-label">NIS</label>
            <input type="text" name="nis" id="nis" class="form-control<?= kelas_invalid($galat, 'nis'); ?>"
                   value="<?= htmlspecialchars((string) $v['nis']); ?>" required>
            <?= pesan_invalid($galat, 'nis'); ?>
        </div>
        <div class="col-md-6 mb-3">
            <label for="nisn" class="form-label">NISN</label>
            <input type="text" name="nisn" id="nisn" class="form-control<?= kelas_invalid($galat, 'nisn'); ?>"
                   value="<?= htmlspecialchars((string) $v['nisn']); ?>" required>
            <?= pesan_invalid($galat, 'nisn'); ?>
        </div>
    </div>

    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" name="nama" id="nama" class="form-control<?= kelas_invalid($galat, 'nama'); ?>"
               value="<?= htmlspecialchars((string) $v['nama']); ?>" required>
        <?= pesan_invalid($galat, 'nama'); ?>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select<?= kelas_invalid($galat, 'jenis_kelamin'); ?>" required>
                <option value="">-- Pilih --</option>
                <option value="L" <?= ($v['jenis_kelamin'] === 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="P" <?= ($v['jenis_kelamin'] === 'P') ? 'selected' : ''; ?>>Perempuan</option>
            </select>
            <?= pesan_invalid($galat, 'jenis_kelamin'); ?>
        </div>
        <div class="col-md-6 mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                   class="form-control<?= kelas_invalid($galat, 'tanggal_lahir'); ?>"
                   value="<?= htmlspecialchars((string) $v['tanggal_lahir']); ?>"
                   min="<?= $tgl_min; ?>" max="<?= $tgl_max; ?>" required>
            <?= pesan_invalid($galat, 'tanggal_lahir'); ?>
            <div class="form-text">Tahun lahir minimal <?= TAHUN_LAHIR_MIN; ?>.</div>
        </div>
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" id="alamat" rows="4" class="form-control"><?= htmlspecialchars((string) $v['alamat']); ?></textarea>
    </div>

    <div class="mb-3">
        <label for="status_aktif" class="form-label">Status</label>
        <?= html_status_select($v['status_aktif']); ?>
    </div>

    <div class="td-actions">
        <button type="submit" name="simpan" class="btn btn-primary"><?= htmlspecialchars($label_tombol); ?></button>
        <a href="kelola_siswa.php" class="btn btn-secondary">Batal</a>
    </div>

</form>

<script>
(function () {
    // Pesan bahasa Indonesia untuk isian yang kosong / di luar batas
    var pesan = {
        nis: 'NIS wajib diisi.',
        nisn: 'NISN wajib diisi.',
        nama: 'Nama wajib diisi.',
        jenis_kelamin: 'Pilih jenis kelamin.',
        tanggal_lahir: 'Tanggal lahir wajib diisi.'
    };
    Object.keys(pesan).forEach(function (id) {
        var el = document.getElementById(id);
        if (!el) { return; }
        el.addEventListener('invalid', function () {
            if (el.validity.customError) { return; }
            if (el.validity.valueMissing) {
                el.setCustomValidity(pesan[id]);
            } else if (el.validity.rangeUnderflow) {
                el.setCustomValidity('Tahun lahir tidak boleh kurang dari <?= TAHUN_LAHIR_MIN; ?>.');
            } else if (el.validity.rangeOverflow) {
                el.setCustomValidity('Tanggal lahir tidak boleh melebihi hari ini.');
            }
        });
        el.addEventListener('input', function () { el.setCustomValidity(''); });
        el.addEventListener('change', function () { el.setCustomValidity(''); });
    });

    // NIS dan NISN tidak boleh sama
    var nis = document.getElementById('nis');
    var nisn = document.getElementById('nisn');
    function cekSama() {
        var a = nis.value.trim(), b = nisn.value.trim();
        nisn.setCustomValidity(a !== '' && a === b ? 'NISN tidak boleh sama dengan NIS.' : '');
    }
    nis.addEventListener('input', cekSama);
    nisn.addEventListener('input', cekSama);
})();
</script>
