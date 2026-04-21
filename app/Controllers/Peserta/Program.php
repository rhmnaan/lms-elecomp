<?php
namespace App\Controllers\Peserta;

use App\Controllers\BaseController;

class Program extends BaseController
{
    protected int $idUsers;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->idUsers = (int) session()->get('id_users');
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $program_list = $db->table('program p')
            ->select('
                p.id_program,
                p.nama_program,
                p.deskripsi_program,
                COUNT(DISTINCT k.id_kelas) AS total_kelas,
                COUNT(DISTINCT kp.id_kelas) AS kelas_diikuti
            ')
            ->join('kelas k', 'k.id_program = p.id_program AND k.deleted_at IS NULL', 'left')
            ->join(
                'kelas_peserta kp',
                'kp.id_kelas = k.id_kelas
                AND kp.id_users = ' . (int) $this->idUsers . '
                AND kp.deleted_at IS NULL',
                'left'
            )
            ->where('p.deleted_at IS NULL')
            ->groupBy('p.id_program')
            ->get()
            ->getResultArray();

        return view('Dashboard/Peserta/program', [
            'program_list' => $program_list,
        ]);
    }

    public function kelas($id_program)
    {
        $db = \Config\Database::connect();

        // Ambil ID kelas yang sudah diakses dari kelas_peserta
        $kelasPesertaIds = $db->table('kelas_peserta')
            ->select('id_kelas')
            ->where('id_users', $this->idUsers)
            ->where('deleted_at IS NULL')
            ->get()
            ->getResultArray();

        // Ambil ID kelas dari voucher_claim
        $voucherClaimIds = $db->table('voucher_claim vc')
            ->select('v.id_kelas')
            ->join('voucher v', 'v.id_voucher = vc.id_voucher')
            ->where('vc.id_users', $this->idUsers)
            ->get()
            ->getResultArray();

        // Gabungkan & unique
        $excludeIds = array_unique(array_merge(
            array_column($kelasPesertaIds, 'id_kelas'),
            array_column($voucherClaimIds, 'id_kelas')
        ));

        // Ambil kelas yang belum diakses
        $query = $db->table('kelas k')
            ->select('
                k.id_kelas,
                k.nama_kelas,
                k.deskripsi_kelas,
                k.tipe_kelas,
                k.harga,
                k.lynk_url,
                COUNT(DISTINCT m.id_modul) AS total_modul,
                COUNT(DISTINCT ma.id_materi) AS total_materi
            ')
            ->join('modul m', 'm.id_kelas = k.id_kelas AND m.deleted_at IS NULL', 'left')
            ->join('materi ma', 'ma.id_modul = m.id_modul AND ma.deleted_at IS NULL', 'left')
            ->where('k.id_program', $id_program)
            ->where('k.deleted_at IS NULL');

        if (!empty($excludeIds)) {
            $query->whereNotIn('k.id_kelas', $excludeIds);
        }

        $kelas_list = $query
            ->groupBy('k.id_kelas')
            ->get()
            ->getResultArray();

        // ===============================
        // Ambil info voucher (kelas gratis)
        // ===============================
        foreach ($kelas_list as &$k) {
            if ($k['tipe_kelas'] === 'gratis') {
                $voucher = $db->table('voucher')
                    ->select('id_voucher, tanggal_berakhir, kuota')
                    ->where('id_kelas', $k['id_kelas'])
                    ->where('is_active', 1)
                    ->where('deleted_at IS NULL')
                    ->where('tanggal_mulai <=', date('Y-m-d H:i:s'))
                    ->where('tanggal_berakhir >=', date('Y-m-d H:i:s'))
                    ->get()
                    ->getFirstRow('array');

                if ($voucher) {
                    // Cek apakah user sudah claim
                    $alreadyClaimed = $voucherClaimModel->where('id_voucher', $voucher['id_voucher'])
                        ->where('id_users', $this->idUsers)
                        ->first() !== null;

                    // Cek kuota
                    $totalClaim = $voucherClaimModel->where('id_voucher', $voucher['id_voucher'])
                        ->countAllResults();

                    if (! $alreadyClaimed && $totalClaim < $voucher['kuota']) {
                        $k['voucher'] = $voucher;
                    } else {
                        $k['voucher'] = null;
                    }
                } else {
                    $k['voucher'] = null;
                }
            } else {
                $k['voucher'] = null;
            }
        }
        unset($k);

        return view('Dashboard/Peserta/kelas', [
            'kelas_list'  => $kelas_list,
            'total_kelas' => count($kelas_list),
        ]);
    }
}