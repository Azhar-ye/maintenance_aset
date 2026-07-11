<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Edit Aset</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('/admin/aset/update/' . $aset['id_aset']); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Kode Aset</label>
                    <input type="text" name="kode_aset" class="form-control" value="<?= esc($aset['kode_aset']); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Nama Aset</label>
                    <input type="text" name="nama_aset" class="form-control" value="<?= esc($aset['nama_aset']); ?>" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Kategori</label>
                    <select name="id_kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $row) : ?>
                            <option value="<?= $row['id_kategori']; ?>" <?= $aset['id_kategori'] == $row['id_kategori'] ? 'selected' : ''; ?>>
                                <?= esc($row['nama_kategori']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Lokasi</label>
                    <select name="id_lokasi" class="form-control" required>
                        <option value="">-- Pilih Lokasi --</option>
                        <?php foreach ($lokasi as $row) : ?>
                            <option value="<?= $row['id_lokasi']; ?>" <?= $aset['id_lokasi'] == $row['id_lokasi'] ? 'selected' : ''; ?>>
                                <?= esc($row['nama_lokasi']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Divisi</label>
                    <select name="id_divisi" class="form-control" required>
                        <option value="">-- Pilih Divisi --</option>
                        <?php foreach ($divisi as $row) : ?>
                            <option value="<?= $row['id_divisi']; ?>" <?= $aset['id_divisi'] == $row['id_divisi'] ? 'selected' : ''; ?>>
                                <?= esc($row['nama_divisi']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Merk</label>
                    <input type="text" name="merk" class="form-control" value="<?= esc($aset['merk']); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Pembelian</label>
                    <input type="date" name="tanggal_pembelian" class="form-control" value="<?= esc($aset['tanggal_pembelian']); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Harga Pembelian</label>
                    <input type="number" name="harga_pembelian" class="form-control" value="<?= esc($aset['harga_pembelian']); ?>">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control">
                        <option value="baik" <?= $aset['kondisi'] === 'baik' ? 'selected' : ''; ?>>Baik</option>
                        <option value="perlu_maintenance" <?= $aset['kondisi'] === 'perlu_maintenance' ? 'selected' : ''; ?>>Perlu Maintenance</option>
                        <option value="rusak_ringan" <?= $aset['kondisi'] === 'rusak_ringan' ? 'selected' : ''; ?>>Rusak Ringan</option>
                        <option value="rusak_berat" <?= $aset['kondisi'] === 'rusak_berat' ? 'selected' : ''; ?>>Rusak Berat</option>
                        <option value="tidak_digunakan" <?= $aset['kondisi'] === 'tidak_digunakan' ? 'selected' : ''; ?>>Tidak Digunakan</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Status Aset</label>
                    <select name="status_aset" class="form-control">
                        <option value="aktif" <?= $aset['status_aset'] === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                        <option value="maintenance" <?= $aset['status_aset'] === 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                        <option value="rusak" <?= $aset['status_aset'] === 'rusak' ? 'selected' : ''; ?>>Rusak</option>
                        <option value="nonaktif" <?= $aset['status_aset'] === 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Foto Aset Saat Ini</label>
                    <div class="border rounded p-3 bg-light">
                        <?php if (!empty($aset['foto_aset'])) : ?>
                            <img src="<?= base_url('uploads/aset/' . $aset['foto_aset']); ?>"
                                 alt="Foto Aset"
                                 style="width: 120px; height: 90px; object-fit: cover; border-radius: 8px;">
                            <div class="mt-2">
                                <small class="text-muted"><?= esc($aset['foto_aset']); ?></small>
                            </div>
                        <?php else : ?>
                            <span class="text-muted">Belum ada foto aset.</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Ganti Foto Aset</label>

                    <input
                        type="file"
                        name="foto_aset"
                        class="form-control"
                        accept="image/*">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti foto.
                    </small>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Spesifikasi</label>
                    <textarea name="spesifikasi" class="form-control" rows="3"><?= esc($aset['spesifikasi']); ?></textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"><?= esc($aset['keterangan']); ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>
                Update
            </button>

            <a href="<?= base_url('/admin/aset'); ?>" class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>