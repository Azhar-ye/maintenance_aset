<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Tambah Lokasi</h3>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/lokasi/store'); ?>" method="post">
            <div class="mb-3">
                <label>Nama Lokasi</label>
                <input type="text" name="nama_lokasi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Detail Lokasi</label>
                <textarea name="detail_lokasi" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('/admin/lokasi'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>