<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $allowedFields = [
        'id_divisi',
        'nama',
        'email',
        'password',
        'role',
        'no_hp',
        'alamat',
        'status',
        'foto_user'
    ];
}