<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h3>Laporan Cost Tracking</h3>

<form method="get" action="<?= base_url('/manajer/laporan-cost-tracking'); ?>" class="row mb-3">
    <div class="col-md-3">
        <label>Tanggal Awal</label>
        <input type="date"
               name="tanggal_awal"
               class="form-control"
               value="<?= esc($tanggal_awal ?? ''); ?>">
    </div>

    <div class="col-md-3">
        <label>Tanggal Akhir</label>
        <input type="date"
               name="tanggal_akhir"
               class="form-control"
               value="<?= esc($tanggal_akhir ?? ''); ?>">
    </div>

    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">
            Filter
        </button>

        <a href="<?= base_url('/manajer/laporan-cost-tracking'); ?>"
           class="btn btn-secondary ms-2">
            Reset
        </a>
    </div>
</form>

<?php
    $queryFilter = '';

    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        $queryFilter = '?tanggal_awal=' . $tanggal_awal . '&tanggal_akhir=' . $tanggal_akhir;
    }
?>

<a href="<?= base_url('/manajer/laporan-cost-tracking/pdf' . $queryFilter); ?>"
   target="_blank"
   class="btn btn-danger mb-3">
    Export PDF
</a>

<a href="<?= base_url('/manajer/laporan-cost-tracking/excel' . $queryFilter); ?>"
   class="btn btn-success mb-3">
    Export Excel
</a>

<div class="card mt-3">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aset</th>
                    <th>Vendor</th>
                    <th>Jenis Biaya</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cost)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($cost as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= esc($row['kode_aset']); ?> - <?= esc($row['nama_aset']); ?></td>
                            <td><?= esc($row['nama_vendor'] ?? '-'); ?></td>
                            <td><?= esc(str_replace('_', ' ', ucfirst($row['jenis_biaya']))); ?></td>
                            <td><?= esc($row['deskripsi_biaya']); ?></td>
                            <td><?= esc($row['tanggal_biaya']); ?></td>
                            <td>Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <th colspan="6" class="text-end">Total Biaya</th>
                        <th>Rp <?= number_format($total ?? 0, 0, ',', '.'); ?></th>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">Data cost tracking belum tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>