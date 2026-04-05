<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\ModulModel;
use App\Models\MateriModel;
use App\Models\QuizModel;

class DashboardPengajar extends BaseController
{
    // ══════════════════════════════════════════════════════════════════════
    //  HELPER
    // ══════════════════════════════════════════════════════════════════════
    private function guardPengajar()
    {
        if (session()->get('role') !== 'pengajar') {
            return redirect()->to('/dashboard');
        }
        return null;
    }

    private function myId(): int
    {
        return (int) session()->get('id_users');
    }

    private function jsonResponse(array $data, int $status = 200)
    {
        return $this->response
            ->setStatusCode($status)
            ->setContentType('application/json')
            ->setBody(json_encode($data));
    }

    // ══════════════════════════════════════════════════════════════════════
    //  BERANDA
    // ══════════════════════════════════════════════════════════════════════
    public function beranda()
    {
        if ($r = $this->guardPengajar()) return $r;

        $db  = \Config\Database::connect();
        $uid = $this->myId();

        $total_kelas  = $db->table('kelas')->where('id_users', $uid)->countAllResults();

        $total_modul  = $db->query("
            SELECT COUNT(*) AS total FROM modul m
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users = {$uid} AND m.deleted_at IS NULL
        ")->getRow()->total;

        $total_materi = $db->query("
            SELECT COUNT(*) AS total FROM materi mt
            JOIN modul m ON m.id_modul = mt.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users = {$uid} AND mt.deleted_at IS NULL
        ")->getRow()->total;

        $total_quiz   = $db->query("
            SELECT COUNT(*) AS total FROM quiz q
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users = {$uid} AND q.deleted_at IS NULL
        ")->getRow()->total;

        $total_peserta = $db->table('users')
            ->where('role_users', 'peserta')
            ->where('deleted_at IS NULL')
            ->countAllResults();

        $dist_lulus = $db->query("
            SELECT COUNT(*) AS total FROM quiz_results qr
            JOIN quiz q ON q.id_quiz = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users = {$uid} AND qr.nilai_quiz_results >= 70 AND qr.deleted_at IS NULL
        ")->getRow()->total;

        $dist_cukup = $db->query("
            SELECT COUNT(*) AS total FROM quiz_results qr
            JOIN quiz q ON q.id_quiz = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users = {$uid}
              AND qr.nilai_quiz_results >= 50 AND qr.nilai_quiz_results < 70
              AND qr.deleted_at IS NULL
        ")->getRow()->total;

        $dist_kurang = $db->query("
            SELECT COUNT(*) AS total FROM quiz_results qr
            JOIN quiz q ON q.id_quiz = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users = {$uid} AND qr.nilai_quiz_results < 50 AND qr.deleted_at IS NULL
        ")->getRow()->total;

        $leaderboard = $db->query("
            SELECT u.nama_users, k.nama_kelas,
                   ROUND(AVG(qr.nilai_quiz_results), 1) AS rata_nilai,
                   COUNT(qr.id_quiz_results) AS total_quiz_dikerjakan
            FROM quiz_results qr
            JOIN users u ON u.id_users = qr.id_users
            JOIN quiz  q ON q.id_quiz  = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users = {$uid} AND u.role_users = 'peserta'
              AND u.deleted_at IS NULL AND qr.deleted_at IS NULL
            GROUP BY u.id_users, u.nama_users, k.id_kelas, k.nama_kelas
            ORDER BY rata_nilai DESC LIMIT 5
        ")->getResultArray();

        $aktivitas_terbaru = $db->query("
            SELECT u.nama_users, q.judul_quiz, k.nama_kelas,
                   qr.nilai_quiz_results, qr.waktu_selesai_quiz_results
            FROM quiz_results qr
            JOIN users u ON u.id_users = qr.id_users
            JOIN quiz  q ON q.id_quiz  = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users = {$uid} AND qr.deleted_at IS NULL
            ORDER BY qr.waktu_selesai_quiz_results DESC LIMIT 6
        ")->getResultArray();

        return view('Dashboard/Pengajar/beranda', [
            'nama_pengajar'     => session()->get('nama'),
            'total_peserta'     => $total_peserta,
            'total_kelas'       => $total_kelas,
            'total_modul'       => $total_modul,
            'total_materi'      => $total_materi,
            'total_quiz'        => $total_quiz,
            'dist_lulus'        => $dist_lulus,
            'dist_cukup'        => $dist_cukup,
            'dist_kurang'       => $dist_kurang,
            'leaderboard'       => $leaderboard,
            'aktivitas_terbaru' => $aktivitas_terbaru,
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  KELAS
    // ══════════════════════════════════════════════════════════════════════
    public function kelas()
    {
        if ($r = $this->guardPengajar()) return $r;

        $db     = \Config\Database::connect();
        $uid    = $this->myId();
        $search = $this->request->getGet('search');

        $sql = "
            SELECT k.*,
                COUNT(DISTINCT m.id_modul)          AS total_modul,
                COUNT(DISTINCT mt.id_materi)        AS total_materi,
                COUNT(DISTINCT kp.id_kelas_peserta) AS total_peserta
            FROM kelas k
            LEFT JOIN modul m          ON m.id_kelas  = k.id_kelas  AND m.deleted_at  IS NULL
            LEFT JOIN materi mt        ON mt.id_modul = m.id_modul  AND mt.deleted_at IS NULL
            LEFT JOIN kelas_peserta kp ON kp.id_kelas = k.id_kelas
            WHERE k.id_users = {$uid} AND k.deleted_at IS NULL
        ";

        if ($search) {
            $safe = $db->escapeString($search);
            $sql .= " AND k.nama_kelas LIKE '%{$safe}%'";
        }

        $sql .= " GROUP BY k.id_kelas ORDER BY k.created_at DESC";

        $semua_peserta = $db->table('users')
            ->select('id_users, nama_users, email_users')
            ->where('role_users', 'peserta')
            ->where('deleted_at IS NULL')
            ->orderBy('nama_users')
            ->get()->getResultArray();

        return view('Dashboard/Pengajar/kelas', [
            'kelas_list'    => $db->query($sql)->getResultArray(),
            'search'        => $search,
            'semua_peserta' => $semua_peserta,
        ]);
    }

    public function kelasStore()
    {
        if ($r = $this->guardPengajar()) return $r;

        $rules = [
            'nama_kelas'      => 'required|min_length[3]|max_length[150]',
            'deskripsi_kelas' => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new KelasModel())->insert([
            'nama_kelas'      => $this->request->getPost('nama_kelas'),
            'deskripsi_kelas' => $this->request->getPost('deskripsi_kelas'),
            'id_users'        => $this->myId(),
        ]);

        return redirect()->to('/dashboard/pengajar/kelas')->with('success', 'Kelas berhasil dibuat.');
    }

    public function kelasUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) return $r;

        $model = new KelasModel();
        if (!$this->isMyKelas($model, $id)) {
            return redirect()->to('/dashboard/pengajar/kelas')->with('error', 'Kelas tidak ditemukan.');
        }

        $rules = [
            'nama_kelas'      => 'required|min_length[3]|max_length[150]',
            'deskripsi_kelas' => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'nama_kelas'      => $this->request->getPost('nama_kelas'),
            'deskripsi_kelas' => $this->request->getPost('deskripsi_kelas'),
        ]);

        return redirect()->to('/dashboard/pengajar/kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function kelasDelete(int $id)
    {
        if ($r = $this->guardPengajar()) return $r;

        $model = new KelasModel();
        if (!$this->isMyKelas($model, $id)) {
            return redirect()->to('/dashboard/pengajar/kelas')->with('error', 'Kelas tidak ditemukan.');
        }

        $model->delete($id);
        return redirect()->to('/dashboard/pengajar/kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  KELAS PESERTA — AJAX endpoints
    // ══════════════════════════════════════════════════════════════════════
    public function kelasPesertaList(int $idKelas)
    {
        if ($r = $this->guardPengajar()) return $r;

        if (!$this->isMyKelas(new KelasModel(), $idKelas)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Kelas tidak ditemukan.'], 403);
        }

        $db      = \Config\Database::connect();
        $peserta = $db->table('kelas_peserta kp')
            ->select('kp.id_kelas_peserta, kp.tanggal_daftar_kelas_peserta,
                      u.id_users, u.nama_users, u.email_users')
            ->join('users u', 'u.id_users = kp.id_users')
            ->where('kp.id_kelas', $idKelas)
            ->where('u.deleted_at IS NULL')
            ->orderBy('u.nama_users')
            ->get()->getResultArray();

        return $this->jsonResponse(['success' => true, 'peserta' => $peserta]);
    }

    public function kelasPesertaStore()
    {
        if ($r = $this->guardPengajar()) return $r;

        $idKelas = (int) $this->request->getPost('id_kelas');
        $idUser  = (int) $this->request->getPost('id_users');

        if (!$idKelas || !$idUser) {
            return $this->jsonResponse(['success' => false, 'message' => 'Data tidak lengkap.'], 422);
        }

        if (!$this->isMyKelas(new KelasModel(), $idKelas)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Kelas tidak ditemukan.'], 403);
        }

        $db   = \Config\Database::connect();
        $user = $db->table('users')
            ->where('id_users', $idUser)
            ->where('role_users', 'peserta')
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();

        if (!$user) {
            return $this->jsonResponse(['success' => false, 'message' => 'Pengguna tidak valid.'], 422);
        }

        $ada = $db->table('kelas_peserta')
            ->where('id_kelas', $idKelas)
            ->where('id_users', $idUser)
            ->countAllResults();

        if ($ada > 0) {
            return $this->jsonResponse([
                'success' => false,
                'message' => "{$user['nama_users']} sudah terdaftar di kelas ini."
            ], 422);
        }

        $db->table('kelas_peserta')->insert([
            'id_kelas'                     => $idKelas,
            'id_users'                     => $idUser,
            'tanggal_daftar_kelas_peserta' => date('Y-m-d H:i:s'),
        ]);

        return $this->jsonResponse([
            'success' => true,
            'message' => "{$user['nama_users']} berhasil ditambahkan ke kelas."
        ]);
    }

    public function kelasPesertaKick(int $idKP)
    {
        if ($r = $this->guardPengajar()) return $r;

        $db  = \Config\Database::connect();
        $row = $db->table('kelas_peserta kp')
            ->select('kp.*, u.nama_users, k.id_users AS pengajar_id')
            ->join('kelas k', 'k.id_kelas = kp.id_kelas')
            ->join('users u', 'u.id_users = kp.id_users')
            ->where('kp.id_kelas_peserta', $idKP)
            ->get()->getRowArray();

        if (!$row || (int) $row['pengajar_id'] !== $this->myId()) {
            return $this->jsonResponse(['success' => false, 'message' => 'Data tidak ditemukan.'], 403);
        }

        $db->table('kelas_peserta')->where('id_kelas_peserta', $idKP)->delete();

        return $this->jsonResponse([
            'success' => true,
            'message' => "{$row['nama_users']} berhasil dikeluarkan dari kelas."
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  MODUL
    // ══════════════════════════════════════════════════════════════════════
    public function modul()
    {
        if ($r = $this->guardPengajar()) return $r;

        $db     = \Config\Database::connect();
        $uid    = $this->myId();
        $search = $this->request->getGet('search');

        $query = $db->table('modul m')
            ->select('m.*, k.nama_kelas, COUNT(mt.id_materi) AS total_materi')
            ->join('kelas k',   'k.id_kelas = m.id_kelas')
            ->join('materi mt', 'mt.id_modul = m.id_modul AND mt.deleted_at IS NULL', 'left')
            ->where('k.id_users', $uid)
            ->where('m.deleted_at IS NULL')
            ->groupBy('m.id_modul');

        if ($search) $query->like('m.judul_modul', $search);

        return view('Dashboard/Pengajar/modul', [
            'modul'  => $query->get()->getResultArray(),
            'kelas'  => (new KelasModel())->where('id_users', $uid)->findAll(),
            'search' => $search,
        ]);
    }

    public function modulStore()
    {
        if ($r = $this->guardPengajar()) return $r;

        $rules = [
            'id_kelas'     => 'required|is_natural_no_zero',
            'judul_modul'  => 'required|min_length[3]|max_length[150]',
            'urutan_modul' => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idKelas = (int) $this->request->getPost('id_kelas');
        if (!$this->isMyKelas(new KelasModel(), $idKelas)) {
            return redirect()->back()->with('error', 'Kelas tidak valid.');
        }

        (new ModulModel())->insert([
            'id_kelas'     => $idKelas,
            'judul_modul'  => $this->request->getPost('judul_modul'),
            'urutan_modul' => $this->request->getPost('urutan_modul') ?: 1,
        ]);

        return redirect()->to('/dashboard/pengajar/modul')->with('success', 'Modul berhasil ditambahkan.');
    }

    public function modulUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) return $r;

        $modulModel = new ModulModel();
        $modul      = $modulModel->find($id);

        if (!$modul || !$this->isMyKelas(new KelasModel(), $modul['id_kelas'])) {
            return redirect()->to('/dashboard/pengajar/modul')->with('error', 'Modul tidak ditemukan.');
        }

        $rules = [
            'judul_modul'  => 'required|min_length[3]|max_length[150]',
            'urutan_modul' => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $modulModel->update($id, [
            'judul_modul'  => $this->request->getPost('judul_modul'),
            'urutan_modul' => $this->request->getPost('urutan_modul') ?: $modul['urutan_modul'],
        ]);

        return redirect()->to('/dashboard/pengajar/modul')->with('success', 'Modul berhasil diperbarui.');
    }

    public function modulDelete(int $id)
    {
        if ($r = $this->guardPengajar()) return $r;

        $modulModel = new ModulModel();
        $modul      = $modulModel->find($id);

        if (!$modul || !$this->isMyKelas(new KelasModel(), $modul['id_kelas'])) {
            return redirect()->to('/dashboard/pengajar/modul')->with('error', 'Modul tidak ditemukan.');
        }

        $modulModel->delete($id);
        return redirect()->to('/dashboard/pengajar/modul')->with('success', 'Modul berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  MATERI
    // ══════════════════════════════════════════════════════════════════════
    public function materi()
    {
        if ($r = $this->guardPengajar()) return $r;

        $db     = \Config\Database::connect();
        $uid    = $this->myId();
        $search = $this->request->getGet('search');

        $query = $db->table('materi mt')
            ->select('mt.*, m.judul_modul, k.nama_kelas, k.id_kelas,
                      (mt.post_test IS NOT NULL AND mt.post_test != "") AS has_post_test,
                      (mt.pre_test  IS NOT NULL AND mt.pre_test  != "") AS has_pre_test')
            ->join('modul m', 'm.id_modul = mt.id_modul')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('k.id_users', $uid)
            ->where('mt.deleted_at IS NULL')
            ->orderBy('k.id_kelas, m.urutan_modul, mt.id_materi');

        if ($search) $query->like('mt.judul_materi', $search);

        $modul = $db->table('modul m')
            ->select('m.id_modul, m.judul_modul, k.nama_kelas')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('k.id_users', $uid)
            ->where('m.deleted_at IS NULL')
            ->orderBy('k.id_kelas, m.urutan_modul')
            ->get()->getResultArray();

        return view('Dashboard/Pengajar/materi', [
            'materi' => $query->get()->getResultArray(),
            'modul'  => $modul,
            'search' => $search,
        ]);
    }

    public function materiStore()
    {
        if ($r = $this->guardPengajar()) return $r;

        $rules = [
            'id_modul'     => 'required|is_natural_no_zero',
            'judul_materi' => 'required|min_length[3]|max_length[200]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idModul = (int) $this->request->getPost('id_modul');
        if (!$this->isMyModul($idModul)) {
            return redirect()->back()->with('error', 'Modul tidak valid.');
        }

        $filePath = null;
        $filePdf  = $this->request->getFile('file_materi');
        if ($filePdf && $filePdf->isValid() && !$filePdf->hasMoved()) {
            if ($filePdf->getExtension() !== 'pdf') {
                return redirect()->back()->withInput()->with('error', 'File harus berformat PDF.');
            }
            if ($filePdf->getSize() > 10 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Ukuran file PDF maksimal 10 MB.');
            }
            $newName = $filePdf->getRandomName();
            $filePdf->move(FCPATH . 'uploads/materi', $newName);
            $filePath = 'uploads/materi/' . $newName;
        }

        (new MateriModel())->insert([
            'id_modul'         => $idModul,
            'judul_materi'     => $this->request->getPost('judul_materi'),
            'pre_test'         => $this->buildQuizJsonFor('pre_test'),   // ← JSON quiz soal
            'file_materi'      => $filePath,
            'video_url_materi' => $this->request->getPost('video_url_materi') ?: null,
            'post_test'        => $this->buildQuizJsonFor('post_test'),  // ← JSON quiz soal
        ]);

        return redirect()->to('/dashboard/pengajar/materi')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function materiUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) return $r;

        $materiModel = new MateriModel();
        $materi      = $materiModel->find($id);

        if (!$materi || !$this->isMyModul($materi['id_modul'])) {
            return redirect()->to('/dashboard/pengajar/materi')->with('error', 'Materi tidak ditemukan.');
        }

        $rules = [
            'judul_materi' => 'required|min_length[3]|max_length[200]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = $materi['file_materi'];
        $filePdf  = $this->request->getFile('file_materi');
        if ($filePdf && $filePdf->isValid() && !$filePdf->hasMoved()) {
            if ($filePdf->getExtension() !== 'pdf') {
                return redirect()->back()->withInput()->with('error', 'File harus berformat PDF.');
            }
            if ($filePdf->getSize() > 10 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Ukuran file PDF maksimal 10 MB.');
            }
            if ($materi['file_materi'] && file_exists(FCPATH . $materi['file_materi'])) {
                @unlink(FCPATH . $materi['file_materi']);
            }
            $newName = $filePdf->getRandomName();
            $filePdf->move(FCPATH . 'uploads/materi', $newName);
            $filePath = 'uploads/materi/' . $newName;
        }

        // Jika soal tidak dikirim ulang, pertahankan nilai lama
        $preTestJson  = $this->buildQuizJsonFor('pre_test');
        $postTestJson = $this->buildQuizJsonFor('post_test');

        $materiModel->update($id, [
            'judul_materi'     => $this->request->getPost('judul_materi'),
            'pre_test'         => $preTestJson  ?? $materi['pre_test'],
            'file_materi'      => $filePath,
            'video_url_materi' => $this->request->getPost('video_url_materi') ?: null,
            'post_test'        => $postTestJson ?? $materi['post_test'],
        ]);

        return redirect()->to('/dashboard/pengajar/materi')->with('success', 'Materi berhasil diperbarui.');
    }

    public function materiDelete(int $id)
    {
        if ($r = $this->guardPengajar()) return $r;

        $materiModel = new MateriModel();
        $materi      = $materiModel->find($id);

        if (!$materi || !$this->isMyModul($materi['id_modul'])) {
            return redirect()->to('/dashboard/pengajar/materi')->with('error', 'Materi tidak ditemukan.');
        }

        if ($materi['file_materi'] && file_exists(FCPATH . $materi['file_materi'])) {
            @unlink(FCPATH . $materi['file_materi']);
        }

        $materiModel->delete($id);
        return redirect()->to('/dashboard/pengajar/materi')->with('success', 'Materi berhasil dihapus.');
    }

    public function materiList()
    {
        if ($r = $this->guardPengajar()) return $r;

        $db  = \Config\Database::connect();
        $uid = $this->myId();

        $materi = $db->table('materi mt')
            ->select('mt.*, m.judul_modul, k.nama_kelas,
                      (mt.post_test IS NOT NULL AND mt.post_test != "") AS has_post_test,
                      (mt.pre_test  IS NOT NULL AND mt.pre_test  != "") AS has_pre_test')
            ->join('modul m', 'm.id_modul = mt.id_modul')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('k.id_users', $uid)
            ->where('mt.deleted_at IS NULL')
            ->orderBy('k.id_kelas, m.urutan_modul, mt.id_materi')
            ->get()->getResultArray();

        $modul = $db->table('modul m')
            ->select('m.id_modul, m.judul_modul, k.nama_kelas')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('k.id_users', $uid)
            ->where('m.deleted_at IS NULL')
            ->orderBy('k.id_kelas, m.urutan_modul')
            ->get()->getResultArray();

        return view('Dashboard/Pengajar/materi', [
            'materi'      => $materi,
            'modul'       => $modul,
            'search'      => null,
            'materi_list' => $materi,
            'total'       => count($materi),
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  QUIZ
    // ══════════════════════════════════════════════════════════════════════
    public function quiz()
    {
        if ($r = $this->guardPengajar()) return $r;

        $db     = \Config\Database::connect();
        $uid    = $this->myId();
        $search = $this->request->getGet('search');

        $query = $db->table('quiz q')
            ->select('q.*, m.judul_modul, k.nama_kelas')
            ->join('modul m', 'm.id_modul = q.id_modul')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('k.id_users', $uid)
            ->where('q.deleted_at IS NULL');

        if ($search) $query->like('q.judul_quiz', $search);

        return view('Dashboard/Pengajar/Quiz/index', [
            'quiz_list'  => $query->get()->getResultArray(),
            'modul_list' => $db->table('modul m')
                ->select('m.id_modul, m.judul_modul, k.nama_kelas')
                ->join('kelas k', 'k.id_kelas = m.id_kelas')
                ->where('k.id_users', $uid)
                ->where('m.deleted_at IS NULL')
                ->get()->getResultArray(),
            'search' => $search,
        ]);
    }

    public function quizStore()
    {
        if ($r = $this->guardPengajar()) return $r;

        $rules = [
            'id_modul'    => 'required|is_natural_no_zero',
            'judul_quiz'  => 'required|min_length[3]|max_length[200]',
            'durasi_quiz' => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idModul = (int) $this->request->getPost('id_modul');
        if (!$this->isMyModul($idModul)) {
            return redirect()->back()->with('error', 'Modul tidak valid.');
        }

        (new QuizModel())->insert([
            'id_modul'    => $idModul,
            'judul_quiz'  => $this->request->getPost('judul_quiz'),
            'durasi_quiz' => $this->request->getPost('durasi_quiz') ?: null,
        ]);

        return redirect()->to('/dashboard/pengajar/quiz')->with('success', 'Quiz berhasil ditambahkan.');
    }

    public function quizUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) return $r;

        $quizModel = new QuizModel();
        $quiz      = $quizModel->find($id);

        if (!$quiz || !$this->isMyModul($quiz['id_modul'])) {
            return redirect()->to('/dashboard/pengajar/quiz')->with('error', 'Quiz tidak ditemukan.');
        }

        $rules = [
            'judul_quiz'  => 'required|min_length[3]|max_length[200]',
            'durasi_quiz' => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $quizModel->update($id, [
            'judul_quiz'  => $this->request->getPost('judul_quiz'),
            'durasi_quiz' => $this->request->getPost('durasi_quiz') ?: null,
        ]);

        return redirect()->to('/dashboard/pengajar/quiz')->with('success', 'Quiz berhasil diperbarui.');
    }

    public function quizDelete(int $id)
    {
        if ($r = $this->guardPengajar()) return $r;

        $quizModel = new QuizModel();
        $quiz      = $quizModel->find($id);

        if (!$quiz || !$this->isMyModul($quiz['id_modul'])) {
            return redirect()->to('/dashboard/pengajar/quiz')->with('error', 'Quiz tidak ditemukan.');
        }

        $quizModel->delete($id);
        return redirect()->to('/dashboard/pengajar/quiz')->with('success', 'Quiz berhasil dihapus.');
    }

    public function quizHasil(int $idQuiz)
    {
        if ($r = $this->guardPengajar()) return $r;

        $db   = \Config\Database::connect();
        $quiz = (new QuizModel())->find($idQuiz);

        if (!$quiz || !$this->isMyModul($quiz['id_modul'])) {
            return redirect()->to('/dashboard/pengajar/quiz')->with('error', 'Quiz tidak ditemukan.');
        }

        $hasil = $db->query("
            SELECT u.nama_users, qr.nilai_quiz_results, qr.waktu_selesai_quiz_results
            FROM quiz_results qr
            JOIN users u ON u.id_users = qr.id_users
            WHERE qr.id_quiz = {$idQuiz} AND qr.deleted_at IS NULL
            ORDER BY qr.waktu_selesai_quiz_results DESC
        ")->getResultArray();

        return view('Dashboard/Pengajar/Quiz/hasil', ['quiz' => $quiz, 'hasil' => $hasil]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  PROFIL
    // ══════════════════════════════════════════════════════════════════════
    public function profil()
    {
        if ($r = $this->guardPengajar()) return $r;

        return view('Dashboard/Pengajar/profil', [
            'user' => \Config\Database::connect()
                ->table('users')->where('id_users', $this->myId())->get()->getRowArray(),
        ]);
    }

    public function profilUpdate()
    {
        if ($r = $this->guardPengajar()) return $r;

        $id    = $this->myId();
        $rules = [
            'nama_users'  => 'required|min_length[3]|max_length[100]',
            'email_users' => "required|valid_email|is_unique[users.email_users,id_users,{$id}]",
        ];

        if ($this->request->getPost('password')) {
            $rules['password']         = 'min_length[6]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_users'  => $this->request->getPost('nama_users'),
            'email_users' => $this->request->getPost('email_users'),
        ];

        if ($this->request->getPost('password')) {
            $data['password_users'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        \Config\Database::connect()->table('users')->where('id_users', $id)->update($data);
        session()->set('nama_users', $data['nama_users']);

        return redirect()->to('/dashboard/pengajar/profil')->with('success', 'Profil berhasil diperbarui.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  PESERTA
    // ══════════════════════════════════════════════════════════════════════
    public function peserta()
    {
        if ($r = $this->guardPengajar()) return $r;

        $pengajarId = $this->myId();
        $db         = \Config\Database::connect();

        $peserta = $db->table('kelas_peserta kp')
            ->select('u.id_users, u.nama_users, u.email_users, k.id_kelas, k.nama_kelas,
                      kp.tanggal_daftar_kelas_peserta,
                      ROUND(AVG(qr.nilai_quiz_results)) AS rata_nilai,
                      COUNT(DISTINCT qr.id_quiz_results) AS jumlah_quiz')
            ->join('kelas k',         'k.id_kelas = kp.id_kelas')
            ->join('users u',         'u.id_users = kp.id_users')
            ->join('quiz_results qr', 'qr.id_users = u.id_users', 'left')
            ->where('k.id_users',   $pengajarId)
            ->where('u.role_users', 'peserta')
            ->groupBy('kp.id_kelas_peserta')
            ->orderBy('k.id_kelas, u.nama_users')
            ->get()->getResultObject();

        $kelasList = $db->table('kelas k')
            ->select('k.id_kelas, k.nama_kelas, COUNT(kp.id_kelas_peserta) AS jumlah_peserta')
            ->join('kelas_peserta kp', 'kp.id_kelas = k.id_kelas', 'left')
            ->join('users u', "u.id_users = kp.id_users AND u.role_users = 'peserta'", 'left')
            ->where('k.id_users', $pengajarId)
            ->groupBy('k.id_kelas')
            ->orderBy('k.nama_kelas')
            ->get()->getResultObject();

        $pesertaArr       = (array) $peserta;
        $totalPeserta     = count($pesertaArr);
        $totalQuizResults = array_sum(array_column($pesertaArr, 'jumlah_quiz'));
        $nilaiArr         = array_filter(array_column($pesertaArr, 'rata_nilai'));
        $rataRataNilai    = count($nilaiArr) > 0 ? round(array_sum($nilaiArr) / count($nilaiArr)) : 0;

        return view('dashboard/pengajar/peserta', [
            'title'            => 'Daftar Peserta',
            'peserta'          => $peserta,
            'kelasList'        => $kelasList,
            'totalPeserta'     => $totalPeserta,
            'totalQuizResults' => $totalQuizResults,
            'rataRataNilai'    => $rataRataNilai,
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ══════════════════════════════════════════════════════════════════════
    private function isMyKelas(KelasModel $model, int $idKelas): bool
    {
        $kelas = $model->find($idKelas);
        return $kelas && (int) $kelas['id_users'] === $this->myId();
    }

    private function isMyModul(int $idModul): bool
    {
        $row = \Config\Database::connect()
            ->table('modul m')
            ->select('k.id_users')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('m.id_modul', $idModul)
            ->where('m.deleted_at IS NULL')
            ->get()->getRowArray();

        return $row && (int) $row['id_users'] === $this->myId();
    }

    /**
     * Build JSON quiz array from POST field.
     * Used for both pre_test and post_test.
     *
     * @param string $field  POST key: 'pre_test' | 'post_test'
     * @return string|null   JSON string or null if no valid soal
     */
    private function buildQuizJsonFor(string $field): ?string
    {
        $rawQuiz = $this->request->getPost($field);
        if (empty($rawQuiz) || !is_array($rawQuiz)) return null;

        $soalList = [];
        foreach ($rawQuiz as $item) {
            $pertanyaan = trim($item['pertanyaan'] ?? '');
            $pilihan    = $item['pilihan'] ?? [];
            $jawaban    = (int) ($item['jawaban_benar'] ?? 0);
            if ($pertanyaan === '' || count($pilihan) < 2) continue;
            $soalList[] = [
                'pertanyaan'    => $pertanyaan,
                'pilihan'       => array_values($pilihan),
                'jawaban_benar' => $jawaban,
            ];
        }

        return count($soalList) > 0
            ? json_encode($soalList, JSON_UNESCAPED_UNICODE)
            : null;
    }

    /**
     * @deprecated Gunakan buildQuizJsonFor('post_test') sebagai gantinya.
     */
    private function buildQuizJson(): ?string
    {
        return $this->buildQuizJsonFor('post_test');
    }
}