<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Tambah User</h3>
        <p class="text-muted mb-0">Tambahkan akun pengguna baru ke sistem.</p>
    </div>

    <a href="<?= base_url('/admin/user'); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('/admin/user/store'); ?>" method="post">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama User</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control" placeholder="Contoh: Azhar123" required>
                    <small class="text-muted">Password akan otomatis disimpan dalam bentuk hash.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Divisi</label>
                    <select name="id_divisi" class="form-control" required>
                        <option value="">-- Pilih Divisi --</option>
                        <?php foreach ($divisi as $row) : ?>
                            <option value="<?= $row['id_divisi']; ?>">
                                <?= esc($row['nama_divisi']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="karyawan">Karyawan</option>
                        <option value="admin">Admin</option>
                        <option value="manajer">Manajer</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i>
                Simpan
            </button>

            <a href="<?= base_url('/admin/user'); ?>" class="btn btn-secondary">
                Batal
            </a>

        </form>
    </div>
</div>

<?= $this->endSection(); ?>