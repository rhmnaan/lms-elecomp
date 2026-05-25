<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasPesertaModel;
use App\Models\MateriModel;
use App\Models\MateriQuizResultsModel;
use App\Models\ModulModel;
use App\Models\TugasModel;
use App\Models\TugasPengumpulanModel;
use App\Models\UserMateriProgressModel;
use App\Models\AplikasiPendukungModel;
use App\Models\AplikasiUserModel;

class DashboardPeserta extends BaseController
{
    protected int $idUsers;
    protected KelasPesertaModel $kelasPesertaModel;
    protected ModulModel $modulModel;
    protected MateriModel $materiModel;
    protected $userMateriProgressModel;
    protected $aplikasiModel;
    protected $aplikasiUserModel;
    
    public function __construct()
    {
        $this->aplikasiModel = new AplikasiPendukungModel();
        $this->aplikasiUserModel = new AplikasiUserModel();
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

        if (! empty($id_kelas_list)) {
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
        if (! empty($id_kelas_list)) {
            $total_materi = $db->table('materi ma')
                ->join('modul m', 'm.id_modul = ma.id_modul')
                ->whereIn('m.id_kelas', $id_kelas_list)
                ->where('ma.deleted_at IS NULL')
                ->where('m.deleted_at IS NULL')
                ->countAllResults();
        }

        $total_quiz_tersedia = 0;
        if (! empty($id_kelas_list)) {
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
        if (! empty($id_kelas_list)) {
            $rows = $db->table('materi_quiz_results mqr')
                ->select('mqr.nilai, mqr.jenis_test')
                ->join('materi ma', 'ma.id_materi = mqr.id_materi')
                ->join('modul mo', 'mo.id_modul  = ma.id_modul')
                ->whereIn('mo.id_kelas', $id_kelas_list)
                ->where('mqr.id_users', $this->idUsers)
                ->get()->getResultArray();
        }

        $total_quiz_dikerjakan = count($rows);
        $dist_lulus            = $dist_cukup = $dist_kurang = 0;
        $sum_nilai             = 0;

        foreach ($rows as $r) {
            $n          = (int) $r['nilai'];
            $sum_nilai += $n;
            if ($n >= 70) {
                $dist_lulus++;
            } elseif ($n >= 50) {
                $dist_cukup++;
            } else {
                $dist_kurang++;
            }
        }

        $rata_nilai = $total_quiz_dikerjakan > 0
            ? round($sum_nilai / $total_quiz_dikerjakan, 1)
            : 0;

        $riwayat_quiz = [];
        if (! empty($id_kelas_list)) {
            $riwayat_quiz = $db->table('materi_quiz_results mqr')
                ->select('mqr.nilai             AS nilai_quiz_results,
                          mqr.created_at        AS waktu_selesai_quiz_results,
                          CONCAT(ma.judul_materi, " (", mqr.jenis_test, "-test)") AS judul_quiz,
                          k.nama_kelas')
                ->join('materi ma', 'ma.id_materi = mqr.id_materi')
                ->join('modul mo', 'mo.id_modul  = ma.id_modul')
                ->join('kelas k', 'k.id_kelas   = mo.id_kelas')
                ->where('mqr.id_users', $this->idUsers)
                ->whereIn('mo.id_kelas', $id_kelas_list)
                ->orderBy('mqr.created_at', 'DESC')
                ->limit(5)
                ->get()->getResultArray();
        }

        $materi_terbaru = [];
        if (! empty($id_kelas_list)) {
            $materi_terbaru = $db->table('materi ma')
                ->select('ma.id_materi, ma.judul_materi,
                          ma.file_materi, ma.video_url_materi,
                          mo.id_modul, mo.judul_modul, k.nama_kelas')
                ->join('modul mo', 'mo.id_modul = ma.id_modul')
                ->join('kelas k', 'k.id_kelas  = mo.id_kelas')
                ->whereIn('mo.id_kelas', $id_kelas_list)
                ->where('ma.deleted_at IS NULL')
                ->where('mo.deleted_at IS NULL')
                ->orderBy('ma.created_at', 'DESC')
                ->limit(6)
                ->get()->getResultArray();
        }

        $peringkat           = null;
        $total_peserta_kelas = null;

        if (! empty($id_kelas_list)) {
            $id_kelas_pertama = $id_kelas_list[0];

            $peserta_ids = $db->table('kelas_peserta')
                ->select('id_users')
                ->where('id_kelas', $id_kelas_pertama)
                ->where('deleted_at IS NULL')
                ->get()->getResultArray();
            $peserta_ids         = array_column($peserta_ids, 'id_users');
            $total_peserta_kelas = count($peserta_ids);

            if (! empty($peserta_ids)) {
                $rank_rows = $db->table('materi_quiz_results mqr')
                    ->select('mqr.id_users, AVG(mqr.nilai) AS avg_val')
                    ->join('materi ma', 'ma.id_materi = mqr.id_materi')
                    ->join('modul mo', 'mo.id_modul  = ma.id_modul')
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
    //  KELAS SAYA (SEMUA KELAS YANG SUDAH DI-CLAIM)
    // =========================================================
    public function kelasSaya()
    {
        $db = \Config\Database::connect();

        $kelas_list = $db->table('kelas k')
            ->select('
                k.id_kelas,
                k.nama_kelas,
                k.deskripsi_kelas,
                kp.tanggal_daftar_kelas_peserta,
                kp.tanggal_berakhir,
                p.id_program,
                p.nama_program,
                u.nama_users AS nama_pengajar,
                COUNT(DISTINCT m.id_modul) AS total_modul,
                COUNT(DISTINCT ma.id_materi) AS total_materi
            ')
            ->join('program p', 'p.id_program = k.id_program', 'left')
            ->join('users u', 'u.id_users = k.id_users', 'left')
            ->join('modul m', 'm.id_kelas = k.id_kelas AND m.deleted_at IS NULL', 'left')
            ->join('materi ma', 'ma.id_modul = m.id_modul AND ma.deleted_at IS NULL', 'left')
            ->join(
                'kelas_peserta kp',
                'kp.id_kelas = k.id_kelas
                AND kp.id_users = ' . (int) $this->idUsers . '
                AND kp.deleted_at IS NULL',
                'inner'
            )
            ->where('k.deleted_at IS NULL')
            ->groupBy('k.id_kelas')
            ->get()
            ->getResultArray();

        // Hitung progress & kelompokkan per program
        $grouped = [];
        $kelasIds = array_column($kelas_list, 'id_kelas');
        $tugasCounts = [];
        if (! empty($kelasIds)) {
            $tugasCounts = $db->table('tugas')
                ->select('id_kelas, COUNT(*) AS total_tugas')
                ->whereIn('id_kelas', $kelasIds)
                ->where('deleted_at IS NULL')
                ->groupBy('id_kelas')
                ->get()
                ->getResultArray();
            $tugasCounts = array_column($tugasCounts, 'total_tugas', 'id_kelas');
        }

        foreach ($kelas_list as &$k) {
            $total = $db->table('materi ma')
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

            $k['persen'] = $total > 0 ? round(($selesai / $total) * 100) : 0;
            $k['tugas_count'] = isset($tugasCounts[$k['id_kelas']]) ? (int) $tugasCounts[$k['id_kelas']] : 0;

            $programKey = $k['id_program'] ?? 0;
            if (! isset($grouped[$programKey])) {
                $grouped[$programKey] = [
                    'nama_program' => $k['nama_program'] ?? 'Tanpa Program',
                    'kelas'        => [],
                ];
            }

            // ===============================
            // HITUNG SISA HARI AKSES KELAS
            // (AKURAT BERDASARKAN TANGGAL)
            // ===============================
            if (! empty($k['tanggal_berakhir'])) {

                $hariIni = new \DateTime(date('Y-m-d')); // jam 00:00:00
                $akhir   = new \DateTime(date('Y-m-d', strtotime($k['tanggal_berakhir'])));

                // Selisih hari murni (tanpa jam)
                $selisih = (int) $hariIni->diff($akhir)->format('%r%a');

                $k['sisa_hari'] = max(0, $selisih);

            } else {
                // NULL = akses selamanya
                $k['sisa_hari'] = null;
            }
            
            $grouped[$programKey]['kelas'][] = $k;
        }
        unset($k);

        return view('Dashboard/Peserta/kelas-saya', [
            'grouped'     => $grouped,
            'total_kelas' => count($kelas_list),
        ]);
    }


    // =========================================================
    // TUGAS KELAS
    // =========================================================
    public function kelasTugas($id_kelas = null)
    {
        if (! $id_kelas) {
            $id_kelas = $this->request->getGet('kelas');
        }

        if (! $id_kelas) {
            return redirect()->to(base_url('dashboard/peserta/kelas-saya'))
                ->with('error', 'Kelas tidak valid.');
        }

        $db = \Config\Database::connect();

        $kelas = $db->table('kelas k')
            ->select('k.id_kelas, k.nama_kelas, k.deskripsi_kelas, u.nama_users AS nama_pengajar')
            ->join('users u', 'u.id_users = k.id_users', 'left')
            ->join(
                'kelas_peserta kp',
                'kp.id_kelas = k.id_kelas 
                AND kp.id_users = ' . (int)$this->idUsers . ' 
                AND kp.deleted_at IS NULL',
                'inner'
            )
            ->where('k.id_kelas', $id_kelas)
            ->where('k.deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $kelas) {
            return redirect()->to(base_url('dashboard/peserta/kelas-saya'))
                ->with('error', 'Kelas tidak ditemukan.');
        }

        $tugas = $this->getTugasForClass($id_kelas);

        // ===============================
        // BACK URL (DARI HALAMAN SEBELUMNYA)
        // ===============================
        $backUrl = $this->request->getGet('back');
        $backUrl = $backUrl ?: base_url('dashboard/peserta/kelas-saya');

        return view('Dashboard/Peserta/kelas_tugas', [
            'kelas'   => $kelas,
            'tugas'   => $tugas,
            'backUrl' => $backUrl,
        ]);
    }

    public function tugasRiwayat($id_tugas = null)
    {
        if (! $id_tugas) {
            return redirect()->back()->with('error', 'Tugas tidak valid.');
        }

        $db = \Config\Database::connect();
        $tugas = $db->table('tugas t')
            ->select('t.*, k.id_kelas')
            ->join('kelas k', 'k.id_kelas = t.id_kelas', 'left')
            ->where('t.id_tugas', $id_tugas)
            ->where('t.deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $tugas) {
            return redirect()->back()->with('error', 'Tugas tidak ditemukan.');
        }

        $kelasPeserta = $db->table('kelas_peserta')
            ->where('id_kelas', $tugas['id_kelas'])
            ->where('id_users', $this->idUsers)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();

        if (! $kelasPeserta) {
            return redirect()->back()->with('error', 'Akses tidak diizinkan.');
        }

        $history = (new TugasPengumpulanModel())->getHistory($id_tugas, $this->idUsers);

        return view('Dashboard/Peserta/tugas_history', [
            'tugas'   => $tugas,
            'history' => $history,
        ]);
    }

    private function getTugasForClass(int $idKelas): array
    {
        $db = \Config\Database::connect();

        $kelasPeserta = $db->table('kelas_peserta')
            ->where('id_kelas', $idKelas)
            ->where('id_users', $this->idUsers)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();

        if (! $kelasPeserta) {
            return [];
        }

        $joinDate = $kelasPeserta['tanggal_daftar_kelas_peserta'];

        $tugasRows = $db->table('tugas t')
            ->select('t.*, m.judul_modul')
            ->join('modul m', 'm.id_modul = t.id_modul', 'left')
            ->where('t.id_kelas', $idKelas)
            ->where('t.deleted_at IS NULL')
            ->orderBy('t.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $pengumpulanModel = new TugasPengumpulanModel();
        $deadlineModel = new \App\Models\TugasDeadlinePesertaModel();

        $classTugas = [];

        foreach ($tugasRows as $task) {

            // =========================
            // 1️⃣ DEADLINE KHUSUS PESERTA
            // =========================
            $deadlinePeserta = $deadlineModel->getDeadline(
                $task['id_tugas'],
                $this->idUsers
            );

            if ($deadlinePeserta) {
                $deadlineAt = $deadlinePeserta['deadline_at'];
            }
            // =========================
            // 2️⃣ DEADLINE DEFAULT TUGAS
            // =========================
            elseif (! empty($task['deadline_hari'])) {
                $deadlineAt = date(
                    'Y-m-d H:i:s',
                    strtotime("+{$task['deadline_hari']} days", strtotime($joinDate))
                );
            }
            // =========================
            // 3️⃣ TANPA DEADLINE
            // =========================
            else {
                $deadlineAt = null;
            }

            // Status kadaluarsa
            $isExpired = $deadlineAt ? strtotime($deadlineAt) < time() : false;

            // Riwayat pengumpulan
            $history = $pengumpulanModel->getHistory(
                $task['id_tugas'],
                $this->idUsers
            );

            $hasSubmission = ! empty($history);

            // Submit hanya tergantung deadline
            $canSubmit = ! $isExpired;

            $classTugas[] = array_merge($task, [
                'deadline_at'     => $deadlineAt,
                'is_expired'      => $isExpired,
                'has_submission'  => $hasSubmission,
                'history'         => $history,
                'can_submit'      => $canSubmit,
            ]);
        }

        return $classTugas;
    }

    // =========================================================
    //  MODUL
    // =========================================================
    public function modul()
    {
        $focusKelas = $this->request->getGet('kelas');
        $kelas_list = $this->kelasPesertaModel->getKelasByPeserta($this->idUsers);
        $db         = \Config\Database::connect();

        foreach ($kelas_list as &$k) {
            $k['modul_list'] = $this->modulModel->getWithProgress($k['id_kelas'], $this->idUsers);

            // Hitung jumlah file per tipe untuk setiap modul
            foreach ($k['modul_list'] as &$m) {
                $materi_list = $db->table('materi')
                    ->select('file_materi, video_url_materi')
                    ->where('id_modul', $m['id_modul'])
                    ->where('deleted_at IS NULL')
                    ->get()->getResultArray();

                $count = ['pdf' => 0, 'word' => 0, 'excel' => 0, 'ppt' => 0, 'video' => 0];

                foreach ($materi_list as $mt) {
                    if (!empty($mt['video_url_materi'])) {
                        $count['video']++;
                    }
                    if (!empty($mt['file_materi'])) {
                        $ext = strtolower(pathinfo($mt['file_materi'], PATHINFO_EXTENSION));
                        if ($ext === 'pdf')                        $count['pdf']++;
                        elseif (in_array($ext, ['doc','docx']))   $count['word']++;
                        elseif (in_array($ext, ['xls','xlsx']))   $count['excel']++;
                        elseif (in_array($ext, ['ppt','pptx']))   $count['ppt']++;
                    }
                }

                $m['file_count'] = $count;
            }
            unset($m);
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
        if (! $id_modul) {
            return redirect()->to(base_url('dashboard/peserta/modul'));
        }

        $modul = $this->modulModel
            ->select('modul.*, kelas.id_kelas, kelas.nama_kelas, users.nama_users AS nama_pengajar')
            ->join('kelas', 'kelas.id_kelas = modul.id_kelas')
            ->join('users', 'users.id_users = kelas.id_users', 'left')
            ->where('modul.id_modul', $id_modul)
            ->first();

        if (! $modul) {
            return redirect()->to(base_url('dashboard/peserta/modul'))
                ->with('error', 'Modul tidak ditemukan');
        }

        if (! $this->kelasPesertaModel->isEnrolled($modul['id_kelas'], $this->idUsers)) {
            return redirect()->to(base_url('dashboard/peserta/modul'))
                ->with('error', 'Anda tidak terdaftar di kelas ini');
        }

        $materi_list = $this->materiModel->getWithTipe($id_modul);
        $db          = \Config\Database::connect();

        $tugasData = $this->getTugasForPeserta($modul['id_kelas'], $id_modul);
        $hasPendingTugas = $tugasData['has_pending_tugas'] ?? false;

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
                $materi['is_accessible'] = $prevPosttest > 0 && ! $hasPendingTugas;
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

        if (! $materiAktif && ! empty($materi_list)) {
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
            'modul'             => $modul,
            'materi_list'       => $materi_list,
            'materi_aktif'      => $materiAktif,
            'total_materi'      => count($materi_list),
            'has_pretest'       => ! empty($pretestResult),
            'nilai_pre'         => $pretestResult,
            'has_posttest'      => ! empty($posttestResult),
            'nilai_post'        => $posttestResult,
            'materi_selesai'    => ! empty($materiSelesai),
            'tugas_list'        => $tugasData['tugas_list'] ?? [],
            'has_pending_tugas' => $hasPendingTugas,
        ]);
    }

private function hasCompletedAllQuizInKelas(int $idKelas): bool
{
    $db = \Config\Database::connect();

    $materiList = $db->table('materi ma')
        ->select('ma.id_materi, ma.pre_test, ma.post_test')
        ->join('modul mo', 'mo.id_modul = ma.id_modul')
        ->where('mo.id_kelas', $idKelas)
        ->where('ma.deleted_at IS NULL')
        ->where('mo.deleted_at IS NULL')
        ->get()->getResultArray();

    foreach ($materiList as $materi) {

        // Cek pre_test — wajib sudah dikerjakan (nilai berapapun)
        if (! empty($materi['pre_test']) && $materi['pre_test'] !== 'null') {
            $soal = json_decode($materi['pre_test'], true);
            if (! empty($soal)) {
                $done = $db->table('materi_quiz_results')
                    ->where('id_materi', $materi['id_materi'])
                    ->where('id_users', $this->idUsers)
                    ->where('jenis_test', 'pre')
                    ->countAllResults();
                if ($done === 0) return false;
            }
        }

        // Cek post_test — wajib lulus (nilai >= 70)
        if (! empty($materi['post_test']) && $materi['post_test'] !== 'null') {
            $soal = json_decode($materi['post_test'], true);
            if (! empty($soal)) {
                $done = $db->table('materi_quiz_results')
                    ->where('id_materi', $materi['id_materi'])
                    ->where('id_users', $this->idUsers)
                    ->where('jenis_test', 'post')
                    ->where('nilai >=', 70)
                    ->countAllResults();
                if ($done === 0) return false;
            }
        }
    }

    return true;
}

public function submitTugas()
{
    $idTugas = (int) $this->request->getPost('id_tugas');
    if (! $idTugas) {
        return redirect()->back()->with('error', 'Data tugas tidak valid.');
    }

    $tugasModel = new TugasModel();
    $tugas      = $tugasModel->asArray()->find($idTugas);

    if (! $tugas) {
        return redirect()->back()->with('error', 'Tugas tidak ditemukan.');
    }

    if (! $this->kelasPesertaModel->isEnrolled($tugas['id_kelas'], $this->idUsers)) {
        return redirect()->back()->with('error', 'Anda tidak terdaftar di kelas tugas ini.');
    }

    $db = \Config\Database::connect();

    $kelasPeserta = $db->table('kelas_peserta')
        ->where('id_kelas', $tugas['id_kelas'])
        ->where('id_users', $this->idUsers)
        ->where('deleted_at', null)
        ->get()->getRowArray();

    if (! $kelasPeserta) {
        return redirect()->back()->with('error', 'Data pendaftaran kelas tidak ditemukan.');
    }

    // Cek deadline
    if (isset($tugas['deadline_hari']) && ! empty($tugas['deadline_hari'])) {
        $deadlineAt = date('Y-m-d H:i:s', strtotime("+{$tugas['deadline_hari']} days", strtotime($kelasPeserta['tanggal_daftar_kelas_peserta'])));
        if (strtotime($deadlineAt) < time()) {
            return redirect()->back()->with('error', 'Batas waktu pengumpulan tugas telah berakhir.');
        }
    }

    // Cek semua quiz selesai
    if (! $this->hasCompletedAllQuizInKelas($tugas['id_kelas'])) {
        return redirect()->back()->with('error', 'Anda harus menyelesaikan semua pre-test dan post-test pada kelas ini sebelum mengumpulkan tugas.');
    }

    $tipeJawaban = $this->request->getPost('tipe_jawaban');
    if (! in_array($tipeJawaban, ['file', 'text'])) {
        return redirect()->back()->with('error', 'Tipe jawaban tidak valid.');
    }

    $data = [
        'id_tugas'        => $idTugas,
        'id_users'        => $this->idUsers,
        'tipe_jawaban'    => $tipeJawaban,
        'catatan_peserta' => $this->request->getPost('catatan_peserta') ?: null,
        'status'          => 'dikumpulkan',
        'created_at'      => date('Y-m-d H:i:s'),
    ];

    if ($tipeJawaban === 'file') {
        $file = $this->request->getFile('jawaban_file');
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'Silakan unggah file jawaban tugas.');
        }

        $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
        $ext     = strtolower($file->getExtension());
        if (! in_array($ext, $allowed)) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Gunakan PDF, Word, Excel, atau PowerPoint.');
        }
        if ($file->getSize() > 20 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 20 MB.');
        }

        // Simpan sementara ke lokal dulu
        $uploadDir = FCPATH . 'uploads/tugas/tmp/';
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadDir, $newName);
        $tmpPath = $uploadDir . $newName;

        // Load helper
        helper('google_drive');

        // Ambil nama kelas dan nama peserta
        $kelas = $db->table('kelas')
            ->select('nama_kelas')
            ->where('id_kelas', $tugas['id_kelas'])
            ->get()->getRowArray();

        $user = $db->table('users')
            ->select('nama_users')
            ->where('id_users', $this->idUsers)
            ->get()->getRowArray();

        $namaFile = sprintf(
            '%s_%s_%s_%s.%s',
            preg_replace('/[^a-zA-Z0-9]/', '_', $kelas['nama_kelas'] ?? 'kelas'),
            preg_replace('/[^a-zA-Z0-9]/', '_', $user['nama_users'] ?? 'peserta'),
            preg_replace('/[^a-zA-Z0-9]/', '_', $tugas['judul_tugas'] ?? 'tugas'),
            date('Ymd'),
            $ext
        );

        // Upload ke Google Drive (otomatis fallback ke lokal jika gagal)
        $driveConfig = new \Config\GoogleDrive();
        $driveResult = uploadToGoogleDrive(
            $tmpPath,
            $namaFile,
            getMimeType($ext),
            $driveConfig->tugasFolderId
        );

        // Hapus tmp jika masih ada
        @unlink($tmpPath);

        $data['link_file']     = $driveResult['view_link'];
        $data['drive_file_id'] = $driveResult['file_id'];
        $data['jawaban_text']  = null;

        log_message('info', '[submitTugas] File tersimpan di: ' . $driveResult['storage'] . ' | link: ' . $driveResult['view_link']);

    } else {
        $jawabanText = trim($this->request->getPost('jawaban_text'));
        if ($jawabanText === '') {
            return redirect()->back()->with('error', 'Silakan isi jawaban tugas.');
        }

        $deadlineModel = new \App\Models\TugasDeadlinePesertaModel();

        $deadlinePeserta = $deadlineModel->getDeadline(
            $tugas['id_kelas'],
            $this->idUsers
        );

        if ($deadlinePeserta && !empty($deadlinePeserta['deadline_at'])) {

            $deadlineAt = $deadlinePeserta['deadline_at'];

            if (strtotime($deadlineAt) < strtotime(date('Y-m-d H:i:s'))) {
                return redirect()->back()
                    ->with('error', 'Batas waktu pengumpulan tugas telah berakhir.');
            }
        }

        $tipeJawaban = $this->request->getPost('tipe_jawaban');
        if (! in_array($tipeJawaban, ['file', 'text'])) {
            return redirect()->back()->with('error', 'Tipe jawaban tidak valid.');
        }

        $data = [
            'id_tugas'      => $idTugas,
            'id_users'      => $this->idUsers,
            'tipe_jawaban'  => $tipeJawaban,
            'catatan_peserta' => $this->request->getPost('catatan_peserta') ?: null,
            'status'        => 'dikumpulkan',
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        if ($tipeJawaban === 'file') {
            $file = $this->request->getFile('jawaban_file');
            if (! $file || ! $file->isValid() || $file->hasMoved()) {
                return redirect()->back()->with('error', 'Silakan unggah file jawaban tugas.');
            }

            $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
            $ext = strtolower($file->getExtension());
            if (! in_array($ext, $allowed)) {
                return redirect()->back()->with('error', 'Format file tidak didukung. Gunakan PDF, Word, Excel, atau PowerPoint.');
            }
            if ($file->getSize() > 20 * 1024 * 1024) {
                return redirect()->back()->with('error', 'Ukuran file maksimal 20 MB.');
            }

            $uploadDir = FCPATH . 'uploads/tugas/';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $newName = $file->getRandomName();
            $file->move($uploadDir, $newName);
            $data['link_file'] = 'uploads/tugas/' . $newName;
            $data['jawaban_text'] = null;
        } else {
            $jawabanText = trim($this->request->getPost('jawaban_text'));
            if ($jawabanText === '') {
                return redirect()->back()->with('error', 'Silakan isi jawaban tugas.');
            }
            $data['jawaban_text'] = $jawabanText;
            $data['link_file'] = null;
        }

        (new TugasPengumpulanModel())->insert($data);

        return redirect()->back()->with('success', 'Jawaban tugas berhasil dikirim.');
        $data['jawaban_text'] = $jawabanText;
        $data['link_file']    = null;
    }

    (new TugasPengumpulanModel())->insert($data);

    return redirect()->back()->with('success', 'Jawaban tugas berhasil dikirim.');
}

    // =========================================================
    //  TUGAS DETAIL
    // =========================================================
    public function tugasDetail($id_tugas = null)
    {
        if (! $id_tugas) {
            return redirect()->back()->with('error', 'Tugas tidak ditemukan');
        }

        $db = \Config\Database::connect();
        
        // Get tugas detail
        $tugas = $db->table('tugas t')
            ->select('t.*, m.judul_modul, k.nama_kelas, k.id_kelas')
            ->join('kelas k', 'k.id_kelas = t.id_kelas')
            ->join('modul m', 'm.id_modul = t.id_modul', 'left')
            ->where('t.id_tugas', $id_tugas)
            ->where('t.deleted_at', null)
            ->get()->getRowArray();

        if (! $tugas) {
            return redirect()->back()->with('error', 'Tugas tidak ditemukan');
        }

        // Check enrollment
        if (! $this->kelasPesertaModel->isEnrolled($tugas['id_kelas'], $this->idUsers)) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar di kelas ini');
        }

        // Get kelas peserta info
        $kelasPeserta = $db->table('kelas_peserta')
            ->where('id_kelas', $tugas['id_kelas'])
            ->where('id_users', $this->idUsers)
            ->where('deleted_at', null)
            ->get()->getRowArray();

        // Calculate deadline
        $deadlineAt = null;
        $isExpired = false;
        $canSubmit = true;

        if ($tugas['deadline_hari'] !== null && $tugas['deadline_hari'] !== '') {
            $deadlineAt = date('Y-m-d H:i:s', strtotime("+{$tugas['deadline_hari']} days", strtotime($kelasPeserta['tanggal_daftar_kelas_peserta'])));
            $isExpired = strtotime($deadlineAt) < time();
            $canSubmit = ! $isExpired;
        }

        // Check posttest requirement
        if ($tugas['is_wajib_posttest'] && ! $this->hasPassedModulePosttest($tugas['id_modul'])) {
            $canSubmit = false;
        }

        // Get history
        $pengumpulanModel = new TugasPengumpulanModel();
        $history = $pengumpulanModel->getHistory($id_tugas, $this->idUsers);
        $hasSubmission = ! empty($history);

        return view('Dashboard/Peserta/tugas_detail', [
            'tugas'          => $tugas,
            'deadline_at'    => $deadlineAt,
            'is_expired'     => $isExpired,
            'can_submit'     => $canSubmit,
            'has_submission' => $hasSubmission,
            'history'        => $history,
        ]);
    }

    private function getTugasForPeserta(int $idKelas, int $idModul): array
    {
        $db = \Config\Database::connect();

        $kelasPeserta = $db->table('kelas_peserta')
            ->where('id_kelas', $idKelas)
            ->where('id_users', $this->idUsers)
            ->where('deleted_at', null)
            ->get()->getRowArray();

        if (! $kelasPeserta) {
            return ['tugas_list' => [], 'has_pending_tugas' => false];
        }

        $joinDate = $kelasPeserta['tanggal_daftar_kelas_peserta'];
        $hasModulePosttest = $this->hasPassedModulePosttest($idModul);

        $tugasRows = $db->table('tugas t')
            ->where('t.id_kelas', $idKelas)
            ->groupStart()
                ->where('t.id_modul', null)
                ->orWhere('t.id_modul', $idModul)
            ->groupEnd()
            ->where('t.deleted_at', null)
            ->orderBy('t.created_at', 'DESC')
            ->get()->getResultArray();

        $pengumpulanModel = new TugasPengumpulanModel();
        $tugasList = [];
        $hasPending = false;

        foreach ($tugasRows as $task) {
            $deadlineAt = null;
            $isExpired = false;
            if (! empty($task['deadline_hari']) || $task['deadline_hari'] === '0') {
                $deadlineAt = date('Y-m-d H:i:s', strtotime("+{$task['deadline_hari']} days", strtotime($joinDate)));
                $isExpired = strtotime($deadlineAt) < time();
            }

            $history = $pengumpulanModel->getHistory($task['id_tugas'], $this->idUsers);
            $hasSubmission = ! empty($history);
            $canSubmit = ! $isExpired && (! $task['is_wajib_posttest'] || $hasModulePosttest);
            if (! $isExpired && $canSubmit && ! $hasSubmission) {
                $hasPending = true;
            }

            $tugasList[] = array_merge($task, [
                'deadline_at'             => $deadlineAt,
                'is_expired'              => $isExpired,
                'can_submit'              => $canSubmit,
                'has_submission'          => $hasSubmission,
                'last_submission'         => $history[0] ?? null,
                'history'                 => $history,
                'available_after_posttest' => $task['is_wajib_posttest'] && ! $hasModulePosttest,
            ]);
        }

        return ['tugas_list' => $tugasList, 'has_pending_tugas' => $hasPending];
    }

    private function hasPassedModulePosttest(?int $idModul): bool
    {
        if (empty($idModul)) {
            return false;
        }

        $db = \Config\Database::connect();
        return $db->table('materi_quiz_results r')
            ->join('materi m', 'm.id_materi = r.id_materi')
            ->where('m.id_modul', $idModul)
            ->where('r.id_users', $this->idUsers)
            ->where('r.jenis_test', 'post')
            ->where('r.nilai >=', 70)  // ← Pastikan nilai >= 70
            ->countAllResults() > 0;
    }

    // =========================================================
    //  SELESAI MATERI (AJAX)
    // =========================================================
    public function selesaiMateri()
    {
        log_message('debug', '[selesaiMateri] START');
        log_message('debug', '[selesaiMateri] Is AJAX: ' . ($this->request->isAJAX() ? 'true' : 'false'));
        log_message('debug', '[selesaiMateri] Session ID User: ' . (isset($this->idUsers) ? $this->idUsers : 'NOT SET'));

        if (! $this->request->isAJAX()) {
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
        if (! $id_materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        $materi = $this->materiModel->getDetail($id_materi);

        if (! $materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        if (! $this->kelasPesertaModel->isEnrolled($materi['id_kelas'], $this->idUsers)) {
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
            'has_pretest'    => ! empty($pretestResult),
            'nilai_pre'      => $pretestResult,
            'has_posttest'   => ! empty($posttestResult),
            'nilai_post'     => $posttestResult,
            'materi_selesai' => ! empty($materiSelesai),
        ]);
    }

    // =========================================================
    //  PRETEST
    // =========================================================
    public function pretest($id_materi = null)
    {
        if (! $id_materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        $materi = $this->materiModel->getDetail($id_materi);

        if (! $materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        if (! $this->kelasPesertaModel->isEnrolled($materi['id_kelas'], $this->idUsers)) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Anda tidak memiliki akses ke materi ini');
        }

        $soal = [];
        if (! empty($materi['pre_test'])) {
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

        $redirect = $this->request->getGet('redirect') ?? base_url('Dashboard/Peserta/materi-modul/' . $materi['id_modul']);

        return view('Dashboard/Peserta/pretest_view', [
            'materi'      => $materi,
            'soal'        => $soal,
            'has_pretest' => ! empty($pretestResult),
            'nilai_pre'   => $pretestResult,
            'redirect'    => $redirect,
        ]);
    }

    // =========================================================
    //  POSTTEST
    // =========================================================
    public function posttest($id_materi = null)
    {
        if (! $id_materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        $materi = $this->materiModel->getDetail($id_materi);

        if (! $materi) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Materi tidak ditemukan');
        }

        if (! $this->kelasPesertaModel->isEnrolled($materi['id_kelas'], $this->idUsers)) {
            return redirect()->to(base_url('dashboard/peserta/materi-list'))
                ->with('error', 'Anda tidak memiliki akses ke materi ini');
        }

        $materiSelesai = $this->userMateriProgressModel
            ->isCompleted($this->idUsers, $id_materi);

        if (! $materiSelesai) {
            return redirect()->back()->with('error', 'Selesaikan materi terlebih dahulu sebelum mengerjakan post-test');
        }

        $soal = [];
        if (! empty($materi['post_test'])) {
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

        $redirect = $this->request->getGet('redirect') ?? base_url('Dashboard/Peserta/materi-modul/' . $materi['id_modul']);

        return view('Dashboard/Peserta/posttest_view', [
            'materi'       => $materi,
            'soal'         => $soal,
            'has_posttest' => ! empty($posttestResult),
            'nilai_post'   => $posttestResult,
            'redirect'     => $redirect,
        ]);
    }

    // =========================================================
    //  SIMPAN HASIL QUIZ MATERI (AJAX)
    // =========================================================
    public function simpanHasilQuizMateri()
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $idMateri    = (int) $this->request->getPost('id_materi');
        $jenisTest   = $this->request->getPost('jenis_test');
        $nilai       = (int) $this->request->getPost('nilai');
        $jumlahBenar = (int) $this->request->getPost('jumlah_benar');
        $jumlahSalah = (int) $this->request->getPost('jumlah_salah');
        $jawaban     = $this->request->getPost('jawaban_peserta');
        $redirect    = $this->request->getPost('redirect');

        if (! $idMateri || ! in_array($jenisTest, ['pre', 'post'])) {
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
    // =========================================================
    //  APLIKASI PENDUKUNG
    // =========================================================
    public function aplikasi()
    {
        $userId = session()->get('id_users');
        
        $aplikasi = $this->aplikasiUserModel
            ->select('aplikasi_pendukung.*')
            ->join('aplikasi_pendukung', 'aplikasi_pendukung.id_aplikasi = aplikasi_user.id_aplikasi')
            ->where('aplikasi_user.id_users', $userId)
            ->findAll();
        
        // Jika tidak ada akses spesifik, tampilkan semua aplikasi
        if (empty($aplikasi)) {
            $aplikasi = $this->aplikasiModel->findAll();
        }
        
        return view('dashboard/peserta/aplikasi_pendukung', [
            'title' => 'Aplikasi Pendukung',
            'aplikasi' => $aplikasi
        ]);
    }

    public function aplikasiPendukung()
    {
        return $this->aplikasi();
    }
}