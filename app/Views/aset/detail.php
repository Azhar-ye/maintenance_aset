<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Detail Aset</h3>
        <p class="text-muted mb-0">
            Informasi lengkap aset perusahaan
        </p>
    </div>

    <a href="<?= base_url('/admin/aset'); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="row">

    <div class="col-md-4">

        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">

                <?php if (!empty($aset['foto_aset'])) : ?>
                    <img src="<?= base_url('uploads/aset/' . $aset['foto_aset']); ?>"
                         class="img-fluid rounded mb-3"
                         style="max-height:300px;">
                <?php else : ?>
                    <div class="py-5 text-muted">
                        <i class="bi bi-image fs-1"></i>
                        <p class="mt-2">Foto aset belum tersedia</p>
                    </div>
                <?php endif; ?>

                <h5><?= esc($aset['nama_aset']); ?></h5>

                <small class="text-muted">
                    <?= esc($aset['kode_aset']); ?>
                </small>

                <hr>

                <?php
                    $qrUrl = base_url('/admin/aset/detail/' . $aset['id_aset']);
                    $qrImage = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' . urlencode($qrUrl);
                ?>

                <div class="mt-3">
                    <h6>QR Code Aset</h6>

                    <img src="<?= $qrImage; ?>"
                         alt="QR Code Aset"
                         class="img-fluid border rounded p-2 bg-white mb-2"
                         style="width: 180px; height: 180px;">

                    <div class="d-grid gap-2">
                        <a href="<?= $qrImage; ?>"
                           target="_blank"
                           class="btn btn-success btn-sm">
                            <i class="bi bi-download"></i>
                            Download QR
                        </a>

                        <a href="<?= base_url('/admin/aset/label/' . $aset['id_aset']); ?>"
                           class="btn btn-dark btn-sm">
                            <i class="bi bi-printer"></i>
                            Label QR
                        </a>
                    </div>

                    <div class="mt-2">
                        <small class="text-muted">
                            Scan untuk membuka detail aset.
                        </small>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="col-md-8">

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                Informasi Aset
            </div>

            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="30%">Kode Aset</th>
                        <td><?= esc($aset['kode_aset']); ?></td>
                    </tr>

                    <tr>
                        <th>Nama Aset</th>
                        <td><?= esc($aset['nama_aset']); ?></td>
                    </tr>

                    <tr>
                        <th>Kategori</th>
                        <td><?= esc($aset['nama_kategori']); ?></td>
                    </tr>

                    <tr>
                        <th>Lokasi</th>
                        <td><?= esc($aset['nama_lokasi']); ?></td>
                    </tr>

                    <tr>
                        <th>Divisi</th>
                        <td><?= esc($aset['nama_divisi']); ?></td>
                    </tr>

                    <tr>
                        <th>Merk</th>
                        <td><?= esc($aset['merk']); ?></td>
                    </tr>

                    <tr>
                        <th>Tanggal Pembelian</th>
                        <td><?= esc($aset['tanggal_pembelian']); ?></td>
                    </tr>

                    <tr>
                        <th>Harga Pembelian</th>
                        <td>
                            Rp <?= number_format($aset['harga_pembelian'], 0, ',', '.'); ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Kondisi</th>
                        <td><?= esc(str_replace('_', ' ', ucfirst($aset['kondisi']))); ?></td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td><?= esc(ucfirst($aset['status_aset'])); ?></td>
                    </tr>

                    <tr>
                        <th>Spesifikasi</th>
                        <td><?= nl2br(esc($aset['spesifikasi'])); ?></td>
                    </tr>

                    <tr>
                        <th>Keterangan</th>
                        <td><?= nl2br(esc($aset['keterangan'])); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                Riwayat Maintenance Aset
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Vendor</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($riwayat_maintenance)) : ?>
                                <?php $no = 1; ?>
                                <?php foreach ($riwayat_maintenance as $row) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($row['nama_vendor'] ?? '-'); ?></td>
                                        <td><?= esc(str_replace('_', ' ', ucfirst($row['jenis_pekerjaan']))); ?></td>
                                        <td><?= esc($row['tanggal_mulai']); ?></td>
                                        <td><?= esc($row['tanggal_selesai']); ?></td>
                                        <td>
                                            <?php if ($row['status_pekerjaan'] === 'selesai') : ?>
                                                <span class="badge bg-success">Selesai</span>
                                            <?php elseif ($row['status_pekerjaan'] === 'diproses') : ?>
                                                <span class="badge bg-warning text-dark">Diproses</span>
                                            <?php else : ?>
                                                <span class="badge bg-secondary">
                                                    <?= esc(ucfirst($row['status_pekerjaan'])); ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-clock-history fs-3 d-block mb-2"></i>
                                        Belum ada riwayat maintenance untuk aset ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection(); ?>