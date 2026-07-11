<?php

namespace App\Controllers;

use App\Models\MaintenanceModel;
use App\Models\AsetModel;
use App\Models\VendorModel;
use App\Models\LaporanKerusakanModel;

class Maintenance extends BaseController
{
    protected $maintenanceModel;
    protected $asetModel;
    protected $vendorModel;
    protected $laporanModel;

    public function __construct()
    {
        $this->maintenanceModel = new MaintenanceModel();
        $this->asetModel = new AsetModel();
        $this->vendorModel = new VendorModel();
        $this->laporanModel = new LaporanKerusakanModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $jenis = $this->request->getGet('jenis_pekerjaan');
        $status = $this->request->getGet('status_pekerjaan');

        $builder = $this->maintenanceModel
            ->select('maintenance.*, aset.kode_aset, aset.nama_aset, vendor.nama_vendor')
            ->join('aset', 'aset.id_aset = maintenance.id_aset', 'left')
            ->join('vendor', 'vendor.id_vendor = maintenance.id_vendor', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('aset.kode_aset', $keyword)
                ->orLike('aset.nama_aset', $keyword)
                ->orLike('vendor.nama_vendor', $keyword)
                ->groupEnd();
        }

        if (!empty($jenis)) {
            $builder->where('maintenance.jenis_pekerjaan', $jenis);
        }

        if (!empty($status)) {
            $builder->where('maintenance.status_pekerjaan', $status);
        }

        $data = [
            'title' => 'Data Maintenance',
            'maintenance' => $builder
                ->orderBy('maintenance.id_maintenance', 'DESC')
                ->findAll(),
            'keyword' => $keyword,
            'jenis_pekerjaan' => $jenis,
            'status_pekerjaan' => $status
        ];

        return view('maintenance/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Maintenance',
            'aset' => $this->asetModel->findAll(),
            'vendor' => $this->vendorModel->where('status', 'aktif')->findAll(),
            'laporan' => $this->laporanModel
                ->select('laporan_kerusakan.*, aset.kode_aset, aset.nama_aset')
                ->join('aset', 'aset.id_aset = laporan_kerusakan.id_aset', 'left')
                ->whereIn('status_laporan', ['valid', 'diproses'])
                ->findAll()
        ];

        return view('maintenance/create', $data);
    }

    public function store()
    {
        $this->maintenanceModel->save([
            'id_aset' => $this->request->getPost('id_aset'),
            'id_vendor' => $this->request->getPost('id_vendor'),
            'id_laporan' => $this->request->getPost('id_laporan') ?: null,
            'jenis_pekerjaan' => $this->request->getPost('jenis_pekerjaan'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai') ?: null,
            'deskripsi_pekerjaan' => $this->request->getPost('deskripsi_pekerjaan'),
            'hasil_pekerjaan' => $this->request->getPost('hasil_pekerjaan'),
            'status_pekerjaan' => $this->request->getPost('status_pekerjaan'),
            'dibuat_oleh' => session()->get('id_user')
        ]);

        if ($this->request->getPost('id_laporan')) {
            $this->laporanModel->update($this->request->getPost('id_laporan'), [
                'status_laporan' => 'diproses'
            ]);
        }

        $this->asetModel->update($this->request->getPost('id_aset'), [
            'status_aset' => 'maintenance',
            'kondisi' => 'perlu_maintenance'
        ]);

        return redirect()->to('/admin/maintenance')->with('success', 'Data maintenance berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Maintenance',
            'maintenance' => $this->maintenanceModel->find($id),
            'aset' => $this->asetModel->findAll(),
            'vendor' => $this->vendorModel->where('status', 'aktif')->findAll(),
            'laporan' => $this->laporanModel
                ->select('laporan_kerusakan.*, aset.kode_aset, aset.nama_aset')
                ->join('aset', 'aset.id_aset = laporan_kerusakan.id_aset', 'left')
                ->findAll()
        ];

        return view('maintenance/edit', $data);
    }

    public function update($id)
    {
        $idAset = $this->request->getPost('id_aset');
        $statusPekerjaan = $this->request->getPost('status_pekerjaan');
        $idLaporan = $this->request->getPost('id_laporan') ?: null;

        $this->maintenanceModel->update($id, [
            'id_aset' => $idAset,
            'id_vendor' => $this->request->getPost('id_vendor'),
            'id_laporan' => $idLaporan,
            'jenis_pekerjaan' => $this->request->getPost('jenis_pekerjaan'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai') ?: null,
            'deskripsi_pekerjaan' => $this->request->getPost('deskripsi_pekerjaan'),
            'hasil_pekerjaan' => $this->request->getPost('hasil_pekerjaan'),
            'status_pekerjaan' => $statusPekerjaan
        ]);

        if ($statusPekerjaan === 'selesai') {
            $this->asetModel->update($idAset, [
                'status_aset' => 'aktif',
                'kondisi' => 'baik'
            ]);

            if ($idLaporan) {
                $this->laporanModel->update($idLaporan, [
                    'status_laporan' => 'selesai'
                ]);
            }
        }

        return redirect()->to('/admin/maintenance')->with('success', 'Data maintenance berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->maintenanceModel->delete($id);

        return redirect()->to('/admin/maintenance')->with('success', 'Data maintenance berhasil dihapus.');
    }
}