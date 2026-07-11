<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">User Management</h3>
        <p class="text-muted mb-0">Kelola akun pengguna sistem</p>
    </div>

    <a href="<?= base_url('/admin/user/create'); ?>" class="btn btn-primary">
        <i class="bi bi-person-plus"></i>
        Tambah User
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="get" action="<?= base_url('/admin/user'); ?>">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text"
                           name="keyword"
                           class="form-control"
                           placeholder="Cari nama atau email..."
                           value="<?= esc($keyword ?? ''); ?>">
                </div>

                <div class="col-md-2">
                    <select name="role" class="form-control">
                        <option value="">Semua Role</option>
                        <option value="admin" <?= ($role ?? '') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="karyawan" <?= ($role ?? '') === 'karyawan' ? 'selected' : ''; ?>>Karyawan</option>
                        <option value="manajer" <?= ($role ?? '') === 'manajer' ? 'selected' : ''; ?>>Manajer</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="id_divisi" class="form-control">
                        <option value="">Semua Divisi</option>
                        <?php foreach ($divisi as $row) : ?>
                            <option value="<?= $row['id_divisi']; ?>" <?= ($id_divisi ?? '') == $row['id_divisi'] ? 'selected' : ''; ?>>
                                <?= esc($row['nama_divisi']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="aktif" <?= ($status ?? '') === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                        <option value="nonaktif" <?= ($status ?? '') === 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="sort" class="form-control">
                        <option value="">Terbaru</option>
                        <option value="nama_asc" <?= ($sort ?? '') === 'nama_asc' ? 'selected' : ''; ?>>Nama A-Z</option>
                        <option value="nama_desc" <?= ($sort ?? '') === 'nama_desc' ? 'selected' : ''; ?>>Nama Z-A</option>
                        <option value="email_asc" <?= ($sort ?? '') === 'email_asc' ? 'selected' : ''; ?>>Email A-Z</option>
                        <option value="role_asc" <?= ($sort ?? '') === 'role_asc' ? 'selected' : ''; ?>>Role</option>
                        <option value="divisi_asc" <?= ($sort ?? '') === 'divisi_asc' ? 'selected' : ''; ?>>Divisi</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter"></i>
                    </button>
                </div>
            </div>

            <?php if (!empty($keyword) || !empty($role) || !empty($status) || !empty($id_divisi) || !empty($sort)) : ?>
                <div class="mt-3">
                    <a href="<?= base_url('/admin/user'); ?>" class="btn btn-sm btn-outline-secondary">
                        Reset Filter
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Daftar User</strong>
        <small class="text-muted">Total: <?= !empty($users) ? count($users) : 0; ?> user</small>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama User</th>
                        <th>Email</th>
                        <th>Divisi</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($users)) : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><strong><?= esc($row['nama']); ?></strong></td>
                                <td><?= esc($row['email']); ?></td>
                                <td><?= esc($row['nama_divisi'] ?? '-'); ?></td>

                                <td>
                                    <?php if ($row['role'] == 'admin') : ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php elseif ($row['role'] == 'manajer') : ?>
                                        <span class="badge bg-warning text-dark">Manajer</span>
                                    <?php else : ?>
                                        <span class="badge bg-primary">Karyawan</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($row['status'] == 'aktif') : ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="<?= base_url('/admin/user/detail/' . $row['id_user']); ?>"
                                       class="btn btn-info btn-sm text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="<?= base_url('/admin/user/edit/' . $row['id_user']); ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="<?= base_url('/admin/user/delete/' . $row['id_user']); ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus user ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-people fs-3 d-block mb-2"></i>
                                Data user tidak ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>