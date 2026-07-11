<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Data Lokasi</h3>
        <p class="text-muted mb-0">
            Kelola lokasi penempatan aset perusahaan.
        </p>
    </div>

    <a href="<?= base_url('/admin/lokasi/create'); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Lokasi
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Daftar Lokasi</strong>

        <small class="text-muted">
            Total: <?= !empty($lokasi) ? count($lokasi) : 0; ?> lokasi
        </small>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Lokasi</th>
                        <th>Detail Lokasi</th>
                        <th width="14%">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($lokasi)) : ?>

                        <?php $no = 1; ?>

                        <?php foreach ($lokasi as $row) : ?>

                            <tr>

                                <td><?= $no++; ?></td>

                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        <?= esc($row['nama_lokasi']); ?>
                                    </span>
                                </td>

                                <td>
                                    <?= esc($row['detail_lokasi']); ?>
                                </td>

                                <td>

                                    <a href="<?= base_url('/admin/lokasi/edit/' . $row['id_lokasi']); ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="<?= base_url('/admin/lokasi/delete/' . $row['id_lokasi']); ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">

                                        <i class="bi bi-trash"></i>

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">

                                <i class="bi bi-geo-alt fs-3 d-block mb-2"></i>

                                Data lokasi belum tersedia.

                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>