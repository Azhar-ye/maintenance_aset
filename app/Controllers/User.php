<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DivisiModel;
use App\Models\ActivityLogModel;

class User extends BaseController
{
    protected $userModel;
    protected $divisiModel;
    protected $activityLogModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->divisiModel = new DivisiModel();
        $this->activityLogModel = new ActivityLogModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');
        $status = $this->request->getGet('status');
        $idDivisi = $this->request->getGet('id_divisi');
        $sort = $this->request->getGet('sort');

        $builder = $this->userModel
            ->select('users.*, divisi.nama_divisi')
            ->join('divisi', 'divisi.id_divisi = users.id_divisi', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('users.email', $keyword)
                ->groupEnd();
        }

        if (!empty($role)) {
            $builder->where('users.role', $role);
        }

        if (!empty($status)) {
            $builder->where('users.status', $status);
        }

        if (!empty($idDivisi)) {
            $builder->where('users.id_divisi', $idDivisi);
        }

        if ($sort === 'nama_asc') {
            $builder->orderBy('users.nama', 'ASC');
        } elseif ($sort === 'nama_desc') {
            $builder->orderBy('users.nama', 'DESC');
        } elseif ($sort === 'email_asc') {
            $builder->orderBy('users.email', 'ASC');
        } elseif ($sort === 'role_asc') {
            $builder->orderBy('users.role', 'ASC');
        } elseif ($sort === 'divisi_asc') {
            $builder->orderBy('divisi.nama_divisi', 'ASC');
        } else {
            $builder->orderBy('users.id_user', 'DESC');
        }

        $data = [
            'title' => 'User Management',
            'users' => $builder->findAll(),
            'divisi' => $this->divisiModel->findAll(),
            'keyword' => $keyword,
            'role' => $role,
            'status' => $status,
            'id_divisi' => $idDivisi,
            'sort' => $sort
        ];

        return view('user/index', $data);
    }

    public function detail($id)
    {
        $user = $this->userModel
            ->select('users.*, divisi.nama_divisi')
            ->join('divisi', 'divisi.id_divisi = users.id_divisi', 'left')
            ->where('users.id_user', $id)
            ->first();

        if (!$user) {
            return redirect()
                ->to('/admin/user')
                ->with('success', 'Data user tidak ditemukan.');
        }

        return view('user/detail', [
            'title' => 'Detail User',
            'user' => $user
        ]);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User',
            'divisi' => $this->divisiModel->findAll()
        ];

        return view('user/create', $data);
    }

    public function store()
    {
        $password = $this->request->getPost('password');

        $this->userModel->save([
            'id_divisi' => $this->request->getPost('id_divisi'),
            'nama'      => $this->request->getPost('nama'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'role'      => $this->request->getPost('role'),
            'no_hp'     => $this->request->getPost('no_hp'),
            'alamat'    => $this->request->getPost('alamat'),
            'status'    => $this->request->getPost('status')
        ]);

        $this->simpanLog(
            'Menambahkan user: ' . $this->request->getPost('nama'),
            'User Management'
        );

        return redirect()
            ->to('/admin/user')
            ->with('success', 'Data user berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()
                ->to('/admin/user')
                ->with('success', 'Data user tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'divisi' => $this->divisiModel->findAll()
        ];

        return view('user/edit', $data);
    }

    public function update($id)
    {
        $userLama = $this->userModel->find($id);

        if (!$userLama) {
            return redirect()
                ->to('/admin/user')
                ->with('success', 'Data user tidak ditemukan.');
        }

        $data = [
            'id_divisi' => $this->request->getPost('id_divisi'),
            'nama'      => $this->request->getPost('nama'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'no_hp'     => $this->request->getPost('no_hp'),
            'alamat'    => $this->request->getPost('alamat'),
            'status'    => $this->request->getPost('status')
        ];

        $password = $this->request->getPost('password');

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        $this->simpanLog(
            'Mengubah user: ' . $userLama['nama'],
            'User Management'
        );

        return redirect()
            ->to('/admin/user')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($id == session()->get('id_user')) {
            return redirect()
                ->to('/admin/user')
                ->with('success', 'User yang sedang login tidak dapat dihapus.');
        }

        $user = $this->userModel->find($id);

        if ($user) {
            $this->userModel->delete($id);

            $this->simpanLog(
                'Menghapus user: ' . $user['nama'],
                'User Management'
            );
        }

        return redirect()
            ->to('/admin/user')
            ->with('success', 'Data user berhasil dihapus.');
    }

    private function simpanLog($aktivitas, $modul = 'User Management')
    {
        $this->activityLogModel->save([
            'id_user' => session()->get('id_user'),
            'nama_user' => session()->get('nama'),
            'role' => session()->get('role'),
            'aktivitas' => $aktivitas,
            'modul' => $modul
        ]);
    }
}