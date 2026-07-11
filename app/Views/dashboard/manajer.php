<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Dashboard Manajer</h3>
        <p class="text-muted mb-0">Selamat datang, <?= session()->get('nama'); ?>. Berikut ringkasan monitoring aset dan biaya maintenance.</p>
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
                    <h6 class="text-muted mb-2">Total Maintenance</h6>
                    <h3 class="mb-0"><?= $total_maintenance; ?></h3>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-tools fs-4 text-warning"></i>
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
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="bi bi-exclamation-triangle fs-4 text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Biaya</h6>
                    <h5 class="mb-0">Rp <?= number_format($total_biaya, 0, ',', '.'); ?></h5>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-cash-stack fs-4 text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-7 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0">
                <strong>Grafik Biaya Maintenance Per Bulan</strong>
            </div>
            <div class="card-body">
                <canvas id="biayaBulananChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-5 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0">
                <strong>Akses Cepat Laporan</strong>
            </div>
            <div class="card-body">
                <a href="<?= base_url('/manajer/laporan-aset'); ?>" class="btn btn-outline-primary w-100 mb-2 text-start">
                    <i class="bi bi-file-earmark-text me-2"></i> Laporan Aset
                </a>

                <a href="<?= base_url('/manajer/laporan-maintenance'); ?>" class="btn btn-outline-warning w-100 mb-2 text-start">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Maintenance
                </a>

                <a href="<?= base_url('/manajer/laporan-cost-tracking'); ?>" class="btn btn-outline-success w-100 text-start">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i> Laporan Cost Tracking
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mt-3">
    <div class="card-header bg-white border-0">
        <strong>Maintenance Terbaru</strong>
    </div>

    <div class="card-body">
        <table class="table table-hover table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Aset</th>
                    <th>Vendor</th>
                    <th>Jenis</th>
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
                            <td><?= esc(str_replace('_', ' ', ucfirst($row['jenis_pekerjaan']))); ?></td>
                            <td>
                                <span class="badge bg-primary">
                                    <?= esc(ucfirst($row['status_pekerjaan'])); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada data maintenance.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
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
                backgroundColor: '#198754'
            }]
        }
    });
</script>

<?= $this->endSection(); ?>