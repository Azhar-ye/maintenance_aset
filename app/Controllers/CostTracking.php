<?php

namespace App\Controllers;

use App\Models\CostTrackingModel;
use App\Models\MaintenanceModel;

class CostTracking extends BaseController
{
    protected $costModel;
    protected $maintenanceModel;

    public function __construct()
    {
        $this->costModel = new CostTrackingModel();
        $this->maintenanceModel = new MaintenanceModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $jenisBiaya = $this->request->getGet('jenis_biaya');
        $tanggalAwal = $this->request->getGet('tanggal_awal');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        $builder = $this->costModel
            ->select('cost_tracking.*, maintenance.jenis_pekerjaan, aset.kode_aset, aset.nama_aset, vendor.nama_vendor')
            ->join('maintenance', 'maintenance.id_maintenance = cost_tracking.id_maintenance', 'left')
            ->join('aset', 'aset.id_aset = maintenance.id_aset', 'left')
            ->join('vendor', 'vendor.id_vendor = maintenance.id_vendor', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('aset.kode_aset', $keyword)
                ->orLike('aset.nama_aset', $keyword)
                ->orLike('vendor.nama_vendor', $keyword)
                ->orLike('cost_tracking.deskripsi_biaya', $keyword)
                ->groupEnd();
        }

        if (!empty($jenisBiaya)) {
            $builder->where('cost_tracking.jenis_biaya', $jenisBiaya);
        }

        if (!empty($tanggalAwal)) {
            $builder->where('cost_tracking.tanggal_biaya >=', $tanggalAwal);
        }

        if (!empty($tanggalAkhir)) {
            $builder->where('cost_tracking.tanggal_biaya <=', $tanggalAkhir);
        }

        $data = [
            'title' => 'Cost Tracking',
            'cost' => $builder
                ->orderBy('cost_tracking.id_cost', 'DESC')
                ->findAll(),

            'keyword' => $keyword,
            'jenis_biaya' => $jenisBiaya,
            'tanggal_awal' => $tanggalAwal,
            'tanggal_akhir' => $tanggalAkhir
        ];

        return view('cost_tracking/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Cost Tracking',
            'maintenance' => $this->maintenanceModel
                ->select('maintenance.*, aset.kode_aset, aset.nama_aset')
                ->join('aset', 'aset.id_aset = maintenance.id_aset', 'left')
                ->findAll()
        ];

        return view('cost_tracking/create', $data);
    }

    public function store()
    {
        $this->costModel->save([
            'id_maintenance' => $this->request->getPost('id_maintenance'),
            'jenis_biaya' => $this->request->getPost('jenis_biaya'),
            'deskripsi_biaya' => $this->request->getPost('deskripsi_biaya'),
            'nominal' => $this->request->getPost('nominal'),
            'tanggal_biaya' => $this->request->getPost('tanggal_biaya')
        ]);

        return redirect()
            ->to('/admin/cost-tracking')
            ->with('success', 'Data biaya berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Cost Tracking',
            'cost' => $this->costModel->find($id),
            'maintenance' => $this->maintenanceModel
                ->select('maintenance.*, aset.kode_aset, aset.nama_aset')
                ->join('aset', 'aset.id_aset = maintenance.id_aset', 'left')
                ->findAll()
        ];

        return view('cost_tracking/edit', $data);
    }

    public function update($id)
    {
        $this->costModel->update($id, [
            'id_maintenance' => $this->request->getPost('id_maintenance'),
            'jenis_biaya' => $this->request->getPost('jenis_biaya'),
            'deskripsi_biaya' => $this->request->getPost('deskripsi_biaya'),
            'nominal' => $this->request->getPost('nominal'),
            'tanggal_biaya' => $this->request->getPost('tanggal_biaya')
        ]);

        return redirect()
            ->to('/admin/cost-tracking')
            ->with('success', 'Data biaya berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->costModel->delete($id);

        return redirect()
            ->to('/admin/cost-tracking')
            ->with('success', 'Data biaya berhasil dihapus.');
    }
}