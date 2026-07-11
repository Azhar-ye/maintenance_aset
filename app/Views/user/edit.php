<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Edit User</h3>
        <p class="text-muted mb-0">Ubah data akun pengguna sistem.</p>
    </div>

    <a href="<?= base_url('/admin/user'); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('/admin/user/update/' . $user['id_user']); ?>" method="post">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama User</label>
                    <input type="text" name="nama" class="form-control" value="<?= esc($user['nama']); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= esc($user['email']); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Password Baru</label>
                    <input type="text" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                    <small class="text-muted">Isi hanya jika ingin reset password user.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Divisi</label>
                    <select name="id_divisi" class="form-control" required>
                        <option value="">-- Pilih Divisi --</option>
                        <?php foreach ($divisi as $row) : ?>
                            <option value="<?= $row['id_divisi']; ?>" <?= $user['id_divisi'] == $row['id_divisi'] ? 'selected' : ''; ?>>
                                <?= esc($row['nama_divisi']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="karyawan" <?= $user['role'] === 'karyawan' ? 'selected' : ''; ?>>Karyawan</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="manajer" <?= $user['role'] === 'manajer' ? 'selected' : ''; ?>>Manajer</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= esc($user['no_hp']); ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="aktif" <?= $user['status'] === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                        <option value="nonaktif" <?= $user['status'] === 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"><?= esc($user['alamat']); ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i>
                Update
            </button>

            <a href="<?= base_url('/admin/user'); ?>" class="btn btn-secondary">
                Batal
            </a>

        </form>
    </div>
</div>

<?= $this->endSection(); ?>