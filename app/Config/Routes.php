<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');
$routes->get('test-db', 'TestDb::index');

$routes->get('/login', 'Auth::login');
$routes->post('/login/proses', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');

$routes->get('/profile', 'Profile::index');
$routes->post('/profile/update', 'Profile::update');

$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('dashboard', 'Dashboard::admin');
    $routes->get('activity-log', 'ActivityLog::index');

    $routes->get('vendor', 'Vendor::index');
    $routes->get('vendor/create', 'Vendor::create');
    $routes->post('vendor/store', 'Vendor::store');
    $routes->get('vendor/edit/(:num)', 'Vendor::edit/$1');
    $routes->post('vendor/update/(:num)', 'Vendor::update/$1');
    $routes->get('vendor/delete/(:num)', 'Vendor::delete/$1');

    $routes->get('kategori-aset', 'KategoriAset::index');
    $routes->get('kategori-aset/create', 'KategoriAset::create');
    $routes->post('kategori-aset/store', 'KategoriAset::store');
    $routes->get('kategori-aset/edit/(:num)', 'KategoriAset::edit/$1');
    $routes->post('kategori-aset/update/(:num)', 'KategoriAset::update/$1');
    $routes->get('kategori-aset/delete/(:num)', 'KategoriAset::delete/$1');

    $routes->get('lokasi', 'Lokasi::index');
    $routes->get('lokasi/create', 'Lokasi::create');
    $routes->post('lokasi/store', 'Lokasi::store');
    $routes->get('lokasi/edit/(:num)', 'Lokasi::edit/$1');
    $routes->post('lokasi/update/(:num)', 'Lokasi::update/$1');
    $routes->get('lokasi/delete/(:num)', 'Lokasi::delete/$1');

    $routes->get('aset', 'Aset::index');
    $routes->get('aset/detail/(:num)', 'Aset::detail/$1');
    $routes->get('aset/label/(:num)', 'Aset::label/$1');
    $routes->get('aset/create', 'Aset::create');
    $routes->post('aset/store', 'Aset::store');
    $routes->get('aset/edit/(:num)', 'Aset::edit/$1');
    $routes->post('aset/update/(:num)', 'Aset::update/$1');
    $routes->get('aset/delete/(:num)', 'Aset::delete/$1');

    $routes->get('laporan-kerusakan', 'LaporanKerusakan::index');
    $routes->get('laporan-kerusakan/validasi/(:num)', 'LaporanKerusakan::validasi/$1');
    $routes->get('laporan-kerusakan/tolak/(:num)', 'LaporanKerusakan::tolak/$1');
    $routes->get('laporan-kerusakan/proses/(:num)', 'LaporanKerusakan::proses/$1');
    $routes->get('laporan-kerusakan/selesai/(:num)', 'LaporanKerusakan::selesai/$1');
    $routes->get('laporan-kerusakan/delete/(:num)', 'LaporanKerusakan::delete/$1');

    $routes->get('maintenance', 'Maintenance::index');
    $routes->get('maintenance/create', 'Maintenance::create');
    $routes->post('maintenance/store', 'Maintenance::store');
    $routes->get('maintenance/edit/(:num)', 'Maintenance::edit/$1');
    $routes->post('maintenance/update/(:num)', 'Maintenance::update/$1');
    $routes->get('maintenance/delete/(:num)', 'Maintenance::delete/$1');

    $routes->get('cost-tracking', 'CostTracking::index');
    $routes->get('cost-tracking/create', 'CostTracking::create');
    $routes->post('cost-tracking/store', 'CostTracking::store');
    $routes->get('cost-tracking/edit/(:num)', 'CostTracking::edit/$1');
    $routes->post('cost-tracking/update/(:num)', 'CostTracking::update/$1');
    $routes->get('cost-tracking/delete/(:num)', 'CostTracking::delete/$1');

    $routes->get('jadwal-maintenance', 'JadwalMaintenance::index');
    $routes->get('jadwal-maintenance/create', 'JadwalMaintenance::create');
    $routes->post('jadwal-maintenance/store', 'JadwalMaintenance::store');
    $routes->get('jadwal-maintenance/edit/(:num)', 'JadwalMaintenance::edit/$1');
    $routes->post('jadwal-maintenance/update/(:num)', 'JadwalMaintenance::update/$1');
    $routes->get('jadwal-maintenance/delete/(:num)', 'JadwalMaintenance::delete/$1');

    $routes->get('user', 'User::index');
    $routes->get('user/create', 'User::create');
    $routes->get('user/detail/(:num)', 'User::detail/$1');
    $routes->post('user/store', 'User::store');

    $routes->get('user/edit/(:num)', 'User::edit/$1');
    $routes->post('user/update/(:num)', 'User::update/$1');

    $routes->get('user/delete/(:num)', 'User::delete/$1');
});

$routes->group('karyawan', ['filter' => 'auth:karyawan'], function($routes) {
    $routes->get('dashboard', 'Dashboard::karyawan');
    $routes->get('laporan-kerusakan', 'LaporanKerusakan::riwayat');
    $routes->get('laporan-kerusakan/create', 'LaporanKerusakan::create');
    $routes->post('laporan-kerusakan/store', 'LaporanKerusakan::store');
});

$routes->group('manajer', ['filter' => 'auth:manajer'], function($routes) {
    $routes->get('dashboard', 'Dashboard::manajer');

    $routes->get('laporan-aset', 'Laporan::aset');
    $routes->get('laporan-maintenance', 'Laporan::maintenance');
    $routes->get('laporan-cost-tracking', 'Laporan::costTracking');

    $routes->get('laporan-cost-tracking/pdf', 'Laporan::exportCostTrackingPdf');
    $routes->get('laporan-cost-tracking/excel', 'Laporan::exportCostTrackingExcel');

    $routes->get('laporan-aset/pdf', 'Laporan::exportAsetPdf');
    $routes->get('laporan-maintenance/pdf', 'Laporan::exportMaintenancePdf');
    $routes->get('laporan-aset/excel', 'Laporan::exportAsetExcel');
    $routes->get('laporan-maintenance/excel', 'Laporan::exportMaintenanceExcel');
});