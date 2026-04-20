<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'id_users',
        'id_kelas',
        'kode_transaksi',
        'lynk_transaction_id',
        'nama_produk',
        'harga',
        'qty',
        'total',
        'status',
        'metode_pembayaran',
        'tanggal_transaksi',
        'tanggal_bayar',
    ];
}