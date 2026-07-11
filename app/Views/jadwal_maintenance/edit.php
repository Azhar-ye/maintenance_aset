<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Edit Jadwal Maintenance</h3>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/jadwal-maintenance/update/' . $jadwal['id_jadwal']); ?>" method="post">
            <div class="mb-3">
                <label>Aset</label>
                <select name="id_aset" class="form-control" required>
                    <option value="">-- Pilih Aset --</option>
                    <?php foreach ($aset as $row) : ?>
                        <option value="<?= $row['id_aset']; ?>" <?= $jadwal['id_aset'] == $row['id_aset'] ? 'selected' : ''; ?>>
                            <?= esc($row['kode_aset']); ?> - <?= esc($row['nama_aset']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Jadwal</label>
                <input type="date" name="tanggal_jadwal" class="form-control" value="<?= esc($jadwal['tanggal_jadwal']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Jenis Maintenance</label>
                <input type="text" name="jenis_maintenance" class="form-control" value="<?= esc($jadwal['jenis_maintenance']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Periode</label>
                <select name="periode" class="form-control" required>
                    <option value="mingguan" <?= $jadwal['periode'] === 'mingguan' ? 'selected' : ''; ?>>Mingguan</option>
                    <option value="bulanan" <?= $jadwal['periode'] === 'bulanan' ? 'selected' : ''; ?>>Bulanan</option>
                    <option value="3_bulanan" <?= $jadwal['periode'] === '3_bulanan' ? 'selected' : ''; ?>>3 Bulanan</option>
                    <option value="6_bulanan" <?= $jadwal['periode'] === '6_bulanan' ? 'selected' : ''; ?>>6 Bulanan</option>
                    <option value="tahunan" <?= $jadwal['periode'] === 'tahunan' ? 'selected' : ''; ?>>Tahunan</option>
                    <option value="sekali" <?= $jadwal['periode'] === 'sekali' ? 'selected' : ''; ?>>Sekali</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Prioritas</label>
                <select name="prioritas" class="form-control" required>
                    <option value="rendah" <?= $jadwal['prioritas'] === 'rendah' ? 'selected' : ''; ?>>Rendah</option>
                    <option value="sedang" <?= $jadwal['prioritas'] === 'sedang' ? 'selected' : ''; ?>>Sedang</option>
                    <option value="tinggi" <?= $jadwal['prioritas'] === 'tinggi' ? 'selected' : ''; ?>>Tinggi</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Status Jadwal</label>
                <select name="status_jadwal" class="form-control" required>
                    <option value="terjadwal" <?= $jadwal['status_jadwal'] === 'terjadwal' ? 'selected' : ''; ?>>Terjadwal</option>
                    <option value="diproses" <?= $jadwal['status_jadwal'] === 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                    <option value="selesai" <?= $jadwal['status_jadwal'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                    <option value="dibatalkan" <?= $jadwal['status_jadwal'] === 'dibatalkan' ? 'selected' : ''; ?>>Dibatalkan</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"><?= esc($jadwal['keterangan']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('/admin/jadwal-maintenance'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>