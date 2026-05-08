<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class GoogleAuth extends Controller
{
    private function getClient()
    {
        $client = new \Google\Client();
        $client->setApplicationName('Upload Tugas App');
        $client->setAuthConfig(WRITEPATH . 'client_secret.json');
        $client->addScope(\Google\Service\Drive::DRIVE_FILE);
        $client->setRedirectUri(base_url('auth/google/callback'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return $client;
    }

    public function index()
    {
        $tokenPath = WRITEPATH . 'google_token.json';

        if (file_exists($tokenPath)) {
            $token  = json_decode(file_get_contents($tokenPath), true);
            $client = $this->getClient();
            $client->setAccessToken($token);

            if (! $client->isAccessTokenExpired()) {
                return view('google_auth_status', [
                    'status'  => 'connected',
                    'message' => 'Google Drive sudah terkoneksi!',
                ]);
            }
        }

        return view('google_auth_status', [
            'status'  => 'disconnected',
            'message' => 'Google Drive belum terkoneksi.',
        ]);
    }

    public function authorize()
    {
        $client  = $this->getClient();
        $authUrl = $client->createAuthUrl();

        return redirect()->to($authUrl);
    }

    public function callback()
    {
        $client = $this->getClient();

        if (! isset($_GET['code'])) {
            return redirect()->to('/auth/google')->with('error', 'Authorization gagal.');
        }

        try {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

            if (isset($token['error'])) {
                throw new \Exception($token['error_description'] ?? 'Gagal mendapatkan token.');
            }

            file_put_contents(WRITEPATH . 'google_token.json', json_encode($token));

            return redirect()->to('/auth/google')->with('success', 'Google Drive berhasil terkoneksi!');

        } catch (\Exception $e) {
            log_message('error', '[GoogleAuth] ' . $e->getMessage());
            return redirect()->to('/auth/google')->with('error', 'Gagal koneksi: ' . $e->getMessage());
        }
    }

    public function disconnect()
    {
        $tokenPath = WRITEPATH . 'google_token.json';

        if (file_exists($tokenPath)) {
            unlink($tokenPath);
        }

        return redirect()->to('/auth/google')->with('success', 'Google Drive berhasil diputus.');
    }
}