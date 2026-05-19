<?php

namespace App\Models;

use CodeIgniter\Model;

class NegaraTujuan extends Model
{
    protected $table         = 'negara_tujuan';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'produk_id', 'negara',
        'alasan_pemilihan', 'persyaratan_ekspor',
    ];
}