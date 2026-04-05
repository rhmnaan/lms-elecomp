<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModulModel;
use App\Models\MateriModel;
use App\Models\QuizResultsModel;
use App\Models\KelasPesertaModel;
use App\Models\MateriQuizResultsModel;

class DashboardPeserta extends BaseController
{
    protected int $idUsers;
    protected KelasPesertaModel $kelasPesertaModel;
    protected ModulModel $modulModel;
    protected MateriModel $materiModel;
    protected QuizResultsModel $quizResultModel;

    public function __construct()
    {
        $this->kelasPesertaModel = new KelasPesertaModel();
        $this->modulModel = new ModulModel();
        $this->materiModel = new MateriModel();
        $this->quizResultModel = new QuizResultsModel();
    }

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->idUsers = (int) session()->get('id_users');
    }

    public function beranda()
    {
        $db = \Config\Database::connect();

        // ── Kelas yang diikuti ──────────────────────────────────────────
        $kelas_list = $db->table('kelas_peserta kp')
            ->select('k.id_kelas, k.nama_kelas,
                  u.nama_users AS nama_pengajar,
                  COUNT(DISTINCT m.id_modul) AS total_modul')
            ->join('kelas k', 'k.id_kelas = kp.id_kelas')
            ->join('users u', 'u.id_users = k.id_users', 'left')
            ->join('modul m', 'm.id_kelas = k.id_kelas', 'left')
            ->where('kp.id_users', $this->idUsers)
            ->where('kp.deleted_at', null)
            ->groupBy('k.id_kelas')
            ->get()->getResultArray();

        // Tambahkan modul_selesai (default 0 karena belum ada progress)
        foreach ($kelas_list as &$k) {
            $k['modul_selesai'] = 0;
        }
        unset($k);

        $id_kelas_list = array_column($kelas_list, 'id_kelas');
        $total_kelas = count($kelas_list);

        // ── Total materi ────────────────────────────────────────────────
        $total_materi = 0;
        if (!empty($id_kelas_list)) {
            $total_materi = $db->table('materi ma')
                ->join('modul m', 'm.id_modul = ma.id_modul')
                ->whereIn('m.id_kelas', $id_kelas_list)
                ->where('ma.deleted_at', null)
                ->countAllResults();
        }

        // ── Total quiz tersedia ─────────────────────────────────────────
        $total_quiz_tersedia = 0;
        if (!empty($id_kelas_list)) {
            $total_quiz_tersedia = $db->table('quiz q')
                ->join('modul m', 'm.id_modul = q.id_modul')
                ->whereIn('m.id_kelas', $id_kelas_list)
                ->where('q.deleted_at', null)
                ->countAllResults();
        }

        // ── Quiz yang sudah dikerjakan siswa ini ────────────────────────
        $total_quiz_dikerjakan = $db->table('quiz_results')
            ->where('id_users', $this->idUsers)
            ->where('deleted_at', null)
            ->countAllResults();

        // ── Rata-rata nilai ─────────────────────────────────────────────
        $rata_row = $db->table('quiz_results')
            ->selectAvg('nilai_quiz_results', 'rata')
            ->where('id_users', $this->idUsers)
            ->where('deleted_at', null)
            ->get()->getRowArray();
        $rata_nilai = $rata_row ? round($rata_row['rata'] ?? 0, 1) : 0;

        // ── Distribusi nilai ────────────────────────────────────────────
        $dist_lulus = $dist_cukup = $dist_kurang = 0;
        if ($total_quiz_dikerjakan > 0) {
            $rows = $db->table('quiz_results')
                ->select('nilai_quiz_results')
                ->where('id_users', $this->idUsers)
                ->where('deleted_at', null)
                ->get()->getResultArray();

            foreach ($rows as $r) {
                $n = (int) $r['nilai_quiz_results'];
                if ($n >= 70) $dist_lulus++;
                elseif ($n >= 50) $dist_cukup++;
                else $dist_kurang++;
            }
        }

        // ── Riwayat quiz terbaru ────────────────────────────────────────
        $riwayat_quiz = $db->table('quiz_results qr')
            ->select('qr.nilai_quiz_results, qr.waktu_selesai_quiz_results,
                  q.judul_quiz, k.nama_kelas')
            ->join('quiz q', 'q.id_quiz = qr.id_quiz')
            ->join('modul m', 'm.id_modul = q.id_modul')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('qr.id_users', $this->idUsers)
            ->where('qr.deleted_at', null)
            ->orderBy('qr.waktu_selesai_quiz_results', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // ── Materi terbaru ──────────────────────────────────────────────
        $materi_terbaru = [];
        if (!empty($id_kelas_list)) {
            $materi_terbaru = $db->table('materi ma')
                ->select('ma.id_materi, ma.judul_materi,
                      ma.file_materi, ma.video_url_materi,
                      mo.judul_modul, k.nama_kelas')
                ->join('modul mo', 'mo.id_modul = ma.id_modul')
                ->join('kelas k', 'k.id_kelas = mo.id_kelas')
                ->whereIn('mo.id_kelas', $id_kelas_list)
                ->where('ma.deleted_at', null)
                ->orderBy('ma.created_at', 'DESC')
                ->limit(6)
                ->get()->getResultArray();
        }

        // ── Peringkat di kelas (opsional, ambil kelas pertama) ──────────
        $peringkat = null;
        $total_peserta_kelas = null;
        if (!empty($id_kelas_list)) {
            $id_kelas_pertama = $id_kelas_list[0];

            $peserta_ids = $db->table('kelas_peserta')
                ->select('id_users')
                ->where('id_kelas', $id_kelas_pertama)
                ->where('deleted_at', null)
                ->get()->getResultArray();
            $peserta_ids = array_column($peserta_ids, 'id_users');
            $total_peserta_kelas = count($peserta_ids);

            if (!empty($peserta_ids)) {
                $rank_rows = $db->table('quiz_results qr')
                    ->select('qr.id_users, AVG(qr.nilai_quiz_results) AS avg_val')
                    ->join('quiz q', 'q.id_quiz = qr.id_quiz')
                    ->join('modul m', 'm.id_modul = q.id_modul')
                    ->whereIn('qr.id_users', $peserta_ids)
                    ->where('m.id_kelas', $id_kelas_pertama)
                    ->where('qr.deleted_at', null)
                    ->groupBy('qr.id_users')
                    ->orderBy('avg_val', 'DESC')
                    ->get()->getResultArray();

                foreach ($rank_rows as $pos => $row) {
                    if ((int) $row['id_users'] === $this->idUsers) {
                        $peringkat = $pos + 1;
                        break;
                    }
                }
            }
        }

        // ── Materi terbaru ──────────────────────────────────────────────
        $materi_terbaru = [];
        if (!empty($id_kelas_list)) {
            $materi_terbaru = $db->table('materi ma')
                ->select('ma.id_materi, ma.judul_materi,
                  ma.file_materi, ma.video_url_materi,
                  mo.id_modul, mo.judul_modul, k.nama_kelas') // TAMBAHKAN mo.id_modul
                ->join('modul mo', 'mo.id_modul = ma.id_modul')
                ->join('kelas k', 'k.id_kelas = mo.id_kelas')
                ->whereIn('mo.id_kelas', $id_kelas_list)
                ->where('ma.deleted_at', null)
                ->orderBy('ma.created_at', 'DESC')
                ->limit(6)
                ->get()->getResultArray();
        }

        return view('Dashboard/Peserta/beranda', [
            'kelas_list' => $kelas_list,
            'total_kelas' => $total_kelas,
            'total_materi' => $total_materi,
            'total_quiz_tersedia' => $total_quiz_tersedia,
            'total_quiz_dikerjakan' => $total_quiz_dikerjakan,
            'rata_nilai' => $rata_nilai,
            'dist_lulus' => $dist_lulus,
            'dist_cukup' => $dist_cukup,
            'dist_kurang' => $dist_kurang,
            'riwayat_quiz' => $riwayat_quiz,
            'materi_terbaru' => $materi_terbaru,
            'peringkat' => $peringkat,
            'total_peserta_kelas' => $total_peserta_kelas,
        ]);
    }

    public function kelas()
    {
        $kelas_list = $this->kelasPesertaModel->getKelasByPeserta($this->idUsers);

        foreach ($kelas_list as &$k) {
            $quiz_done = $this->quizResultModel->getQuizDoneCountByKelas($this->idUsers, $k['id_kelas']);
            $k['quiz_dikerjakan'] = $quiz_done;
            $k['persen'] = $k['total_quiz'] > 0
                ? min(100, round(($quiz_done / $k['total_quiz']) * 100))
                : 0;
        }

        return view('Dashboard/Peserta/kelas', [
            'kelas_list' => $kelas_list,
            'total_kelas' => count($kelas_list),
        ]);
    }

    public function modul()
    {
        $focusKelas = $this->request->getGet('kelas');

        $kelas_list = $this->kelasPesertaModel->getKelasByPeserta($this->idUsers);

        foreach ($kelas_list as &$k) {
            $modul_list = $this->modulModel->getWithProgress($k['id_kelas'], $this->idUsers);
            $k['modul_list'] = $modul_list;
        }

        return view('Dashboard/Peserta/modul', [
            'kelas_list' => $kelas_list,
            'focus_kelas' => $focusKelas,
        ]);
    }

    public function materi_list()
    {
        $materi_list = $this->materiModel->getWithKelasModul($this->idUsers);

        foreach ($materi_list as &$m) {
            if ($m['video_url_materi']) {
                $m['tipe'] = 'video';
            } elseif ($m['file_materi']) {
                $m['tipe'] = 'file';
            } else {
                $m['tipe'] = 'artikel';
            }
        }

        return view('Dashboard/Peserta/materi_list', [
            'materi_list' => $materi_list,
            'total' => count($materi_list),
        ]);
    }

    public function materi_modul($id_modul = null)
    {
        if (!$id_modul) {
            return redirect()->to(base_url('dashboard/peserta/modul'));
        }

        $modul = $this->modulModel->select('modul.*, kelas.id_kelas, kelas.nama_kelas, users.nama_users as nama_pengajar')
            ->join('kelas', 'kelas.id_kelas = modul.id_kelas')
            ->join('users', 'users.id_users = kelas.id_users', 'left')
            ->where('modul.id_modul', $id_modul)
            ->first();

        if (!$modul) {
            return redirect()->to(base_url('dashboard/peserta/modul'))->with('error', 'Modul tidak ditemukan');
        }

        if (!$this->kelasPesertaModel->isEnrolled($modul['id_kelas'], $this->idUsers)) {
            return redirect()->to(base_url('dashboard/peserta/modul'))->with('error', 'Anda tidak terdaftar di kelas ini');
        }

        $materi_list = $this->materiModel->getWithTipe($id_modul);

        $materiAktif = null;
        $materiId = $this->request->getGet('materi');

        if ($materiId) {
            foreach ($materi_list as $m) {
                if ($m['id_materi'] == $materiId) {
                    $materiAktif = $m;
                    break;
                }
            }
        }

        if (!$materiAktif && !empty($materi_list)) {
            $materiAktif = $materi_list[0];
        }

        return view('Dashboard/Peserta/materi_modul', [
            'modul' => $modul,
            'materi_list' => $materi_list,
            'materi_aktif' => $materiAktif,
            'total_materi' => count($materi_list),
        ]);
    }

    public function materi($id_materi = null)
    {
        if (!$id_materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))->with('error', 'Materi tidak ditemukan');
        }

        $materi = $this->materiModel->getDetail($id_materi);

        if (!$materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))->with('error', 'Materi tidak ditemukan');
        }

        if (!$this->kelasPesertaModel->isEnrolled($materi['id_kelas'], $this->idUsers)) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))->with('error', 'Anda tidak memiliki akses ke materi ini');
        }

        if ($materi['video_url_materi']) {
            $materi['tipe'] = 'video';
        } elseif ($materi['file_materi']) {
            $materi['tipe'] = 'file';
        } else {
            $materi['tipe'] = 'artikel';
        }

        [$prev_materi, $next_materi] = $this->materiModel->getAdjacent($id_materi, $materi['id_modul']);

        return view('Dashboard/Peserta/materi_detail', [
            'materi' => $materi,
            'prev_materi' => $prev_materi,
            'next_materi' => $next_materi,
        ]);
    }

    public function quiz()
    {
        $db = \Config\Database::connect();

        $quiz = $db->table('quiz q')
            ->select('q.*, k.nama_kelas')
            ->join('modul m', 'm.id_modul = q.id_modul')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->get()
            ->getResultArray();

        return view('Dashboard/Peserta/quiz_list', [
            'quiz' => $quiz
        ]);
    }
    public function kerjakanQuiz($id_quiz)
    {
        $db = \Config\Database::connect();

        $quiz = $db->table('quiz')
            ->where('id_quiz', $id_quiz)
            ->get()->getRowArray();

        $soal = $db->table('quiz_soal')
            ->where('id_quiz', $id_quiz)
            ->get()->getResultArray();

        return view('Dashboard/Peserta/quiz_kerjakan', [
            'quiz' => $quiz,
            'soal' => $soal
        ]);
    }
    public function submitQuiz($id_quiz)
    {
        $db = \Config\Database::connect();

        $jawaban_user = $this->request->getPost('jawaban');

        $soal = $db->table('quiz_soal')
            ->where('id_quiz', $id_quiz)
            ->get()->getResultArray();

        $benar = 0;
        $total = count($soal);

        foreach ($soal as $s) {
            $id = $s['id_soal'];

            if (isset($jawaban_user[$id]) && $jawaban_user[$id] == $s['jawaban_benar']) {
                $benar++;
            }
        }

        $nilai = $total > 0 ? ($benar / $total) * 100 : 0;

        // 🔥 INI TEMPATNYA (SETELAH HITUNG NILAI)
        $db->table('quiz_results')->insert([
            'id_users' => session()->get('id_users'),
            'id_quiz' => $id_quiz,
            'jumlah_benar_quiz_results' => $benar,
            'jumlah_salah_quiz_results' => $total - $benar,
            'nilai_quiz_results' => round($nilai),
            'waktu_selesai_quiz_results' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('dashboard/peserta/hasil-quiz')
            ->with('success', 'Quiz selesai! Nilai kamu: ' . round($nilai));
    }
    public function hasilQuiz()
    {
        $db = \Config\Database::connect();

        $hasil = $db->table('quiz_results qr')
            ->select('qr.*, q.judul_quiz')
            ->join('quiz q', 'q.id_quiz = qr.id_quiz')
            ->where('qr.id_users', $this->idUsers)
            ->orderBy('qr.created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('Dashboard/Peserta/hasil_quiz', [
            'hasil' => $hasil
        ]);
    }
    // Tambahkan di bagian use atas

    // Tambahkan method ini di dalam class DashboardPeserta
    public function simpanHasilQuizMateri()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $idMateri    = (int) $this->request->getPost('id_materi');
        $nilai       = (int) $this->request->getPost('nilai');
        $jumlahBenar = (int) $this->request->getPost('jumlah_benar');
        $jumlahSalah = (int) $this->request->getPost('jumlah_salah');

        if (!$idMateri) {
            return $this->response
                ->setContentType('application/json')
                ->setJSON(['success' => false, 'message' => 'ID materi tidak valid.']);
        }

        $model  = new MateriQuizResultsModel();
        $result = $model->simpan($this->idUsers, $idMateri, $nilai, $jumlahBenar, $jumlahSalah);

        return $this->response
            ->setContentType('application/json')
            ->setJSON([
                'success' => $result,
                'message' => $result ? 'Hasil quiz berhasil disimpan.' : 'Gagal menyimpan hasil quiz.',
            ]);
    }
}
