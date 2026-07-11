<?php

namespace App\Controllers;

use App\Models\VendorModel;

class Vendor extends BaseController
{
    protected $vendorModel;

    public function __construct()
    {
        $this->vendorModel = new VendorModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Vendor',
            'vendor' => $this->vendorModel->findAll()
        ];

        return view('vendor/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Vendor'
        ];

        return view('vendor/create', $data);
    }

    public function store()
    {
        $this->vendorModel->save([
            'nama_vendor'   => $this->request->getPost('nama_vendor'),
            'jenis_layanan' => $this->request->getPost('jenis_layanan'),
            'pic_vendor'    => $this->request->getPost('pic_vendor'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
            'alamat'        => $this->request->getPost('alamat'),
            'status'        => $this->request->getPost('status')
        ]);

        return redirect()->to('/admin/vendor')->with('success', 'Data vendor berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Vendor',
            'vendor' => $this->vendorModel->find($id)
        ];

        return view('vendor/edit', $data);
    }

    public function update($id)
    {
        $this->vendorModel->update($id, [
            'nama_vendor'   => $this->request->getPost('nama_vendor'),
            'jenis_layanan' => $this->request->getPost('jenis_layanan'),
            'pic_vendor'    => $this->request->getPost('pic_vendor'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
            'alamat'        => $this->request->getPost('alamat'),
            'status'        => $this->request->getPost('status')
        ]);

        return redirect()->to('/admin/vendor')->with('success', 'Data vendor berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->vendorModel->delete($id);

        return redirect()->to('/admin/vendor')->with('success', 'Data vendor berhasil dihapus.');
    }
}