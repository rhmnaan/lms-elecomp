<?php

namespace App\Controllers;

use App\Models\Users;
use CodeIgniter\I18n\Time;

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

        if (! $input || ! $password) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Username/Email dan password wajib diisi.',
            ]);
        }

        $usersModel = new Users();

        $user = $usersModel
            ->groupStart()
            ->where('email_users', $input)
            ->orWhere('nama_users', $input)
            ->groupEnd()
            ->first();

        if (! $user || ! password_verify($password, $user['password_users'])) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Username/Email atau password salah.',
            ]);
        }

        // 🛠️ PERBAIKAN: Konversi paksa nilai dari DB ke Boolean (bool)
        // Mengatasi masalah string "1" atau integer 1 dari driver database agar tidak gagal di strict comparison
        $emailVerified = isset($user['email_verified']) ? (bool)$user['email_verified'] : false;

        if (!$emailVerified) {
            return $this->response->setJSON([
                'status'  => 'unverified',
                'message' => 'Email belum diverifikasi. Silakan cek inbox email Anda untuk verifikasi.',
                'email'   => $user['email_users'],
            ]);
        }

        // Jika sampai sini, berarti email sudah verified, lanjut set session
        session()->set([
            'logged_in'   => true,
            'id_users'    => $user['id_users'],
            'nama'        => $user['nama_users'],
            'email_users' => $user['email_users'],
            'role'        => $user['role_users'],
        ]);

        $currentFP = $_COOKIE['device_fp'] ?? null;
        $dbFP      = $user['fingerprint_device'];

        $syncData = ['action' => null];

        if ($currentFP) {
            $syncData['fingerprint_device'] = $currentFP;
            if ($dbFP && $dbFP !== $currentFP) {
                $syncData['action'] = 'switched'; // Memicu modal konflik sesi di frontend jika device berbeda
            }
        }

        $usersModel
            ->where('id_users', $user['id_users'])
            ->set($syncData)
            ->update();

        $redirect = match ($user['role_users']) {
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

    // POST /auth/resend-verification
    public function resendVerification()
    {
        $email = $this->request->getPost('email');

        if (! $email) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Email tidak ditemukan.',
            ]);
        }

        $usersModel = new Users();
        $user       = $usersModel->where('email_users', $email)->first();

        if (! $user) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Email tidak terdaftar.',
            ]);
        }

        // 🛠️ PERBAIKAN: Gunakan konversi boolean yang sama di sini demi konsistensi
        $emailVerified = isset($user['email_verified']) ? (bool)$user['email_verified'] : false;

        if ($emailVerified) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Email sudah terverifikasi. Silakan login.',
            ]);
        }

        // Generate token baru
        $token   = bin2hex(random_bytes(32));
        $expires = Time::now()->addHours(24);

        $usersModel->update($user['id_users'], [
            'verification_token' => $token,
            'token_expires_at'   => $expires,
        ]);

        // Kirim email
        $verificationLink = base_url("register/verify?token={$token}");
        $emailService     = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Verifikasi Email Akun LMS Elecomp');
        $emailService->setMessage(view('emails/verification', [
            'nama' => $user['nama_users'],
            'link' => $verificationLink,
        ]));

        if ($emailService->send()) {
            return $this->response->setJSON([
                'status'  => 'successful',
                'message' => 'Email verifikasi berhasil dikirim ulang. Silakan cek inbox Anda.',
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Gagal mengirim email. Coba beberapa saat lagi.',
            ]);
        }
    }

    // GET /logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}