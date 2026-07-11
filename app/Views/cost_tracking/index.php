<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php
    $total = 0;

    if (!empty($cost)) {
        foreach ($cost as $row) {
            $total += $row['nominal'];
        }
    }
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Cost Tracking</h3>
        <p class="text-muted mb-0">Kelola dan pantau seluruh biaya maintenance aset perusahaan.</p>
    </div>

    <a href="<?= base_url('/admin/cost-tracking/create'); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Biaya
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
        <form method="get" action="<?= base_url('/admin/cost-tracking'); ?>">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text"
                               name="keyword"
                               class="form-control"
                               placeholder="Cari aset, vendor, atau deskripsi biaya..."
                               value="<?= esc($keyword ?? ''); ?>">
                    </div>
                </div>

                <div class="col-md-2">
                    <select name="jenis_biaya" class="form-control">
                        <option value="">Semua Jenis</option>

                        <option value="sparepart" <?= ($jenis_biaya ?? '') === 'sparepart' ? 'selected' : ''; ?>>
                            Sparepart
                        </option>

                        <option value="jasa_vendor" <?= ($jenis_biaya ?? '') === 'jasa_vendor' ? 'selected' : ''; ?>>
                            Jasa Vendor
                        </option>

                        <option value="transportasi" <?= ($jenis_biaya ?? '') === 'transportasi' ? 'selected' : ''; ?>>
                            Transportasi
                        </option>

                        <option value="lainnya" <?= ($jenis_biaya ?? '') === 'lainnya' ? 'selected' : ''; ?>>
                            Lainnya
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="date"
                           name="tanggal_awal"
                           class="form-control"
                           value="<?= esc($tanggal_awal ?? ''); ?>">
                </div>

                <div class="col-md-2">
                    <input type="date"
                           name="tanggal_akhir"
                           class="form-control"
                           value="<?= esc($tanggal_akhir ?? ''); ?>">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-1"></i>
                        Filter
                    </button>
                </div>

                <?php if (!empty($keyword) || !empty($jenis_biaya) || !empty($tanggal_awal) || !empty($tanggal_akhir)) : ?>
                    <div class="col-md-2 mt-2">
                        <a href="<?= base_url('/admin/cost-tracking'); ?>" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <small class="text-muted">Total Biaya Maintenance</small>
            <h4 class="mb-0">Rp <?= number_format($total, 0, ',', '.'); ?></h4>
        </div>

        <div class="rounded-circle bg-success bg-opacity-10 p-3">
            <i class="bi bi-cash-stack fs-3 text-success"></i>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Daftar Biaya Maintenance</strong>
        <small class="text-muted">Total: <?= !empty($cost) ? count($cost) : 0; ?> data</small>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aset</th>
                        <th>Vendor</th>
                        <th>Jenis Biaya</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th width="14%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($cost)) : ?>
                        <?php $no = 1; ?>

                        <?php foreach ($cost as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>

                                <td>
                                    <strong><?= esc($row['kode_aset']); ?></strong><br>
                                    <small class="text-muted"><?= esc($row['nama_aset']); ?></small>
                                </td>

                                <td><?= esc($row['nama_vendor'] ?? '-'); ?></td>

                                <td>
                                    <span class="badge bg-light text-dark">
                                        <?= esc(str_replace('_', ' ', ucfirst($row['jenis_biaya']))); ?>
                                    </span>
                                </td>

                                <td><?= esc($row['deskripsi_biaya']); ?></td>

                                <td><?= esc($row['tanggal_biaya']); ?></td>

                                <td>
                                    <strong>
                                        Rp <?= number_format($row['nominal'], 0, ',', '.'); ?>
                                    </strong>
                                </td>

                                <td>
                                    <a href="<?= base_url('/admin/cost-tracking/edit/' . $row['id_cost']); ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="<?= base_url('/admin/cost-tracking/delete/' . $row['id_cost']); ?>"
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
                                Data biaya tidak ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

                <?php if (!empty($cost)) : ?>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-end">Total Biaya</th>
                            <th colspan="2">
                                Rp <?= number_format($total, 0, ',', '.'); ?>
                            </th>
                        </tr>
                    </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>