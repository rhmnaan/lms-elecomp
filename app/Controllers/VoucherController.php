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
     * Claim voucher untuk kelas.
     *
     * Kode voucher WAJIB diisi — sistem tidak melakukan fallback otomatis
     * ke kuota tanpa kode. Jika kosong, request langsung ditolak.
     */
    public function claim()
    {
        // Hanya terima AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request tidak valid.'
            ]);
        }

        $id_users     = session()->get('id_users');
        $id_kelas     = trim($this->request->getPost('id_kelas') ?? '');
        $kode_voucher = trim($this->request->getPost('kode_voucher') ?? '');

        // --- 1. Validasi input dasar ---
        if (empty($id_kelas) || empty($id_users)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap. Silakan muat ulang halaman.'
            ]);
        }

        // --- 2. Kode voucher WAJIB diisi ---
        if (empty($kode_voucher)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kode voucher wajib diisi.'
            ]);
        }

        // --- 3. Validasi voucher: kode harus cocok + valid + kuota tersisa ---
        $voucher = $this->voucherModel->validateVoucher($kode_voucher, $id_kelas);

        if (!$voucher) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kode voucher tidak valid, sudah kadaluarsa, atau kuota habis.'
            ]);
        }

        // --- 4. Cek apakah voucher sudah pernah diklaim user ini ---
        if ($this->voucherModel->isVoucherClaimedByUser($voucher['id_voucher'], $id_users)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kode voucher ini sudah pernah Anda gunakan sebelumnya.'
            ]);
        }

        // --- 5. Cek apakah user sudah terdaftar di kelas ini ---
        $sudahTerdaftar = $this->kelasPesertaModel
            ->where('id_users', $id_users)
            ->where('id_kelas', $id_kelas)
            ->where('deleted_at IS NULL')
            ->first();

        if ($sudahTerdaftar) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda sudah terdaftar di kelas ini.'
            ]);
        }

        // --- 6. Proses klaim dalam transaksi database ---
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // a. Catat klaim voucher
            $this->voucherClaimModel->insert([
                'id_voucher'    => $voucher['id_voucher'],
                'id_users'      => $id_users,
                'tanggal_klaim' => date('Y-m-d H:i:s'),
                'status'        => 'claimed',
                'created_at'    => date('Y-m-d H:i:s'),
            ]);

            // b. Daftarkan user ke kelas (PAKSA ikut durasi voucher)

            // pastikan durasi benar-benar dari voucher
            $durasiHari = isset($voucher['durasi_hari']) 
                ? (int) $voucher['durasi_hari'] 
                : 0;

            $tanggalMulai = date('Y-m-d H:i:s');

            // hitung tanggal berakhir sesuai voucher
            $tanggalBerakhir = null;
            if ($durasiHari > 0) {
                $tanggalBerakhir = date(
                    'Y-m-d H:i:s',
                    strtotime($tanggalMulai . " +{$durasiHari} days")
                );
            }

            log_message('debug', 'Voucher durasi_hari = ' . $durasiHari);
            log_message('debug', 'Tanggal mulai = ' . $tanggalMulai);
            log_message('debug', 'Tanggal berakhir = ' . ($tanggalBerakhir ?? 'NULL'));

            // 1️⃣ INSERT dulu (hindari trigger / default)
            $idKelasPeserta = $this->kelasPesertaModel->insert([
                'id_users'                     => $id_users,
                'id_kelas'                     => $id_kelas,
                'tanggal_daftar_kelas_peserta' => $tanggalMulai,
                'status'                       => 'aktif',
            ]);

            if (!$idKelasPeserta) {
                throw new \Exception('Gagal insert kelas_peserta');
            }

            // 2️⃣ UPDATE paksa tanggal_berakhir (override apapun)
            $this->kelasPesertaModel->update($idKelasPeserta, [
                'tanggal_berakhir' => $tanggalBerakhir,
            ]);
            // c. Kurangi kuota voucher (nonaktifkan jika habis)
            $this->voucherModel->claimVoucher($voucher['id_voucher']);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memproses klaim. Silakan coba lagi.'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Selamat! Voucher berhasil diklaim dan Anda sudah terdaftar di kelas.'
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', '[VoucherController::claim] ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }
}