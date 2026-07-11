<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        $user = $userModel
            ->select('users.*, divisi.nama_divisi')
            ->join('divisi', 'divisi.id_divisi = users.id_divisi', 'left')
            ->where('users.email', $email)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        if ($user['status'] !== 'aktif') {
            return redirect()->back()->with('error', 'Akun tidak aktif.');
        }

        session()->set([
            'id_user'      => $user['id_user'],
            'nama'         => $user['nama'],
            'email'        => $user['email'],
            'role'         => $user['role'],
            'nama_divisi'  => $user['nama_divisi'] ?? '-',
            'foto_user'    => $user['foto_user'] ?? null,
            'logged_in'    => true
        ]);

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        if ($user['role'] === 'karyawan') {
            return redirect()->to('/karyawan/dashboard');
        }

        if ($user['role'] === 'manajer') {
            return redirect()->to('/manajer/dashboard');
        }

        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}