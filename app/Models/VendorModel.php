<?php

namespace App\Models;

use CodeIgniter\Model;

class VendorModel extends Model
{
    protected $table = 'vendor';
    protected $primaryKey = 'id_vendor';

    protected $allowedFields = [
        'nama_vendor',
        'jenis_layanan',
        'pic_vendor',
        'no_hp',
        'email', 
        'alamat',
        'status'
    ];
}