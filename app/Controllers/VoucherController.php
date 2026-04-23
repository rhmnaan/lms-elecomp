<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VoucherModel;
use App\Models\KelasPesertaModel;
use App\Models\VoucherClaimModel;

class VoucherController extends BaseController
{
    protected $voucherModel;
    protected $kelasPesertaModel;
    protected $voucherClaimModel;

    public function __construct()
    {
        $this->voucherModel      = new VoucherModel();
        $this->kelasPesertaModel = new KelasPesertaModel();
        $this->voucherClaimModel = new VoucherClaimModel();
    }

    /**
     * Claim voucher untuk kelas
     */
    public function claim()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request tidak valid'
            ]);
        }

        $id_users     = session()->get('id_users');
        $kode_voucher = $this->request->getPost('kode_voucher');
        $id_kelas     = $this->request->getPost('id_kelas');

        // Validasi input
        if (empty($id_kelas) || empty($id_users)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap'
            ]);
        }

        // Cari/validasi voucher
        if (empty($kode_voucher)) {
            $voucher = $this->voucherModel->getValidVoucher(null, $id_kelas);
        } else {
            $voucher = $this->voucherModel->validateVoucher($kode_voucher, $id_kelas);
        }

        if (!$voucher) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Voucher tidak valid, sudah kadaluarsa, atau kuota habis'
            ]);
        }

        // Cek apakah voucher sudah diklaim user ini
        if ($this->voucherModel->isVoucherClaimedByUser($voucher['id_voucher'], $id_users)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Voucher sudah pernah diklaim oleh Anda'
            ]);
        }

        // Cek apakah user sudah terdaftar di kelas ini
        $sudahTerdaftar = $this->kelasPesertaModel
            ->where('id_users', $id_users)
            ->where('id_kelas', $id_kelas)
            ->where('deleted_at IS NULL')
            ->first();

        if ($sudahTerdaftar) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda sudah terdaftar di kelas ini'
            ]);
        }

        // Mulai transaksi
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. Simpan klaim voucher
            $this->voucherClaimModel->insert([
                'id_voucher'    => $voucher['id_voucher'],
                'id_users'      => $id_users,
                'tanggal_klaim' => date('Y-m-d H:i:s'),
                'status'        => 'claimed',
                'created_at'    => date('Y-m-d H:i:s'),
            ]);

            // 2. Daftarkan user ke kelas
            $this->kelasPesertaModel->insert([
                'id_users'                     => $id_users,
                'id_kelas'                     => $id_kelas,
                'tanggal_daftar_kelas_peserta' => date('Y-m-d H:i:s'),
            ]);

            // 3. Update is_active voucher (nonaktif jika kuota habis)
            $this->voucherModel->claimVoucher($voucher['id_voucher']);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memproses claim voucher'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Berhasil claim voucher dan bergabung ke kelas!'
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ]);
        }
    }
}