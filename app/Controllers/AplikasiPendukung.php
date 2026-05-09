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

    /**
     * ============================
     * HALAMAN DAFTAR APLIKASI
     * ============================
     */
    public function index()
    {
        return view('Dashboard/Pengajar/aplikasi_pendukung', [
            'title'    => 'Aplikasi Pendukung',
            'aplikasi' => $this->aplikasiModel->findAll()
        ]);
    }

    /**
     * ============================
     * SIMPAN APLIKASI BARU
     * ============================
     */
    public function store()
    {
        if (!$this->validate([
            'nama_aplikasi' => 'required',
            'link_aplikasi' => 'required|valid_url'
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data tidak valid');
        }

        $this->aplikasiModel->save([
            'nama_aplikasi' => $this->request->getPost('nama_aplikasi'),
            'link_aplikasi' => $this->request->getPost('link_aplikasi'),
        ]);

        // store()
        return redirect()->to('/dashboard/pengajar/aplikasi-pendukung')
            ->with('success', 'Aplikasi berhasil ditambahkan');
    }

    /**
     * ============================
     * UPDATE APLIKASI
     * ============================
     */
    public function update($id)
    {
        $this->aplikasiModel->update($id, [
            'nama_aplikasi' => $this->request->getPost('nama_aplikasi'),
            'link_aplikasi' => $this->request->getPost('link_aplikasi'),
        ]);

        // update()
        return redirect()->to('/dashboard/pengajar/aplikasi-pendukung')
            ->with('success', 'Aplikasi berhasil diperbarui');
    }

    /**
     * ============================
     * HAPUS APLIKASI
     * ============================
     */
    public function delete($id)
    {
        $this->aplikasiModel->delete($id);

        // delete()
        return redirect()->to('/dashboard/pengajar/aplikasi-pendukung')
            ->with('success', 'Aplikasi berhasil dihapus');
    }

    /**
     * =====================================
     * MANAJEMEN AKSES USER (TETAP)
     * =====================================
     */
    public function manajemen()
    {
        return view('Dashboard/Pengajar/manajemen_aplikasi', [
            'title'    => 'Manajemen Akses Aplikasi',
            'users'    => $this->userModel->findAll(),
            'aplikasi' => $this->aplikasiModel->findAll()
        ]);
    }

    public function simpanAkses()
    {
        $idUsers = $this->request->getPost('id_users');
        $aplikasiDipilih = $this->request->getPost('aplikasi') ?? [];

        $this->aplikasiUserModel
            ->where('id_users', $idUsers)
            ->delete();

        foreach ($aplikasiDipilih as $idAplikasi) {
            $this->aplikasiUserModel->insert([
                'id_users'    => $idUsers,
                'id_aplikasi' => $idAplikasi
            ]);
        }

        return redirect()->back()->with('success', 'Akses aplikasi berhasil diperbarui');
    }
}