<?php

namespace App\Controllers;

use App\Models\LokasiModel;

class Lokasi extends BaseController
{
    protected $lokasiModel;

    public function __construct()
    {
        $this->lokasiModel = new LokasiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Lokasi',
            'lokasi' => $this->lokasiModel->findAll()
        ];

        return view('lokasi/index', $data);
    }

    public function create()
    {
        return view('lokasi/create', [
            'title' => 'Tambah Lokasi'
        ]);
    }

    public function store()
    {
        $this->lokasiModel->save([
            'nama_lokasi' => $this->request->getPost('nama_lokasi'),
            'detail_lokasi' => $this->request->getPost('detail_lokasi')
        ]);

        return redirect()->to('/admin/lokasi')->with('success', 'Data lokasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return view('lokasi/edit', [
            'title' => 'Edit Lokasi',
            'lokasi' => $this->lokasiModel->find($id)
        ]);
    }

    public function update($id)
    {
        $this->lokasiModel->update($id, [
            'nama_lokasi' => $this->request->getPost('nama_lokasi'),
            'detail_lokasi' => $this->request->getPost('detail_lokasi')
        ]);

        return redirect()->to('/admin/lokasi')->with('success', 'Data lokasi berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->lokasiModel->delete($id);

        return redirect()->to('/admin/lokasi')->with('success', 'Data lokasi berhasil dihapus.');
    }
}