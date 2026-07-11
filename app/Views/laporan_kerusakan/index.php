<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Laporan Kerusakan</h3>
        <p class="text-muted mb-0">
            Kelola laporan kerusakan aset dari karyawan, mulai dari validasi hingga penyelesaian.
        </p>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="get" action="<?= base_url('/admin/laporan-kerusakan'); ?>">
            <div class="row g-2">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text"
                               name="keyword"
                               class="form-control"
                               placeholder="Cari aset, pelapor, judul, atau deskripsi..."
                               value="<?= esc($keyword ?? ''); ?>">
                    </div>
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
                        <option value="darurat" <?= ($prioritas ?? '') === 'darurat' ? 'selected' : ''; ?>>
                            Darurat
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="status_laporan" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="menunggu_validasi" <?= ($status_laporan ?? '') === 'menunggu_validasi' ? 'selected' : ''; ?>>
                            Menunggu Validasi
                        </option>
                        <option value="valid" <?= ($status_laporan ?? '') === 'valid' ? 'selected' : ''; ?>>
                            Valid
                        </option>
                        <option value="ditolak" <?= ($status_laporan ?? '') === 'ditolak' ? 'selected' : ''; ?>>
                            Ditolak
                        </option>
                        <option value="diproses" <?= ($status_laporan ?? '') === 'diproses' ? 'selected' : ''; ?>>
                            Diproses
                        </option>
                        <option value="selesai" <?= ($status_laporan ?? '') === 'selesai' ? 'selected' : ''; ?>>
                            Selesai
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-1"></i>
                        Filter
                    </button>
                </div>

                <?php if (!empty($keyword) || !empty($prioritas) || !empty($status_laporan)) : ?>
                    <div class="col-md-2 mt-2">
                        <a href="<?= base_url('/admin/laporan-kerusakan'); ?>" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Daftar Laporan Kerusakan</strong>

        <small class="text-muted">
            Total: <?= !empty($laporan) ? count($laporan) : 0; ?> laporan
        </small>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aset</th>
                        <th>Pelapor</th>
                        <th>Laporan</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th width="24%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($laporan)) : ?>
                        <?php $no = 1; ?>

                        <?php foreach ($laporan as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>

                                <td>
                                    <strong><?= esc($row['kode_aset']); ?></strong><br>
                                    <small class="text-muted"><?= esc($row['nama_aset']); ?></small>
                                </td>

                                <td><?= esc($row['nama_pelapor']); ?></td>

                                <td>
                                    <strong><?= esc($row['judul_laporan']); ?></strong><br>
                                    <small class="text-muted">
                                        <?= esc($row['deskripsi_kerusakan']); ?>
                                    </small>
                                </td>

                                <td>
                                    <?php if ($row['prioritas'] === 'darurat') : ?>
                                        <span class="badge bg-dark">Darurat</span>
                                    <?php elseif ($row['prioritas'] === 'tinggi') : ?>
                                        <span class="badge bg-danger">Tinggi</span>
                                    <?php elseif ($row['prioritas'] === 'sedang') : ?>
                                        <span class="badge bg-warning text-dark">Sedang</span>
                                    <?php else : ?>
                                        <span class="badge bg-success">Rendah</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($row['status_laporan'] === 'menunggu_validasi') : ?>
                                        <span class="badge bg-secondary">Menunggu Validasi</span>
                                    <?php elseif ($row['status_laporan'] === 'valid') : ?>
                                        <span class="badge bg-info text-dark">Valid</span>
                                    <?php elseif ($row['status_laporan'] === 'ditolak') : ?>
                                        <span class="badge bg-danger">Ditolak</span>
                                    <?php elseif ($row['status_laporan'] === 'diproses') : ?>
                                        <span class="badge bg-warning text-dark">Diproses</span>
                                    <?php else : ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($row['foto_kerusakan'])) : ?>
                                        <a href="<?= base_url('uploads/kerusakan/' . $row['foto_kerusakan']); ?>"
                                           target="_blank"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-image"></i>
                                            Lihat
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($row['status_laporan'] === 'menunggu_validasi') : ?>
                                        <a href="<?= base_url('/admin/laporan-kerusakan/validasi/' . $row['id_laporan']); ?>"
                                           class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i>
                                        </a>

                                        <a href="<?= base_url('/admin/laporan-kerusakan/tolak/' . $row['id_laporan']); ?>"
                                           class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-circle"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($row['status_laporan'] === 'valid') : ?>
                                        <a href="<?= base_url('/admin/laporan-kerusakan/proses/' . $row['id_laporan']); ?>"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-tools"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($row['status_laporan'] === 'diproses') : ?>
                                        <a href="<?= base_url('/admin/laporan-kerusakan/selesai/' . $row['id_laporan']); ?>"
                                           class="btn btn-primary btn-sm">
                                            <i class="bi bi-flag"></i>
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?= base_url('/admin/laporan-kerusakan/delete/' . $row['id_laporan']); ?>"
                                       class="btn btn-dark btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
                                Data laporan kerusakan tidak ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>