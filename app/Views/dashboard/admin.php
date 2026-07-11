<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Dashboard Admin / GA</h3>
        <p class="text-muted mb-0">Selamat datang, <?= session()->get('nama'); ?>. Berikut ringkasan kondisi aset perusahaan.</p>
    </div>
</div>

<div class="card shadow-sm mb-4 border-0">
    <div class="card-header bg-white border-0 d-flex align-items-center">
        <i class="bi bi-bell-fill text-warning me-2"></i>
        <strong>Notification Center</strong>
    </div>

    <div class="card-body pt-0">
        <?php if (
            $jadwal_mendekati == 0 &&
            $jadwal_terlambat == 0 &&
            $laporan_menunggu == 0 &&
            $maintenance_diproses == 0
        ) : ?>
            <div class="alert alert-success mb-0">
                <i class="bi bi-check-circle me-2"></i>
                Tidak ada notifikasi penting saat ini.
            </div>
        <?php else : ?>
            <?php if ($jadwal_mendekati > 0) : ?>
                <div class="alert alert-info">
                    <i class="bi bi-calendar-event me-2"></i>
                    Ada <?= $jadwal_mendekati; ?> jadwal maintenance yang mendekati deadline.
                </div>
            <?php endif; ?>

            <?php if ($jadwal_terlambat > 0) : ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-octagon me-2"></i>
                    Ada <?= $jadwal_terlambat; ?> jadwal maintenance yang terlambat.
                </div>
            <?php endif; ?>

            <?php if ($laporan_menunggu > 0) : ?>
                <div class="alert alert-warning">
                    <i class="bi bi-hourglass-split me-2"></i>
                    Ada <?= $laporan_menunggu; ?> laporan kerusakan yang menunggu validasi.
                </div>
            <?php endif; ?>

            <?php if ($maintenance_diproses > 0) : ?>
                <div class="alert alert-primary mb-0">
                    <i class="bi bi-tools me-2"></i>
                    Ada <?= $maintenance_diproses; ?> maintenance yang sedang diproses.
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Aset</h6>
                    <h3 class="mb-0"><?= $total_aset; ?></h3>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-pc-display fs-4 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Vendor</h6>
                    <h3 class="mb-0"><?= $total_vendor; ?></h3>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-truck fs-4 text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Laporan Kerusakan</h6>
                    <h3 class="mb-0"><?= $total_laporan; ?></h3>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-exclamation-triangle fs-4 text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Maintenance</h6>
                    <h3 class="mb-0"><?= $total_maintenance; ?></h3>
                </div>
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="bi bi-tools fs-4 text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h6 class="text-muted mb-2">Total Biaya Maintenance</h6>
            <h3 class="mb-0">Rp <?= number_format($total_biaya, 0, ',', '.'); ?></h3>
        </div>
        <div class="rounded-circle bg-info bg-opacity-10 p-3">
            <i class="bi bi-cash-stack fs-4 text-info"></i>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total User</h6>
                    <h3 class="mb-0"><?= $total_user; ?></h3>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-people fs-4 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Admin</h6>
                    <h3 class="mb-0"><?= $total_admin; ?></h3>
                </div>
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="bi bi-person-gear fs-4 text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Karyawan</h6>
                    <h3 class="mb-0"><?= $total_karyawan; ?></h3>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-person-badge fs-4 text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Manajer</h6>
                    <h3 class="mb-0"><?= $total_manajer; ?></h3>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-person-check fs-4 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0">
        <strong>Akses Cepat</strong>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-2">
                <a href="<?= base_url('/admin/aset/create'); ?>" class="btn btn-outline-primary w-100 text-start">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Aset
                </a>
            </div>

            <div class="col-md-3 mb-2">
                <a href="<?= base_url('/admin/laporan-kerusakan'); ?>" class="btn btn-outline-warning w-100 text-start">
                    <i class="bi bi-exclamation-triangle me-2"></i> Validasi Laporan
                </a>
            </div>

            <div class="col-md-3 mb-2">
                <a href="<?= base_url('/admin/maintenance/create'); ?>" class="btn btn-outline-success w-100 text-start">
                    <i class="bi bi-tools me-2"></i> Tambah Maintenance
                </a>
            </div>

            <div class="col-md-3 mb-2">
                <a href="<?= base_url('/admin/activity-log'); ?>" class="btn btn-outline-dark w-100 text-start">
                    <i class="bi bi-clock-history me-2"></i> Activity Log
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0">
                <strong>Grafik Status Aset</strong>
            </div>
            <div class="card-body">
                <canvas id="statusAsetChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0">
                <strong>Grafik Biaya Maintenance Per Bulan</strong>
            </div>
            <div class="card-body">
                <canvas id="biayaBulananChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0">
                <strong>Top 5 Aset dengan Biaya Maintenance Tertinggi</strong>
            </div>
            <div class="card-body">
                <table class="table table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Aset</th>
                            <th>Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($top_aset_biaya)) : ?>
                            <?php $no = 1; ?>
                            <?php foreach ($top_aset_biaya as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <strong><?= esc($row['kode_aset']); ?></strong><br>
                                        <small class="text-muted"><?= esc($row['nama_aset']); ?></small>
                                    </td>
                                    <td>Rp <?= number_format($row['total_biaya'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data biaya.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0">
                <strong>Maintenance Terbaru</strong>
            </div>
            <div class="card-body">
                <table class="table table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Aset</th>
                            <th>Vendor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($maintenance_terbaru)) : ?>
                            <?php foreach ($maintenance_terbaru as $row) : ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($row['kode_aset']); ?></strong><br>
                                        <small class="text-muted"><?= esc($row['nama_aset']); ?></small>
                                    </td>
                                    <td><?= esc($row['nama_vendor'] ?? '-'); ?></td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <?= esc(ucfirst($row['status_pekerjaan'])); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data maintenance.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-white border-0">
        <strong>Laporan Kerusakan Terbaru</strong>
    </div>
    <div class="card-body">
        <table class="table table-hover table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Aset</th>
                    <th>Pelapor</th>
                    <th>Judul</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($laporan_terbaru)) : ?>
                    <?php foreach ($laporan_terbaru as $row) : ?>
                        <tr>
                            <td>
                                <strong><?= esc($row['kode_aset']); ?></strong><br>
                                <small class="text-muted"><?= esc($row['nama_aset']); ?></small>
                            </td>
                            <td><?= esc($row['nama_pelapor']); ?></td>
                            <td><?= esc($row['judul_laporan']); ?></td>
                            <td>
                                <span class="badge bg-secondary">
                                    <?= esc(str_replace('_', ' ', ucfirst($row['status_laporan']))); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada laporan kerusakan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const statusAsetChart = document.getElementById('statusAsetChart');

    new Chart(statusAsetChart, {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Maintenance', 'Rusak', 'Nonaktif'],
            datasets: [{
                data: [
                    <?= $aset_aktif; ?>,
                    <?= $aset_maintenance; ?>,
                    <?= $aset_rusak; ?>,
                    <?= $aset_nonaktif; ?>
                ],
                backgroundColor: ['#0d6efd', '#ffc107', '#dc3545', '#6c757d']
            }]
        }
    });

    const biayaBulananChart = document.getElementById('biayaBulananChart');

    new Chart(biayaBulananChart, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($biaya_bulanan as $row) : ?>
                    'Bulan <?= $row['bulan']; ?>',
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Total Biaya',
                data: [
                    <?php foreach ($biaya_bulanan as $row) : ?>
                        <?= $row['total']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: '#0d6efd'
            }]
        }
    });
</script>

<?= $this->endSection(); ?>