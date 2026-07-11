<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Detail User</h3>
        <p class="text-muted mb-0">Informasi lengkap akun pengguna sistem.</p>
    </div>

    <a href="<?= base_url('/admin/user'); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                     style="width: 90px; height: 90px;">
                    <i class="bi bi-person-circle fs-1 text-primary"></i>
                </div>

                <h5 class="mb-1"><?= esc($user['nama']); ?></h5>
                <p class="text-muted mb-2"><?= esc($user['email']); ?></p>

                <?php if ($user['status'] === 'aktif') : ?>
                    <span class="badge bg-success">Aktif</span>
                <?php else : ?>
                    <span class="badge bg-secondary">Nonaktif</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-3">
        <div class="card shadow-sm">
            <div class="card-header">
                Informasi User
            </div>

            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="30%">Nama</th>
                        <td><?= esc($user['nama']); ?></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td><?= esc($user['email']); ?></td>
                    </tr>

                    <tr>
                        <th>Divisi</th>
                        <td><?= esc($user['nama_divisi'] ?? '-'); ?></td>
                    </tr>

                    <tr>
                        <th>Role</th>
                        <td>
                            <?php if ($user['role'] === 'admin') : ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php elseif ($user['role'] === 'manajer') : ?>
                                <span class="badge bg-warning text-dark">Manajer</span>
                            <?php else : ?>
                                <span class="badge bg-primary">Karyawan</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>No HP</th>
                        <td><?= esc($user['no_hp'] ?? '-'); ?></td>
                    </tr>

                    <tr>
                        <th>Alamat</th>
                        <td><?= nl2br(esc($user['alamat'] ?? '-')); ?></td>
                    </tr>

                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td><?= esc($user['created_at'] ?? '-'); ?></td>
                    </tr>

                    <tr>
                        <th>Terakhir Diupdate</th>
                        <td><?= esc($user['updated_at'] ?? '-'); ?></td>
                    </tr>
                </table>

                <a href="<?= base_url('/admin/user/edit/' . $user['id_user']); ?>" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i>
                    Edit User
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>