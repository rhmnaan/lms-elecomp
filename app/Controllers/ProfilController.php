<?php

namespace App\Controllers;

use App\Models\Users;

class ProfilController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new Users();
    }

    /**
     * Ambil prefix view & redirect berdasarkan role
     */
    private function rolePath()
    {
        $role = session()->get('role');

        return $role === 'pengajar'
            ? 'Dashboard/Pengajar'
            : 'Dashboard/Peserta';
    }

    private function roleRedirect()
    {
        $role = session()->get('role');

        return $role === 'pengajar'
            ? 'dashboard/pengajar/profil'
            : 'dashboard/peserta/profil';
    }

    // =============================
    // PROFIL
    // =============================
    public function index()
    {
        $userId = session()->get('id_users');
        $user   = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        return view(
            $this->rolePath() . '/profil',
            [
                'title' => 'Profil Saya',
                'user'  => $user,
            ]
        );
    }

    // =============================
    // EDIT PROFIL
    // =============================
    public function edit()
    {
        $userId = session()->get('id_users');
        $user   = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        return view(
            $this->rolePath() . '/edit_profil',
            [
                'title' => 'Edit Profil',
                'user'  => $user,
            ]
        );
    }

    // =============================
    // UPDATE PROFIL
    // =============================
    public function update()
    {
        $userId   = session()->get('id_users');
        $userLama = $this->userModel->find($userId);

        if (!$userLama) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $namaBaru     = trim($this->request->getPost('nama_users'));
        $usernameBaru = trim($this->request->getPost('username'));
        $emailBaru    = trim($this->request->getPost('email_users'));
        $nomorHpBaru  = trim($this->request->getPost('nomor_hp'));

        $rules = [];
        $data  = [];

        // Cek perubahan nama
        if ($namaBaru !== ($userLama['nama_users'] ?? '')) {
            $rules['nama_users'] = 'required|min_length[3]|max_length[100]';
            $data['nama_users']  = $namaBaru;
        }

        // Cek perubahan username
        if ($usernameBaru !== ($userLama['username'] ?? '')) {
            $rules['username'] = "required|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z0-9_.]+$/]|is_unique[users.username,id_users,{$userId}]";
            $data['username']  = $usernameBaru;
        }

        // Cek perubahan email
        if ($emailBaru !== ($userLama['email_users'] ?? '')) {
            $rules['email_users'] = "required|valid_email|is_unique[users.email_users,id_users,{$userId}]";
            $data['email_users']  = $emailBaru;
        }

        // Cek perubahan nomor HP
        if ($nomorHpBaru !== ($userLama['nomor_hp'] ?? '')) {
            $rules['nomor_hp'] = "required|min_length[9]|max_length[15]|regex_match[/^[0-9]+$/]|is_unique[users.nomor_hp,id_users,{$userId}]";
            $data['nomor_hp']  = $nomorHpBaru;
        }

        if (empty($data)) {
            return redirect()->back()->with('error', 'Tidak ada perubahan data');
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->userModel->update($userId, $data);

        // Update session jika nama berubah
        if (isset($data['nama_users'])) {
            session()->set('nama', $data['nama_users']);
        }

        return redirect()
            ->to($this->roleRedirect())
            ->with('success', 'Profil berhasil diperbarui');
    }
}