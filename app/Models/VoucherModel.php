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

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    /**
     * Validasi voucher berdasarkan kode dan kelas
     */
    public function validateVoucher($kode_voucher, $id_kelas)
    {
        return $this->where('kode_voucher', $kode_voucher)
            ->where('id_kelas', $id_kelas)
            ->where('is_active', 1)
            ->where('deleted_at IS NULL')
            ->first();
    }

    /**
     * Claim voucher - update status menjadi tidak aktif
     */
    public function claimVoucher($id_voucher)
    {
        return $this->update($id_voucher, [
            'is_active'  => 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Cek apakah voucher sudah pernah diklaim user
     */
    public function isVoucherClaimedByUser($id_voucher, $id_users)
    {
        $voucherClaimModel = new \App\Models\VoucherClaimModel();
        return $voucherClaimModel->where('id_voucher', $id_voucher)
            ->where('id_users', $id_users)
            ->first() !== null;
    }
}
