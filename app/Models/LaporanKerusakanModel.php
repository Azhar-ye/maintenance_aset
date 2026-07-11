<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanKerusakanModel extends Model
{
    protected $table = 'laporan_kerusakan';
    protected $primaryKey = 'id_laporan';

    protected $allowedFields = [
        'id_aset',
        'id_pelapor',
        'judul_laporan',
        'deskripsi_kerusakan',
        'foto_kerusakan',
        'tanggal_laporan',
        'prioritas',
        'status_laporan',
        'catatan_validasi',
        'divalidasi_oleh',
        'tanggal_validasi'
    ];
}