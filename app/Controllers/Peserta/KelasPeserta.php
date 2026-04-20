<?php
namespace App\Controllers\Peserta;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\KelasPesertaModel;
use App\Models\ProgramModel;
use App\Models\VoucherClaimModel;
use App\Models\VoucherModel;

class KelasPeserta extends BaseController
{
    protected $programModel;
    protected $kelasModel;
    protected $voucherModel;
    protected $pesertaKelasModel;
    protected $voucherClaimModel;

    public function __construct()
    {
        $this->programModel      = new ProgramModel();
        $this->kelasModel        = new KelasModel();
        $this->voucherModel      = new VoucherModel();
        $this->pesertaKelasModel = new KelasPesertaModel();
        $this->voucherClaimModel = new VoucherClaimModel(); // ⬅️ penting
    }

    private function hasClaimedVoucher($id_users, $id_kelas): bool
    {
        return $this->voucherClaimModel
            ->join('voucher', 'voucher.id_voucher = voucher_claim.id_voucher')
            ->where('voucher_claim.id_users', $id_users)
            ->where('voucher.id_kelas', $id_kelas)
            ->where('voucher_claim.status', 'aktif') // atau 'claimed'
            ->countAllResults() > 0;
    }

    /**
     * =========================
     * TEMUKAN KELAS - PROGRAM
     * =========================
     */
    public function program()
    {
        $data['programs'] = $this->programModel->findAll();

        return view('Dashboard/Peserta/kelas/program', $data);
    }

    /**
     * =========================
     * LIST KELAS DALAM PROGRAM
     * =========================
     */
    public function kelasByProgram($id_program)
    {
        $id_users = session('id_users');

        // Ambil ID kelas yang sudah diklaim oleh user
        $claimedKelasIds = $this->voucherClaimModel
            ->select('voucher.id_kelas')
            ->join('voucher', 'voucher.id_voucher = voucher_claim.id_voucher')
            ->where('voucher_claim.id_users', $id_users)
            ->where('voucher_claim.status', 'aktif')
            ->findAll();

        $claimedIds = array_column($claimedKelasIds, 'id_kelas');

        // Ambil kelas yang belum diklaim oleh user
        $query = $this->kelasModel
            ->select('kelas.*, voucher.id_voucher, voucher.tanggal_berakhir, voucher.kuota')
            ->join('voucher', 'voucher.id_kelas = kelas.id_kelas', 'left')
            ->where('kelas.id_program', $id_program)
            ->where('kelas.tipe_kelas', 'gratis') // hanya kelas gratis yang bisa diklaim dengan voucher
            ->where('voucher.status', 'aktif')
            ->where('voucher.deleted_at IS NULL')
            ->where('voucher.tanggal_berakhir >= CURDATE()')
            ->where('voucher.kuota > 0');

        // Hanya exclude jika ada kelas yang sudah diklaim
        if (! empty($claimedIds)) {
            $query->whereNotIn('kelas.id_kelas', $claimedIds);
        }

        $data['kelas_list'] = $query
            ->groupBy('kelas.id_kelas')
            ->findAll();

        // Hitung total kelas yang tersedia
        $data['total_kelas'] = count($data['kelas_list']);

        return view('Dashboard/Peserta/kelas', $data);
    }

    /**
     * =========================
     * DETAIL KELAS (LOCKED)
     * =========================
     */
    public function detail($id_kelas)
    {
        $id_users = session('id_users');

        // 🔒 CEK VOUCHER
        if (! $this->hasClaimedVoucher($id_users, $id_kelas)) {
            return redirect()
                ->to('dashboard/peserta/kelas/program')
                ->with('error', 'Kelas ini terkunci. Silakan klaim voucher terlebih dahulu.');
        }

        $data['kelas'] = $this->kelasModel->find($id_kelas);

        if (! $data['kelas']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelas tidak ditemukan');
        }

        return view('Dashboard/Peserta/kelas/detail_kelas', $data);
    }

    /**
     * =========================
     * KELAS SAYA
     * =========================
     */
    public function kelasSaya()
    {
        $id_users = session('id_users');
        $db = \Config\Database::connect();

        $data['kelas_saya'] = $this->voucherClaimModel
            ->select('
                kelas.id_kelas,
                kelas.nama_kelas,
                kelas.deskripsi_kelas,
                IFNULL(peserta_kelas.progress, 0) as progress
            ')
            ->join('voucher', 'voucher.id_voucher = voucher_claim.id_voucher')
            ->join('kelas', 'kelas.id_kelas = voucher.id_kelas')
            ->join(
                'kelas_peserta',
                'kelas_peserta.id_kelas = kelas.id_kelas
                AND kelas_peserta.id_users = voucher_claim.id_users',
                'left'
            )
            ->where('voucher_claim.id_users', $id_users)
            ->where('voucher_claim.status', 'aktif')
            ->where('voucher_claim.deleted_at', null)
            ->groupBy('kelas.id_kelas')
            ->findAll();

        return view('Dashboard/Peserta/kelas-saya', $data);
    }
}