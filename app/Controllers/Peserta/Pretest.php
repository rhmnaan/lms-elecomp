<?php

namespace App\Controllers\Peserta;

use App\Controllers\BaseController;
use App\Models\MateriModel;
use App\Models\UserMateriProgressModel;

class Pretest extends BaseController
{
    protected $materiModel;

    public function __construct()
    {
        $this->materiModel = new MateriModel();
    }

    /* =========================
       🔹 TAMPILKAN PRETEST
    ========================= */
    public function index($id_materi)
    {
        // 🔥 Ambil URL asal
        $redirect = $this->request->getGet('redirect');

        // Simpan ke session
        if ($redirect) {
            session()->set('redirect_url_pretest', $redirect);
        }

        $materi = $this->materiModel->find($id_materi);

        if (!$materi) {
            return redirect()->back()->with('error', 'Materi tidak ditemukan');
        }

        $soal = [];
        if (!empty($materi['pre_test'])) {
            $decoded = json_decode($materi['pre_test'], true);
            if (is_array($decoded)) {
                $soal = $decoded;
            }
        }

        return view('dashboard/peserta/pretest_view', [
            'materi' => $materi,
            'soal'   => $soal
        ]);
    }

    /* =========================
       🔹 SIMPAN HASIL PRETEST
    ========================= */
    public function submit()
    {
        $request = $this->request;

        $idMateri = $request->getPost('id_materi');
        $jawaban  = $request->getPost('jawaban');

        $materi = $this->materiModel->find($idMateri);

        $soal = json_decode($materi['pre_test'], true);

        $benar = 0;

        foreach ($soal as $i => $s) {
            if (isset($jawaban[$i]) && $jawaban[$i] == $s['jawaban_benar']) {
                $benar++;
            }
        }

        $total = count($soal);
        $nilai = $total > 0 ? round(($benar / $total) * 100) : 0;

        // Simpan ke tabel materi_quiz_results
        $db = \Config\Database::connect();
        $db->table('materi_quiz_results')->insert([
            'id_materi'     => $idMateri,
            'id_users'      => session()->get('id_users'),
            'jenis_test'    => 'pre',
            'nilai'         => $nilai,
            'jumlah_benar'  => $benar,
            'jumlah_salah'  => $total - $benar,
            'jawaban_peserta' => json_encode($jawaban),
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        $redirectUrl = session()->get('redirect_url_pretest');

        if ($redirectUrl) {
            return redirect()->to($redirectUrl)->with('success', "Nilai kamu: $nilai");
        }

        // fallback kalau gak ada
        return redirect()->to('dashboard/peserta/modul')->with('success', "Nilai kamu: $nilai");
    }
}