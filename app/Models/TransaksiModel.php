<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $allowedFields = [
        'id_users',
        'id_voucher',
        'invoice_id',
        'payment_provider',
        'payment_reference',
        'amount',
        'status',
        'paid_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
}