<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalMaintenanceModel extends Model
{
    protected $table = 'jadwal_maintenance';
    protected $primaryKey = 'id_jadwal';

    protected $allowedFields = [
        'id_aset',
        'tanggal_jadwal',
        'jenis_maintenance',
        'periode',
        'prioritas',
        'status_jadwal',
        'keterangan'
    ];
}