<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php
    $queryString = http_build_query(array_filter([
        'keyword' => $keyword ?? '',
        'id_kategori' => $id_kategori ?? '',
        'id_lokasi' => $id_lokasi ?? '',
        'id_divisi' => $id_divisi ?? '',
        'kondisi' => $kondisi ?? '',
        'status_aset' => $status_aset ?? ''
    ], function ($value) {
        return $value !== null && $value !== '';
    }));

    $pdfUrl = base_url('/manajer/laporan-aset/pdf') . (!empty($queryString) ? '?' . $queryString : '');
    $excelUrl = base_url('/manajer/laporan-aset/excel') . (!empty($queryString) ? '?' . $queryString : '');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Laporan Aset</h3>
        <p class="text-muted mb-0">Laporan data aset berdasarkan kategori, lokasi, divisi, kondisi, dan status.</p>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="get" action="<?= base_url('/manajer/laporan-aset'); ?>">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                               name="keyword"
                               class="form-control"
                               placeholder="Cari kode aset, nama aset, kategori, lokasi..."
                               value="<?= esc($keyword ?? ''); ?>">
                    </div>
                </div>

                <div class="col-md-2">
                    <select name="id_kategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($kategori as $row) : ?>
                            <option value="<?= $row['id_kategori']; ?>" <?= ($id_kategori ?? '') == $row['id_kategori'] ? 'selected' : ''; ?>>
                                <?= esc($row['nama_kategori']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="id_lokasi" class="form-control">
                        <option value="">Semua Lokasi</option>
                        <?php foreach ($lokasi as $row) : ?>
                            <option value="<?= $row['id_lokasi']; ?>" <?= ($id_lokasi ?? '') == $row['id_lokasi'] ? 'selected' : ''; ?>>
                                <?= esc($row['nama_lokasi']); ?>
                            </option>
                        <?php endforeach; ?>
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
                    <select name="kondisi" class="form-control">
                        <option value="">Semua Kondisi</option>
                        <option value="baik" <?= ($kondisi ?? '') === 'baik' ? 'selected' : ''; ?>>Baik</option>
                        <option value="perlu_maintenance" <?= ($kondisi ?? '') === 'perlu_maintenance' ? 'selected' : ''; ?>>Perlu Maintenance</option>
                        <option value="rusak_ringan" <?= ($kondisi ?? '') === 'rusak_ringan' ? 'selected' : ''; ?>>Rusak Ringan</option>
                        <option value="rusak_berat" <?= ($kondisi ?? '') === 'rusak_berat' ? 'selected' : ''; ?>>Rusak Berat</option>
                    </select>
                </div>

                <div class="col-md-2 mt-2">
                    <select name="status_aset" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="aktif" <?= ($status_aset ?? '') === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                        <option value="maintenance" <?= ($status_aset ?? '') === 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                        <option value="rusak" <?= ($status_aset ?? '') === 'rusak' ? 'selected' : ''; ?>>Rusak</option>
                        <option value="nonaktif" <?= ($status_aset ?? '') === 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                    </select>
                </div>

                <div class="col-md-2 mt-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-1"></i>
                        Filter
                    </button>
                </div>

                <div class="col-md-2 mt-2">
                    <a href="<?= base_url('/manajer/laporan-aset'); ?>" class="btn btn-secondary w-100">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="mb-3">
    <a href="<?= $pdfUrl; ?>" target="_blank" class="btn btn-danger">
        <i class="bi bi-file-earmark-pdf me-1"></i>
        Export PDF
    </a>

    <a href="<?= $excelUrl; ?>" class="btn btn-success">
        <i class="bi bi-file-earmark-excel me-1"></i>
        Export Excel
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Daftar Laporan Aset</strong>
        <small class="text-muted">Total: <?= !empty($aset) ? count($aset) : 0; ?> aset</small>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Divisi</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($aset)) : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($aset as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><strong><?= esc($row['kode_aset']); ?></strong></td>
                                <td><?= esc($row['nama_aset']); ?></td>
                                <td><?= esc($row['nama_kategori']); ?></td>
                                <td><?= esc($row['nama_lokasi']); ?></td>
                                <td><?= esc($row['nama_divisi']); ?></td>

                                <td>
                                    <?= esc(str_replace('_', ' ', ucfirst($row['kondisi']))); ?>
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
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
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