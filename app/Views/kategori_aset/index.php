<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Data Kategori Aset</h3>
        <p class="text-muted mb-0">Kelola kategori untuk pengelompokan aset perusahaan.</p>
    </div>

    <a href="<?= base_url('/admin/kategori-aset/create'); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Kategori
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
        <strong>Daftar Kategori Aset</strong>
        <small class="text-muted">Total: <?= !empty($kategori) ? count($kategori) : 0; ?> kategori</small>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th width="14%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($kategori)) : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($kategori as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>

                                <td>
                                    <span class="badge bg-light text-dark">
                                        <?= esc($row['nama_kategori']); ?>
                                    </span>
                                </td>

                                <td><?= esc($row['keterangan']); ?></td>

                                <td>
                                    <a href="<?= base_url('/admin/kategori-aset/edit/' . $row['id_kategori']); ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="<?= base_url('/admin/kategori-aset/delete/' . $row['id_kategori']); ?>"
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
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Data kategori aset belum tersedia.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>