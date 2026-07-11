<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Tambah Maintenance</h3>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/maintenance/store'); ?>" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
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

                <div class="col-md-6 mb-3">
                    <label>Vendor</label>
                    <select name="id_vendor" class="form-control">
                        <option value="">-- Pilih Vendor --</option>
                        <?php foreach ($vendor as $row) : ?>
                            <option value="<?= $row['id_vendor']; ?>">
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
                            <option value="<?= $row['id_laporan']; ?>">
                                <?= esc($row['kode_aset']); ?> - <?= esc($row['nama_aset']); ?> | <?= esc($row['judul_laporan']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Pekerjaan</label>
                    <select name="jenis_pekerjaan" class="form-control" required>
                        <option value="maintenance_rutin">Maintenance Rutin</option>
                        <option value="perbaikan_kerusakan">Perbaikan Kerusakan</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status Pekerjaan</label>
                    <select name="status_pekerjaan" class="form-control" required>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi_pekerjaan" class="form-control" rows="3"></textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Hasil Pekerjaan</label>
                    <textarea name="hasil_pekerjaan" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('/admin/maintenance'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>