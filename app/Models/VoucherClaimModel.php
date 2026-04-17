<?php

namespace App\Models;

use CodeIgniter\Model;

class VoucherClaimModel extends Model
{
    protected $table            = 'voucher_claim';
    protected $primaryKey       = 'id_claim';

    protected $allowedFields = [
        'id_voucher',
        'id_users',
        'tanggal_klaim',
        'status',
        'created_at',
    ];

    /**
     * Timestamp settings
     */
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = null; // karena kolom updated_at tidak ada

    /**
     * Return type (opsional tapi disarankan)
     */
    protected $returnType = 'array';
}