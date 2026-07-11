<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Dashboard Karyawan</h3>
        <p class="text-muted mb-0">
            Selamat datang, <?= session()->get('nama'); ?>. Anda dapat membuat dan memantau laporan kerusakan aset.
        </p>
    </div>

    <a href="<?= base_url('/karyawan/laporan-kerusakan/create'); ?>" class="btn btn-primary">
        <i class="bi bi-pencil-square me-1"></i>
        Lapor Kerusakan
    </a>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Laporan</h6>
                    <h3 class="mb-0"><?= $total_laporan; ?></h3>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-file-earmark-text fs-4 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Menunggu Validasi</h6>
                    <h3 class="mb-0"><?= $laporan_menunggu; ?></h3>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Diproses</h6>
                    <h3 class="mb-0"><?= $laporan_diproses; ?></h3>
                </div>
                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                    <i class="bi bi-tools fs-4 text-info"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Selesai</h6>
                    <h3 class="mb-0"><?= $laporan_selesai; ?></h3>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-check-circle fs-4 text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0">
                <strong>Aksi Cepat</strong>
            </div>

            <div class="card-body">
                <a href="<?= base_url('/karyawan/laporan-kerusakan/create'); ?>"
                   class="btn btn-outline-primary w-100 mb-2 text-start">
                    <i class="bi bi-pencil-square me-2"></i>
                    Buat Laporan Kerusakan
                </a>

                <a href="<?= base_url('/karyawan/laporan-kerusakan'); ?>"
                   class="btn btn-outline-secondary w-100 text-start">
                    <i class="bi bi-clock-history me-2"></i>
                    Lihat Riwayat Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0">
                <strong>5 Laporan Terbaru</strong>
            </div>

            <div class="card-body">
                <table class="table table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Aset</th>
                            <th>Judul</th>
                            <th>Prioritas</th>
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

                                    <td><?= esc($row['judul_laporan']); ?></td>

                                    <td><?= esc(ucfirst($row['prioritas'])); ?></td>

                                    <td>
                                        <?php if ($row['status_laporan'] === 'menunggu_validasi') : ?>
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        <?php elseif ($row['status_laporan'] === 'diproses') : ?>
                                            <span class="badge bg-info">Diproses</span>
                                        <?php elseif ($row['status_laporan'] === 'selesai') : ?>
                                            <span class="badge bg-success">Selesai</span>
                                        <?php elseif ($row['status_laporan'] === 'ditolak') : ?>
                                            <span class="badge bg-danger">Ditolak</span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary">
                                                <?= esc(str_replace('_', ' ', ucfirst($row['status_laporan']))); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Belum ada laporan kerusakan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>