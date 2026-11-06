<?php
// layout/form_wali_kelas.php - dipakai bersama oleh tambah_wali_kelas.php dan edit_wali_kelas.php
// Variabel: $v, $galat, $label_tombol, $daftar_tahun, $daftar_kelas, $daftar_guru
$galat = $galat ?? [];
$label_tombol = $label_tombol ?? 'Simpan';
?>
<?= html_alert_galat($galat); ?>

<form method="POST">

    <div class="mb-3">
        <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
        <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select<?= kelas_invalid($galat, 'tahun_ajaran_id'); ?>" required>
            <option value="">-- Pilih Tahun Ajaran --</option>
            <?php foreach ($daftar_tahun as $t) { ?>
                <option value="<?= (int) $t['id']; ?>" <?= ((string) $v['tahun_ajaran_id'] === (string) $t['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($t['nama']); ?>
                </option>
            <?php } ?>
        </select>
        <?= pesan_invalid($galat, 'tahun_ajaran_id'); ?>
    </div>
    <div class="mb-3">
        <label for="kelas_id" class="form-label">Kelas</label>
        <select name="kelas_id" id="kelas_id" class="form-select<?= kelas_invalid($galat, 'kelas_id'); ?>" required>
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($daftar_kelas as $k) { ?>
                <option value="<?= (int) $k['id']; ?>" <?= ((string) $v['kelas_id'] === (string) $k['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($k['nama'] . ' - ' . $k['tingkat'] . ' ' . $k['jurusan']); ?>
                </option>
            <?php } ?>
        </select>
        <?= pesan_invalid($galat, 'kelas_id'); ?>
    </div>
    <div class="mb-3">
        <label for="guru_id" class="form-label">Guru / Wali Kelas</label>
        <select name="guru_id" id="guru_id" class="form-select<?= kelas_invalid($galat, 'guru_id'); ?>" required>
            <option value="">-- Pilih Guru --</option>
            <?php foreach ($daftar_guru as $g) { ?>
                <option value="<?= (int) $g['id']; ?>" <?= ((string) $v['guru_id'] === (string) $g['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($g['nip'] . ' - ' . $g['nama']); ?>
                </option>
            <?php } ?>
        </select>
        <?= pesan_invalid($galat, 'guru_id'); ?>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" min="<?= tanggal_min(); ?>" class="form-control<?= kelas_invalid($galat, 'tanggal_mulai'); ?>"
                   value="<?= htmlspecialchars((string) $v['tanggal_mulai']); ?>" required>
            <?= pesan_invalid($galat, 'tanggal_mulai'); ?>
        </div>
        <div class="col-md-6 mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" min="<?= tanggal_min(); ?>" class="form-control<?= kelas_invalid($galat, 'tanggal_selesai'); ?>"
                   value="<?= htmlspecialchars((string) $v['tanggal_selesai']); ?>" required>
            <?= pesan_invalid($galat, 'tanggal_selesai'); ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="status_aktif" class="form-label">Status</label>
        <?= html_status_select($v['status_aktif']); ?>
    </div>

    <div class="td-actions">
        <button type="submit" name="simpan" class="btn btn-primary"><?= htmlspecialchars($label_tombol); ?></button>
        <a href="kelola_wali_kelas.php" class="btn btn-secondary">Batal</a>
    </div>

</form>
