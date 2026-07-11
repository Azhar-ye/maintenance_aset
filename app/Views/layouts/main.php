<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Dashboard'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
</head>

<body>

<?php
    $uri = service('uri');
    $segment1 = $uri->getSegment(1);
    $segment2 = $uri->getSegment(2);
    $currentPath = $segment1 . '/' . $segment2;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-0">
            <div class="sidebar-brand d-flex align-items-center gap-2">
                <img src="<?= base_url('assets/img/logo-ams.png'); ?>"
                     alt="Logo AMS"
                     style="width: 34px; height: 34px; object-fit: contain; border-radius: 6px; background: #ffffff; padding: 3px;">

                <span>Asset Management</span>
            </div>

            <div class="sidebar-menu">
                <div class="menu-title">Main Menu</div>

                <a href="<?= base_url('/' . session()->get('role') . '/dashboard'); ?>"
                   class="<?= $segment2 === 'dashboard' ? 'active' : ''; ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>

                <?php if (session()->get('role') === 'admin') : ?>
                    <div class="menu-title">Master Data</div>

                    <a href="<?= base_url('/admin/aset'); ?>"
                       class="<?= $currentPath === 'admin/aset' ? 'active' : ''; ?>">
                        <i class="bi bi-pc-display me-2"></i> Data Aset
                    </a>

                    <a href="<?= base_url('/admin/kategori-aset'); ?>"
                       class="<?= $currentPath === 'admin/kategori-aset' ? 'active' : ''; ?>">
                        <i class="bi bi-tags me-2"></i> Kategori Aset
                    </a>

                    <a href="<?= base_url('/admin/lokasi'); ?>"
                       class="<?= $currentPath === 'admin/lokasi' ? 'active' : ''; ?>">
                        <i class="bi bi-geo-alt me-2"></i> Lokasi
                    </a>

                    <a href="<?= base_url('/admin/vendor'); ?>"
                       class="<?= $currentPath === 'admin/vendor' ? 'active' : ''; ?>">
                        <i class="bi bi-truck me-2"></i> Vendor
                    </a>

                    <a href="<?= base_url('/admin/user'); ?>"
                       class="<?= $currentPath === 'admin/user' ? 'active' : ''; ?>">
                        <i class="bi bi-people me-2"></i> User Management
                    </a>

                    <div class="menu-title">Maintenance</div>

                    <a href="<?= base_url('/admin/maintenance'); ?>"
                       class="<?= $currentPath === 'admin/maintenance' ? 'active' : ''; ?>">
                        <i class="bi bi-tools me-2"></i> Maintenance
                    </a>

                    <a href="<?= base_url('/admin/jadwal-maintenance'); ?>"
                       class="<?= $currentPath === 'admin/jadwal-maintenance' ? 'active' : ''; ?>">
                        <i class="bi bi-calendar-check me-2"></i> Jadwal Maintenance
                    </a>

                    <a href="<?= base_url('/admin/laporan-kerusakan'); ?>"
                       class="<?= $currentPath === 'admin/laporan-kerusakan' ? 'active' : ''; ?>">
                        <i class="bi bi-exclamation-triangle me-2"></i> Laporan Kerusakan
                    </a>

                    <a href="<?= base_url('/admin/cost-tracking'); ?>"
                       class="<?= $currentPath === 'admin/cost-tracking' ? 'active' : ''; ?>">
                        <i class="bi bi-cash-stack me-2"></i> Cost Tracking
                    </a>

                    <div class="menu-title">Monitoring</div>

                    <a href="<?= base_url('/admin/activity-log'); ?>"
                       class="<?= $currentPath === 'admin/activity-log' ? 'active' : ''; ?>">
                        <i class="bi bi-clock-history me-2"></i> Activity Log
                    </a>
                <?php endif; ?>

                <?php if (session()->get('role') === 'karyawan') : ?>
                    <div class="menu-title">Laporan</div>

                    <a href="<?= base_url('/karyawan/laporan-kerusakan/create'); ?>"
                       class="<?= $currentPath === 'karyawan/laporan-kerusakan' && $uri->getSegment(3) === 'create' ? 'active' : ''; ?>">
                        <i class="bi bi-pencil-square me-2"></i> Lapor Kerusakan
                    </a>

                    <a href="<?= base_url('/karyawan/laporan-kerusakan'); ?>"
                       class="<?= $currentPath === 'karyawan/laporan-kerusakan' && $uri->getSegment(3) !== 'create' ? 'active' : ''; ?>">
                        <i class="bi bi-clock-history me-2"></i> Riwayat Laporan
                    </a>
                <?php endif; ?>

                <?php if (session()->get('role') === 'manajer') : ?>
                    <div class="menu-title">Laporan Manajer</div>

                    <a href="<?= base_url('/manajer/laporan-aset'); ?>"
                       class="<?= $currentPath === 'manajer/laporan-aset' ? 'active' : ''; ?>">
                        <i class="bi bi-file-earmark-text me-2"></i> Laporan Aset
                    </a>

                    <a href="<?= base_url('/manajer/laporan-maintenance'); ?>"
                       class="<?= $currentPath === 'manajer/laporan-maintenance' ? 'active' : ''; ?>">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Maintenance
                    </a>

                    <a href="<?= base_url('/manajer/laporan-cost-tracking'); ?>"
                       class="<?= $currentPath === 'manajer/laporan-cost-tracking' ? 'active' : ''; ?>">
                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Laporan Cost Tracking
                    </a>
                <?php endif; ?>

                <div class="menu-title">Account</div>

                <a href="<?= base_url('/profile'); ?>"
                   class="<?= $segment1 === 'profile' ? 'active' : ''; ?>">
                    <i class="bi bi-person-circle me-2"></i> Profil Saya
                </a>

                <a href="<?= base_url('/logout'); ?>" class="text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </div>
        </div>

        <div class="col-md-10 p-0">
            <div class="topbar d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><?= $title ?? 'Dashboard'; ?></h5>
                    <small class="text-muted">Sistem Informasi Monitoring Maintenance dan Cost Tracking Aset</small>
                </div>

                <a href="<?= base_url('/profile'); ?>"
                   class="user-badge text-decoration-none text-dark d-flex align-items-center">

                    <?php if (session()->get('foto_user')) : ?>
                        <img src="<?= base_url('uploads/user/' . session()->get('foto_user')); ?>"
                             width="36"
                             height="36"
                             class="rounded-circle me-2"
                             style="object-fit: cover;">
                    <?php else : ?>
                        <i class="bi bi-person-circle me-2"></i>
                    <?php endif; ?>

                    <span>
                        <?= session()->get('nama'); ?> |
                        <?= session()->get('nama_divisi'); ?>
                    </span>
                </a>
            </div>

            <div class="content-wrapper">
                <?= $this->renderSection('content'); ?>
            </div>

            <footer class="app-footer d-flex justify-content-between align-items-center">
                <div>
                    Asset Management System v1.0
                </div>

                <div>
                    Enterprise Asset Monitoring & Cost Tracking © 2026
                </div>
            </footer>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>