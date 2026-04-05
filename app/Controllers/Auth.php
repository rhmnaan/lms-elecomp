<?php

namespace App\Controllers;

use App\Models\Users;

class Auth extends BaseController
{
    // GET /login
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    // POST /auth/authenticate
    public function authenticate()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email || !$password) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Email dan password wajib diisi.'
            ]);
        }

        $usersModel = new Users();
        $user = $usersModel->where('email_users', $email)->first();

        if (!$user || !password_verify($password, $user['password_users'])) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Email atau password salah.'
            ]);
        }

        session()->set([
            'logged_in' => true,
            'id_users'  => $user['id_users'],
            'nama'      => $user['nama_users'],
            'email'     => $user['email_users'],
            'role'      => $user['role_users'],
        ]);

        // Setelah login berhasil:
        // 1. Sync fingerprint_device di DB dengan cookie browser sekarang
        //    Ini penting agar SSE tidak langsung detect sebagai hijack
        // 2. Reset action ke NULL agar state DB netral
        $currentFP = $_COOKIE['device_fp'] ?? null;
        $syncData  = ['action' => null];
        if ($currentFP) {
            $syncData['fingerprint_device'] = $currentFP;
        }
        $usersModel
            ->where('email_users', $email)
            ->set($syncData)
            ->update();

        $redirect = match($user['role_users']) {
            'admin' => '/dashboard/admin/beranda',
            'pengajar'  => '/dashboard/pengajar',
            'peserta' => '/dashboard/peserta/beranda',
            default => '/dashboard',
        };

        return $this->response->setJSON([
            'status'   => 'successful',
            'redirect' => $redirect,
        ]);
    }

    // GET /logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}