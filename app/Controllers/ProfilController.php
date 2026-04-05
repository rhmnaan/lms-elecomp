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
                'user'  => $user
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
                'user'  => $user
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

        $namaBaru  = trim($this->request->getPost('nama_users'));
        $emailBaru = trim($this->request->getPost('email_users'));

        $rules = [];
        $data  = [];

        if ($namaBaru !== $userLama['nama_users']) {
            $rules['nama_users'] = 'required|min_length[3]|max_length[100]';
            $data['nama_users']  = $namaBaru;
        }

        if ($emailBaru !== $userLama['email_users']) {
            $rules['email_users'] =
                "required|valid_email|is_unique[users.email_users,id_users,{$userId}]";
            $data['email_users'] = $emailBaru;
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

        // Update session
        session()->set($data);

        return redirect()
            ->to($this->roleRedirect())
            ->with('success', 'Profil berhasil diperbarui');
    }
}