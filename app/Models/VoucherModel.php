<?php

namespace App\Models;

use CodeIgniter\Model;

class VoucherModel extends Model
{
    protected $table      = 'voucher';
    protected $primaryKey = 'id_voucher';

    protected $allowedFields = [
        'kode_voucher',
        'nama_voucher',
        'deskripsi',
        'id_kelas',
        'harga',
        'status',
        'expired_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
}