<?php

namespace App\Controllers;

use App\Models\LaporanKerusakanModel;
use App\Models\AsetModel;

class LaporanKerusakan extends BaseController
{
    protected $laporanModel;
    protected $asetModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanKerusakanModel();
        $this->asetModel = new AsetModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $prioritas = $this->request->getGet('prioritas');
        $statusLaporan = $this->request->getGet('status_laporan');

        $builder = $this->laporanModel
            ->select('laporan_kerusakan.*, aset.kode_aset, aset.nama_aset, users.nama AS nama_pelapor')
            ->join('aset', 'aset.id_aset = laporan_kerusakan.id_aset', 'left')
            ->join('users', 'users.id_user = laporan_kerusakan.id_pelapor', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('aset.kode_aset', $keyword)
                ->orLike('aset.nama_aset', $keyword)
                ->orLike('users.nama', $keyword)
                ->orLike('laporan_kerusakan.judul_laporan', $keyword)
                ->orLike('laporan_kerusakan.deskripsi_kerusakan', $keyword)
                ->groupEnd();
        }

        if (!empty($prioritas)) {
            $builder->where('laporan_kerusakan.prioritas', $prioritas);
        }

        if (!empty($statusLaporan)) {
            $builder->where('laporan_kerusakan.status_laporan', $statusLaporan);
        }

        $data = [
            'title' => 'Laporan Kerusakan',
            'laporan' => $builder
                ->orderBy('laporan_kerusakan.id_laporan', 'DESC')
                ->findAll(),

            'keyword' => $keyword,
            'prioritas' => $prioritas,
            'status_laporan' => $statusLaporan
        ];

        return view('laporan_kerusakan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Lapor Kerusakan',
            'aset' => $this->asetModel->findAll()
        ];

        return view('laporan_kerusakan/create', $data);
    }

    public function store()
    {
        $fotoName = null;
        $foto = $this->request->getFile('foto_kerusakan');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/kerusakan', $fotoName);
        }

        $this->laporanModel->save([
            'id_aset' => $this->request->getPost('id_aset'),
            'id_pelapor' => session()->get('id_user'),
            'judul_laporan' => $this->request->getPost('judul_laporan'),
            'deskripsi_kerusakan' => $this->request->getPost('deskripsi_kerusakan'),
            'foto_kerusakan' => $fotoName,
            'prioritas' => $this->request->getPost('prioritas'),
            'status_laporan' => 'menunggu_validasi'
        ]);

        return redirect()
            ->to('/karyawan/laporan-kerusakan')
            ->with('success', 'Laporan kerusakan berhasil dikirim.');
    }

    public function riwayat()
    {
        $data = [
            'title' => 'Riwayat Laporan Kerusakan',
            'laporan' => $this->laporanModel
                ->select('laporan_kerusakan.*, aset.kode_aset, aset.nama_aset')
                ->join('aset', 'aset.id_aset = laporan_kerusakan.id_aset', 'left')
                ->where('laporan_kerusakan.id_pelapor', session()->get('id_user'))
                ->orderBy('laporan_kerusakan.id_laporan', 'DESC')
                ->findAll()
        ];

        return view('laporan_kerusakan/riwayat', $data);
    }

    public function validasi($id)
    {
        $this->laporanModel->update($id, [
            'status_laporan' => 'valid',
            'divalidasi_oleh' => session()->get('id_user'),
            'tanggal_validasi' => date('Y-m-d H:i:s'),
            'catatan_validasi' => 'Laporan telah divalidasi.'
        ]);

        return redirect()
            ->to('/admin/laporan-kerusakan')
            ->with('success', 'Laporan kerusakan berhasil divalidasi.');
    }

    public function tolak($id)
    {
        $this->laporanModel->update($id, [
            'status_laporan' => 'ditolak',
            'divalidasi_oleh' => session()->get('id_user'),
            'tanggal_validasi' => date('Y-m-d H:i:s'),
            'catatan_validasi' => 'Laporan ditolak karena data tidak sesuai.'
        ]);

        return redirect()
            ->to('/admin/laporan-kerusakan')
            ->with('success', 'Laporan kerusakan berhasil ditolak.');
    }

    public function proses($id)
    {
        $this->laporanModel->update($id, [
            'status_laporan' => 'diproses'
        ]);

        return redirect()
            ->to('/admin/laporan-kerusakan')
            ->with('success', 'Status laporan berhasil diperbarui menjadi diproses.');
    }

    public function selesai($id)
    {
        $this->laporanModel->update($id, [
            'status_laporan' => 'selesai'
        ]);

        return redirect()
            ->to('/admin/laporan-kerusakan')
            ->with('success', 'Status laporan berhasil diperbarui menjadi selesai.');
    }

    public function delete($id)
    {
        $laporan = $this->laporanModel->find($id);

        if ($laporan && !empty($laporan['foto_kerusakan'])) {
            $path = FCPATH . 'uploads/kerusakan/' . $laporan['foto_kerusakan'];

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->laporanModel->delete($id);

        return redirect()
            ->to('/admin/laporan-kerusakan')
            ->with('success', 'Laporan kerusakan berhasil dihapus.');
    }
}