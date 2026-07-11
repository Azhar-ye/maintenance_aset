<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Jadwal Maintenance</h3>
        <p class="text-muted mb-0">
            Kelola jadwal maintenance preventif dan berkala aset perusahaan.
        </p>
    </div>

    <a href="<?= base_url('/admin/jadwal-maintenance/create'); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Jadwal
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
        <form method="get" action="<?= base_url('/admin/jadwal-maintenance'); ?>">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text"
                               name="keyword"
                               class="form-control"
                               placeholder="Cari kode aset, nama aset, atau jenis maintenance..."
                               value="<?= esc($keyword ?? ''); ?>">
                    </div>
                </div>

                <div class="col-md-2">
                    <select name="periode" class="form-control">
                        <option value="">Semua Periode</option>
                        <option value="mingguan" <?= ($periode ?? '') === 'mingguan' ? 'selected' : ''; ?>>
                            Mingguan
                        </option>
                        <option value="bulanan" <?= ($periode ?? '') === 'bulanan' ? 'selected' : ''; ?>>
                            Bulanan
                        </option>
                        <option value="3_bulanan" <?= ($periode ?? '') === '3_bulanan' ? 'selected' : ''; ?>>
                            3 Bulanan
                        </option>
                        <option value="6_bulanan" <?= ($periode ?? '') === '6_bulanan' ? 'selected' : ''; ?>>
                            6 Bulanan
                        </option>
                        <option value="tahunan" <?= ($periode ?? '') === 'tahunan' ? 'selected' : ''; ?>>
                            Tahunan
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="prioritas" class="form-control">
                        <option value="">Semua Prioritas</option>
                        <option value="rendah" <?= ($prioritas ?? '') === 'rendah' ? 'selected' : ''; ?>>
                            Rendah
                        </option>
                        <option value="sedang" <?= ($prioritas ?? '') === 'sedang' ? 'selected' : ''; ?>>
                            Sedang
                        </option>
                        <option value="tinggi" <?= ($prioritas ?? '') === 'tinggi' ? 'selected' : ''; ?>>
                            Tinggi
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status_jadwal" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="terjadwal" <?= ($status_jadwal ?? '') === 'terjadwal' ? 'selected' : ''; ?>>
                            Terjadwal
                        </option>
                        <option value="diproses" <?= ($status_jadwal ?? '') === 'diproses' ? 'selected' : ''; ?>>
                            Diproses
                        </option>
                        <option value="selesai" <?= ($status_jadwal ?? '') === 'selesai' ? 'selected' : ''; ?>>
                            Selesai
                        </option>
                        <option value="dibatalkan" <?= ($status_jadwal ?? '') === 'dibatalkan' ? 'selected' : ''; ?>>
                            Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status_waktu" class="form-control">
                        <option value="">Semua Waktu</option>
                        <option value="terlambat" <?= ($status_waktu ?? '') === 'terlambat' ? 'selected' : ''; ?>>
                            Terlambat
                        </option>
                        <option value="hari_ini" <?= ($status_waktu ?? '') === 'hari_ini' ? 'selected' : ''; ?>>
                            Hari Ini
                        </option>
                        <option value="mendekati" <?= ($status_waktu ?? '') === 'mendekati' ? 'selected' : ''; ?>>
                            Mendekati
                        </option>
                        <option value="aman" <?= ($status_waktu ?? '') === 'aman' ? 'selected' : ''; ?>>
                            Aman
                        </option>
                    </select>
                </div>

                <div class="col-md-2 mt-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-1"></i>
                        Filter
                    </button>
                </div>

                <div class="col-md-2 mt-2">
                    <a href="<?= base_url('/admin/jadwal-maintenance'); ?>" class="btn btn-secondary w-100">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Daftar Jadwal Maintenance</strong>
        <small class="text-muted">
            Total: <?= !empty($jadwal) ? count($jadwal) : 0; ?> jadwal
        </small>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aset</th>
                        <th>Tanggal Jadwal</th>
                        <th>Status Waktu</th>
                        <th>Jenis Maintenance</th>
                        <th>Periode</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th width="14%">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($jadwal)) : ?>

                    <?php $no = 1; ?>

                    <?php foreach ($jadwal as $row) : ?>

                        <?php
                            $today = date('Y-m-d');
                            $tanggalJadwal = $row['tanggal_jadwal'];
                            $selisihHari = (strtotime($tanggalJadwal) - strtotime($today)) / 86400;
                        ?>

                        <tr>

                            <td><?= $no++; ?></td>

                            <td>
                                <strong><?= esc($row['kode_aset']); ?></strong><br>
                                <small class="text-muted">
                                    <?= esc($row['nama_aset']); ?>
                                </small>
                            </td>

                            <td><?= esc($row['tanggal_jadwal']); ?></td>

                            <td>

                                <?php if ($row['status_jadwal'] === 'selesai') : ?>

                                    <span class="badge bg-success">
                                        Selesai
                                    </span>

                                <?php elseif ($row['status_jadwal'] === 'dibatalkan') : ?>

                                    <span class="badge bg-secondary">
                                        Dibatalkan
                                    </span>

                                <?php elseif ($selisihHari < 0) : ?>

                                    <span class="badge bg-danger">
                                        Terlambat
                                    </span>

                                <?php elseif ($selisihHari == 0) : ?>

                                    <span class="badge bg-warning text-dark">
                                        Hari Ini
                                    </span>

                                <?php elseif ($selisihHari <= 7) : ?>

                                    <span class="badge bg-info text-dark">
                                        Mendekati Jadwal
                                    </span>

                                <?php else : ?>

                                    <span class="badge bg-primary">
                                        Aman
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>
                                <?= esc($row['jenis_maintenance']); ?>
                            </td>

                            <td>
                                <?= esc(str_replace('_', ' ', ucfirst($row['periode']))); ?>
                            </td>

                            <td>

                                <?php if ($row['prioritas'] === 'tinggi') : ?>

                                    <span class="badge bg-danger">
                                        Tinggi
                                    </span>

                                <?php elseif ($row['prioritas'] === 'sedang') : ?>

                                    <span class="badge bg-warning text-dark">
                                        Sedang
                                    </span>

                                <?php else : ?>

                                    <span class="badge bg-success">
                                        Rendah
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <?php if ($row['status_jadwal'] === 'terjadwal') : ?>

                                    <span class="badge bg-secondary">
                                        Terjadwal
                                    </span>

                                <?php elseif ($row['status_jadwal'] === 'diproses') : ?>

                                    <span class="badge bg-warning text-dark">
                                        Diproses
                                    </span>

                                <?php elseif ($row['status_jadwal'] === 'selesai') : ?>

                                    <span class="badge bg-success">
                                        Selesai
                                    </span>

                                <?php else : ?>

                                    <span class="badge bg-danger">
                                        Dibatalkan
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <a href="<?= base_url('/admin/jadwal-maintenance/edit/' . $row['id_jadwal']); ?>"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <a href="<?= base_url('/admin/jadwal-maintenance/delete/' . $row['id_jadwal']); ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">

                                    <i class="bi bi-trash"></i>

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">

                            <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>

                            Data jadwal maintenance tidak ditemukan.

                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>