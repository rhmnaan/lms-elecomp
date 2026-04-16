<?php

namespace App\Models;

use CodeIgniter\Model;

class VoucherClaimModel extends Model
{
    protected $table      = 'voucher_claim';
    protected $primaryKey = 'id_claim';

    protected $allowedFields = [
        'id_users',
        'id_voucher',
        'kode_voucher',
        'status',
        'claimed_at',
        'used_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
}