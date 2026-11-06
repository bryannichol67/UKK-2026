<?php
// layout/form_penempatan.php
// Form dipakai bersama oleh tambah_penempatan_siswa.php dan edit_penempatan_siswa.php
// Variabel yang dibutuhkan: $v (nilai form), $siswa, $tahun, $kelas, $label_tombol
?>
<form method="POST">

    <div class="mb-3">
        <label for="siswa_id" class="form-label">Siswa</label>
        <select name="siswa_id" id="siswa_id" class="form-select" required>
            <option value="">-- Pilih Siswa --</option>
            <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                <option value="<?= (int) $s['id']; ?>" <?= ($v['siswa_id'] == $s['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($s['nis'] . ' - ' . $s['nama']); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
        <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select" required>
            <option value="">-- Pilih Tahun Ajaran --</option>
            <?php while ($ta = mysqli_fetch_assoc($tahun)) { ?>
                <option value="<?= (int) $ta['id']; ?>" <?= ($v['tahun_ajaran_id'] == $ta['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($ta['nama']); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="kelas_id" class="form-label">Kelas</label>
        <select name="kelas_id" id="kelas_id" class="form-select" required>
            <option value="">-- Pilih Kelas --</option>
            <?php while ($k = mysqli_fetch_assoc($kelas)) { ?>
                <option value="<?= (int) $k['id']; ?>" <?= ($v['kelas_id'] == $k['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($k['nama'] . ' - Tingkat ' . $k['tingkat'] . ' - ' . $k['jurusan']); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" min="<?= tanggal_min(); ?>" class="form-control"
                   value="<?= htmlspecialchars($v['tanggal_mulai']); ?>" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" min="<?= tanggal_min(); ?>" class="form-control"
                   value="<?= htmlspecialchars($v['tanggal_selesai']); ?>" required>
        </div>
    </div>

    <div class="mb-4">
        <label for="status_aktif" class="form-label">Status</label>
        <select name="status_aktif" id="status_aktif" class="form-select" required>
            <option value="1" <?= ($v['status_aktif'] == 1) ? 'selected' : ''; ?>>Aktif</option>
            <option value="0" <?= ($v['status_aktif'] == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary"><?= $label_tombol; ?></button>
    <a href="penempatan_siswa.php" class="btn btn-secondary">Batal</a>
</form>
