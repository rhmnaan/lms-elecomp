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
        $input    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$input || !$password) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Username/Email dan password wajib diisi.'
            ]);
        }

        $usersModel = new Users();

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
        $syncData  = [];

        if ($currentFP) {
            $existing = $usersModel
                ->where('id_users', $user['id_users'])
                ->select('fingerprint_device')
                ->first();

            $dbFP = $existing['fingerprint_device'] ?? null;

            if ($dbFP === $currentFP || $dbFP === null || $dbFP === '') {
                // Perangkat sama atau belum ada fingerprint → aman reset action
                $syncData = [
                    'fingerprint_device' => $currentFP,
                    'action'             => null,
                ];
            } else {
                // Perangkat BEDA → hanya update fingerprint, JANGAN reset action
                // Biarkan action ('keep'/'other') tetap ada agar SSE tab lama bisa deteksi
                $syncData = [
                    'fingerprint_device' => $currentFP,
                ];
            }
        } else {
            // Tidak ada cookie fp → hanya reset action
            $syncData = ['action' => null];
        }

        $usersModel
            ->where('id_users', $user['id_users'])
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