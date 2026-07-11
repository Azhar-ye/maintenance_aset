<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Tambah Jadwal Maintenance</h3>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/jadwal-maintenance/store'); ?>" method="post">
            <div class="mb-3">
                <label>Aset</label>
                <select name="id_aset" class="form-control" required>
                    <option value="">-- Pilih Aset --</option>
                    <?php foreach ($aset as $row) : ?>
                        <option value="<?= $row['id_aset']; ?>">
                            <?= esc($row['kode_aset']); ?> - <?= esc($row['nama_aset']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Jadwal</label>
                <input type="date" name="tanggal_jadwal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jenis Maintenance</label>
                <input type="text" name="jenis_maintenance" class="form-control" placeholder="Contoh: Cleaning, pengecekan rutin, ganti oli" required>
            </div>

            <div class="mb-3">
                <label>Periode</label>
                <select name="periode" class="form-control" required>
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                    <option value="3_bulanan">3 Bulanan</option>
                    <option value="6_bulanan">6 Bulanan</option>
                    <option value="tahunan">Tahunan</option>
                    <option value="sekali">Sekali</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Prioritas</label>
                <select name="prioritas" class="form-control" required>
                    <option value="rendah">Rendah</option>
                    <option value="sedang">Sedang</option>
                    <option value="tinggi">Tinggi</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Status Jadwal</label>
                <select name="status_jadwal" class="form-control" required>
                    <option value="terjadwal">Terjadwal</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('/admin/jadwal-maintenance'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>