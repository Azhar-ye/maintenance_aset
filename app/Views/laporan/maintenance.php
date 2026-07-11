<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php
    $queryString = http_build_query(array_filter([
        'keyword' => $keyword ?? '',
        'jenis_pekerjaan' => $jenis_pekerjaan ?? '',
        'status_pekerjaan' => $status_pekerjaan ?? '',
        'tanggal_awal' => $tanggal_awal ?? '',
        'tanggal_akhir' => $tanggal_akhir ?? ''
    ], function ($value) {
        return $value !== null && $value !== '';
    }));

    $pdfUrl = base_url('/manajer/laporan-maintenance/pdf') . (!empty($queryString) ? '?' . $queryString : '');
    $excelUrl = base_url('/manajer/laporan-maintenance/excel') . (!empty($queryString) ? '?' . $queryString : '');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Laporan Maintenance</h3>
        <p class="text-muted mb-0">Laporan pekerjaan maintenance berdasarkan aset, vendor, jenis, status, dan periode tanggal.</p>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="get" action="<?= base_url('/manajer/laporan-maintenance'); ?>">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                               name="keyword"
                               class="form-control"
                               placeholder="Cari aset atau vendor..."
                               value="<?= esc($keyword ?? ''); ?>">
                    </div>
                </div>

                <div class="col-md-2">
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

                <div class="col-md-2 mt-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-1"></i>
                        Filter
                    </button>
                </div>

                <div class="col-md-2 mt-2">
                    <a href="<?= base_url('/manajer/laporan-maintenance'); ?>" class="btn btn-secondary w-100">
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
        <strong>Daftar Laporan Maintenance</strong>
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
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
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