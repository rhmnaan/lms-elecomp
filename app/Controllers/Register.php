<?php

namespace App\Controllers;

use App\Models\Users;

class Register extends BaseController
{
    // GET /register
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/register');
    }

    // POST /register
    public function store()
    {
        $email    = $this->request->getPost('email_users');
        $password = $this->request->getPost('password_users');
        $nama     = $this->request->getPost('nama_users');

        if (!$email || !$password || !$nama) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Semua field wajib diisi.'
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Format email tidak valid.'
            ]);
        }

        if (strlen($password) < 8) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Password minimal 8 karakter.'
            ]);
        }

        if (!preg_match('/[a-zA-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Password harus mengandung huruf dan angka.'
            ]);
        }

        $usersModel = new Users();

        // Cek email sudah terdaftar
        if ($usersModel->where('email_users', $email)->first()) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Email sudah terdaftar. Silakan gunakan email lain.'
            ]);
        }

        // Ambil fingerprint dari cookie (sudah di-set oleh register.php view sebelum submit)
        // Jika tidak ada (misal JS disabled), biarkan null — SSE akan skip guard
        $fp = $_COOKIE['device_fp'] ?? null;

        // Simpan ke DB — termasuk fingerprint perangkat pertama
        $usersModel->insert([
            'nama_users'         => $nama,
            'email_users'        => $email,
            'password_users'     => password_hash($password, PASSWORD_BCRYPT),
            'role_users'         => 'peserta',
            'fingerprint_device' => $fp,      // ← set dari awal agar SSE punya baseline
            // action dibiarkan NULL — user langsung aktif, tidak ada konflik sesi
        ]);

        // Ambil data user yang baru dibuat
        $newUser = $usersModel->where('email_users', $email)->first();

        // Langsung set session — user tidak perlu login manual lagi
        session()->set([
            'logged_in' => true,
            'id_users'  => $newUser['id_users'],
            'nama'      => $newUser['nama_users'],
            'email'     => $newUser['email_users'],
            'role'      => $newUser['role_users'],
        ]);

        return $this->response->setJSON([
            'status'   => 'successful',
            'redirect' => base_url('/dashboard/peserta/beranda'),
        ]);
    }
}