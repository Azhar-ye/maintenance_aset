<?php

namespace App\Controllers;

use App\Models\JadwalMaintenanceModel;
use App\Models\AsetModel;

class JadwalMaintenance extends BaseController
{
    protected $jadwalModel;
    protected $asetModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalMaintenanceModel();
        $this->asetModel = new AsetModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $periode = $this->request->getGet('periode');
        $prioritas = $this->request->getGet('prioritas');
        $statusJadwal = $this->request->getGet('status_jadwal');
        $statusWaktu = $this->request->getGet('status_waktu');

        $today = date('Y-m-d');
        $tujuhHariKedepan = date('Y-m-d', strtotime('+7 days'));

        $builder = $this->jadwalModel
            ->select('jadwal_maintenance.*, aset.kode_aset, aset.nama_aset')
            ->join('aset', 'aset.id_aset = jadwal_maintenance.id_aset', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('aset.kode_aset', $keyword)
                ->orLike('aset.nama_aset', $keyword)
                ->orLike('jadwal_maintenance.jenis_maintenance', $keyword)
                ->groupEnd();
        }

        if (!empty($periode)) {
            $builder->where('jadwal_maintenance.periode', $periode);
        }

        if (!empty($prioritas)) {
            $builder->where('jadwal_maintenance.prioritas', $prioritas);
        }

        if (!empty($statusJadwal)) {
            $builder->where('jadwal_maintenance.status_jadwal', $statusJadwal);
        }

        if (!empty($statusWaktu)) {
            if ($statusWaktu === 'terlambat') {
                $builder->where('jadwal_maintenance.tanggal_jadwal <', $today)
                    ->where('jadwal_maintenance.status_jadwal', 'terjadwal');
            } elseif ($statusWaktu === 'hari_ini') {
                $builder->where('jadwal_maintenance.tanggal_jadwal', $today)
                    ->where('jadwal_maintenance.status_jadwal', 'terjadwal');
            } elseif ($statusWaktu === 'mendekati') {
                $builder->where('jadwal_maintenance.tanggal_jadwal >', $today)
                    ->where('jadwal_maintenance.tanggal_jadwal <=', $tujuhHariKedepan)
                    ->where('jadwal_maintenance.status_jadwal', 'terjadwal');
            } elseif ($statusWaktu === 'aman') {
                $builder->where('jadwal_maintenance.tanggal_jadwal >', $tujuhHariKedepan)
                    ->where('jadwal_maintenance.status_jadwal', 'terjadwal');
            }
        }

        $data = [
            'title' => 'Jadwal Maintenance',
            'jadwal' => $builder
                ->orderBy('jadwal_maintenance.tanggal_jadwal', 'ASC')
                ->findAll(),

            'keyword' => $keyword,
            'periode' => $periode,
            'prioritas' => $prioritas,
            'status_jadwal' => $statusJadwal,
            'status_waktu' => $statusWaktu
        ];

        return view('jadwal_maintenance/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Jadwal Maintenance',
            'aset' => $this->asetModel->findAll()
        ];

        return view('jadwal_maintenance/create', $data);
    }

    public function store()
    {
        $this->jadwalModel->save([
            'id_aset' => $this->request->getPost('id_aset'),
            'tanggal_jadwal' => $this->request->getPost('tanggal_jadwal'),
            'jenis_maintenance' => $this->request->getPost('jenis_maintenance'),
            'periode' => $this->request->getPost('periode'),
            'prioritas' => $this->request->getPost('prioritas'),
            'status_jadwal' => $this->request->getPost('status_jadwal'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);

        return redirect()
            ->to('/admin/jadwal-maintenance')
            ->with('success', 'Jadwal maintenance berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Jadwal Maintenance',
            'jadwal' => $this->jadwalModel->find($id),
            'aset' => $this->asetModel->findAll()
        ];

        return view('jadwal_maintenance/edit', $data);
    }

    public function update($id)
    {
        $this->jadwalModel->update($id, [
            'id_aset' => $this->request->getPost('id_aset'),
            'tanggal_jadwal' => $this->request->getPost('tanggal_jadwal'),
            'jenis_maintenance' => $this->request->getPost('jenis_maintenance'),
            'periode' => $this->request->getPost('periode'),
            'prioritas' => $this->request->getPost('prioritas'),
            'status_jadwal' => $this->request->getPost('status_jadwal'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);

        return redirect()
            ->to('/admin/jadwal-maintenance')
            ->with('success', 'Jadwal maintenance berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->jadwalModel->delete($id);

        return redirect()
            ->to('/admin/jadwal-maintenance')
            ->with('success', 'Jadwal maintenance berhasil dihapus.');
    }
}