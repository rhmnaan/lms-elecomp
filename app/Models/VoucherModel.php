<?php

namespace App\Models;

use CodeIgniter\Model;

class VoucherModel extends Model
{
    protected $table          = 'voucher';
    protected $primaryKey     = 'id_voucher';
    protected $useSoftDeletes = true;
    protected $useTimestamps  = true;

    protected $allowedFields = [
        'id_kelas',
        'kode_voucher',
        'nama_voucher',
        'deskripsi',
        'kuota',
        'tanggal_mulai',
        'tanggal_berakhir',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    /* =========================
     * VALIDASI VOUCHER
     * ========================= */

    public function getValidVoucher($kode_voucher, $id_kelas)
    {
        return $this->where('kode_voucher', $kode_voucher)
            ->where('id_kelas', $id_kelas)
            ->where('is_active', 1)
            ->where('kuota >', 0)
            ->where('deleted_at', null)
            ->where('tanggal_mulai <=', date('Y-m-d H:i:s'))
            ->where('tanggal_berakhir >=', date('Y-m-d H:i:s'))
            ->first();
    }

    /* =========================
     * CEK SUDAH PERNAH KLAIM
     * ========================= */

    public function isClaimedByUser($id_voucher, $id_users)
    {
        return model('VoucherClaimModel')
            ->where('id_voucher', $id_voucher)
            ->where('id_users', $id_users)
            ->where('deleted_at', null)
            ->first() !== null;
    }

    /* =========================
     * PROSES KLAIM
     * ========================= */

    public function claim($voucher, $id_users)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Simpan ke voucher_claim
        model('VoucherClaimModel')->insert([
            'id_voucher'   => $voucher['id_voucher'],
            'id_users'     => $id_users,
            'tanggal_klaim'=> date('Y-m-d H:i:s'),
            'status'       => 'claimed',
        ]);

        // 2. Kurangi kuota
        $this->update($voucher['id_voucher'], [
            'kuota'      => $voucher['kuota'] - 1,
            'updated_at' => date('Y-m-d H:i:s'),
            'is_active'  => ($voucher['kuota'] - 1) > 0 ? 1 : 0
        ]);

        $db->transComplete();

        return $db->transStatus();
    }
}