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
        $input    = $this->request->getPost('email'); // field name tetap 'email'
        $password = $this->request->getPost('password');

        if (!$input || !$password) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Username/Email dan password wajib diisi.'
            ]);
        }

        $usersModel = new Users();

        // Cari berdasarkan email ATAU nama_users (username)
        $user = $usersModel
            ->groupStart()
                ->where('email_users', $input)
                ->orWhere('nama_users', $input)
            ->groupEnd()
            ->first();

        if (!$user || !password_verify($password, $user['password_users'])) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Username/Email atau password salah.'
            ]);
        }

        session()->set([
            'logged_in' => true,
            'id_users'  => $user['id_users'],
            'nama'      => $user['nama_users'],
            'email'     => $user['email_users'],
            'role'      => $user['role_users'],
        ]);

        $currentFP = $_COOKIE['device_fp'] ?? null;
        $syncData  = ['action' => null];
        if ($currentFP) {
            $syncData['fingerprint_device'] = $currentFP;
        }
        $usersModel
            ->where('id_users', $user['id_users']) // pakai id agar lebih aman
            ->set($syncData)
            ->update();

        $redirect = match($user['role_users']) {
            'admin'    => '/dashboard/admin/beranda',
            'pengajar' => '/dashboard/pengajar',
            'peserta'  => '/dashboard/peserta/beranda',
            default    => '/dashboard',
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