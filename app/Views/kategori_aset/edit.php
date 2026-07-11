<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Edit Kategori Aset</h3>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/kategori-aset/update/' . $kategori['id_kategori']); ?>" method="post">
            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" value="<?= esc($kategori['nama_kategori']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"><?= esc($kategori['keterangan']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('/admin/kategori-aset'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>