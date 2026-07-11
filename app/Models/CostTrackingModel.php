<?php

namespace App\Models;

use CodeIgniter\Model;

class CostTrackingModel extends Model
{
    protected $table = 'cost_tracking';
    protected $primaryKey = 'id_cost';

    protected $allowedFields = [
        'id_maintenance',
        'jenis_biaya',
        'deskripsi_biaya',
        'nominal',
        'tanggal_biaya',
        'bukti_biaya'
    ];
}