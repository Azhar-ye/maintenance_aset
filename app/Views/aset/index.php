<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Data Aset</h3>
        <p class="text-muted mb-0">Kelola seluruh data aset perusahaan berdasarkan kategori, lokasi, dan divisi.</p>
    </div>

    <a href="<?= base_url('/admin/aset/create'); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Aset
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
        <form method="get" action="<?= base_url('/admin/aset'); ?>">
            <div class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            name="keyword"
                            class="form-control"
                            placeholder="Cari kode aset, nama aset, lokasi, atau divisi..."
                            value="<?= esc($keyword ?? ''); ?>">
                    </div>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Cari
                    </button>
                </div>
            </div>
        </form>

        <?php if (!empty($keyword)) : ?>
            <div class="mt-3">
                <small class="text-muted">
                    Hasil pencarian untuk:
                    <strong><?= esc($keyword); ?></strong>
                </small>

                <a href="<?= base_url('/admin/aset'); ?>" class="btn btn-sm btn-outline-secondary ms-2">
                    Reset
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Daftar Aset</strong>
        <small class="text-muted">Total: <?= !empty($aset) ? count($aset) : 0; ?> aset</small>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Divisi</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($aset)) : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($aset as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>

                                <td>
                                    <?php if (!empty($row['foto_aset'])) : ?>
                                        <img src="<?= base_url('uploads/aset/' . $row['foto_aset']); ?>"
                                             alt="Foto Aset"
                                             style="width: 60px; height: 45px; object-fit: cover; border-radius: 8px;">
                                    <?php else : ?>
                                        <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                             style="width: 60px; height: 45px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <strong><?= esc($row['kode_aset']); ?></strong>
                                </td>

                                <td><?= esc($row['nama_aset']); ?></td>

                                <td>
                                    <span class="badge bg-light text-dark">
                                        <?= esc($row['nama_kategori']); ?>
                                    </span>
                                </td>

                                <td><?= esc($row['nama_lokasi']); ?></td>
                                <td><?= esc($row['nama_divisi']); ?></td>

                                <td>
                                    <?php if ($row['kondisi'] === 'baik') : ?>
                                        <span class="badge bg-success">Baik</span>
                                    <?php elseif ($row['kondisi'] === 'perlu_maintenance') : ?>
                                        <span class="badge bg-warning text-dark">Perlu Maintenance</span>
                                    <?php elseif ($row['kondisi'] === 'rusak_ringan') : ?>
                                        <span class="badge bg-danger">Rusak Ringan</span>
                                    <?php elseif ($row['kondisi'] === 'rusak_berat') : ?>
                                        <span class="badge bg-dark">Rusak Berat</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">
                                            <?= esc(str_replace('_', ' ', ucfirst($row['kondisi']))); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($row['status_aset'] === 'aktif') : ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php elseif ($row['status_aset'] === 'maintenance') : ?>
                                        <span class="badge bg-warning text-dark">Maintenance</span>
                                    <?php elseif ($row['status_aset'] === 'rusak') : ?>
                                        <span class="badge bg-danger">Rusak</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="<?= base_url('/admin/aset/detail/' . $row['id_aset']); ?>"
                                       class="btn btn-info btn-sm text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="<?= base_url('/admin/aset/edit/' . $row['id_aset']); ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="<?= base_url('/admin/aset/delete/' . $row['id_aset']); ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Data aset tidak ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>