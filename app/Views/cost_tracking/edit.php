<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Edit Biaya Maintenance</h3>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/cost-tracking/update/' . $cost['id_cost']); ?>" method="post">
            <div class="mb-3">
                <label>Maintenance</label>
                <select name="id_maintenance" class="form-control" required>
                    <option value="">-- Pilih Maintenance --</option>
                    <?php foreach ($maintenance as $row) : ?>
                        <option value="<?= $row['id_maintenance']; ?>" <?= $cost['id_maintenance'] == $row['id_maintenance'] ? 'selected' : ''; ?>>
                            <?= esc($row['kode_aset']); ?> - <?= esc($row['nama_aset']); ?> |
                            <?= esc(str_replace('_', ' ', ucfirst($row['jenis_pekerjaan']))); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Jenis Biaya</label>
                <select name="jenis_biaya" class="form-control" required>
                    <option value="sparepart" <?= $cost['jenis_biaya'] === 'sparepart' ? 'selected' : ''; ?>>Sparepart</option>
                    <option value="jasa_vendor" <?= $cost['jenis_biaya'] === 'jasa_vendor' ? 'selected' : ''; ?>>Jasa Vendor</option>
                    <option value="transportasi" <?= $cost['jenis_biaya'] === 'transportasi' ? 'selected' : ''; ?>>Transportasi</option>
                    <option value="lainnya" <?= $cost['jenis_biaya'] === 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Deskripsi Biaya</label>
                <input type="text" name="deskripsi_biaya" class="form-control" value="<?= esc($cost['deskripsi_biaya']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Nominal</label>
                <input type="number" name="nominal" class="form-control" value="<?= esc($cost['nominal']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Tanggal Biaya</label>
                <input type="date" name="tanggal_biaya" class="form-control" value="<?= esc($cost['tanggal_biaya']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('/admin/cost-tracking'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>