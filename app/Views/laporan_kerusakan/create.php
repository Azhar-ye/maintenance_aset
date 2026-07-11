<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Lapor Kerusakan Aset</h3>

<div class="card mt-3">
    <div class="card-body">
        <form action="<?= base_url('/karyawan/laporan-kerusakan/store'); ?>" method="post" enctype="multipart/form-data">
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
                <label>Judul Laporan</label>
                <input type="text" name="judul_laporan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi Kerusakan</label>
                <textarea name="deskripsi_kerusakan" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label>Prioritas</label>
                <select name="prioritas" class="form-control">
                    <option value="rendah">Rendah</option>
                    <option value="sedang">Sedang</option>
                    <option value="tinggi">Tinggi</option>
                    <option value="darurat">Darurat</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Foto Kerusakan</label>
                <input type="file" name="foto_kerusakan" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Kirim Laporan</button>
            <a href="<?= base_url('/karyawan/dashboard'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>