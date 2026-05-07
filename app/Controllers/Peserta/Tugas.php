<?php

namespace App\Controllers\Peserta;

use App\Controllers\BaseController;
use App\Models\TugasModel;
use App\Models\KelasModel;
use App\Models\TugasKomentarModel;

class Tugas extends BaseController
{
    protected $tugasModel;
    protected $komentarModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->tugasModel = new TugasModel();
        $this->kelasModel = new KelasModel();
        $this->komentarModel = new TugasKomentarModel();
    }

    /**
     * Tampilkan tugas per kelas
     * URL: dashboard/peserta/tugas/{id_kelas}
     */
    public function index($id_kelas = null)
    {
        if (!$id_kelas) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan');
        }

        // Data kelas
        $kelas = $this->kelasModel
            ->where('id_kelas', $id_kelas)
            ->where('deleted_at', null)
            ->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Data kelas tidak ditemukan');
        }

        // Tugas per kelas
        $tugas = $this->tugasModel->getByKelas($id_kelas);

        foreach ($tugas as &$item) {
            $item['komentar'] = $this->komentarModel->getByPengumpulan($item['id_pengumpulan']);
        }
        unset($item);

        return view('Dashboard/Peserta/tugas', [
            'kelas'       => $kelas,
            'tugas'       => $tugas,
            'total_tugas' => count($tugas)
        ]);
    }
}