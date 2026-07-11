<?php

namespace App\Models;

use CodeIgniter\Model;

class AsetModel extends Model
{
    protected $table = 'aset';
    protected $primaryKey = 'id_aset';

    protected $allowedFields = [
        'id_kategori',
        'id_lokasi',
        'id_divisi',
        'kode_aset',
        'nama_aset',
        'merk',
        'spesifikasi',
        'tanggal_pembelian',
        'harga_pembelian',
        'kondisi',
        'status_aset',
        'foto_aset',
        'keterangan'
    ];
}