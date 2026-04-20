<?php

namespace App\Models;

use CodeIgniter\Model;

class VoucherClaimModel extends Model
{
    protected $table      = 'voucher_claim';
    protected $primaryKey = 'id_claim';

    protected $returnType = 'array';

    // ⛔ MATIKAN TIMESTAMP
    protected $useTimestamps = false;

    protected $allowedFields = [
        'id_voucher',
        'id_users',
        'tanggal_klaim',
        'status',
        'created_at',
    ];
}