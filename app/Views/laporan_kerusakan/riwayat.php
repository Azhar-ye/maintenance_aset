<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Riwayat Laporan Kerusakan</h3>
    <a href="<?= base_url('/karyawan/laporan-kerusakan/create'); ?>" class="btn btn-primary">Buat Laporan</a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aset</th>
                    <th>Judul</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($laporan)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($laporan as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?= esc($row['kode_aset']); ?><br>
                                <small><?= esc($row['nama_aset']); ?></small>
                            </td>
                            <td>
                                <?= esc($row['judul_laporan']); ?><br>
                                <small><?= esc($row['deskripsi_kerusakan']); ?></small>
                            </td>
                            <td><?= esc(ucfirst($row['prioritas'])); ?></td>
                            <td>
                                <?php if ($row['status_laporan'] === 'menunggu_validasi') : ?>
                                    <span class="badge bg-secondary">Menunggu Validasi</span>
                                <?php elseif ($row['status_laporan'] === 'valid') : ?>
                                    <span class="badge bg-info">Valid</span>
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
                                    <a href="<?= base_url('uploads/kerusakan/' . $row['foto_kerusakan']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        Lihat
                                    </a>
                                <?php else : ?>
                                    <span class="text-muted">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada laporan kerusakan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>