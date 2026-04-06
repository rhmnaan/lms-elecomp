<?php

namespace App\Controllers\Peserta;

use App\Controllers\BaseController;
use App\Models\MateriModel;

class Posttest extends BaseController
{
    protected $materiModel;

    public function __construct()
    {
        $this->materiModel = new MateriModel();
    }

    // 🔹 TAMPILKAN POST TEST
    public function index($id_materi)
    {
        $redirect = $this->request->getGet('redirect');

        if ($redirect) {
            session()->set('redirect_url_posttest', $redirect);
        }

        $materi = $this->materiModel->find($id_materi);

        if (!$materi) {
            return redirect()->back()->with('error', 'Materi tidak ditemukan');
        }

        $soal = [];
        if (!empty($materi['post_test'])) {
            $decoded = json_decode($materi['post_test'], true);
            if (is_array($decoded)) {
                $soal = $decoded;
            }
        }

        return view('dashboard/peserta/posttest_view', [
            'materi' => $materi,
            'soal'   => $soal
        ]);
    }

    // 🔹 SIMPAN HASIL POST TEST
    public function submit()
    {
        $request = $this->request;

        $idMateri = $request->getPost('id_materi');
        $jawaban  = $request->getPost('jawaban');

        $materi = $this->materiModel->find($idMateri);
        $soal   = json_decode($materi['post_test'], true);

        $benar = 0;

        foreach ($soal as $i => $s) {
            if (isset($jawaban[$i]) && $jawaban[$i] == $s['jawaban_benar']) {
                $benar++;
            }
        }

        $total = count($soal);
        $nilai = $total > 0 ? round(($benar / $total) * 100) : 0;

        // 🔥 simpan ke DB
        $db = \Config\Database::connect();
        $db->table('materi_quiz_results')->insert([
            'id_materi'     => $idMateri,
            'id_users'      => session()->get('id_users'),
            'jenis_test'    => 'post',
            'nilai'         => $nilai,
            'jumlah_benar'  => $benar,
            'jumlah_salah'  => $total - $benar,
            'jawaban_peserta' => json_encode($jawaban),
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        $redirectUrl = session()->get('redirect_url_posttest');

        if ($redirectUrl) {
            return redirect()->to($redirectUrl)->with('success', "Nilai Post Test: $nilai");
        }

        return redirect()->to('dashboard/peserta/modul')->with('success', "Nilai Post Test: $nilai");
    }
}