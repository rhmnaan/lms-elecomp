<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\ModulModel;
use App\Models\VoucherModel;

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
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db  = \Config\Database::connect();
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
            'nama_pengajar'    => session()->get('nama'),
            'total_peserta'    => $total_peserta,
            'total_kelas'      => $total_kelas,
            'total_modul'      => $total_modul,
            'total_materi'     => $total_materi,
            'kelas_list'       => $kelas_list,
            'peserta_terbaru'  => $peserta_terbaru,
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

        $db  = \Config\Database::connect();
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
            'title'        => 'Manajemen Program',
            'program_list' => $program,
        ]);
    }

    public function programStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'nama_program'      => 'required|min_length[3]|max_length[150]',
            'deskripsi_program' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Data program tidak valid.');
        }

        \Config\Database::connect()->table('program')->insert([
            'nama_program'      => $this->request->getPost('nama_program'),
            'deskripsi_program' => $this->request->getPost('deskripsi_program'),
            'id_users'          => $this->myId(),
            'created_at'        => date('Y-m-d H:i:s'),
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

        if (! $cek) {
            return redirect()->back()->with('error', 'Program tidak ditemukan.');
        }

        $db->table('program')->where('id_program', $id)->update([
            'nama_program'      => $this->request->getPost('nama_program'),
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

        $db     = \Config\Database::connect();
        $uid    = $this->myId();
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
            $safe  = $db->escapeString($search);
            $sql  .= " AND k.nama_kelas LIKE '%{$safe}%'";
        }

        $sql .= " GROUP BY k.id_kelas ORDER BY k.created_at DESC";

        $semua_peserta = $db->table('users')
            ->select('id_users, nama_users, email_users')
            ->where('role_users', 'peserta')
            ->where('deleted_at IS NULL')
            ->orderBy('nama_users')
            ->get()->getResultArray();

        $programList  = $db->table('program')
            ->where('id_users', $uid)
            ->where('deleted_at IS NULL')
            ->orderBy('nama_program')
            ->get()->getResultArray();

        return view('Dashboard/Pengajar/kelas', [
            'kelas_list'    => $db->query($sql)->getResultArray(),
            'search'        => $search,
            'semua_peserta' => $semua_peserta,
            'programList'   => $programList,
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  kelasStore — DIUBAH: upload gambar ke public/uploads/kelas/
    //  hanya nama file yang disimpan di kolom gambar_kelas
    // ──────────────────────────────────────────────────────────────────────
    public function kelasStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'nama_kelas'      => 'required|min_length[3]|max_length[150]',
            'deskripsi_kelas' => 'permit_empty|max_length[500]',
            'id_program'      => 'required|is_natural_no_zero',
            'harga'           => 'permit_empty|decimal',
            'lynk_url'        => 'permit_empty|max_length[255]',
            'gambar_kelas'    => 'permit_empty|uploaded[gambar_kelas]|max_size[gambar_kelas,2048]|ext_in[gambar_kelas,jpg,jpeg,png]|mime_in[gambar_kelas,image/jpg,image/jpeg,image/png]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $harga   = $this->request->getPost('harga');
        $lynkUrl = $this->request->getPost('lynk_url');

        $finalHarga   = ($harga !== '') ? $harga : null;
        $finalLynkUrl = ($lynkUrl !== '') ? $lynkUrl : null;

        // Handle gambar upload
        $gambarPath = null;
        if ($gambar = $this->request->getFile('gambar_kelas')) {
            if ($gambar->isValid() && ! $gambar->hasMoved()) {
                $newName = $gambar->getRandomName();
                $gambar->move(FCPATH . 'uploads/kelas/', $newName);
                $gambarPath = $newName;
            }
        }

        (new KelasModel())->insert([
            'nama_kelas'      => $this->request->getPost('nama_kelas'),
            'deskripsi_kelas' => $this->request->getPost('deskripsi_kelas'),
            'id_users'        => $this->myId(),
            'id_program'      => $this->request->getPost('id_program'),
            'harga'           => $finalHarga,
            'lynk_url'        => $finalLynkUrl,
            'gambar_kelas'    => $gambarPath,
        ]);

        return redirect()->to('/dashboard/pengajar/kelas')->with('success', 'Kelas berhasil dibuat.');
    }

    // ──────────────────────────────────────────────────────────────────────
    //  kelasUpdate — DIUBAH: upload gambar ke public/uploads/kelas/
    //  hapus file lama otomatis jika upload gambar baru
    // ──────────────────────────────────────────────────────────────────────
    public function kelasUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $model = new KelasModel();
        if (! $this->isMyKelas($model, $id)) {
            return redirect()->to('/dashboard/pengajar/kelas')->with('error', 'Kelas tidak ditemukan.');
        }

        $rules = [
            'nama_kelas'      => 'required|min_length[3]|max_length[150]',
            'deskripsi_kelas' => 'permit_empty|max_length[500]',
            'id_program'      => 'required|is_natural_no_zero',
            'harga'           => 'permit_empty|decimal',
            'lynk_url'        => 'permit_empty|max_length[255]',
            'gambar_kelas'    => 'permit_empty|uploaded[gambar_kelas]|max_size[gambar_kelas,2048]|ext_in[gambar_kelas,jpg,jpeg,png]|mime_in[gambar_kelas,image/jpg,image/jpeg,image/png]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $harga   = $this->request->getPost('harga');
        $lynkUrl = $this->request->getPost('lynk_url');

        $finalHarga   = ($harga !== '') ? $harga : null;
        $finalLynkUrl = ($lynkUrl !== '') ? $lynkUrl : null;

        // Handle gambar upload
        $gambarPath = null;
        $existing   = $model->find($id);
        if ($gambar = $this->request->getFile('gambar_kelas')) {
            if ($gambar->isValid() && ! $gambar->hasMoved()) {
                // Hapus gambar lama jika ada
                if (! empty($existing['gambar_kelas'])) {
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
            // Jika tidak ada gambar baru, gunakan yang lama
            $gambarPath = $existing['gambar_kelas'] ?? null;
        }

        $model->update($id, [
            'nama_kelas'      => $this->request->getPost('nama_kelas'),
            'deskripsi_kelas' => $this->request->getPost('deskripsi_kelas'),
            'id_program'      => $this->request->getPost('id_program'),
            'harga'           => $finalHarga,
            'lynk_url'        => $finalLynkUrl,
            'gambar_kelas'    => $gambarPath,
        ]);

        return redirect()->to('/dashboard/pengajar/kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function kelasDelete(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $model = new KelasModel();
        if (! $this->isMyKelas($model, $id)) {
            return redirect()->to('/dashboard/pengajar/kelas')->with('error', 'Kelas tidak ditemukan.');
        }

        // Hapus file gambar dari public jika ada
        $existing = $model->withDeleted()->find($id);
        if (! empty($existing['gambar_kelas'])) {
            $imgPath = FCPATH . 'uploads/kelas/' . $existing['gambar_kelas'];
            if (file_exists($imgPath)) {
                @unlink($imgPath);
            }
        }

        $model->delete($id);
        return redirect()->to('/dashboard/pengajar/kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  KELAS PESERTA — AJAX endpoints
    // ══════════════════════════════════════════════════════════════════════
    public function kelasPesertaList(int $idKelas)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        if (! $this->isMyKelas(new KelasModel(), $idKelas)) {
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
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $idKelas = (int) $this->request->getPost('id_kelas');
        $idUser  = (int) $this->request->getPost('id_users');

        if (! $idKelas || ! $idUser) {
            return $this->jsonResponse(['success' => false, 'message' => 'Data tidak lengkap.'], 422);
        }

        if (! $this->isMyKelas(new KelasModel(), $idKelas)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Kelas tidak ditemukan.'], 403);
        }

        $db   = \Config\Database::connect();
        $user = $db->table('users')
            ->where('id_users', $idUser)
            ->where('role_users', 'peserta')
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();

        if (! $user) {
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
            'id_kelas'                     => $idKelas,
            'id_users'                     => $idUser,
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

        $db  = \Config\Database::connect();
        $row = $db->table('kelas_peserta kp')
            ->select('kp.*, u.nama_users, k.id_users AS pengajar_id')
            ->join('kelas k', 'k.id_kelas = kp.id_kelas')
            ->join('users u', 'u.id_users = kp.id_users')
            ->where('kp.id_kelas_peserta', $idKP)
            ->get()->getRowArray();

        if (! $row || (int) $row['pengajar_id'] !== $this->myId()) {
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

        $db     = \Config\Database::connect();
        $uid    = $this->myId();
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

        $programIds  = array_unique(array_column($kelasList, 'id_program'));
        $programList = ! empty($programIds)
            ? $db->table('program')->whereIn('id_program', $programIds)->get()->getResultArray()
            : [];

        return view('Dashboard/Pengajar/modul', [
            'modul'   => $query->get()->getResultArray(),
            'kelas'   => $kelasList,
            'program' => $programList,
            'search'  => $search,
        ]);
    }

    public function modulStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'id_kelas'     => 'required|is_natural_no_zero',
            'judul_modul'  => 'required|min_length[3]|max_length[150]',
            'urutan_modul' => 'permit_empty|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idKelas = (int) $this->request->getPost('id_kelas');
        if (! $this->isMyKelas(new KelasModel(), $idKelas)) {
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
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        if (! $this->isMyModul($id)) {
            return redirect()->to('/dashboard/pengajar/modul')->with('error', 'Modul tidak ditemukan.');
        }

        $modulModel = new ModulModel();
        $modul      = $modulModel->find($id);

        if (! $modul) {
            return redirect()->to('/dashboard/pengajar/modul')->with('error', 'Modul tidak ditemukan.');
        }

        $rules = [
            'judul_modul'  => 'required|min_length[3]|max_length[150]',
            'urutan_modul' => 'permit_empty|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
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
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        if (! $this->isMyModul($id)) {
            return redirect()->to('/dashboard/pengajar/modul')->with('error', 'Modul tidak ditemukan.');
        }

        $modulModel = new ModulModel();
        $modul      = $modulModel->find($id);

        if (! $modul) {
            return redirect()->to('/dashboard/pengajar/modul')->with('error', 'Modul tidak ditemukan.');
        }

        $modulModel->delete($id);
        return redirect()->to('/dashboard/pengajar/modul')->with('success', 'Modul berhasil dihapus.');
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
        $program    = ! empty($programIds)
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

        $db     = \Config\Database::connect();
        $uid    = $this->myId();
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
            'materi'  => $query->get()->getResultArray(),
            'modul'   => $filter['modul'],
            'program' => $filter['program'],
            'kelas'   => $filter['kelas'],
            'search'  => $search,
        ]);
    }

    public function materiStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'id_modul'     => 'required|is_natural_no_zero',
            'judul_materi' => 'required|min_length[3]|max_length[200]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idModul = (int) $this->request->getPost('id_modul');
        if (! $this->isMyModul($idModul)) {
            return redirect()->back()->with('error', 'Modul tidak valid.');
        }

        $filePath = null;
        $filePdf  = $this->request->getFile('file_materi');
        if ($filePdf && $filePdf->isValid() && ! $filePdf->hasMoved()) {
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
            'pre_test'         => $this->buildQuizJsonFor('pre_test'),
            'file_materi'      => $filePath,
            'video_url_materi' => $this->request->getPost('video_url_materi') ?: null,
            'post_test'        => $this->buildQuizJsonFor('post_test'),
        ]);

        return redirect()->to('/dashboard/pengajar/materi')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function materiUpdate(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $materiModel = new MateriModel();
        $materi      = $materiModel->find($id);

        if (! $materi || ! $this->isMyModul($materi['id_modul'])) {
            return redirect()->to('/dashboard/pengajar/materi')->with('error', 'Materi tidak ditemukan.');
        }

        $rules = [
            'judul_materi' => 'required|min_length[3]|max_length[200]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = $materi['file_materi'];
        $filePdf  = $this->request->getFile('file_materi');
        if ($filePdf && $filePdf->isValid() && ! $filePdf->hasMoved()) {
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

        $preTestJson  = $this->buildQuizJsonFor('pre_test');
        $postTestJson = $this->buildQuizJsonFor('post_test');

        $materiModel->update($id, [
            'judul_materi'     => $this->request->getPost('judul_materi'),
            'pre_test'         => $preTestJson ?? $materi['pre_test'],
            'file_materi'      => $filePath,
            'video_url_materi' => $this->request->getPost('video_url_materi') ?: null,
            'post_test'        => $postTestJson ?? $materi['post_test'],
        ]);

        return redirect()->to('/dashboard/pengajar/materi')->with('success', 'Materi berhasil diperbarui.');
    }

    public function materiDelete(int $id)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $materiModel = new MateriModel();
        $materi      = $materiModel->find($id);

        if (! $materi || ! $this->isMyModul($materi['id_modul'])) {
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
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db  = \Config\Database::connect();
        $uid = $this->myId();

        $materi = $db->table('materi mt')
            ->select('mt.*, m.judul_modul, k.nama_kelas, k.id_kelas, k.id_program,
                      (mt.post_test IS NOT NULL AND mt.post_test != "") AS has_post_test,
                      (mt.pre_test  IS NOT NULL AND mt.pre_test  != "") AS has_pre_test')
            ->join('modul m', 'm.id_modul = mt.id_modul')
            ->join('kelas k', 'k.id_kelas = m.id_kelas')
            ->where('k.id_users', $uid)
            ->where('mt.deleted_at IS NULL')
            ->orderBy('k.id_kelas, m.urutan_modul, mt.id_materi')
            ->get()->getResultArray();

        $filter = $this->getMateriFilterData($uid);

        return view('Dashboard/Pengajar/materi', [
            'materi'      => $materi,
            'modul'       => $filter['modul'],
            'program'     => $filter['program'],
            'kelas'       => $filter['kelas'],
            'search'      => null,
            'materi_list' => $materi,
            'total'       => count($materi),
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  VIDEO
    // ══════════════════════════════════════════════════════════════════════
    public function video()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        return view('Dashboard/Pengajar/video_upload');
    }

    public function videoList()
    {
        if (! session()->get('id_users')) {
            return $this->jsonResponse(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $db  = \Config\Database::connect();
        $uid = (int) session()->get('id_users');

        $videos = $db->table('video_encrypted')
            ->where('id_users', $uid)
            ->where('deleted_at IS NULL')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        return $this->jsonResponse(['success' => true, 'data' => $videos]);
    }

    public function videoDelete($videoId = null)
    {
        if (! session()->get('id_users')) {
            return $this->jsonResponse(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        if (empty($videoId)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Video ID diperlukan.'], 400);
        }

        $videoId = preg_replace('/[^a-zA-Z0-9_\\-.]/', '', $videoId);
        $db      = \Config\Database::connect();
        $uid     = (int) session()->get('id_users');

        $row = $db->table('video_encrypted')
            ->where('video_id', $videoId)
            ->where('id_users', $uid)
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();

        if (! $row) {
            return $this->jsonResponse(['success' => false, 'message' => 'Video tidak ditemukan.'], 404);
        }

        $encFile = WRITEPATH . 'uploads/encrypted/' . $videoId . '.enc';
        if (file_exists($encFile)) {
            @unlink($encFile);
        }

        $db->table('video_encrypted')
            ->where('video_id', $videoId)
            ->update(['deleted_at' => date('Y-m-d H:i:s')]);

        return $this->jsonResponse(['success' => true, 'message' => 'Video berhasil dihapus.']);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  VOUCHER
    // ══════════════════════════════════════════════════════════════════════
    public function voucher()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db  = \Config\Database::connect();
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
            'title'       => 'Manajemen Voucher',
            'vouchers'    => $vouchers,
            'kelasList'   => $kelasList,
            'programList' => $programList,
        ]);
    }

    public function kelasByProgram(int $idProgram)
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $db  = \Config\Database::connect();
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
            'kelas'   => $kelas,
        ]);
    }

    public function voucherStore()
    {
        if ($r = $this->guardPengajar()) {
            return $r;
        }

        $rules = [
            'id_kelas'         => 'required|is_natural_no_zero',
            'kode_voucher'     => 'required|min_length[3]|max_length[50]|is_unique[voucher.kode_voucher]',
            'nama_voucher'     => 'required|min_length[3]|max_length[100]',
            'tanggal_mulai'    => 'required|valid_date[Y-m-d]',
            'tanggal_berakhir' => 'required|valid_date[Y-m-d]',
            'kuota'            => 'permit_empty|is_natural',
            'deskripsi'        => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $idKelas = (int) $this->request->getPost('id_kelas');
        if (! $this->isMyKelas(new KelasModel(), $idKelas)) {
            return redirect()->back()->with('error', 'Kelas tidak valid.');
        }

        $kuota = $this->request->getPost('kuota');

        (new VoucherModel())->insert([
            'id_kelas'         => $idKelas,
            'kode_voucher'     => strtoupper(trim($this->request->getPost('kode_voucher'))),
            'nama_voucher'     => $this->request->getPost('nama_voucher'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'tanggal_mulai'    => $this->request->getPost('tanggal_mulai'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir'),
            'kuota'            => $kuota !== '' ? (int) $kuota : null,
            'is_active'        => 1,
            'created_at'       => date('Y-m-d H:i:s'),
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
        if (! $voucher) {
            return redirect()->back()->with('error', 'Voucher tidak ditemukan.');
        }

        $rules = [
            'nama_voucher'     => 'required|min_length[3]|max_length[100]',
            'tanggal_mulai'    => 'required|valid_date[Y-m-d]',
            'tanggal_berakhir' => 'required|valid_date[Y-m-d]',
            'kuota'            => 'permit_empty|is_natural',
            'deskripsi'        => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $kuota = $this->request->getPost('kuota');

        (new VoucherModel())->update($id, [
            'nama_voucher'     => $this->request->getPost('nama_voucher'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'tanggal_mulai'    => $this->request->getPost('tanggal_mulai'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir'),
            'kuota'            => $kuota !== '' ? (int) $kuota : null,
            'updated_at'       => date('Y-m-d H:i:s'),
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
        if (! $voucher) {
            return $this->jsonResponse(['success' => false, 'message' => 'Voucher tidak ditemukan.'], 404);
        }

        $newStatus = $voucher['is_active'] ? 0 : 1;

        (new VoucherModel())->update($id, [
            'is_active'  => $newStatus,
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
        if (! $voucher) {
            return redirect()->back()->with('error', 'Voucher tidak ditemukan.');
        }

        (new VoucherModel())->delete($id);

        return redirect()->to('/dashboard/pengajar/voucher')
            ->with('success', 'Voucher berhasil dihapus.');
    }

    public function voucherKlaim()
    {
        if (! session()->get('id_users')) {
            return $this->jsonResponse(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $kodeVoucher = trim($this->request->getPost('kode_voucher'));
        $idUsers     = (int) session()->get('id_users');

        if (empty($kodeVoucher)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Kode voucher diperlukan.'], 422);
        }

        $db      = \Config\Database::connect();
        $voucher = $db->table('voucher')
            ->where('kode_voucher', strtoupper($kodeVoucher))
            ->where('is_active', 1)
            ->where('deleted_at IS NULL')
            ->where('tanggal_mulai <=', date('Y-m-d H:i:s'))
            ->where('tanggal_berakhir >=', date('Y-m-d H:i:s'))
            ->get()->getRowArray();

        if (! $voucher) {
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
            'id_voucher'    => $voucher['id_voucher'],
            'id_users'      => $idUsers,
            'tanggal_klaim' => date('Y-m-d H:i:s'),
            'status'        => 'aktif',
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        $sudahDaftar = $db->table('kelas_peserta')
            ->where('id_kelas', $voucher['id_kelas'])
            ->where('id_users', $idUsers)
            ->countAllResults();

        if ($sudahDaftar === 0) {
            $db->table('kelas_peserta')->insert([
                'id_kelas'                     => $voucher['id_kelas'],
                'id_users'                     => $idUsers,
                'tanggal_daftar_kelas_peserta' => date('Y-m-d H:i:s'),
                'created_at'                   => date('Y-m-d H:i:s'),
            ]);
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

        $id    = $this->myId();
        $rules = [
            'nama_users'  => 'required|min_length[3]|max_length[100]',
            'email_users' => "required|valid_email|is_unique[users.email_users,id_users,{$id}]",
        ];

        if ($this->request->getPost('password')) {
            $rules['password']         = 'min_length[6]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (! $this->validate($rules)) {
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

        $pesertaArr   = (array) $peserta;
        $totalPeserta = count($pesertaArr);

        return view('Dashboard/Pengajar/peserta', [
            'title'        => 'Daftar Peserta',
            'peserta'      => $peserta,
            'kelasList'    => $kelasList,
            'totalPeserta' => $totalPeserta,
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ══════════════════════════════════════════════════════════════════════
    private function isMyKelas(KelasModel $model, int $idKelas): bool
    {
        $kelas = $model->withDeleted()->find($idKelas);
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

    private function getMyVoucher(int $idVoucher): ?array
    {
        $db = \Config\Database::connect();
        return $db->query("
            SELECT v.* FROM voucher v
            JOIN kelas k ON k.id_kelas = v.id_kelas
            WHERE v.id_voucher = {$idVoucher}
              AND k.id_users   = {$this->myId()}
              AND v.deleted_at IS NULL
        ")->getRowArray() ?: null;
    }

    private function buildQuizJsonFor(string $field): ?string
    {
        $rawQuiz = $this->request->getPost($field);
        if (empty($rawQuiz) || ! is_array($rawQuiz)) {
            return null;
        }

        $soalList = [];
        foreach ($rawQuiz as $item) {
            $pertanyaan = trim($item['pertanyaan'] ?? '');
            $pilihan    = $item['pilihan'] ?? [];
            $jawaban    = (int) ($item['jawaban_benar'] ?? 0);
            if ($pertanyaan === '' || count($pilihan) < 2) {
                continue;
            }

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
