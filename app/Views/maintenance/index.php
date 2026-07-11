<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Data Maintenance</h3>
        <p class="text-muted mb-0">Kelola data pekerjaan maintenance aset perusahaan.</p>
    </div>

    <a href="<?= base_url('/admin/maintenance/create'); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Maintenance
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
        <form method="get" action="<?= base_url('/admin/maintenance'); ?>">
            <div class="row g-2">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                               name="keyword"
                               class="form-control"
                               placeholder="Cari kode aset, nama aset, atau vendor..."
                               value="<?= esc($keyword ?? ''); ?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="jenis_pekerjaan" class="form-control">
                        <option value="">Semua Jenis</option>
                        <option value="maintenance_rutin" <?= ($jenis_pekerjaan ?? '') === 'maintenance_rutin' ? 'selected' : ''; ?>>
                            Maintenance Rutin
                        </option>
                        <option value="perbaikan_kerusakan" <?= ($jenis_pekerjaan ?? '') === 'perbaikan_kerusakan' ? 'selected' : ''; ?>>
                            Perbaikan Kerusakan
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status_pekerjaan" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="diproses" <?= ($status_pekerjaan ?? '') === 'diproses' ? 'selected' : ''; ?>>
                            Diproses
                        </option>
                        <option value="selesai" <?= ($status_pekerjaan ?? '') === 'selesai' ? 'selected' : ''; ?>>
                            Selesai
                        </option>
                        <option value="dibatalkan" <?= ($status_pekerjaan ?? '') === 'dibatalkan' ? 'selected' : ''; ?>>
                            Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-1"></i>
                        Filter
                    </button>
                </div>
            </div>

            <?php if (!empty($keyword) || !empty($jenis_pekerjaan) || !empty($status_pekerjaan)) : ?>
                <div class="mt-3">
                    <small class="text-muted">
                        Filter aktif
                    </small>

                    <a href="<?= base_url('/admin/maintenance'); ?>" class="btn btn-sm btn-outline-secondary ms-2">
                        Reset
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Daftar Maintenance</strong>
        <small class="text-muted">Total: <?= !empty($maintenance) ? count($maintenance) : 0; ?> data</small>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aset</th>
                        <th>Vendor</th>
                        <th>Jenis Pekerjaan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th width="14%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($maintenance)) : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($maintenance as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>

                                <td>
                                    <strong><?= esc($row['kode_aset']); ?></strong><br>
                                    <small class="text-muted"><?= esc($row['nama_aset']); ?></small>
                                </td>

                                <td><?= esc($row['nama_vendor'] ?? '-'); ?></td>

                                <td>
                                    <?php if ($row['jenis_pekerjaan'] === 'maintenance_rutin') : ?>
                                        <span class="badge bg-info text-dark">Maintenance Rutin</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Perbaikan Kerusakan</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= esc($row['tanggal_mulai']); ?></td>
                                <td><?= esc($row['tanggal_selesai'] ?? '-'); ?></td>

                                <td>
                                    <?php if ($row['status_pekerjaan'] === 'diproses') : ?>
                                        <span class="badge bg-warning text-dark">Diproses</span>
                                    <?php elseif ($row['status_pekerjaan'] === 'selesai') : ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Dibatalkan</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="<?= base_url('/admin/maintenance/edit/' . $row['id_maintenance']); ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="<?= base_url('/admin/maintenance/delete/' . $row['id_maintenance']); ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Data maintenance tidak ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>