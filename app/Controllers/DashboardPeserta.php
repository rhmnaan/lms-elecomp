<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModulModel;
use App\Models\MateriModel;
use App\Models\KelasPesertaModel;
use App\Models\MateriQuizResultsModel;
use App\Models\UserMateriProgressModel;

class DashboardPeserta extends BaseController
{
    protected int $idUsers;
    protected KelasPesertaModel $kelasPesertaModel;
    protected ModulModel $modulModel;
    protected MateriModel $materiModel;
    protected $userMateriProgressModel;

    public function __construct()
    {
        $this->kelasPesertaModel       = new KelasPesertaModel();
        $this->modulModel              = new ModulModel();
        $this->materiModel             = new MateriModel();
        $this->userMateriProgressModel = new UserMateriProgressModel();
    }

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->idUsers = (int) session()->get('id_users');
    }

    // =========================================================
    //  BERANDA
    // =========================================================
    public function beranda()
    {
        $db = \Config\Database::connect();

        $kelas_list = $db->table('kelas_peserta kp')
            ->select('k.id_kelas, k.nama_kelas,
                      u.nama_users AS nama_pengajar,
                      COUNT(DISTINCT m.id_modul) AS total_modul')
            ->join('kelas k', 'k.id_kelas = kp.id_kelas')
            ->join('users u', 'u.id_users = k.id_users', 'left')
            ->join('modul m', 'm.id_kelas = k.id_kelas AND m.deleted_at IS NULL', 'left')
            ->where('kp.id_users', $this->idUsers)
            ->where('kp.deleted_at IS NULL')
            ->where('k.deleted_at IS NULL')
            ->groupBy('k.id_kelas')
            ->get()->getResultArray();

        $id_kelas_list = array_column($kelas_list, 'id_kelas');
        $total_kelas   = count($kelas_list);

        foreach ($kelas_list as &$k) {
            $k['modul_selesai'] = 0;
        }
        unset($k);

        if (!empty($id_kelas_list)) {
            foreach ($kelas_list as &$k) {
                $moduls_in_kelas = $db->table('modul')
                    ->where('id_kelas', $k['id_kelas'])
                    ->where('deleted_at IS NULL')
                    ->get()->getResultArray();

                foreach ($moduls_in_kelas as $modul) {
                    $total_materi_modul = $db->table('materi')
                        ->where('id_modul', $modul['id_modul'])
                        ->where('deleted_at IS NULL')
                        ->countAllResults();

                    if ($total_materi_modul > 0) {
                        $materi_selesai = $db->table('user_materi_progress ump')
                            ->join('materi m', 'm.id_materi = ump.id_materi')
                            ->where('ump.id_users', $this->idUsers)
                            ->where('m.id_modul', $modul['id_modul'])
                            ->where('m.deleted_at IS NULL')
                            ->where('ump.is_completed', 1)
                            ->countAllResults();

                        if ($materi_selesai >= $total_materi_modul) {
                            $k['modul_selesai']++;
                        }
                    }
                }
            }
            unset($k);
        }

        $total_materi = 0;
        if (!empty($id_kelas_list)) {
            $total_materi = $db->table('materi ma')
                ->join('modul m', 'm.id_modul = ma.id_modul')
                ->whereIn('m.id_kelas', $id_kelas_list)
                ->where('ma.deleted_at IS NULL')
                ->where('m.deleted_at IS NULL')
                ->countAllResults();
        }

        $total_quiz_tersedia = 0;
        if (!empty($id_kelas_list)) {
            $total_quiz_tersedia = $db->table('materi ma')
                ->join('modul m', 'm.id_modul = ma.id_modul')
                ->whereIn('m.id_kelas', $id_kelas_list)
                ->where('ma.deleted_at IS NULL')
                ->where('m.deleted_at IS NULL')
                ->groupStart()
                    ->where('ma.post_test IS NOT NULL')
                    ->orWhere('ma.pre_test IS NOT NULL')
                ->groupEnd()
                ->countAllResults();
        }

        $rows = [];
        if (!empty($id_kelas_list)) {
            $rows = $db->table('materi_quiz_results mqr')
                ->select('mqr.nilai, mqr.jenis_test')
                ->join('materi ma', 'ma.id_materi = mqr.id_materi')
                ->join('modul mo',  'mo.id_modul  = ma.id_modul')
                ->whereIn('mo.id_kelas', $id_kelas_list)
                ->where('mqr.id_users', $this->idUsers)
                ->get()->getResultArray();
        }

        $total_quiz_dikerjakan = count($rows);
        $dist_lulus = $dist_cukup = $dist_kurang = 0;
        $sum_nilai  = 0;

        foreach ($rows as $r) {
            $n = (int) $r['nilai'];
            $sum_nilai += $n;
            if ($n >= 70)     $dist_lulus++;
            elseif ($n >= 50) $dist_cukup++;
            else              $dist_kurang++;
        }

        $rata_nilai = $total_quiz_dikerjakan > 0
            ? round($sum_nilai / $total_quiz_dikerjakan, 1)
            : 0;

        $riwayat_quiz = [];
        if (!empty($id_kelas_list)) {
            $riwayat_quiz = $db->table('materi_quiz_results mqr')
                ->select('mqr.nilai             AS nilai_quiz_results,
                          mqr.created_at        AS waktu_selesai_quiz_results,
                          CONCAT(ma.judul_materi, " (", mqr.jenis_test, "-test)") AS judul_quiz,
                          k.nama_kelas')
                ->join('materi ma', 'ma.id_materi = mqr.id_materi')
                ->join('modul mo',  'mo.id_modul  = ma.id_modul')
                ->join('kelas k',   'k.id_kelas   = mo.id_kelas')
                ->where('mqr.id_users', $this->idUsers)
                ->whereIn('mo.id_kelas', $id_kelas_list)
                ->orderBy('mqr.created_at', 'DESC')
                ->limit(5)
                ->get()->getResultArray();
        }

        $materi_terbaru = [];
        if (!empty($id_kelas_list)) {
            $materi_terbaru = $db->table('materi ma')
                ->select('ma.id_materi, ma.judul_materi,
                          ma.file_materi, ma.video_url_materi,
                          mo.id_modul, mo.judul_modul, k.nama_kelas')
                ->join('modul mo', 'mo.id_modul = ma.id_modul')
                ->join('kelas k',  'k.id_kelas  = mo.id_kelas')
                ->whereIn('mo.id_kelas', $id_kelas_list)
                ->where('ma.deleted_at IS NULL')
                ->where('mo.deleted_at IS NULL')
                ->orderBy('ma.created_at', 'DESC')
                ->limit(6)
                ->get()->getResultArray();
        }

        $peringkat           = null;
        $total_peserta_kelas = null;

        if (!empty($id_kelas_list)) {
            $id_kelas_pertama = $id_kelas_list[0];

            $peserta_ids = $db->table('kelas_peserta')
                ->select('id_users')
                ->where('id_kelas', $id_kelas_pertama)
                ->where('deleted_at IS NULL')
                ->get()->getResultArray();
            $peserta_ids         = array_column($peserta_ids, 'id_users');
            $total_peserta_kelas = count($peserta_ids);

            if (!empty($peserta_ids)) {
                $rank_rows = $db->table('materi_quiz_results mqr')
                    ->select('mqr.id_users, AVG(mqr.nilai) AS avg_val')
                    ->join('materi ma', 'ma.id_materi = mqr.id_materi')
                    ->join('modul mo',  'mo.id_modul  = ma.id_modul')
                    ->whereIn('mqr.id_users', $peserta_ids)
                    ->where('mo.id_kelas', $id_kelas_pertama)
                    ->groupBy('mqr.id_users')
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

        return view('Dashboard/Peserta/beranda', [
            'kelas_list'            => $kelas_list,
            'total_kelas'           => $total_kelas,
            'total_materi'          => $total_materi,
            'total_quiz_tersedia'   => $total_quiz_tersedia,
            'total_quiz_dikerjakan' => $total_quiz_dikerjakan,
            'rata_nilai'            => $rata_nilai,
            'dist_lulus'            => $dist_lulus,
            'dist_cukup'            => $dist_cukup,
            'dist_kurang'           => $dist_kurang,
            'riwayat_quiz'          => $riwayat_quiz,
            'materi_terbaru'        => $materi_terbaru,
            'peringkat'             => $peringkat,
            'total_peserta_kelas'   => $total_peserta_kelas,
        ]);
    }

    // =========================================================
    //  KELAS
    // =========================================================
    public function kelas()
    {
        $db = \Config\Database::connect();

        $kelas_list = $db->table('kelas_peserta kp')
            ->select('k.id_kelas, k.nama_kelas, k.deskripsi_kelas,
                      u.nama_users AS nama_pengajar,
                      COUNT(DISTINCT m.id_modul) AS total_modul,
                      COUNT(DISTINCT ma.id_materi) AS total_materi')
            ->join('kelas k', 'k.id_kelas = kp.id_kelas')
            ->join('users u', 'u.id_users = k.id_users', 'left')
            ->join('modul m', 'm.id_kelas = k.id_kelas AND m.deleted_at IS NULL', 'left')
            ->join('materi ma', 'ma.id_modul = m.id_modul AND ma.deleted_at IS NULL', 'left')
            ->where('kp.id_users', $this->idUsers)
            ->where('kp.deleted_at IS NULL')
            ->where('k.deleted_at IS NULL')
            ->groupBy('k.id_kelas')
            ->get()->getResultArray();

        foreach ($kelas_list as &$k) {
            $id_kelas = $k['id_kelas'];

            $total_materi = $db->table('materi ma')
                ->join('modul m', 'm.id_modul = ma.id_modul')
                ->where('m.id_kelas', $id_kelas)
                ->where('ma.deleted_at IS NULL')
                ->where('m.deleted_at IS NULL')
                ->countAllResults();

            $completed_materi = $db->table('user_materi_progress ump')
                ->join('materi ma', 'ma.id_materi = ump.id_materi')
                ->join('modul m', 'm.id_modul = ma.id_modul')
                ->where('m.id_kelas', $id_kelas)
                ->where('ump.id_users', $this->idUsers)
                ->where('ump.is_completed', 1)
                ->countAllResults();

            $k['persen'] = $total_materi > 0
                ? round(($completed_materi / $total_materi) * 100)
                : 0;
        }
        unset($k);

        return view('Dashboard/Peserta/kelas', [
            'kelas_list'  => $kelas_list,
            'total_kelas' => count($kelas_list),
        ]);
    }

    // =========================================================
    //  MODUL
    // =========================================================
    public function modul()
    {
        $focusKelas = $this->request->getGet('kelas');
        $kelas_list = $this->kelasPesertaModel->getKelasByPeserta($this->idUsers);

        foreach ($kelas_list as &$k) {
            $k['modul_list'] = $this->modulModel->getWithProgress($k['id_kelas'], $this->idUsers);
        }
        unset($k);

        return view('Dashboard/Peserta/modul', [
            'kelas_list'  => $kelas_list,
            'focus_kelas' => $focusKelas,
        ]);
    }

    // =========================================================
    //  MATERI LIST
    // =========================================================
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
        unset($m);

        return view('Dashboard/Peserta/materi_list', [
            'materi_list' => $materi_list,
            'total'       => count($materi_list),
        ]);
    }

    // =========================================================
    //  MATERI MODUL
    // =========================================================
    public function materi_modul($id_modul = null)
    {
        if (!$id_modul) {
            return redirect()->to(base_url('dashboard/peserta/modul'));
        }

        $modul = $this->modulModel
            ->select('modul.*, kelas.id_kelas, kelas.nama_kelas, users.nama_users AS nama_pengajar')
            ->join('kelas', 'kelas.id_kelas = modul.id_kelas')
            ->join('users', 'users.id_users = kelas.id_users', 'left')
            ->where('modul.id_modul', $id_modul)
            ->first();

        if (!$modul) {
            return redirect()->to(base_url('dashboard/peserta/modul'))
                ->with('error', 'Modul tidak ditemukan');
        }

        if (!$this->kelasPesertaModel->isEnrolled($modul['id_kelas'], $this->idUsers)) {
            return redirect()->to(base_url('dashboard/peserta/modul'))
                ->with('error', 'Anda tidak terdaftar di kelas ini');
        }

        $materi_list = $this->materiModel->getWithTipe($id_modul);
        $db          = \Config\Database::connect();

        foreach ($materi_list as $index => &$materi) {
            if ($index == 0) {
                $materi['is_accessible'] = true;
            } else {
                $prevMateri   = $materi_list[$index - 1];
                $prevPosttest = $db->table('materi_quiz_results')
                    ->where('id_materi', $prevMateri['id_materi'])
                    ->where('id_users', $this->idUsers)
                    ->where('jenis_test', 'post')
                    ->where('nilai >=', 70)
                    ->countAllResults();
                $materi['is_accessible'] = $prevPosttest > 0;
            }
        }
        unset($materi);

        $materiAktif = null;
        $materiId    = $this->request->getGet('materi');

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

        $progressModel  = new UserMateriProgressModel();
        $pretestResult  = null;
        $posttestResult = null;
        $materiSelesai  = false;

        if ($materiAktif) {
            $pretestResult = $db->table('materi_quiz_results')
                ->where('id_materi', $materiAktif['id_materi'])
                ->where('id_users', $this->idUsers)
                ->where('jenis_test', 'pre')
                ->orderBy('created_at', 'DESC')
                ->get()->getRowArray();

            $materiSelesai = $progressModel->isCompleted(
                $this->idUsers,
                $materiAktif['id_materi']
            );

            $posttestResult = $db->table('materi_quiz_results')
                ->where('id_materi', $materiAktif['id_materi'])
                ->where('id_users', $this->idUsers)
                ->where('jenis_test', 'post')
                ->orderBy('created_at', 'DESC')
                ->get()->getRowArray();
        }

        return view('Dashboard/Peserta/materi_modul', [
            'modul'          => $modul,
            'materi_list'    => $materi_list,
            'materi_aktif'   => $materiAktif,
            'total_materi'   => count($materi_list),
            'has_pretest'    => !empty($pretestResult),
            'nilai_pre'      => $pretestResult,
            'has_posttest'   => !empty($posttestResult),
            'nilai_post'     => $posttestResult,
            'materi_selesai' => !empty($materiSelesai),
        ]);
    }

    // =========================================================
    //  SELESAI MATERI (AJAX)
    // =========================================================
    public function selesaiMateri()
    {
        log_message('debug', '[selesaiMateri] START');
        log_message('debug', '[selesaiMateri] Is AJAX: ' . ($this->request->isAJAX() ? 'true' : 'false'));
        log_message('debug', '[selesaiMateri] Session ID User: ' . (isset($this->idUsers) ? $this->idUsers : 'NOT SET'));

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Not AJAX request']);
        }

        if (empty($this->idUsers)) {
            return $this->response->setJSON(['success' => false, 'error' => 'User not authenticated']);
        }

        $idMateri = (int) $this->request->getPost('id_materi');
        log_message('debug', '[selesaiMateri] ID Materi received: ' . $idMateri);

        if ($idMateri <= 0) {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid ID materi']);
        }

        try {
            $progressModel = new UserMateriProgressModel();
            $result        = $progressModel->markAsCompleted($this->idUsers, $idMateri);
            $check         = $progressModel->isCompleted($this->idUsers, $idMateri);

            log_message('debug', '[selesaiMateri] Insert result: ' . ($result ? 'true' : 'false'));
            log_message('debug', '[selesaiMateri] Verify check result: ' . ($check ? 'true' : 'false'));

            return $this->response->setJSON([
                'success'   => true,
                'message'   => 'Materi berhasil ditandai selesai',
                'id_materi' => $idMateri,
                'id_user'   => $this->idUsers,
                'verified'  => $check ? true : false,
            ]);
        } catch (\Exception $e) {
            log_message('error', '[selesaiMateri] Exception: ' . $e->getMessage());
            log_message('error', '[selesaiMateri] Stack trace: ' . $e->getTraceAsString());
            return $this->response->setJSON([
                'success' => false,
                'error'   => 'Exception: ' . $e->getMessage(),
            ]);
        }
    }

    // =========================================================
    //  MATERI DETAIL
    // =========================================================
    public function materi($id_materi = null)
    {
        if (!$id_materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        $materi = $this->materiModel->getDetail($id_materi);

        if (!$materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        if (!$this->kelasPesertaModel->isEnrolled($materi['id_kelas'], $this->idUsers)) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Anda tidak memiliki akses ke materi ini');
        }

        $db = \Config\Database::connect();

        $pretestResult = $db->table('materi_quiz_results')
            ->where('id_materi', $materi['id_materi'])
            ->where('id_users', $this->idUsers)
            ->where('jenis_test', 'pre')
            ->orderBy('created_at', 'DESC')
            ->get()->getRowArray();

        $posttestResult = $db->table('materi_quiz_results')
            ->where('id_materi', $materi['id_materi'])
            ->where('id_users', $this->idUsers)
            ->where('jenis_test', 'post')
            ->orderBy('created_at', 'DESC')
            ->get()->getRowArray();

        $materiSelesai = $this->userMateriProgressModel
            ->isCompleted($this->idUsers, $materi['id_materi']);

        if ($materi['video_url_materi']) {
            $materi['tipe'] = 'video';
        } elseif ($materi['file_materi']) {
            $materi['tipe'] = 'file';
        } else {
            $materi['tipe'] = 'artikel';
        }

        [$prev_materi, $next_materi] = $this->materiModel->getAdjacent($id_materi, $materi['id_modul']);

        return view('Dashboard/Peserta/materi_detail', [
            'materi'         => $materi,
            'prev_materi'    => $prev_materi,
            'next_materi'    => $next_materi,
            'has_pretest'    => !empty($pretestResult),
            'nilai_pre'      => $pretestResult,
            'has_posttest'   => !empty($posttestResult),
            'nilai_post'     => $posttestResult,
            'materi_selesai' => !empty($materiSelesai),
        ]);
    }

    // =========================================================
    //  PRETEST
    // =========================================================
    public function pretest($id_materi = null)
    {
        if (!$id_materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        $materi = $this->materiModel->getDetail($id_materi);

        if (!$materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        if (!$this->kelasPesertaModel->isEnrolled($materi['id_kelas'], $this->idUsers)) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Anda tidak memiliki akses ke materi ini');
        }

        $soal = [];
        if (!empty($materi['pre_test'])) {
            $soal = is_string($materi['pre_test'])
                ? json_decode($materi['pre_test'], true)
                : $materi['pre_test'];
        }

        if (empty($soal)) {
            return redirect()->back()->with('error', 'Pre-test tidak tersedia untuk materi ini');
        }

        $db            = \Config\Database::connect();
        $pretestResult = $db->table('materi_quiz_results')
            ->where('id_materi', $id_materi)
            ->where('id_users', $this->idUsers)
            ->where('jenis_test', 'pre')
            ->orderBy('created_at', 'DESC')
            ->get()->getRowArray();

        // ✅ FIX: kirim $redirect ke view agar tidak undefined
        $redirect = $this->request->getGet('redirect')
            ?? base_url('dashboard/peserta/materi-modul/' . $materi['id_modul']);

        return view('Dashboard/Peserta/pretest_view', [
            'materi'      => $materi,
            'soal'        => $soal,
            'has_pretest' => !empty($pretestResult),
            'nilai_pre'   => $pretestResult,
            'redirect'    => $redirect,
        ]);
    }

    // =========================================================
    //  POSTTEST
    // =========================================================
    public function posttest($id_materi = null)
    {
        if (!$id_materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        $materi = $this->materiModel->getDetail($id_materi);

        if (!$materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        if (!$this->kelasPesertaModel->isEnrolled($materi['id_kelas'], $this->idUsers)) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Anda tidak memiliki akses ke materi ini');
        }

        $materiSelesai = $this->userMateriProgressModel
            ->isCompleted($this->idUsers, $id_materi);

        if (!$materiSelesai) {
            return redirect()->back()->with('error', 'Selesaikan materi terlebih dahulu sebelum mengerjakan post-test');
        }

        $soal = [];
        if (!empty($materi['post_test'])) {
            $soal = is_string($materi['post_test'])
                ? json_decode($materi['post_test'], true)
                : $materi['post_test'];
        }

        if (empty($soal)) {
            return redirect()->back()->with('error', 'Post-test tidak tersedia untuk materi ini');
        }

        $db             = \Config\Database::connect();
        $posttestResult = $db->table('materi_quiz_results')
            ->where('id_materi', $id_materi)
            ->where('id_users', $this->idUsers)
            ->where('jenis_test', 'post')
            ->orderBy('created_at', 'DESC')
            ->get()->getRowArray();

        // ✅ FIX: kirim $redirect ke view agar tidak undefined
        $redirect = $this->request->getGet('redirect')
            ?? base_url('dashboard/peserta/materi-modul/' . $materi['id_modul']);

        return view('Dashboard/Peserta/posttest_view', [
            'materi'       => $materi,
            'soal'         => $soal,
            'has_posttest' => !empty($posttestResult),
            'nilai_post'   => $posttestResult,
            'redirect'     => $redirect,
        ]);
    }

    // =========================================================
    //  SIMPAN HASIL QUIZ MATERI (AJAX)
    // =========================================================
    public function simpanHasilQuizMateri()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $idMateri    = (int) $this->request->getPost('id_materi');
        $jenisTest   = $this->request->getPost('jenis_test');
        $nilai       = (int) $this->request->getPost('nilai');
        $jumlahBenar = (int) $this->request->getPost('jumlah_benar');
        $jumlahSalah = (int) $this->request->getPost('jumlah_salah');
        $jawaban     = $this->request->getPost('jawaban_peserta');
        $redirect    = $this->request->getPost('redirect');

        if (!$idMateri || !in_array($jenisTest, ['pre', 'post'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid.']);
        }

        $model  = new MateriQuizResultsModel();
        $result = $model->simpan(
            $idMateri,
            $this->idUsers,
            $jenisTest,
            $nilai,
            $jumlahBenar,
            $jumlahSalah,
            $jawaban
        );

        return $this->response->setJSON([
            'success'  => $result,
            'message'  => $result ? 'Hasil berhasil disimpan.' : 'Gagal menyimpan.',
            'redirect' => $redirect,
        ]);
    }
}