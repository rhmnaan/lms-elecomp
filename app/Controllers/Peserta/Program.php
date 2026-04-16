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

    /**
     * ===============================
     * LIST PROGRAM PESERTA
     * ===============================
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $program_list = $db->table('kelas_peserta kp')
            ->select('
                p.id_program,
                p.nama_program,
                p.deskripsi_program,
                COUNT(DISTINCT k.id_kelas) AS total_kelas
            ')
            ->join('kelas k', 'k.id_kelas = kp.id_kelas')
            ->join('program p', 'p.id_program = k.id_program')
            ->where('kp.id_users', $this->idUsers)
            ->where('kp.deleted_at IS NULL')
            ->where('k.deleted_at IS NULL')
            ->where('p.deleted_at IS NULL')
            ->groupBy('p.id_program')
            ->get()->getResultArray();

        return view('Dashboard/Peserta/program', [
            'program_list' => $program_list,
        ]);
    }

    /**
     * ===============================
     * LIST KELAS PER PROGRAM
     * ===============================
     */
    public function kelas($id_program)
    {
        $db = \Config\Database::connect();

        $kelas_list = $db->table('kelas_peserta kp')
            ->select('
                k.id_kelas,
                k.nama_kelas,
                k.deskripsi_kelas,
                u.nama_users AS nama_pengajar,
                COUNT(DISTINCT m.id_modul) AS total_modul,
                COUNT(DISTINCT ma.id_materi) AS total_materi
            ')
            ->join('kelas k', 'k.id_kelas = kp.id_kelas')
            ->join('users u', 'u.id_users = k.id_users', 'left')
            ->join('modul m', 'm.id_kelas = k.id_kelas AND m.deleted_at IS NULL', 'left')
            ->join('materi ma', 'ma.id_modul = m.id_modul AND ma.deleted_at IS NULL', 'left')
            ->where('kp.id_users', $this->idUsers)
            ->where('k.id_program', $id_program)
            ->where('kp.deleted_at IS NULL')
            ->where('k.deleted_at IS NULL')
            ->groupBy('k.id_kelas')
            ->get()->getResultArray();

        // hitung progress
        foreach ($kelas_list as &$k) {
            $total_materi = $db->table('materi ma')
                ->join('modul m', 'm.id_modul = ma.id_modul')
                ->where('m.id_kelas', $k['id_kelas'])
                ->where('ma.deleted_at IS NULL')
                ->where('m.deleted_at IS NULL')
                ->countAllResults();

            $selesai = $db->table('user_materi_progress ump')
                ->join('materi ma', 'ma.id_materi = ump.id_materi')
                ->join('modul m', 'm.id_modul = ma.id_modul')
                ->where('m.id_kelas', $k['id_kelas'])
                ->where('ump.id_users', $this->idUsers)
                ->where('ump.is_completed', 1)
                ->countAllResults();

            $k['persen'] = $total_materi > 0
                ? round(($selesai / $total_materi) * 100)
                : 0;
        }
        unset($k);

        return view('Dashboard/Peserta/kelas', [
            'kelas_list'  => $kelas_list,
            'total_kelas' => count($kelas_list),
        ]);
    }
}