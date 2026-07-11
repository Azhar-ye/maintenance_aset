<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Edit Maintenance</h3>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/maintenance/update/' . $maintenance['id_maintenance']); ?>" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Aset</label>
                    <select name="id_aset" class="form-control" required>
                        <option value="">-- Pilih Aset --</option>
                        <?php foreach ($aset as $row) : ?>
                            <option value="<?= $row['id_aset']; ?>" <?= $maintenance['id_aset'] == $row['id_aset'] ? 'selected' : ''; ?>>
                                <?= esc($row['kode_aset']); ?> - <?= esc($row['nama_aset']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Vendor</label>
                    <select name="id_vendor" class="form-control">
                        <option value="">-- Pilih Vendor --</option>
                        <?php foreach ($vendor as $row) : ?>
                            <option value="<?= $row['id_vendor']; ?>" <?= $maintenance['id_vendor'] == $row['id_vendor'] ? 'selected' : ''; ?>>
                                <?= esc($row['nama_vendor']); ?> - <?= esc($row['jenis_layanan']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Laporan Kerusakan Terkait</label>
                    <select name="id_laporan" class="form-control">
                        <option value="">-- Tidak terkait laporan --</option>
                        <?php foreach ($laporan as $row) : ?>
                            <option value="<?= $row['id_laporan']; ?>" <?= $maintenance['id_laporan'] == $row['id_laporan'] ? 'selected' : ''; ?>>
                                <?= esc($row['kode_aset']); ?> - <?= esc($row['nama_aset']); ?> | <?= esc($row['judul_laporan']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Pekerjaan</label>
                    <select name="jenis_pekerjaan" class="form-control" required>
                        <option value="maintenance_rutin" <?= $maintenance['jenis_pekerjaan'] === 'maintenance_rutin' ? 'selected' : ''; ?>>Maintenance Rutin</option>
                        <option value="perbaikan_kerusakan" <?= $maintenance['jenis_pekerjaan'] === 'perbaikan_kerusakan' ? 'selected' : ''; ?>>Perbaikan Kerusakan</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status Pekerjaan</label>
                    <select name="status_pekerjaan" class="form-control" required>
                        <option value="diproses" <?= $maintenance['status_pekerjaan'] === 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                        <option value="selesai" <?= $maintenance['status_pekerjaan'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                        <option value="dibatalkan" <?= $maintenance['status_pekerjaan'] === 'dibatalkan' ? 'selected' : ''; ?>>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="<?= esc($maintenance['tanggal_mulai']); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="<?= esc($maintenance['tanggal_selesai']); ?>">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi_pekerjaan" class="form-control" rows="3"><?= esc($maintenance['deskripsi_pekerjaan']); ?></textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Hasil Pekerjaan</label>
                    <textarea name="hasil_pekerjaan" class="form-control" rows="3"><?= esc($maintenance['hasil_pekerjaan']); ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('/admin/maintenance'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>