<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AplikasiPendukungModel;
use App\Models\AplikasiUserModel;
use App\Models\Users;

class AplikasiPendukung extends BaseController
{
    protected $aplikasiModel;
    protected $aplikasiUserModel;
    protected $userModel;

    public function __construct()
    {
        $this->aplikasiModel     = new AplikasiPendukungModel();
        $this->aplikasiUserModel = new AplikasiUserModel();
        $this->userModel         = new Users();
    }

    private function formatUrl($url)
    {
        $url = trim($url);
        if (empty($url)) return '';

        $url = str_replace('\\', '/', $url);

        // Local aplikasi (kalkulator, absensi, dll)
        if (strpos($url, '/') === 0 || !preg_match('/\./', $url)) {
            return ltrim($url, '/');
        }

        // External link
        if (preg_match('/^https?:\/\//i', $url)) {
            return $url;
        }

        return 'http://' . $url;   // ← Pakai HTTP
    }

    public function index()
    {
        $aplikasi = $this->aplikasiModel->findAll();
        
        foreach ($aplikasi as &$app) {
            $app['akses_count'] = $this->aplikasiUserModel
                ->where('id_aplikasi', $app['id_aplikasi'])
                ->countAllResults();
        }
        
        $users = $this->userModel->findAll();
        $formattedPeserta = [];

        foreach ($users as $user) {
            $id = $user['id_users'] ?? $user['id'] ?? 0;
            if ($id > 0) {
                $formattedPeserta[] = [
                    'id'    => (int)$id,
                    'nama'  => $user['nama_users'] ?? $user['nama_lengkap'] ?? 'Tanpa Nama',
                    'email' => $user['email'] ?? ''
                ];
            }
        }

        return view('Dashboard/Pengajar/aplikasi_pendukung', [
            'title'    => 'Aplikasi Pendukung',
            'aplikasi' => $aplikasi,
            'peserta'  => $formattedPeserta
        ]);
    }

    public function getAkses($idAplikasi)
    {
        $akses = $this->aplikasiUserModel->where('id_aplikasi', $idAplikasi)->findAll();
        return $this->response->setJSON([
            'success' => true,
            'akses'   => array_column($akses, 'id_users')
        ]);
    }

    public function simpanAkses()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $json = $this->request->getJSON(true);
        $idAplikasi = $json['id_aplikasi'] ?? null;
        $userIds = $json['user_ids'] ?? [];

        if (!$idAplikasi) {
            return $this->response->setJSON(['success' => false, 'message' => 'Aplikasi tidak ditemukan']);
        }

        $this->aplikasiUserModel->where('id_aplikasi', $idAplikasi)->delete();

        foreach ($userIds as $uid) {
            $this->aplikasiUserModel->insert([
                'id_users'    => $uid,
                'id_aplikasi' => $idAplikasi
            ]);
        }

        return $this->response->setJSON([
            'success'   => true,
            'message'   => 'Akses berhasil disimpan',
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function store()
    {
        $link = $this->formatUrl($this->request->getPost('link_aplikasi'));
        $_POST['link_aplikasi'] = $link;

        $rules = [
            'nama_aplikasi' => 'required|min_length[3]',
            'link_aplikasi' => 'required|min_length[2]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        $this->aplikasiModel->save([
            'nama_aplikasi' => $this->request->getPost('nama_aplikasi'),
            'link_aplikasi' => $link,
        ]);

        return redirect()->to('/dashboard/pengajar/aplikasi-pendukung')
            ->with('success', 'Aplikasi berhasil ditambahkan');
    }

    public function update($id)
    {
        $link = $this->formatUrl($this->request->getPost('link_aplikasi'));
        $_POST['link_aplikasi'] = $link;

        $rules = [
            'nama_aplikasi' => 'required|min_length[3]',
            'link_aplikasi' => 'required|min_length[2]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid');
        }

        $this->aplikasiModel->update($id, [
            'nama_aplikasi' => $this->request->getPost('nama_aplikasi'),
            'link_aplikasi' => $link,
        ]);

        return redirect()->to('/Dashboard/pengajar/aplikasi-pendukung')
            ->with('success', 'Aplikasi berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->aplikasiUserModel->where('id_aplikasi', $id)->delete();
        $this->aplikasiModel->delete($id);
        return redirect()->to('/Dashboard/pengajar/aplikasi-pendukung')
            ->with('success', 'Aplikasi berhasil dihapus');
    }
}