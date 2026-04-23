<?php

namespace App\Controllers;

use App\Models\Users;
use CodeIgniter\I18n\Time;

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

        $fp = $_COOKIE['device_fp'] ?? null;

        // Generate token verifikasi
        $verificationToken = bin2hex(random_bytes(32)); // 64 karakter
        $tokenExpires = Time::now()->addHours(24); // Berlaku 24 jam

        // Simpan ke DB dengan status belum terverifikasi
        $usersModel->insert([
            'nama_users'         => $nama,
            'email_users'        => $email,
            'password_users'     => password_hash($password, PASSWORD_BCRYPT),
            'role_users'         => 'peserta',
            'fingerprint_device' => $fp,
            'email_verified'     => false, // ← Belum terverifikasi
            'verification_token' => $verificationToken,
            'token_expires_at'   => $tokenExpires,
        ]);

        // Kirim email verifikasi
        $emailSent = $this->sendVerificationEmail($email, $nama, $verificationToken);

        if (!$emailSent) {
            log_message('error', 'Email verifikasi gagal dikirim ke: ' . $email);
        }

        return $this->response->setJSON([
            'status'   => 'successful',
            'message'  => 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.',
            'redirect' => base_url('/register/verification-sent'),
        ]);
    }

    private function sendVerificationEmail($email, $nama, $token)
    {
        $verificationLink = base_url("register/verify?token={$token}");

        $emailService = \Config\Services::email();
        
        $emailService->setTo($email);
        $emailService->setSubject('Verifikasi Email Akun LMS Elecomp Anda');
        
        $message = view('emails/verification', [
            'nama' => $nama,
            'link' => $verificationLink
        ]);
        
        $emailService->setMessage($message);

        if ($emailService->send()) {
            return true;
        } else {
            log_message('error', 'SMTP Error: ' . $emailService->printDebugger(['headers']));
            return false;
        }
    }

    // GET /register/verify?token=xxx
    public function verify()
    {
        $token = $this->request->getGet('token');

        if (!$token) {
            return redirect()->to('/register')->with('error', 'Token tidak valid.');
        }

        $usersModel = new Users();
        $user = $usersModel->where('verification_token', $token)->first();

        if (!$user) {
            return view('auth/verification_failed', [
                'message' => 'Token tidak ditemukan atau sudah digunakan.'
            ]);
        }

        // Cek apakah token expired
        $now = Time::now();
        $expiresAt = Time::parse($user['token_expires_at']);

        if ($now->isAfter($expiresAt)) {
            return view('auth/verification_failed', [
                'message' => 'Token sudah kedaluwarsa. Silakan daftar ulang.'
            ]);
        }

        // Update user jadi verified
        $usersModel->update($user['id_users'], [
            'email_verified'     => true,
            'verification_token' => null,
            'token_expires_at'   => null,
        ]);

        // Auto login setelah verifikasi
        session()->set([
            'logged_in' => true,
            'id_users'  => $user['id_users'],
            'nama'      => $user['nama_users'],
            'email'     => $user['email_users'],
            'role'      => $user['role_users'],
        ]);

        return redirect()->to('/dashboard/peserta/beranda')
                        ->with('success', 'Email berhasil diverifikasi!');
    }

    // Halaman konfirmasi email terkirim
    public function verificationSent()
    {
        return view('auth/verification_sent');
    }
}