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
        $email = $this->request->getPost('email_users');
        $password = $this->request->getPost('password_users');
        $nama = $this->request->getPost('nama_users');
        $username = $this->request->getPost('username');
        $nomor_hp = $this->request->getPost('nomor_hp');

        if (!$email || !$password || !$nama) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Semua field wajib diisi.'
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Format email tidak valid.'
            ]);
        }

        if (strlen($password) < 8) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Password minimal 8 karakter.'
            ]);
        }

        if (!preg_match('/[a-zA-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Password harus mengandung huruf dan angka.'
            ]);
        }

        $usersModel = new Users();

        if ($usersModel->where('email_users', $email)->first()) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Email sudah terdaftar. Silakan gunakan email lain.'
            ]);
        }

        if (!$nomor_hp) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Nomor HP wajib diisi.'
            ]);
        }

        if (!preg_match('/^[0-9]{9,15}$/', $nomor_hp)) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Format nomor HP tidak valid. Gunakan angka 9-15 digit.'
            ]);
        }

        if ($usersModel->where('nomor_hp', $nomor_hp)->first()) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Nomor HP sudah terdaftar. Gunakan nomor lain.'
            ]);
        }

        if (!$username) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Username wajib diisi.'
            ]);
        }

        if (!preg_match('/^[a-zA-Z0-9_.]{3,50}$/', $username)) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Format username tidak valid.'
            ]);
        }

        if ($usersModel->where('username', $username)->first()) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Username sudah digunakan. Pilih username lain.'
            ]);
        }

        $fp = $_COOKIE['device_fp'] ?? null;

        $verificationToken = bin2hex(random_bytes(32));
        $tokenExpires = Time::now()->addHours(24);

        $usersModel->insert([
            'nama_users' => $nama,
            'username' => $username,
            'email_users' => $email,
            'password_users' => password_hash($password, PASSWORD_BCRYPT),
            'role_users' => 'peserta',
            'nomor_hp' => $nomor_hp,
            'fingerprint_device' => $fp,
            'email_verified' => false,
            'verification_token' => $verificationToken,
            'token_expires_at' => $tokenExpires,
        ]);

        $emailSent = $this->sendVerificationEmail($email, $nama, $verificationToken);

        if (!$emailSent) {
            log_message('error', 'Email verifikasi gagal dikirim ke: ' . $email);
        }

        return $this->response->setJSON([
            'status' => 'successful',
            'message' => 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.',
            'redirect' => base_url('/register/verification-sent'),
        ]);
    }

    private function sendVerificationEmail($email, $nama, $token)
    {
        $verificationLink = base_url("register/verify?token={$token}");

        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Verifikasi Email Akun LMS Elecomp Anda');
        $emailService->setMessage(view('emails/verification', [
            'nama' => $nama,
            'link' => $verificationLink
        ]));

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

        $now = Time::now();
        $expiresAt = Time::parse($user['token_expires_at']);

        if ($now->isAfter($expiresAt)) {
            return view('auth/verification_failed', [
                'message' => 'Token sudah kedaluwarsa. Silakan daftar ulang.'
            ]);
        }

        $usersModel->update($user['id_users'], [
            'email_verified' => true,
            'verification_token' => null,
            'token_expires_at' => null,
        ]);

        // Auto login setelah verifikasi
        session()->set([
            'logged_in' => true,
            'id_users' => $user['id_users'],
            'nama' => $user['nama_users'],
            'email_users' => $user['email_users'], // ← konsisten dengan Auth
            'role' => $user['role_users'],
        ]);

        // Redirect sesuai role
        $redirect = match ($user['role_users']) {
            'admin' => '/dashboard/admin/beranda',
            'pengajar' => '/dashboard/pengajar',
            'peserta' => '/dashboard/peserta/beranda',
            default => '/dashboard',
        };

        return redirect()->to($redirect)
            ->with('success', 'Email berhasil diverifikasi!');
    }

    // Halaman konfirmasi email terkirim
    public function verificationSent()
    {
        return view('auth/verification_sent');
    }
}