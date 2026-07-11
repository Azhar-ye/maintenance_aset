<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $idUser = session()->get('id_user');

        $user = $this->userModel
            ->select('users.*, divisi.nama_divisi')
            ->join('divisi', 'divisi.id_divisi = users.id_divisi', 'left')
            ->where('users.id_user', $idUser)
            ->first();

        return view('profile/index', [
            'title' => 'Profil Saya',
            'user'  => $user
        ]);
    }

    public function update()
    {
        $idUser = session()->get('id_user');
        $userLama = $this->userModel->find($idUser);

        $foto = $this->request->getFile('foto_user');
        $namaFoto = $userLama['foto_user'] ?? null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!empty($userLama['foto_user'])) {
                $pathFotoLama = ROOTPATH . 'public/uploads/user/' . $userLama['foto_user'];

                if (file_exists($pathFotoLama)) {
                    unlink($pathFotoLama);
                }
            }

            $namaFoto = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads/user', $namaFoto);
        }

        $dataUpdate = [
            'nama'      => $this->request->getPost('nama'),
            'no_hp'     => $this->request->getPost('no_hp'),
            'alamat'    => $this->request->getPost('alamat'),
            'foto_user' => $namaFoto
        ];

        $passwordBaru = $this->request->getPost('password_baru');
        $konfirmasiPassword = $this->request->getPost('konfirmasi_password');

        if (!empty($passwordBaru) || !empty($konfirmasiPassword)) {
            if ($passwordBaru !== $konfirmasiPassword) {
                return redirect()
                    ->to('/profile')
                    ->with('error', 'Konfirmasi password tidak sesuai.');
            }

            if (strlen($passwordBaru) < 6) {
                return redirect()
                    ->to('/profile')
                    ->with('error', 'Password minimal 6 karakter.');
            }

            $dataUpdate['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        $this->userModel->update($idUser, $dataUpdate);

        session()->set([
            'nama' => $this->request->getPost('nama'),
            'foto_user' => $namaFoto
        ]);

        return redirect()
            ->to('/profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}