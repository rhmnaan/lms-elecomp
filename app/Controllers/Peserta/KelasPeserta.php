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
            ->where('voucher.is_active', 1)
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

        // 🔐 CEK AKSES KELAS (izin masuk)
        $kelasPeserta = $this->pesertaKelasModel
            ->where('id_users', $id_users)
            ->where('id_kelas', $id_kelas)
            ->where('status', 'aktif')
            ->first();

        if (! $kelasPeserta) {
            return redirect()
                ->to('dashboard/peserta/kelas-saya')
                ->with('error', 'Akses kelas ini telah berakhir');
        }
        
        $data['kelas'] = $this->kelasModel->find($id_kelas);

        if (! $data['kelas']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelas tidak ditemukan');
        }

        return view('Dashboard/Peserta/kelas/detail_kelas', $data);
    }

    
}