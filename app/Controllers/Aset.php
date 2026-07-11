<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;
use App\Models\AsetModel;
use App\Models\KategoriAsetModel;
use App\Models\LokasiModel;
use App\Models\DivisiModel;
use App\Models\MaintenanceModel;

class Aset extends BaseController
{
    protected $asetModel;
    protected $kategoriModel;
    protected $lokasiModel;
    protected $divisiModel;

    public function __construct()
    {
        $this->asetModel = new AsetModel();
        $this->kategoriModel = new KategoriAsetModel();
        $this->lokasiModel = new LokasiModel();
        $this->divisiModel = new DivisiModel();
    }

        public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->asetModel
            ->select('aset.*, kategori_aset.nama_kategori, lokasi.nama_lokasi, divisi.nama_divisi')
            ->join('kategori_aset', 'kategori_aset.id_kategori = aset.id_kategori', 'left')
            ->join('lokasi', 'lokasi.id_lokasi = aset.id_lokasi', 'left')
            ->join('divisi', 'divisi.id_divisi = aset.id_divisi', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('aset.kode_aset', $keyword)
                ->orLike('aset.nama_aset', $keyword)
                ->orLike('lokasi.nama_lokasi', $keyword)
                ->orLike('divisi.nama_divisi', $keyword)
                ->groupEnd();
        }

        $data = [
            'title' => 'Data Aset',
            'keyword' => $keyword,
            'aset' => $builder->findAll()
        ];

        return view('aset/index', $data);
    }

    public function detail($id)
    {
        $aset = $this->asetModel
            ->select('aset.*, kategori_aset.nama_kategori, lokasi.nama_lokasi, divisi.nama_divisi')
            ->join('kategori_aset', 'kategori_aset.id_kategori = aset.id_kategori', 'left')
            ->join('lokasi', 'lokasi.id_lokasi = aset.id_lokasi', 'left')
            ->join('divisi', 'divisi.id_divisi = aset.id_divisi', 'left')
            ->where('aset.id_aset', $id)
            ->first();

            if (!$aset) {
            return redirect()
                ->to('/admin/aset')
                ->with('success', 'Data aset tidak ditemukan.');
    }

     $maintenanceModel = new MaintenanceModel();

        $riwayatMaintenance = $maintenanceModel
            ->select('maintenance.*, vendor.nama_vendor')
            ->join('vendor', 'vendor.id_vendor = maintenance.id_vendor', 'left')
            ->where('maintenance.id_aset', $id)
            ->orderBy('maintenance.tanggal_mulai', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Detail Aset',
            'aset' => $aset,
            'riwayat_maintenance' => $riwayatMaintenance
    ];

    return view('aset/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Aset',
            'kategori' => $this->kategoriModel->findAll(),
            'lokasi' => $this->lokasiModel->findAll(),
            'divisi' => $this->divisiModel->findAll()
        ];

        return view('aset/create', $data);
    }

    public function store()
    {
        $foto = $this->request->getFile('foto_aset');

        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            $namaFoto = $foto->getRandomName();

            $foto->move(
                ROOTPATH . 'public/uploads/aset',
                $namaFoto
            );
        }

        $this->asetModel->save([
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_lokasi' => $this->request->getPost('id_lokasi'),
            'id_divisi' => $this->request->getPost('id_divisi'),
            'kode_aset' => $this->request->getPost('kode_aset'),
            'nama_aset' => $this->request->getPost('nama_aset'),
            'merk' => $this->request->getPost('merk'),
            'spesifikasi' => $this->request->getPost('spesifikasi'),
            'tanggal_pembelian' => $this->request->getPost('tanggal_pembelian'),
            'harga_pembelian' => $this->request->getPost('harga_pembelian'),
            'kondisi' => $this->request->getPost('kondisi'),
            'status_aset' => $this->request->getPost('status_aset'),
            'foto_aset' => $namaFoto,
            'keterangan' => $this->request->getPost('keterangan')
        ]);

        $this->simpanLog(
            'Menambahkan aset: ' . $this->request->getPost('kode_aset'),
            'Aset'
        );

        return redirect()
            ->to('/admin/aset')
            ->with('success', 'Data aset berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Aset',
            'aset' => $this->asetModel->find($id),
            'kategori' => $this->kategoriModel->findAll(),
            'lokasi' => $this->lokasiModel->findAll(),
            'divisi' => $this->divisiModel->findAll()
        ];

        return view('aset/edit', $data);
    }

    public function update($id)
    {
        $asetLama = $this->asetModel->find($id);

        $foto = $this->request->getFile('foto_aset');

        $namaFoto = $asetLama['foto_aset'] ?? null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!empty($asetLama['foto_aset'])) {
                $pathFotoLama = ROOTPATH . 'public/uploads/aset/' . $asetLama['foto_aset'];

                if (file_exists($pathFotoLama)) {
                    unlink($pathFotoLama);
                }
            }

            $namaFoto = $foto->getRandomName();

            $foto->move(
                ROOTPATH . 'public/uploads/aset',
                $namaFoto
            );
        }

        $this->asetModel->update($id, [
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_lokasi' => $this->request->getPost('id_lokasi'),
            'id_divisi' => $this->request->getPost('id_divisi'),
            'kode_aset' => $this->request->getPost('kode_aset'),
            'nama_aset' => $this->request->getPost('nama_aset'),
            'merk' => $this->request->getPost('merk'),
            'spesifikasi' => $this->request->getPost('spesifikasi'),
            'tanggal_pembelian' => $this->request->getPost('tanggal_pembelian'),
            'harga_pembelian' => $this->request->getPost('harga_pembelian'),
            'kondisi' => $this->request->getPost('kondisi'),
            'status_aset' => $this->request->getPost('status_aset'),
            'foto_aset' => $namaFoto,
            'keterangan' => $this->request->getPost('keterangan')
        ]);

        $this->simpanLog(
            'Mengubah aset: ' . $this->request->getPost('kode_aset'),
            'Aset'
        );

        return redirect()
            ->to('/admin/aset')
            ->with('success', 'Data aset berhasil diperbarui.');
    }

        public function delete($id)
    {
        $aset = $this->asetModel->find($id);

        if ($aset) {

        $this->simpanLog(
            'Menghapus aset: ' . $aset['kode_aset'],
            'Aset'
        );

        if (!empty($aset['foto_aset'])) {

            $pathFoto = ROOTPATH . 'public/uploads/aset/' . $aset['foto_aset'];

            if (file_exists($pathFoto)) {
                unlink($pathFoto);
            }
        }

        $this->asetModel->delete($id);
    }

        return redirect()
            ->to('/admin/aset')
            ->with('success', 'Data aset berhasil dihapus.');
    }

    private function simpanLog($aktivitas, $modul = 'Aset')
    {
    $logModel = new ActivityLogModel();

    $logModel->save([
        'id_user' => session()->get('id_user'),
        'nama_user' => session()->get('nama'),
        'role' => session()->get('role'),
        'aktivitas' => $aktivitas,
        'modul' => $modul
    ]);
    }

    public function label($id)
    {
    $aset = $this->asetModel
        ->where('id_aset', $id)
        ->first();

    if (!$aset) {
        return redirect()->to('/admin/aset');
    }

    return view('aset/label', [
        'title' => 'Label QR Aset',
        'aset' => $aset
    ]);
    }
}