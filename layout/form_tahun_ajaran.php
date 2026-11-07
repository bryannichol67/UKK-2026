<?php
// layout/form_tahun_ajaran.php - dipakai bersama oleh tambah_tahun_ajaran.php dan edit_tahun_ajaran.php
$galat = $galat ?? [];
$label_tombol = $label_tombol ?? 'Simpan';
?>
<?= html_alert_galat($galat); ?>

<form method="POST">

    <div class="mb-3">
        <label for="nama" class="form-label">Nama Tahun Ajaran</label>
        <input type="text" name="nama" id="nama" class="form-control<?= kelas_invalid($galat, 'nama'); ?>"
               value="<?= htmlspecialchars((string) $v['nama']); ?>" placeholder="Contoh: 2026/2027" required>
        <?= pesan_invalid($galat, 'nama'); ?>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control<?= kelas_invalid($galat, 'tanggal_mulai'); ?>"
                   value="<?= htmlspecialchars((string) $v['tanggal_mulai']); ?>" required>
            <?= pesan_invalid($galat, 'tanggal_mulai'); ?>
        </div>
        <div class="col-md-6 mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control<?= kelas_invalid($galat, 'tanggal_selesai'); ?>"
                   value="<?= htmlspecialchars((string) $v['tanggal_selesai']); ?>" required>
            <?= pesan_invalid($galat, 'tanggal_selesai'); ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="status_aktif" class="form-label">Status</label>
        <?= html_status_select($v['status_aktif'], 'status_aktif', isset($galat['status_aktif'])); ?>
        <?= pesan_invalid($galat, 'status_aktif'); ?>
    </div>

    <div class="td-actions">
        <button type="submit" name="simpan" class="btn btn-primary"><?= htmlspecialchars($label_tombol); ?></button>
        <a href="kelola_tahun_ajaran.php" class="btn btn-secondary">Batal</a>
    </div>

</form>
