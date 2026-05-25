<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\ModulModel;
use App\Models\TugasModel;
use App\Models\VoucherModel;
use App\Models\TugasPengumpulanModel;
use App\Models\TugasKomentarModel;
use App\Models\AplikasiPendukungModel;

class DashboardPengajar extends BaseController
{
    // ══════════════════════════════════════════════════════════════════════
    //  HELPER METHODS
    // ══════════════════════════════════════════════════════════════════════
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\Users();
    }

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

    /**
     * Cek apakah kelas milik pengajar yang sedang login
     */
    private function isMyKelas(KelasModel $model, int $idKelas): bool
    {
        if ($idKelas <= 0) {
            return false;
        }

        $kelas = $model
            ->where('id_users', $this->myId())
            ->where('id_kelas', $idKelas)
            ->where('deleted_at IS NULL')
            ->first();

        return $kelas !== null;
    }

    /**
     * Cek apakah modul milik pengajar yang sedang login
     */
    private function isMyModul(int $idModul): bool
    {
        if ($idModul <= 0) {
            return false;
        }

        $db = \Config\Database::connect();
        $count = $db->table('modul m')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('m.id_modul', $idModul)
            ->where('k.id_users', $this->myId())
            ->where('m.deleted_at IS NULL')
            ->where('k.deleted_at IS NULL')
            ->countAllResults();

        return $count > 0;
    }

    /**
     * Ambil data voucher milik pengajar yang login
     */
    private function getMyVoucher(int $idVoucher)
    {
        $db = \Config\Database::connect();
        return $db->table('voucher v')
            ->join('kelas k', 'k.id_kelas = v.id_kelas')
            ->where('v.id_voucher', $idVoucher)
            ->where('k.id_users', $this->myId())
            ->where('v.deleted_at IS NULL')
            ->get()->getRowArray();
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
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db = \Config\Database::connect();
        $uid = $this->myId();

        $total_kelas = $db->table('kelas')
            ->where('id_users', $uid)
            ->where('deleted_at IS NULL')
            ->countAllResults();

        $total_modul = $db->query("
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

        $total_peserta = $db->table('users')
            ->where('role_users', 'peserta')
            ->where('deleted_at IS NULL')
            ->countAllResults();

        $kelas_list = $db->query("
            SELECT k.id_kelas, k.nama_kelas,
                   COUNT(DISTINCT m.id_modul)          AS jumlah_modul,
                   COUNT(DISTINCT kp.id_kelas_peserta) AS jumlah_peserta
            FROM kelas k
            LEFT JOIN modul m          ON m.id_kelas  = k.id_kelas AND m.deleted_at IS NULL
            LEFT JOIN kelas_peserta kp ON kp.id_kelas = k.id_kelas
            WHERE k.id_users = {$uid} AND k.deleted_at IS NULL
            GROUP BY k.id_kelas
            ORDER BY k.created_at DESC
            LIMIT 2
        ")->getResultArray();

        $peserta_terbaru = $db->query("
            SELECT u.nama_users, k.nama_kelas, kp.tanggal_daftar_kelas_peserta AS created_at
            FROM kelas_peserta kp
            JOIN users u  ON u.id_users  = kp.id_users
            JOIN kelas k  ON k.id_kelas  = kp.id_kelas
            WHERE k.id_users = {$uid}
              AND u.role_users = 'peserta'
              AND u.deleted_at IS NULL
            ORDER BY kp.tanggal_daftar_kelas_peserta DESC
            LIMIT 2
        ")->getResultArray();

        $materi_per_kelas = $db->query("
            SELECT k.nama_kelas, COUNT(mt.id_materi) AS jumlah_materi
            FROM kelas k
            LEFT JOIN modul m  ON m.id_kelas  = k.id_kelas AND m.deleted_at IS NULL
            LEFT JOIN materi mt ON mt.id_modul = m.id_modul AND mt.deleted_at IS NULL
            WHERE k.id_users = {$uid} AND k.deleted_at IS NULL
            GROUP BY k.id_kelas
            ORDER BY jumlah_materi DESC
        ")->getResultArray();

        return view('Dashboard/Pengajar/beranda', [
            'nama_pengajar' => session()->get('nama'),
            'total_peserta' => $total_peserta,
            'total_kelas' => $total_kelas,
            'total_modul' => $total_modul,
            'total_materi' => $total_materi,
            'kelas_list' => $kelas_list,
            'peserta_terbaru' => $peserta_terbaru,
            'materi_per_kelas' => $materi_per_kelas,
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  PROGRAM
    // ══════════════════════════════════════════════════════════════════════
    public function program()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db = \Config\Database::connect();
        $uid = $this->myId();

        $program = $db->query("
            SELECT p.id_program, p.nama_program, p.deskripsi_program,
                COUNT(k.id_kelas) AS total_kelas
            FROM program p
            LEFT JOIN kelas k ON k.id_program = p.id_program
                AND k.deleted_at IS NULL
            WHERE p.id_users = {$uid}
            AND p.deleted_at IS NULL
            GROUP BY p.id_program
            ORDER BY p.created_at DESC
        ")->getResultArray();

        return view('Dashboard/Pengajar/program', [
            'title' => 'Manajemen Program',
            'program_list' => $program,
        ]);
    }

    public function programStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'nama_program' => 'required|min_length[3]|max_length[150]',
            'deskripsi_program' => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Data program tidak valid.');
        }

        \Config\Database::connect()->table('program')->insert([
            'nama_program' => $this->request->getPost('nama_program'),
            'deskripsi_program' => $this->request->getPost('deskripsi_program'),
            'id_users' => $this->myId(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/dashboard/pengajar/program')
            ->with('success', 'Program berhasil dibuat.');
    }

    public function programUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db = \Config\Database::connect();

        $cek = $db->table('program')
            ->where('id_program', $id)
            ->where('id_users', $this->myId())
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();

        if (!$cek) {
            return redirect()->back()->with('error', 'Program tidak ditemukan.');
        }

        $db->table('program')->where('id_program', $id)->update([
            'nama_program' => $this->request->getPost('nama_program'),
            'deskripsi_program' => $this->request->getPost('deskripsi_program'),
        ]);

        return redirect()->back()->with('success', 'Program diperbarui.');
    }

    public function programDelete(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        \Config\Database::connect()->table('program')
            ->where('id_program', $id)
            ->where('id_users', $this->myId())
            ->update(['deleted_at' => date('Y-m-d H:i:s')]);

        return redirect()->back()->with('success', 'Program dihapus.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  KELAS
    // ══════════════════════════════════════════════════════════════════════
    public function kelas()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db = \Config\Database::connect();
        $uid = $this->myId();
        $search = $this->request->getGet('search');

        $sql = "
            SELECT k.*,
                k.harga, k.lynk_url,
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

        $programList = $db->table('program')
            ->where('id_users', $uid)
            ->where('deleted_at IS NULL')
            ->orderBy('nama_program')
            ->get()->getResultArray();

        return view('Dashboard/Pengajar/kelas', [
            'kelas_list' => $db->query($sql)->getResultArray(),
            'search' => $search,
            'semua_peserta' => $semua_peserta,
            'programList' => $programList,
        ]);
    }

    public function kelasStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'nama_kelas' => 'required|min_length[3]|max_length[150]',
            'deskripsi_kelas' => 'permit_empty|max_length[500]',
            'id_program' => 'required|is_natural_no_zero',
            'harga' => 'permit_empty|decimal',
            'lynk_url' => 'permit_empty|max_length[255]',
            'gambar_kelas' => 'permit_empty|uploaded[gambar_kelas]|max_size[gambar_kelas,2048]|ext_in[gambar_kelas,jpg,jpeg,png]|mime_in[gambar_kelas,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $harga = $this->request->getPost('harga');
        $lynkUrl = $this->request->getPost('lynk_url');

        $finalHarga = ($harga !== '') ? $harga : null;
        $finalLynkUrl = ($lynkUrl !== '') ? $lynkUrl : null;

        $gambarPath = null;
        if ($gambar = $this->request->getFile('gambar_kelas')) {
            if ($gambar->isValid() && !$gambar->hasMoved()) {
                $newName = $gambar->getRandomName();
                $gambar->move(FCPATH . 'uploads/kelas/', $newName);
                $gambarPath = $newName;
            }
        }

        (new KelasModel())->insert([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'deskripsi_kelas' => $this->request->getPost('deskripsi_kelas'),
            'id_users' => $this->myId(),
            'id_program' => $this->request->getPost('id_program'),
            'harga' => $finalHarga,
            'lynk_url' => $finalLynkUrl,
            'gambar_kelas' => $gambarPath,
        ]);

        return redirect()->to('/dashboard/pengajar/kelas')->with('success', 'Kelas berhasil dibuat.');
    }

    public function kelasUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $model = new KelasModel();
        if (!$this->isMyKelas($model, $id)) {
            return redirect()->to('/dashboard/pengajar/kelas')->with('error', 'Kelas tidak ditemukan.');
        }

        $rules = [
            'nama_kelas' => 'required|min_length[3]|max_length[150]',
            'deskripsi_kelas' => 'permit_empty|max_length[500]',
            'id_program' => 'required|is_natural_no_zero',
            'harga' => 'permit_empty|decimal',
            'lynk_url' => 'permit_empty|max_length[255]',
            'gambar_kelas' => 'permit_empty|uploaded[gambar_kelas]|max_size[gambar_kelas,2048]|ext_in[gambar_kelas,jpg,jpeg,png]|mime_in[gambar_kelas,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $harga = $this->request->getPost('harga');
        $lynkUrl = $this->request->getPost('lynk_url');

        $finalHarga = ($harga !== '') ? $harga : null;
        $finalLynkUrl = ($lynkUrl !== '') ? $lynkUrl : null;

        $gambarPath = null;
        $existing = $model->find($id);
        if ($gambar = $this->request->getFile('gambar_kelas')) {
            if ($gambar->isValid() && !$gambar->hasMoved()) {
                if (!empty($existing['gambar_kelas'])) {
                    $oldPath = FCPATH . 'uploads/kelas/' . $existing['gambar_kelas'];
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }
                $newName = $gambar->getRandomName();
                $gambar->move(FCPATH . 'uploads/kelas/', $newName);
                $gambarPath = $newName;
            }
        } else {
            $gambarPath = $existing['gambar_kelas'] ?? null;
        }

        $model->update($id, [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'deskripsi_kelas' => $this->request->getPost('deskripsi_kelas'),
            'id_program' => $this->request->getPost('id_program'),
            'harga' => $finalHarga,
            'lynk_url' => $finalLynkUrl,
            'gambar_kelas' => $gambarPath,
        ]);

        return redirect()->to('/dashboard/pengajar/kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function kelasDelete(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $model = new KelasModel();
        if (!$this->isMyKelas($model, $id)) {
            return redirect()->to('/dashboard/pengajar/kelas')->with('error', 'Kelas tidak ditemukan.');
        }

        $existing = $model->withDeleted()->find($id);
        if (!empty($existing['gambar_kelas'])) {
            $imgPath = FCPATH . 'uploads/kelas/' . $existing['gambar_kelas'];
            if (file_exists($imgPath)) {
                @unlink($imgPath);
            }
        }

        $model->delete($id);
        return redirect()->to('/dashboard/pengajar/kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  TUGAS PENGUMPULAN & KOMENTAR
    // ══════════════════════════════════════════════════════════════════════
    public function tugasPengumpulan(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $tugasModel = new TugasModel();
        $tugas = $tugasModel->find($id);

        if (!$tugas || !$this->isMyKelas(new KelasModel(), $tugas['id_kelas'])) {
            return redirect()->to('/dashboard/pengajar/tugas')->with('error', 'Tugas tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $extra = $db->table('tugas t')
            ->select('t.*, k.nama_kelas, m.judul_modul')
            ->join('kelas k', 'k.id_kelas = t.id_kelas')
            ->join('modul m', 'm.id_modul = t.id_modul', 'left')
            ->where('t.id_tugas', $id)
            ->get()->getRowArray();

        $pengumpulan = $db->table('tugas_pengumpulan tp')
            ->select('tp.*, u.nama_users, u.email_users AS email')
            ->join('users u', 'u.id_users = tp.id_users')
            ->where('tp.id_tugas', $id)
            ->orderBy('tp.created_at', 'DESC')
            ->get()->getResultArray();

        $komentarModel = new TugasKomentarModel();
        foreach ($pengumpulan as &$item) {
            $item['komentar'] = $komentarModel->getByPengumpulan($item['id_pengumpulan']);
        }
        unset($item);

        return view('Dashboard/Pengajar/tugas_pengumpulan', [
            'tugas' => $extra ?? $tugas,
            'pengumpulan' => $pengumpulan,
        ]);
    }

    public function simpanKomentar()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $idPengumpulan = (int) $this->request->getPost('id_pengumpulan');
        $idTugas = (int) $this->request->getPost('id_tugas');
        $komentar = trim($this->request->getPost('komentar'));

        if (!$idPengumpulan || $komentar === '') {
            return redirect()->back()->with('error', 'Komentar tidak boleh kosong.');
        }

        $komentarModel = new TugasKomentarModel();
        $komentarModel->insert([
            'id_pengumpulan' => $idPengumpulan,
            'id_users' => $this->myId(),
            'komentar' => $komentar,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('dashboard/pengajar/tugas/pengumpulan/' . $idTugas))
            ->with('success', 'Komentar berhasil dikirim.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  KELAS PESERTA (AJAX)
    // ══════════════════════════════════════════════════════════════════════
    public function kelasPesertaList(int $idKelas)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        if (!$this->isMyKelas(new KelasModel(), $idKelas)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Kelas tidak ditemukan.'], 403);
        }

        $db = \Config\Database::connect();
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
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $idKelas = (int) $this->request->getPost('id_kelas');
        $idUser = (int) $this->request->getPost('id_users');

        if (!$idKelas || !$idUser) {
            return $this->jsonResponse(['success' => false, 'message' => 'Data tidak lengkap.'], 422);
        }

        if (!$this->isMyKelas(new KelasModel(), $idKelas)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Kelas tidak ditemukan.'], 403);
        }

        $db = \Config\Database::connect();
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
                'message' => "{$user['nama_users']} sudah terdaftar di kelas ini.",
            ], 422);
        }

        $db->table('kelas_peserta')->insert([
            'id_kelas' => $idKelas,
            'id_users' => $idUser,
            'tanggal_daftar_kelas_peserta' => date('Y-m-d H:i:s'),
        ]);

        return $this->jsonResponse([
            'success' => true,
            'message' => "{$user['nama_users']} berhasil ditambahkan ke kelas.",
        ]);
    }

    public function kelasPesertaKick(int $idKP)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db = \Config\Database::connect();
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
            'message' => "{$row['nama_users']} berhasil dikeluarkan dari kelas.",
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  MODUL
    // ══════════════════════════════════════════════════════════════════════
    public function modul()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db = \Config\Database::connect();
        $uid = $this->myId();
        $search = $this->request->getGet('search');

        $query = $db->table('modul m')
            ->select('m.*, k.nama_kelas, k.id_program, COUNT(mt.id_materi) AS total_materi')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->join('materi mt', 'mt.id_modul = m.id_modul AND mt.deleted_at IS NULL', 'left')
            ->where('k.id_users', $uid)
            ->where('m.deleted_at IS NULL')
            ->groupBy('m.id_modul');

        if ($search) {
            $query->like('m.judul_modul', $search);
        }

        $kelasList = (new KelasModel())->where('id_users', $uid)->findAll();

        $programIds = array_unique(array_column($kelasList, 'id_program'));
        $programList = !empty($programIds)
            ? $db->table('program')->whereIn('id_program', $programIds)->get()->getResultArray()
            : [];

        return view('Dashboard/Pengajar/modul', [
            'modul' => $query->get()->getResultArray(),
            'kelas' => $kelasList,
            'program' => $programList,
            'search' => $search,
        ]);
    }

    public function modulStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'id_kelas' => 'required|is_natural_no_zero',
            'judul_modul' => 'required|min_length[3]|max_length[150]',
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
            'id_kelas' => $idKelas,
            'judul_modul' => $this->request->getPost('judul_modul'),
            'urutan_modul' => $this->request->getPost('urutan_modul') ?: 1,
        ]);

        return redirect()->to('/dashboard/pengajar/modul')->with('success', 'Modul berhasil ditambahkan.');
    }

    public function modulUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        if (!$this->isMyModul($id)) {
            return redirect()->to('/dashboard/pengajar/modul')->with('error', 'Modul tidak ditemukan.');
        }

        $modulModel = new ModulModel();
        $modul = $modulModel->find($id);

        if (!$modul) {
            return redirect()->to('/dashboard/pengajar/modul')->with('error', 'Modul tidak ditemukan.');
        }

        $rules = [
            'judul_modul' => 'required|min_length[3]|max_length[150]',
            'urutan_modul' => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $modulModel->update($id, [
            'judul_modul' => $this->request->getPost('judul_modul'),
            'urutan_modul' => $this->request->getPost('urutan_modul') ?: $modul['urutan_modul'],
        ]);

        return redirect()->to('/dashboard/pengajar/modul')->with('success', 'Modul berhasil diperbarui.');
    }

    public function modulDelete(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        if (!$this->isMyModul($id)) {
            return redirect()->to('/dashboard/pengajar/modul')->with('error', 'Modul tidak ditemukan.');
        }

        $modulModel = new ModulModel();
        $modulModel->delete($id);
        return redirect()->to('/dashboard/pengajar/modul')->with('success', 'Modul berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  TUGAS
    // ══════════════════════════════════════════════════════════════════════
    public function tugas()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db = \Config\Database::connect();
        $uid = $this->myId();

        $programList = $db->table('program p')
            ->join('kelas k', 'k.id_program = p.id_program')
            ->where('k.id_users', $uid)
            ->where('p.deleted_at IS NULL')
            ->groupBy('p.id_program')
            ->get()->getResultArray();

        $kelasList = (new KelasModel())
            ->where('id_users', $uid)
            ->where('deleted_at IS NULL')
            ->findAll();

        $modulList = $db->table('modul m')
            ->select('m.id_modul, m.judul_modul, m.id_kelas')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('k.id_users', $uid)
            ->where('m.deleted_at IS NULL')
            ->orderBy('m.id_kelas, m.urutan_modul')
            ->get()->getResultArray();

        $tugasList = $db->table('tugas t')
            ->select('t.*, k.nama_kelas, m.judul_modul, k.id_program')
            ->join('kelas k', 'k.id_kelas = t.id_kelas')
            ->join('modul m', 'm.id_modul = t.id_modul', 'left')
            ->where('k.id_users', $uid)
            ->where('t.deleted_at IS NULL')
            ->orderBy('t.created_at', 'DESC')
            ->get()->getResultArray();

        return view('Dashboard/Pengajar/tugas', [
            'program' => $programList,
            'kelas' => $kelasList,
            'modul' => $modulList,
            'tugas' => $tugasList,
        ]);
    }

    public function tugasStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'id_kelas' => 'required|is_natural_no_zero',
            'judul_tugas' => 'required|min_length[3]|max_length[200]',
            'deskripsi_tugas' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idKelas = (int) $this->request->getPost('id_kelas');
        if (!$this->isMyKelas(new KelasModel(), $idKelas)) {
            return redirect()->back()->with('error', 'Kelas tidak valid.');
        }

        $idModul = $this->request->getPost('id_modul') ? (int) $this->request->getPost('id_modul') : null;
        if ($idModul && !$this->isMyModul($idModul)) {
            return redirect()->back()->with('error', 'Modul tidak valid.');
        }

        $taskData = [
            'id_kelas' => $idKelas,
            'id_modul' => $idModul,
            'judul_tugas' => $this->request->getPost('judul_tugas'),
            'deskripsi_tugas' => $this->request->getPost('deskripsi_tugas'),
            'created_by' => $this->myId(),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        (new TugasModel())->insert($taskData);

        return redirect()->to('/dashboard/pengajar/tugas')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function tugasDelete(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $tugasModel = new TugasModel();
        $tugas = $tugasModel->find($id);

        if (!$tugas || !$this->isMyKelas(new KelasModel(), $tugas['id_kelas'])) {
            return redirect()->to('/dashboard/pengajar/tugas')->with('error', 'Tugas tidak ditemukan.');
        }

        $tugasModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
        return redirect()->to('/dashboard/pengajar/tugas')->with('success', 'Tugas berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  MATERI
    // ══════════════════════════════════════════════════════════════════════
    private function getMateriFilterData(int $uid): array
    {
        $db = \Config\Database::connect();

        $modul = $db->table('modul m')
            ->select('m.id_modul, m.judul_modul, k.nama_kelas, k.id_kelas, k.id_program')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('k.id_users', $uid)
            ->where('m.deleted_at IS NULL')
            ->orderBy('k.id_kelas, m.urutan_modul')
            ->get()->getResultArray();

        $programIds = array_unique(array_column($modul, 'id_program'));
        $program = !empty($programIds)
            ? $db->table('program')
                ->whereIn('id_program', $programIds)
                ->where('deleted_at IS NULL')
                ->orderBy('nama_program')
                ->get()->getResultArray()
            : [];

        $kelas = $db->table('kelas')
            ->select('id_kelas, nama_kelas, id_program')
            ->where('id_users', $uid)
            ->where('deleted_at IS NULL')
            ->orderBy('nama_kelas')
            ->get()->getResultArray();

        return compact('modul', 'program', 'kelas');
    }

    public function materi()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db = \Config\Database::connect();
        $uid = $this->myId();
        $search = $this->request->getGet('search');

        $query = $db->table('materi mt')
            ->select('mt.*, m.judul_modul, k.nama_kelas, k.id_kelas, k.id_program,
                      (mt.post_test IS NOT NULL AND mt.post_test != "") AS has_post_test,
                      (mt.pre_test  IS NOT NULL AND mt.pre_test  != "") AS has_pre_test')
            ->join('modul m', 'm.id_modul = mt.id_modul')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('k.id_users', $uid)
            ->where('mt.deleted_at IS NULL')
            ->orderBy('k.id_kelas, m.urutan_modul, mt.id_materi');

        if ($search) {
            $query->like('mt.judul_materi', $search);
        }

        $filter = $this->getMateriFilterData($uid);

        return view('Dashboard/Pengajar/materi', [
            'materi' => $query->get()->getResultArray(),
            'modul' => $filter['modul'],
            'program' => $filter['program'],
            'kelas' => $filter['kelas'],
            'search' => $search,
        ]);
    }

    public function materiStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'id_modul' => 'required|is_natural_no_zero',
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
        $fileDoc = $this->request->getFile('file_materi');
        if ($fileDoc && $fileDoc->isValid() && !$fileDoc->hasMoved()) {
            $allowedExt = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
            $ext = strtolower($fileDoc->getExtension());

            if (!in_array($ext, $allowedExt)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Format file tidak didukung. Gunakan PDF, Word, Excel, atau PowerPoint.');
            }
            if ($fileDoc->getSize() > 20 * 1024 * 1024) {
                return redirect()->back()->withInput()
                    ->with('error', 'Ukuran file maksimal 20 MB.');
            }
            $newName = $fileDoc->getRandomName();
            $fileDoc->move(FCPATH . 'uploads/materi', $newName);
            $filePath = 'uploads/materi/' . $newName;
        }

        (new MateriModel())->insert([
            'id_modul' => $idModul,
            'judul_materi' => $this->request->getPost('judul_materi'),
            'pre_test' => $this->buildQuizJsonFor('pre_test'),
            'file_materi' => $filePath,
            'video_url_materi' => $this->request->getPost('video_url_materi') ?: null,
            'post_test' => $this->buildQuizJsonFor('post_test'),
        ]);

        return redirect()->to('/dashboard/pengajar/materi')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function materiUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $materiModel = new MateriModel();
        $materi = $materiModel->find($id);

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
        $fileDoc = $this->request->getFile('file_materi');
        $allowedExt = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

        if ($fileDoc && $fileDoc->isValid() && !$fileDoc->hasMoved()) {
            $ext = strtolower($fileDoc->getExtension());

            if (!in_array($ext, $allowedExt)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Format file tidak didukung. Gunakan PDF, Word, Excel, atau PowerPoint.');
            }
            if ($fileDoc->getSize() > 20 * 1024 * 1024) {
                return redirect()->back()->withInput()
                    ->with('error', 'Ukuran file maksimal 20 MB.');
            }
            if ($materi['file_materi'] && file_exists(FCPATH . $materi['file_materi'])) {
                @unlink(FCPATH . $materi['file_materi']);
            }
            $newName = $fileDoc->getRandomName();
            $fileDoc->move(FCPATH . 'uploads/materi', $newName);
            $filePath = 'uploads/materi/' . $newName;
        }

        $preTestJson = $this->buildQuizJsonFor('pre_test');
        $postTestJson = $this->buildQuizJsonFor('post_test');

        $materiModel->update($id, [
            'judul_materi' => $this->request->getPost('judul_materi'),
            'pre_test' => $preTestJson ?? $materi['pre_test'],
            'file_materi' => $filePath,
            'video_url_materi' => $this->request->getPost('video_url_materi') ?: null,
            'post_test' => $postTestJson ?? $materi['post_test'],
        ]);

        return redirect()->to('/dashboard/pengajar/materi')->with('success', 'Materi berhasil diperbarui.');
    }

    public function materiDelete(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $materiModel = new MateriModel();
        $materi = $materiModel->find($id);

        if (!$materi || !$this->isMyModul($materi['id_modul'])) {
            return redirect()->to('/dashboard/pengajar/materi')->with('error', 'Materi tidak ditemukan.');
        }

        if ($materi['file_materi'] && file_exists(FCPATH . $materi['file_materi'])) {
            @unlink(FCPATH . $materi['file_materi']);
        }

        $materiModel->delete($id);
        return redirect()->to('/dashboard/pengajar/materi')->with('success', 'Materi berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  VOUCHER
    // ══════════════════════════════════════════════════════════════════════
    public function voucher()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db = \Config\Database::connect();
        $uid = $this->myId();

        $vouchers = $db->query("
            SELECT v.*, k.nama_kelas,
                   (SELECT COUNT(*) FROM voucher_claim vc WHERE vc.id_voucher = v.id_voucher) AS total_klaim
            FROM voucher v
            JOIN kelas k ON k.id_kelas = v.id_kelas
            WHERE k.id_users = {$uid}
              AND v.deleted_at IS NULL
            ORDER BY v.created_at DESC
        ")->getResultArray();

        $kelasList = $db->table('kelas')
            ->where('id_users', $uid)
            ->where('deleted_at IS NULL')
            ->orderBy('nama_kelas')
            ->get()->getResultArray();

        $programList = $db->table('program')
            ->where('id_users', $uid)
            ->where('deleted_at IS NULL')
            ->orderBy('nama_program')
            ->get()->getResultArray();

        return view('Dashboard/Pengajar/voucher', [
            'title' => 'Manajemen Voucher',
            'vouchers' => $vouchers,
            'kelasList' => $kelasList,
            'programList' => $programList,
        ]);
    }

    public function kelasByProgram(int $idProgram)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db = \Config\Database::connect();
        $uid = $this->myId();

        $kelas = $db->table('kelas')
            ->select('id_kelas, nama_kelas')
            ->where('id_program', $idProgram)
            ->where('id_users', $uid)
            ->where('deleted_at IS NULL')
            ->orderBy('nama_kelas')
            ->get()->getResultArray();

        return $this->jsonResponse([
            'success' => true,
            'kelas' => $kelas,
        ]);
    }

    public function voucherStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'id_kelas' => 'required|is_natural_no_zero',
            'kode_voucher' => 'required|min_length[3]|max_length[50]|is_unique[voucher.kode_voucher]',
            'nama_voucher' => 'required|min_length[3]|max_length[100]',
            'tanggal_mulai' => 'required|valid_date[Y-m-d]',
            'tanggal_berakhir' => 'required|valid_date[Y-m-d]',
            'durasi_hari' => 'permit_empty|is_natural_no_zero',
            'durasi_tugas' => 'permit_empty|is_natural_no_zero',
            'kuota' => 'permit_empty|is_natural',
            'deskripsi' => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $idKelas = (int) $this->request->getPost('id_kelas');
        if (!$this->isMyKelas(new KelasModel(), $idKelas)) {
            return redirect()->back()->with('error', 'Kelas tidak valid.');
        }

        $kuota = $this->request->getPost('kuota');
        $mulai = $this->request->getPost('tanggal_mulai');
        $durasi = $this->request->getPost('durasi_hari');
        $durasiTugas = $this->request->getPost('durasi_tugas');

        $tanggalBerakhir = $this->request->getPost('tanggal_berakhir');

        if ($durasi) {
            $tanggalBerakhir = date('Y-m-d', strtotime("+{$durasi} days", strtotime($mulai)));
        }

        (new VoucherModel())->insert([
            'id_kelas' => $idKelas,
            'kode_voucher' => strtoupper(trim($this->request->getPost('kode_voucher'))),
            'nama_voucher' => $this->request->getPost('nama_voucher'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal_mulai' => $mulai,
            'tanggal_berakhir' => $tanggalBerakhir,
            'durasi_hari' => $durasi ?: null,
            'durasi_tugas' => $durasiTugas ?: null,
            'kuota' => $kuota !== '' ? (int) $kuota : null,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/dashboard/pengajar/voucher')
            ->with('success', 'Voucher berhasil dibuat.');
    }

    public function voucherUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $voucher = $this->getMyVoucher($id);
        if (!$voucher) {
            return redirect()->back()->with('error', 'Voucher tidak ditemukan.');
        }

        $mulai = $this->request->getPost('tanggal_mulai');
        $durasi = $this->request->getPost('durasi_hari');
        $durasiTugas = $this->request->getPost('durasi_tugas');

        $tanggalBerakhir = $this->request->getPost('tanggal_berakhir');

        if ($durasi) {
            $tanggalBerakhir = date('Y-m-d', strtotime("+{$durasi} days", strtotime($mulai)));
        }

        $rules = [
            'nama_voucher' => 'required|min_length[3]|max_length[100]',
            'tanggal_mulai' => 'required|valid_date[Y-m-d]',
            'tanggal_berakhir' => 'required|valid_date[Y-m-d]',
            'durasi_hari' => 'permit_empty|is_natural_no_zero',
            'durasi_tugas' => 'permit_empty|is_natural_no_zero',
            'kuota' => 'permit_empty|is_natural',
            'deskripsi' => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $kuota = $this->request->getPost('kuota');

        (new VoucherModel())->update($id, [
            'nama_voucher' => $this->request->getPost('nama_voucher'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal_mulai' => $mulai,
            'tanggal_berakhir' => $tanggalBerakhir,
            'durasi_hari' => $durasi ?: null,
            'durasi_tugas' => $durasiTugas ?: null,
            'kuota' => $kuota !== '' ? (int) $kuota : null,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/dashboard/pengajar/voucher')
            ->with('success', 'Voucher berhasil diperbarui.');
    }

    public function voucherToggleActive(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $voucher = $this->getMyVoucher($id);
        if (!$voucher) {
            return $this->jsonResponse(['success' => false, 'message' => 'Voucher tidak ditemukan.'], 404);
        }

        $newStatus = $voucher['is_active'] ? 0 : 1;

        (new VoucherModel())->update($id, [
            'is_active' => $newStatus,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $label = $newStatus ? 'diaktifkan' : 'dinonaktifkan';

        return $this->jsonResponse([
            'success' => true,
            'message' => "Voucher berhasil {$label}.",
            'is_active' => $newStatus,
        ]);
    }

    public function voucherDelete(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $voucher = $this->getMyVoucher($id);
        if (!$voucher) {
            return redirect()->back()->with('error', 'Voucher tidak ditemukan.');
        }

        (new VoucherModel())->delete($id);

        return redirect()->to('/dashboard/pengajar/voucher')
            ->with('success', 'Voucher berhasil dihapus.');
    }

    public function voucherKlaim()
    {
        if (!session()->get('id_users')) {
            return $this->jsonResponse(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $kodeVoucher = trim($this->request->getPost('kode_voucher'));
        $idUsers = (int) session()->get('id_users');

        if (empty($kodeVoucher)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Kode voucher diperlukan.'], 422);
        }

        $db = \Config\Database::connect();
        $voucher = $db->table('voucher')
            ->where('kode_voucher', strtoupper($kodeVoucher))
            ->where('is_active', 1)
            ->where('deleted_at IS NULL')
            ->where('tanggal_mulai <=', date('Y-m-d H:i:s'))
            ->where('tanggal_berakhir >=', date('Y-m-d H:i:s'))
            ->get()->getRowArray();

        if (!$voucher) {
            return $this->jsonResponse(['success' => false, 'message' => 'Kode voucher tidak valid atau sudah kadaluarsa.'], 422);
        }

        $sudahKlaim = $db->table('voucher_claim')
            ->where('id_voucher', $voucher['id_voucher'])
            ->where('id_users', $idUsers)
            ->countAllResults();

        if ($sudahKlaim > 0) {
            return $this->jsonResponse(['success' => false, 'message' => 'Kamu sudah pernah mengklaim voucher ini.'], 422);
        }

        if ($voucher['kuota'] !== null) {
            $totalKlaim = $db->table('voucher_claim')
                ->where('id_voucher', $voucher['id_voucher'])
                ->countAllResults();
            if ($totalKlaim >= $voucher['kuota']) {
                return $this->jsonResponse(['success' => false, 'message' => 'Kuota voucher sudah habis.'], 422);
            }
        }

        $db->table('voucher_claim')->insert([
            'id_voucher' => $voucher['id_voucher'],
            'id_users' => $idUsers,
            'tanggal_klaim' => date('Y-m-d H:i:s'),
            'status' => 'aktif',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $sudahDaftar = $db->table('kelas_peserta')
            ->where('id_kelas', $voucher['id_kelas'])
            ->where('id_users', $idUsers)
            ->countAllResults();

        if ($sudahDaftar === 0) {
            $tanggalMulai = date('Y-m-d H:i:s');
            $durasiHari = isset($voucher['durasi_hari']) ? (int) $voucher['durasi_hari'] : 0;
            $durasiTugas = isset($voucher['durasi_tugas']) ? (int) $voucher['durasi_tugas'] : 0;

            $tanggalBerakhir = null;
            if ($durasiHari > 0) {
                $tanggalBerakhir = date('Y-m-d H:i:s', strtotime($tanggalMulai . " +{$durasiHari} days"));
            }

            $db->table('kelas_peserta')->insert([
                'id_kelas' => $voucher['id_kelas'],
                'id_users' => $idUsers,
                'tanggal_daftar_kelas_peserta' => $tanggalMulai,
                'tanggal_berakhir' => $tanggalBerakhir,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if ($durasiTugas > 0) {
                $deadlineTugas = date('Y-m-d H:i:s', strtotime($tanggalMulai . " +{$durasiTugas} days"));
                $tugasDeadlineModel = new \App\Models\TugasDeadlinePesertaModel();
                $tugasDeadlineModel->setDeadline($voucher['id_kelas'], $idUsers, $deadlineTugas);
            }
        }

        return $this->jsonResponse([
            'success' => true,
            'message' => "Voucher berhasil diklaim! Kamu sudah terdaftar di kelas {$voucher['nama_voucher']}.",
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  PROFIL
    // ══════════════════════════════════════════════════════════════════════
    public function profil()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        return view('Dashboard/Pengajar/profil', [
            'user' => \Config\Database::connect()
                ->table('users')->where('id_users', $this->myId())->get()->getRowArray(),
        ]);
    }

    public function profilUpdate()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $id = $this->myId();
        $rules = [
            'nama_users' => 'required|min_length[3]|max_length[100]',
            'email_users' => "required|valid_email|is_unique[users.email_users,id_users,{$id}]",
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_users' => $this->request->getPost('nama_users'),
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
    //  PESERTA & APLIKASI PENDUKUNG
    // ══════════════════════════════════════════════════════════════════════
    public function peserta()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $pengajarId = $this->myId();
        $db         = \Config\Database::connect();

        $peserta = $db->table('kelas_peserta kp')
            ->select('
                u.id_users,
                u.nama_users,
                u.email_users,
                k.id_kelas,
                k.nama_kelas,
                kp.tanggal_daftar_kelas_peserta
            ')
            ->join('kelas k', 'k.id_kelas = kp.id_kelas')
            ->join('users u', 'u.id_users = kp.id_users')
            ->where('k.id_users', $pengajarId)
            ->where('u.role_users', 'peserta')
            ->orderBy('k.id_kelas, u.nama_users')
            ->get()
            ->getResultObject();

        $kelasList = $db->table('kelas k')
            ->select('k.id_kelas, k.nama_kelas, COUNT(kp.id_kelas_peserta) AS jumlah_peserta')
            ->join('kelas_peserta kp', 'kp.id_kelas = k.id_kelas', 'left')
            ->join('users u', "u.id_users = kp.id_users AND u.role_users = 'peserta'", 'left')
            ->where('k.id_users', $pengajarId)
            ->groupBy('k.id_kelas')
            ->orderBy('k.nama_kelas')
            ->get()->getResultObject();

        $totalPeserta = count((array) $peserta);

        $aplikasiSemua = $db->table('aplikasi_pendukung')
            ->orderBy('nama_aplikasi')
            ->get()
            ->getResultArray();

        return view('Dashboard/Pengajar/peserta', [
            'title'         => 'Daftar Peserta',
            'peserta'       => $peserta,
            'kelasList'     => $kelasList,
            'totalPeserta'  => $totalPeserta,
            'aplikasiSemua' => $aplikasiSemua,
        ]);
    }

    public function pesertaGetAkses(int $idUsers)
    {
        if ($r = $this->guardPengajar()) return $r;

        $db  = \Config\Database::connect();
        $ids = $db->table('aplikasi_user')
            ->select('id_aplikasi')
            ->where('id_users', $idUsers)
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'akses'   => array_map(fn($r) => (int) $r['id_aplikasi'], $ids),
        ]);
    }

    public function pesertaSimpanAkses()
    {
        if ($r = $this->guardPengajar()) return $r;

        $json    = $this->request->getJSON(true);
        $idUsers = (int) ($json['id_users'] ?? 0);
        $newIds  = array_map('intval', $json['aplikasi'] ?? []);

        if ($idUsers <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak valid.',
            ]);
        }

        $db = \Config\Database::connect();
        $db->table('aplikasi_user')->where('id_users', $idUsers)->delete();

        if (!empty($newIds)) {
            $db->table('aplikasi_user')->insertBatch(
                array_map(fn($id) => ['id_aplikasi' => $id, 'id_users' => $idUsers], $newIds)
            );
        }

        return $this->response->setJSON([
            'success'   => true,
            'message'   => 'Akses berhasil disimpan.',
            'csrf_hash' => csrf_hash(),
        ]);
    }

   public function aplikasiPendukung()
    {
        if ($r = $this->guardPengajar()) return $r;

        $pengajarId = session()->get('id_users');

        $db = \Config\Database::connect();

        $peserta = $db->table('kelas_peserta kp')
            ->select('DISTINCT u.id_users, u.nama_users AS nama, u.email_users AS email')
            ->join('kelas k', 'k.id_kelas = kp.id_kelas')
            ->join('users u', 'u.id_users = kp.id_users')
            ->where('k.id_users', $pengajarId)
            ->where('u.role_users', 'peserta')
            ->orderBy('u.nama_users')
            ->get()
            ->getResultArray();

        return view('Dashboard/Pengajar/aplikasi_pendukung', [
            'peserta' => $peserta,
        ]);
    }

    public function aplikasiStore()
    {
        if ($r = $this->guardPengajar()) return $r;

        $db = \Config\Database::connect();
        $db->table('aplikasi_pendukung')->insert([
            'nama_aplikasi' => $this->request->getPost('nama_aplikasi'),
            'link_aplikasi' => $this->request->getPost('link_aplikasi'),
        ]);

        return redirect()->to(base_url('dashboard/pengajar/aplikasi-pendukung'))
            ->with('success', 'Aplikasi berhasil ditambahkan.');
    }

    public function aplikasiUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) return $r;

        $db = \Config\Database::connect();
        $db->table('aplikasi_pendukung')
            ->where('id_aplikasi', $id)
            ->update([
                'nama_aplikasi' => $this->request->getPost('nama_aplikasi'),
                'link_aplikasi' => $this->request->getPost('link_aplikasi'),
            ]);

        return redirect()->to(base_url('dashboard/pengajar/aplikasi-pendukung'))
            ->with('success', 'Aplikasi berhasil diperbarui.');
    }

    public function aplikasiDelete(int $id)
    {
        if ($r = $this->guardPengajar()) return $r;

        $db = \Config\Database::connect();
        $db->table('aplikasi_user')->where('id_aplikasi', $id)->delete();
        $db->table('aplikasi_pendukung')->where('id_aplikasi', $id)->delete();

        return redirect()->to(base_url('dashboard/pengajar/aplikasi-pendukung'))
            ->with('success', 'Aplikasi berhasil dihapus.');
    }

    public function aplikasiGetAkses(int $idAplikasi)
    {
        if ($r = $this->guardPengajar()) return $r;

        $db  = \Config\Database::connect();
        $ids = $db->table('aplikasi_user')
            ->select('id_users')
            ->where('id_aplikasi', $idAplikasi)
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'akses'   => array_map(fn($r) => (int) $r['id_users'], $ids),
        ]);
    }

    public function aplikasiSimpanAkses()
    {
        if ($r = $this->guardPengajar()) return $r;

        $json       = $this->request->getJSON(true);
        $idAplikasi = (int) ($json['id_aplikasi'] ?? 0);
        $userIds    = array_map('intval', $json['user_ids'] ?? []);

        if ($idAplikasi <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Aplikasi tidak valid.',
            ]);
        }

        $db = \Config\Database::connect();
        $db->table('aplikasi_user')->where('id_aplikasi', $idAplikasi)->delete();

        if (!empty($userIds)) {
            $db->table('aplikasi_user')->insertBatch(
                array_map(fn($id) => ['id_aplikasi' => $idAplikasi, 'id_users' => $id], $userIds)
            );
        }

        return $this->response->setJSON([
            'success'   => true,
            'message'   => 'Akses berhasil disimpan.',
            'csrf_hash' => csrf_hash(),
        ]);
    }
    
    // ══════════════════════════════════════════════════════════
    // TAMBAHKAN METHOD INI KE DALAM CLASS DashboardPengajar
    // File: app/Controllers/DashboardPengajar.php
    // ══════════════════════════════════════════════════════════

    // ── 1. Pastikan Users model sudah di-load di constructor ──
    // $this->userModel = new \App\Models\Users();


    // ── 2. Tambahkan method pesertaVerifikasi ──

    public function pesertaVerifikasi()
    {
        $peserta = $this->userModel
            ->where('role_users', 'peserta')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $totalPeserta   = count($peserta);
        $totalVerified  = count(array_filter($peserta, fn($p) => !empty($p['email_verified']) && $p['email_verified'] == 1));
        $totalUnverified = $totalPeserta - $totalVerified;

        return view('Dashboard/Pengajar/peserta_verifikasi', [
            'title'          => 'Manajemen Peserta',
            'peserta'        => $peserta,
            'totalPeserta'   => $totalPeserta,
            'totalVerified'  => $totalVerified,
            'totalUnverified'=> $totalUnverified,
        ]);
    }


    // ── 3. Tambahkan method resendVerifikasi (AJAX) ──

    public function resendVerifikasiEmail()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $json   = $this->request->getJSON(true);
        $userId = $json['id_users'] ?? null;

        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'User tidak ditemukan']);
        }

        $user = $this->userModel->find($userId);
        if (!$user || $user['role_users'] !== 'peserta') {
            return $this->response->setJSON(['success' => false, 'message' => 'Peserta tidak valid']);
        }

        if (!empty($user['email_verified']) && $user['email_verified'] == 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Email sudah terverifikasi']);
        }

        // Generate token baru
        $token     = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $this->userModel->update($userId, [
            'verification_token' => $token,
            'token_expires_at'   => $expiresAt,
        ]);

        // Kirim email — sesuaikan dengan library email yang kamu pakai
        // Contoh menggunakan Email library CodeIgniter bawaan:
        $email = \Config\Services::email();
        $email->setFrom('noreply@yourdomain.com', 'Elecomp LMS');
        $email->setTo($user['email_users']);
        $email->setSubject('Verifikasi Email Akun Elecomp LMS');

        $verifyUrl = base_url('verify-email/' . $token);
        $email->setMessage("
            <h3>Halo, {$user['nama_users']}!</h3>
            <p>Klik link di bawah untuk memverifikasi email kamu:</p>
            <p><a href='{$verifyUrl}' style='background:#2563eb;color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;display:inline-block'>Verifikasi Email</a></p>
            <p style='color:#888;font-size:12px'>Link berlaku selama 24 jam.</p>
        ");
        $email->setMailType('html');

        if ($email->send()) {
            return $this->response->setJSON([
                'success'   => true,
                'message'   => 'Email verifikasi berhasil dikirim',
                'csrf_hash' => csrf_hash(),
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengirim email. Periksa konfigurasi email.',
        ]);
    }

    // Note: Method buildQuizJsonFor() kemungkinan ada di BaseController
}