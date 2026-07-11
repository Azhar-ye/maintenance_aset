<?php

namespace App\Controllers;

class TestDb extends BaseController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $db->initialize();

            if ($db->connID) {
                return 'Koneksi database berhasil';
            }

            return 'Koneksi database gagal';
        } catch (\Throwable $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}