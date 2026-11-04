<?php
// layout/form_kelas.php - dipakai bersama oleh tambah_kelas.php dan edit_kelas.php
$galat = $galat ?? [];
$label_tombol = $label_tombol ?? 'Simpan';
?>
<?= html_alert_galat($galat); ?>

<form method="POST">

    <div class="mb-3">
        <label for="nama" class="form-label">Nama Kelas</label>
        <input type="text" name="nama" id="nama" class="form-control<?= kelas_invalid($galat, 'nama'); ?>"
               value="<?= htmlspecialchars((string) $v['nama']); ?>" required>
        <?= pesan_invalid($galat, 'nama'); ?>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="tingkat" class="form-label">Tingkat</label>
            <input type="text" name="tingkat" id="tingkat" class="form-control<?= kelas_invalid($galat, 'tingkat'); ?>"
                   value="<?= htmlspecialchars((string) $v['tingkat']); ?>" required>
            <?= pesan_invalid($galat, 'tingkat'); ?>
        </div>
        <div class="col-md-6 mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <input type="text" name="jurusan" id="jurusan" class="form-control<?= kelas_invalid($galat, 'jurusan'); ?>"
                   value="<?= htmlspecialchars((string) $v['jurusan']); ?>" required>
            <?= pesan_invalid($galat, 'jurusan'); ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="status_aktif" class="form-label">Status</label>
        <?= html_status_select($v['status_aktif']); ?>
    </div>

    <div class="td-actions">
        <button type="submit" name="simpan" class="btn btn-primary"><?= htmlspecialchars($label_tombol); ?></button>
        <a href="kelola_kelas.php" class="btn btn-secondary">Batal</a>
    </div>

</form>
