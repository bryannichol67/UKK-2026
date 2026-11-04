<?php
// layout/form_guru.php
// Form dipakai bersama oleh tambah_guru.php dan edit_guru.php.
// Variabel: $v (nilai form), $galat (error per kolom), $label_tombol
$galat = $galat ?? [];
$label_tombol = $label_tombol ?? 'Simpan';
?>
<?= html_alert_galat($galat); ?>

<form method="POST" id="formGuru">

    <div class="mb-3">
        <label for="nip" class="form-label">NIP</label>
        <input type="text" name="nip" id="nip" class="form-control<?= kelas_invalid($galat, 'nip'); ?>"
               value="<?= htmlspecialchars((string) $v['nip']); ?>" required>
        <?= pesan_invalid($galat, 'nip'); ?>
    </div>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" name="nama" id="nama" class="form-control<?= kelas_invalid($galat, 'nama'); ?>"
               value="<?= htmlspecialchars((string) $v['nama']); ?>" required>
        <?= pesan_invalid($galat, 'nama'); ?>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control<?= kelas_invalid($galat, 'email'); ?>"
               value="<?= htmlspecialchars((string) $v['email']); ?>" required>
        <?= pesan_invalid($galat, 'email'); ?>
    </div>
    <div class="mb-3">
        <label for="status_aktif" class="form-label">Status</label>
        <?= html_status_select($v['status_aktif']); ?>
    </div>

    <div class="td-actions">
        <button type="submit" name="simpan" class="btn btn-primary"><?= htmlspecialchars($label_tombol); ?></button>
        <a href="kelola_guru.php" class="btn btn-secondary">Batal</a>
    </div>

</form>

<script>
(function () {
    var pesan = { nip: 'NIP wajib diisi.', nama: 'Nama wajib diisi.', email: 'Email wajib diisi dengan format yang benar.' };
    Object.keys(pesan).forEach(function (id) {
        var el = document.getElementById(id);
        el.addEventListener('invalid', function () {
            if (el.validity.valueMissing || el.validity.typeMismatch) { el.setCustomValidity(pesan[id]); }
        });
        el.addEventListener('input', function () { el.setCustomValidity(''); });
    });
})();
</script>
