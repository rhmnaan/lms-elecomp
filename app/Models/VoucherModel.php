<?php

namespace App\Models;

use CodeIgniter\Model;

class VoucherModel extends Model
{
    protected $table         = 'voucher';
    protected $primaryKey    = 'id_voucher';
    protected $useSoftDeletes = true;
    protected $useTimestamps  = true;

    protected $allowedFields = [
        'id_kelas',
        'kode_voucher',
        'nama_voucher',
        'deskripsi',
        'harga',
        'lynk_uuid',
        'tanggal_mulai',
        'tanggal_berakhir',
        'kuota',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}