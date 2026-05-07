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
        'durasi_hari',
        'durasi_tugas', 
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
            ->where('tanggal_mulai <=', date('Y-m-d'))
            ->where('tanggal_berakhir >=', date('Y-m-d'))
            ->first();

        if (!$voucher) return null;

        // Cek kuota tidak habis
        if ($voucher['kuota'] !== null) {
            $totalKlaim = (new \App\Models\VoucherClaimModel())
                ->where('id_voucher', $voucher['id_voucher'])
                ->countAllResults();

            if ($totalKlaim >= $voucher['kuota']) return null;
        }

        return $voucher;
    }

    /**
     * Cari voucher valid untuk kelas (tanpa kode)
     */
    public function getValidVoucher($kode_voucher = null, $id_kelas = null)
    {
        $vouchers = $this->where('id_kelas', $id_kelas)
            ->where('is_active', 1)
            ->where('deleted_at IS NULL')
            ->where('tanggal_mulai <=', date('Y-m-d'))
            ->where('tanggal_berakhir >=', date('Y-m-d'))
            ->findAll();

        foreach ($vouchers as $voucher) {
            if ($voucher['kuota'] !== null) {
                $totalKlaim = (new \App\Models\VoucherClaimModel())
                    ->where('id_voucher', $voucher['id_voucher'])
                    ->countAllResults();

                if ($totalKlaim >= $voucher['kuota']) continue;
            }
            return $voucher;
        }

        return null;
    }

    /**
     * Claim voucher - nonaktifkan jika kuota sudah habis
     */
    public function claimVoucher($id_voucher)
    {
        $voucher = $this->find($id_voucher);

        // Hitung total klaim setelah insert
        $totalKlaim = (new \App\Models\VoucherClaimModel())
            ->where('id_voucher', $id_voucher)
            ->countAllResults();

        // Nonaktifkan hanya jika kuota sudah terpenuhi
        $isActive = 1;
        if ($voucher['kuota'] !== null && $totalKlaim >= $voucher['kuota']) {
            $isActive = 0;
        }

        return $this->update($id_voucher, [
            'is_active'  => $isActive,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Cek apakah voucher sudah pernah diklaim user
     */
    public function isVoucherClaimedByUser($id_voucher, $id_users)
    {
        $voucherClaimModel = new \App\Models\VoucherClaimModel();
        return $voucherClaimModel
            ->where('id_voucher', $id_voucher)
            ->where('id_users', $id_users)
            ->first() !== null;
    }
}