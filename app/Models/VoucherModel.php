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
        $query = $this->where('id_kelas', $id_kelas)
            ->where('is_active', 1)
            ->where('kuota >', 0)
            ->where('deleted_at', null)
            ->where('tanggal_mulai <=', date('Y-m-d H:i:s'))
            ->where('tanggal_berakhir >=', date('Y-m-d H:i:s'));
        
        // Jika kode_voucher diberikan, cari spesifik
        if (!empty($kode_voucher)) {
            $query->where('kode_voucher', $kode_voucher);
        }
        
        return $query->first();
    }

    // Alias untuk backward compatibility
    public function validateVoucher($kode_voucher, $id_kelas)
    {
        return $this->getValidVoucher($kode_voucher, $id_kelas);
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

    // Alias untuk backward compatibility
    public function isVoucherClaimedByUser($id_voucher, $id_users)
    {
        return $this->isClaimedByUser($id_voucher, $id_users);
    }

    /* =========================
     * PROSES KLAIM
     * ========================= */

    public function claimVoucher($id_voucher)
    {
        // Dapatkan voucher
        $voucher = $this->find($id_voucher);
        
        if (!$voucher) {
            return false;
        }

        // Kurangi kuota
        return $this->update($id_voucher, [
            'kuota' => max(0, $voucher['kuota'] - 1),
            'updated_at' => date('Y-m-d H:i:s'),
            'is_active' => ($voucher['kuota'] - 1) > 0 ? 1 : 0
        ]);
    }

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