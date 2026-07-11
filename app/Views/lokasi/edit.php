<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Edit Lokasi</h3>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/lokasi/update/' . $lokasi['id_lokasi']); ?>" method="post">
            <div class="mb-3">
                <label>Nama Lokasi</label>
                <input type="text" name="nama_lokasi" class="form-control" value="<?= esc($lokasi['nama_lokasi']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Detail Lokasi</label>
                <textarea name="detail_lokasi" class="form-control" rows="3"><?= esc($lokasi['detail_lokasi']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('/admin/lokasi'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>