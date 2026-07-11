<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="card shadow-sm">

    <div class="card-header">
        <strong>Activity Log</strong>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Modul</th>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                    </tr>
                </thead>

                <tbody>

                    <?php $no = 1; ?>

                    <?php foreach ($logs as $log) : ?>

                        <tr>

                            <td><?= $no++; ?></td>

                            <td><?= esc($log['nama_user']); ?></td>

                            <td>
                                <span class="badge bg-primary">
                                    <?= ucfirst($log['role']); ?>
                                </span>
                            </td>

                            <td><?= esc($log['modul']); ?></td>

                            <td><?= esc($log['aktivitas']); ?></td>

                            <td><?= esc($log['created_at']); ?></td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>