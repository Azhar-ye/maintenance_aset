<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Tambah Aset</h3>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/aset/store'); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Kode Aset</label>
                    <input type="text" name="kode_aset" class="form-control" placeholder="Contoh: AST-LPT-001" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Nama Aset</label>
                    <input type="text" name="nama_aset" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Kategori</label>
                    <select name="id_kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $row) : ?>
                            <option value="<?= $row['id_kategori']; ?>"><?= esc($row['nama_kategori']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Lokasi</label>
                    <select name="id_lokasi" class="form-control" required>
                        <option value="">-- Pilih Lokasi --</option>
                        <?php foreach ($lokasi as $row) : ?>
                            <option value="<?= $row['id_lokasi']; ?>"><?= esc($row['nama_lokasi']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Divisi</label>
                    <select name="id_divisi" class="form-control" required>
                        <option value="">-- Pilih Divisi --</option>
                        <?php foreach ($divisi as $row) : ?>
                            <option value="<?= $row['id_divisi']; ?>"><?= esc($row['nama_divisi']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Merk</label>
                    <input type="text" name="merk" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Pembelian</label>
                    <input type="date" name="tanggal_pembelian" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Harga Pembelian</label>
                    <input type="number" name="harga_pembelian" class="form-control" value="0">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control">
                        <option value="baik">Baik</option>
                        <option value="perlu_maintenance">Perlu Maintenance</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                        <option value="tidak_digunakan">Tidak Digunakan</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Status Aset</label>
                    <select name="status_aset" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="rusak">Rusak</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Foto Aset</label>
                    <input
                        type="file"
                        name="foto_aset"
                        class="form-control"
                        accept="image/*">

                    <small class="text-muted">
                        Format: JPG, PNG, JPEG
                    </small>
                </div>
                                
                <div class="col-md-12 mb-3">
                    <label>Spesifikasi</label>
                    <textarea name="spesifikasi" class="form-control" rows="3"></textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('/admin/aset'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>