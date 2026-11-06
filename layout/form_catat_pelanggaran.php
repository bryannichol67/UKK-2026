<?php
// layout/form_catat_pelanggaran.php
// Dipakai bersama oleh tambah_catatan_pelanggaran.php dan edit_catat_pelanggaran.php
// Variabel: $v (nilai form), $siswa, $tahun, $kelas, $pelanggaran, $guru, $label_tombol
$daftar_status = ['belum' => 'Belum Ditindaklanjuti', 'proses' => 'Proses', 'selesai' => 'Selesai'];
?>
<form method="POST">
    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Siswa</label>
            <select name="siswa_id" class="form-select" required>
                <option value="">-- Pilih Siswa --</option>
                <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                    <option value="<?= (int) $s['id']; ?>" <?= ($v['siswa_id'] == $s['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($s['nis'] . ' - ' . $s['nama']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Tahun Ajaran</label>
            <select name="tahun_ajaran_id" class="form-select" required>
                <option value="">-- Pilih Tahun Ajaran --</option>
                <?php while ($ta = mysqli_fetch_assoc($tahun)) { ?>
                    <option value="<?= (int) $ta['id']; ?>" <?= ($v['tahun_ajaran_id'] == $ta['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($ta['nama']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <?php while ($k = mysqli_fetch_assoc($kelas)) { ?>
                    <option value="<?= (int) $k['id']; ?>" <?= ($v['kelas_id'] == $k['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($k['nama'] . ' - ' . $k['tingkat'] . ' - ' . $k['jurusan']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Jenis Pelanggaran</label>
            <select name="pelanggaran_id" id="pelanggaran" class="form-select" required>
                <option value="">-- Pilih Pelanggaran --</option>
                <?php while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>
                    <option value="<?= (int) $p['id']; ?>"
                            data-poin="<?= (int) $p['poin']; ?>"
                            <?= ($v['pelanggaran_id'] == $p['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($p['nama'] . ' (' . $p['poin'] . ' poin)'); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Guru Pelapor</label>
            <select name="guru_id" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                <?php while ($g = mysqli_fetch_assoc($guru)) { ?>
                    <option value="<?= (int) $g['id']; ?>" <?= ($v['guru_id'] == $g['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($g['nama']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" min="<?= tanggal_min(); ?>"
                   value="<?= htmlspecialchars($v['tanggal']); ?>" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Poin Pelanggaran</label>
            <input type="number" name="poin" id="poin" class="form-control" min="0"
                   value="<?= htmlspecialchars($v['poin']); ?>" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <?php foreach ($daftar_status as $nilai => $nama_status) { ?>
                    <option value="<?= $nilai; ?>" <?= ($v['status'] == $nilai) ? 'selected' : ''; ?>>
                        <?= $nama_status; ?>
                    </option>
                <?php } ?>
                <?php if (!isset($daftar_status[$v['status']])) { ?>
                    <!-- status lama dari data yang sudah ada -->
                    <option value="<?= htmlspecialchars($v['status']); ?>" selected>
                        <?= htmlspecialchars($v['status']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"><?= htmlspecialchars($v['keterangan']); ?></textarea>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Tindakan</label>
            <textarea name="tindakan" class="form-control" rows="3"><?= htmlspecialchars($v['tindakan']); ?></textarea>
        </div>

    </div>

    <button type="submit" class="btn btn-primary"><?= $label_tombol; ?></button>
    <a href="catat_pelanggaran.php" class="btn btn-secondary">Batal</a>
</form>

<script>
    // Poin terisi otomatis saat jenis pelanggaran dipilih (masih bisa diubah manual)
    document.getElementById('pelanggaran').addEventListener('change', function () {
        var opsi = this.options[this.selectedIndex];
        document.getElementById('poin').value = opsi.dataset.poin || '';
    });
</script>
