<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Tambah Biaya Maintenance</h3>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/cost-tracking/store'); ?>" method="post">
            <div class="mb-3">
                <label>Maintenance</label>
                <select name="id_maintenance" class="form-control" required>
                    <option value="">-- Pilih Maintenance --</option>
                    <?php foreach ($maintenance as $row) : ?>
                        <option value="<?= $row['id_maintenance']; ?>">
                            <?= esc($row['kode_aset']); ?> - <?= esc($row['nama_aset']); ?> |
                            <?= esc(str_replace('_', ' ', ucfirst($row['jenis_pekerjaan']))); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Jenis Biaya</label>
                <select name="jenis_biaya" class="form-control" required>
                    <option value="sparepart">Sparepart</option>
                    <option value="jasa_vendor">Jasa Vendor</option>
                    <option value="transportasi">Transportasi</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Deskripsi Biaya</label>
                <input type="text" name="deskripsi_biaya" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Nominal</label>
                <input type="number" name="nominal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tanggal Biaya</label>
                <input type="date" name="tanggal_biaya" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('/admin/cost-tracking'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>