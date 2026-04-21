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

    /**
     * Validasi voucher berdasarkan kode dan kelas
     */
    public function validateVoucher($kode_voucher, $id_kelas)
    {
        $voucher = $this->where('kode_voucher', $kode_voucher)
            ->where('id_kelas', $id_kelas)
            ->where('is_active', 1)
            ->where('deleted_at IS NULL')
            ->where('tanggal_mulai <=', date('Y-m-d H:i:s'))
            ->where('tanggal_berakhir >=', date('Y-m-d H:i:s'))
            ->first();

        if (! $voucher) {
            return null;
        }

        // Cek kuota
        $totalClaim = (new \App\Models\VoucherClaimModel())
            ->where('id_voucher', $voucher['id_voucher'])
            ->countAllResults();

        if ($totalClaim >= $voucher['kuota']) {
            return null; // Kuota habis
        }

        return $voucher;
    }

    /**
     * Ambil voucher valid untuk kelas (tanpa kode, untuk auto claim)
     */
    public function getValidVoucher($kode_voucher, $id_kelas)
    {
        $query = $this->where('id_kelas', $id_kelas)
            ->where('is_active', 1)
            ->where('deleted_at IS NULL')
            ->where('tanggal_mulai <=', date('Y-m-d H:i:s'))
            ->where('tanggal_berakhir >=', date('Y-m-d H:i:s'));

        if ($kode_voucher) {
            $query->where('kode_voucher', $kode_voucher);
        }

        $voucher = $query->first();

        if (! $voucher) {
            return null;
        }

        // Cek kuota
        $totalClaim = (new \App\Models\VoucherClaimModel())
            ->where('id_voucher', $voucher['id_voucher'])
            ->countAllResults();

        if ($totalClaim >= $voucher['kuota']) {
            return null; // Kuota habis
        }

        return $voucher;
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
