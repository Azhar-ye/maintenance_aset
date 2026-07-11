<?php

namespace App\Controllers;

use App\Models\KategoriAsetModel;

class KategoriAset extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriAsetModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kategori Aset',
            'kategori' => $this->kategoriModel->findAll()
        ];

        return view('kategori_aset/index', $data);
    }

    public function create()
    {
        return view('kategori_aset/create', [
            'title' => 'Tambah Kategori Aset'
        ]);
    }

    public function store()
    {
        $this->kategoriModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);

        return redirect()->to('/admin/kategori-aset')->with('success', 'Data kategori aset berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return view('kategori_aset/edit', [
            'title' => 'Edit Kategori Aset',
            'kategori' => $this->kategoriModel->find($id)
        ]);
    }

    public function update($id)
    {
        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);

        return redirect()->to('/admin/kategori-aset')->with('success', 'Data kategori aset berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);

        return redirect()->to('/admin/kategori-aset')->with('success', 'Data kategori aset berhasil dihapus.');
    }
}