<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyerEkspor extends Model
{
    protected $table         = 'buyer_ekspor';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'negara_tujuan_id', 'nama_perusahaan',
        'alamat', 'website', 'email', 'no_hp', 'nama_pic',
    ];
}