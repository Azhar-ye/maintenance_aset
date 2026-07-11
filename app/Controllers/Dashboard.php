<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\VendorModel;
use App\Models\LaporanKerusakanModel;
use App\Models\MaintenanceModel;
use App\Models\CostTrackingModel;
use App\Models\JadwalMaintenanceModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function admin()
    {
        $asetModel = new AsetModel();
        $vendorModel = new VendorModel();
        $laporanModel = new LaporanKerusakanModel();
        $maintenanceModel = new MaintenanceModel();
        $costModel = new CostTrackingModel();
        $jadwalModel = new JadwalMaintenanceModel();
        $userModel = new UserModel();

        $totalBiaya = $costModel->selectSum('nominal')->first();

        $biayaBulanan = $costModel
            ->select("MONTH(tanggal_biaya) AS bulan, SUM(nominal) AS total")
            ->groupBy("MONTH(tanggal_biaya)")
            ->orderBy("MONTH(tanggal_biaya)", "ASC")
            ->findAll();

        $topAsetBiaya = $costModel
            ->select('aset.kode_aset, aset.nama_aset, SUM(cost_tracking.nominal) AS total_biaya')
            ->join('maintenance', 'maintenance.id_maintenance = cost_tracking.id_maintenance', 'left')
            ->join('aset', 'aset.id_aset = maintenance.id_aset', 'left')
            ->groupBy('aset.id_aset')
            ->orderBy('total_biaya', 'DESC')
            ->limit(5)
            ->findAll();

        $maintenanceTerbaru = $maintenanceModel
            ->select('maintenance.*, aset.kode_aset, aset.nama_aset, vendor.nama_vendor')
            ->join('aset', 'aset.id_aset = maintenance.id_aset', 'left')
            ->join('vendor', 'vendor.id_vendor = maintenance.id_vendor', 'left')
            ->orderBy('maintenance.id_maintenance', 'DESC')
            ->limit(5)
            ->findAll();

        $laporanTerbaru = $laporanModel
            ->select('laporan_kerusakan.*, aset.kode_aset, aset.nama_aset, users.nama AS nama_pelapor')
            ->join('aset', 'aset.id_aset = laporan_kerusakan.id_aset', 'left')
            ->join('users', 'users.id_user = laporan_kerusakan.id_pelapor', 'left')
            ->orderBy('laporan_kerusakan.id_laporan', 'DESC')
            ->limit(5)
            ->findAll();

        $hariIni = date('Y-m-d');
        $tujuhHariKedepan = date('Y-m-d', strtotime('+7 days'));

        $jadwalMendekati = $jadwalModel
            ->where('tanggal_jadwal >=', $hariIni)
            ->where('tanggal_jadwal <=', $tujuhHariKedepan)
            ->where('status_jadwal', 'terjadwal')
            ->countAllResults();

        $jadwalTerlambat = $jadwalModel
            ->where('tanggal_jadwal <', $hariIni)
            ->where('status_jadwal', 'terjadwal')
            ->countAllResults();

        $laporanMenunggu = $laporanModel
            ->where('status_laporan', 'menunggu_validasi')
            ->countAllResults();

        $maintenanceDiproses = $maintenanceModel
            ->where('status_pekerjaan', 'diproses')
            ->countAllResults();

        $data = [
            'title' => 'Dashboard Admin',
            'total_aset' => $asetModel->countAllResults(),
            'total_vendor' => $vendorModel->countAllResults(),
            'total_laporan' => $laporanModel->countAllResults(),
            'total_maintenance' => $maintenanceModel->countAllResults(),
            'total_biaya' => $totalBiaya['nominal'] ?? 0,
            'total_user' => $userModel->countAllResults(),
            'total_admin' => $userModel->where('role', 'admin')->countAllResults(),
            'total_karyawan' => $userModel->where('role', 'karyawan')->countAllResults(),
            'total_manajer' => $userModel->where('role', 'manajer')->countAllResults(),

            'aset_aktif' => $asetModel->where('status_aset', 'aktif')->countAllResults(),
            'aset_maintenance' => $asetModel->where('status_aset', 'maintenance')->countAllResults(),
            'aset_rusak' => $asetModel->where('status_aset', 'rusak')->countAllResults(),
            'aset_nonaktif' => $asetModel->where('status_aset', 'nonaktif')->countAllResults(),

            'biaya_bulanan' => $biayaBulanan,
            'top_aset_biaya' => $topAsetBiaya,
            'maintenance_terbaru' => $maintenanceTerbaru,
            'laporan_terbaru' => $laporanTerbaru,

            'jadwal_mendekati' => $jadwalMendekati,
            'jadwal_terlambat' => $jadwalTerlambat,
            'laporan_menunggu' => $laporanMenunggu,
            'maintenance_diproses' => $maintenanceDiproses
        ];

        return view('dashboard/admin', $data);
    }

    public function karyawan()
    {
        $laporanModel = new LaporanKerusakanModel();

        $idUser = session()->get('id_user');

        $laporanTerbaru = $laporanModel
            ->select('laporan_kerusakan.*, aset.kode_aset, aset.nama_aset')
            ->join('aset', 'aset.id_aset = laporan_kerusakan.id_aset', 'left')
            ->where('laporan_kerusakan.id_pelapor', $idUser)
            ->orderBy('laporan_kerusakan.id_laporan', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'title' => 'Dashboard Karyawan',
            'total_laporan' => $laporanModel
                ->where('id_pelapor', $idUser)
                ->countAllResults(),

            'laporan_menunggu' => $laporanModel
                ->where('id_pelapor', $idUser)
                ->where('status_laporan', 'menunggu_validasi')
                ->countAllResults(),

            'laporan_diproses' => $laporanModel
                ->where('id_pelapor', $idUser)
                ->where('status_laporan', 'diproses')
                ->countAllResults(),

            'laporan_selesai' => $laporanModel
                ->where('id_pelapor', $idUser)
                ->where('status_laporan', 'selesai')
                ->countAllResults(),

            'laporan_terbaru' => $laporanTerbaru
    ];

    return view('dashboard/karyawan', $data);
    }

    public function manajer()
    {
        $asetModel = new AsetModel();
        $maintenanceModel = new MaintenanceModel();
        $costModel = new CostTrackingModel();
        $laporanModel = new LaporanKerusakanModel();

        $totalBiaya = $costModel->selectSum('nominal')->first();

        $biayaBulanan = $costModel
            ->select("MONTH(tanggal_biaya) AS bulan, SUM(nominal) AS total")
            ->groupBy("MONTH(tanggal_biaya)")
            ->orderBy("MONTH(tanggal_biaya)", "ASC")
            ->findAll();

         $maintenanceTerbaru = $maintenanceModel
            ->select('maintenance.*, aset.kode_aset, aset.nama_aset, vendor.nama_vendor')
            ->join('aset', 'aset.id_aset = maintenance.id_aset', 'left')
            ->join('vendor', 'vendor.id_vendor = maintenance.id_vendor', 'left')
            ->orderBy('maintenance.id_maintenance', 'DESC')
            ->limit(5)
            ->findAll();

         $data = [
            'title' => 'Dashboard Manajer',
            'total_aset' => $asetModel->countAllResults(),
            'total_maintenance' => $maintenanceModel->countAllResults(),
            'total_laporan' => $laporanModel->countAllResults(),
            'total_biaya' => $totalBiaya['nominal'] ?? 0,
            'biaya_bulanan' => $biayaBulanan,
            'maintenance_terbaru' => $maintenanceTerbaru
    ];

    return view('dashboard/manajer', $data);
    }
}