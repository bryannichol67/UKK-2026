<?php
// layout/form_jenis_pelanggaran.php - dipakai bersama oleh tambah_jenis_pelanggaran.php dan edit_jenis_pelanggaran.php
// Variabel: $v, $galat, $label_tombol, $daftar_kategori
$galat = $galat ?? [];
$label_tombol = $label_tombol ?? 'Simpan';
?>
<?= html_alert_galat($galat); ?>

<form method="POST">

    <div class="mb-3">
        <label for="pelanggaran_kategori_id" class="form-label">Kategori Pelanggaran</label>
        <select name="pelanggaran_kategori_id" id="pelanggaran_kategori_id"
                class="form-select<?= kelas_invalid($galat, 'pelanggaran_kategori_id'); ?>" required>
            <option value="">-- Pilih Kategori --</option>
            <?php foreach ($daftar_kategori as $kat) { ?>
                <option value="<?= (int) $kat['id']; ?>" <?= ((string) $v['pelanggaran_kategori_id'] === (string) $kat['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($kat['nama']); ?>
                </option>
            <?php } ?>
        </select>
        <?= pesan_invalid($galat, 'pelanggaran_kategori_id'); ?>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" name="kode" id="kode" class="form-control<?= kelas_invalid($galat, 'kode'); ?>"
                   value="<?= htmlspecialchars((string) $v['kode']); ?>" placeholder="Contoh: PG-001" required>
            <?= pesan_invalid($galat, 'kode'); ?>
        </div>
        <div class="col-md-6 mb-3">
            <label for="poin" class="form-label">Poin</label>
            <input type="number" name="poin" id="poin" min="0" class="form-control<?= kelas_invalid($galat, 'poin'); ?>"
                   value="<?= htmlspecialchars((string) $v['poin']); ?>" required>
            <?= pesan_invalid($galat, 'poin'); ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Pelanggaran</label>
        <input type="text" name="nama" id="nama" class="form-control<?= kelas_invalid($galat, 'nama'); ?>"
               value="<?= htmlspecialchars((string) $v['nama']); ?>" required>
        <?= pesan_invalid($galat, 'nama'); ?>
    </div>
    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control"><?= htmlspecialchars((string) $v['deskripsi']); ?></textarea>
    </div>
    <div class="mb-3">
        <label for="status_aktif" class="form-label">Status</label>
        <?= html_status_select($v['status_aktif']); ?>
    </div>

    <div class="td-actions">
        <button type="submit" name="simpan" class="btn btn-primary"><?= htmlspecialchars($label_tombol); ?></button>
        <a href="kelola_jenis_pelanggaran.php" class="btn btn-secondary">Batal</a>
    </div>

</form>
