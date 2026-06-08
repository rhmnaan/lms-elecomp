<?php

namespace App\Controllers;

use App\Models\Users;
use CodeIgniter\I18n\Time;

class ForgotPassword extends BaseController
{
    // ─────────────────────────────────────────────────────────────────────────
    // GET /forgot-password
    // Halaman form input email
    // ─────────────────────────────────────────────────────────────────────────
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/forgot_password');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /forgot-password/send
    // Proses kirim email reset password
    // ─────────────────────────────────────────────────────────────────────────
    public function send()
    {
        $email = trim($this->request->getPost('email'));

        // Validasi format email
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Format email tidak valid.',
            ]);
        }

        $usersModel = new Users();
        $user = $usersModel->where('email_users', $email)->first();

        // Selalu kembalikan respon sukses meski email tidak ditemukan
        // (mencegah user enumeration / email enumeration attack)
        if (!$user) {
            return $this->response->setJSON([
                'status'  => 'successful',
                'message' => 'Jika email terdaftar, tautan reset telah dikirimkan.',
            ]);
        }

        // Cegah spam: cek apakah token yang ada belum kadaluarsa (cooldown 2 menit)
        if (!empty($user['reset_token']) && !empty($user['reset_token_expires_at'])) {
            $tokenExpires = Time::parse($user['reset_token_expires_at']);
            $sentAt       = $tokenExpires->subMinutes(28); // token berlaku 30 menit, jadi dikirim ~2 menit lalu
            $cooldownEnd  = $sentAt->addMinutes(2);

            if (Time::now()->isBefore($cooldownEnd)) {
                return $this->response->setJSON([
                    'status'  => 'successful',
                    'message' => 'Tautan reset sudah dikirim. Tunggu beberapa menit sebelum mengirim ulang.',
                ]);
            }
        }

        // Buat token baru
        $token      = bin2hex(random_bytes(32));
        $expiresAt  = Time::now()->addMinutes(30);

        // Simpan token ke database
        $usersModel->update($user['id_users'], [
            'reset_token'            => $token,
            'reset_token_expires_at' => $expiresAt,
        ]);

        // Kirim email
        $emailSent = $this->sendResetEmail($email, $user['nama_users'], $token);

        if (!$emailSent) {
            log_message('error', 'Email reset password gagal dikirim ke: ' . $email);
        }

        return $this->response->setJSON([
            'status'  => 'successful',
            'message' => 'Tautan reset password telah dikirimkan ke email Anda.',
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /forgot-password/reset?token=xxx
    // Halaman form isi password baru
    // ─────────────────────────────────────────────────────────────────────────
    public function resetForm()
    {
        $token = $this->request->getGet('token');

        if (!$token) {
            return view('auth/reset_password', [
                'valid_token' => false,
                'token'       => null,
                'email'       => null,
            ]);
        }

        $usersModel = new Users();
        $user = $usersModel->where('reset_token', $token)->first();

        // Token tidak ditemukan atau sudah kadaluarsa
        if (!$user || Time::now()->isAfter(Time::parse($user['reset_token_expires_at']))) {
            return view('auth/reset_password', [
                'valid_token' => false,
                'token'       => null,
                'email'       => null,
            ]);
        }

        return view('auth/reset_password', [
            'valid_token' => true,
            'token'       => $token,
            'email'       => $user['email_users'],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /forgot-password/reset
    // Proses simpan password baru
    // ─────────────────────────────────────────────────────────────────────────
    public function reset()
    {
        $token           = $this->request->getPost('token');
        $password        = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        // Validasi input
        if (!$token || !$password || !$passwordConfirm) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Semua field wajib diisi.',
            ]);
        }

        if ($password !== $passwordConfirm) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Konfirmasi password tidak cocok.',
            ]);
        }

        if (strlen($password) < 8) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Password minimal 8 karakter.',
            ]);
        }

        if (!preg_match('/[a-zA-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Password harus mengandung huruf dan angka.',
            ]);
        }

        // Cari user berdasarkan token
        $usersModel = new Users();
        $user = $usersModel->where('reset_token', $token)->first();

        if (!$user) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Token tidak valid. Silakan minta tautan reset baru.',
            ]);
        }

        // Cek apakah token belum kadaluarsa
        if (Time::now()->isAfter(Time::parse($user['reset_token_expires_at']))) {
            return $this->response->setJSON([
                'status'  => 'failed',
                'message' => 'Token sudah kadaluarsa. Silakan minta tautan reset baru.',
            ]);
        }

        // Update password & hapus token
        $usersModel->update($user['id_users'], [
            'password_users'          => password_hash($password, PASSWORD_BCRYPT),
            'reset_token'             => null,
            'reset_token_expires_at'  => null,
        ]);

        log_message('info', 'Password berhasil direset untuk user: ' . $user['email_users']);

        return $this->response->setJSON([
            'status'  => 'successful',
            'message' => 'Password berhasil diperbarui. Silakan login dengan password baru.',
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PRIVATE: Kirim email reset password
    // ─────────────────────────────────────────────────────────────────────────
    private function sendResetEmail(string $email, string $nama, string $token): bool
    {
        $resetLink = base_url("forgot-password/reset?token={$token}");

        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Reset Password Akun LMS Elecomp Anda');
        $emailService->setMessage(view('auth/email_reset_password', [
            'nama'      => $nama,
            'link'      => $resetLink,
            'expires'   => '30 menit',
        ]));

        if ($emailService->send()) {
            return true;
        }

        log_message('error', 'SMTP Error (reset password): ' . $emailService->printDebugger(['headers']));
        return false;
    }
}