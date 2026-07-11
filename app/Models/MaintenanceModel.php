<?php

namespace App\Models;

use CodeIgniter\Model;

class MaintenanceModel extends Model
{
    protected $table = 'maintenance';
    protected $primaryKey = 'id_maintenance';

    protected $allowedFields = [
        'id_aset',
        'id_vendor',
        'id_jadwal',
        'id_laporan',
        'jenis_pekerjaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi_pekerjaan',
        'hasil_pekerjaan',
        'status_pekerjaan',
        'dibuat_oleh'
    ];
}