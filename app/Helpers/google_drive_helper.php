<?php

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

/**
 * Buat Google Client pakai OAuth token (bukan Service Account)
 */
function getOAuthClient(): ?Client
{
    $tokenPath = WRITEPATH . 'google_token.json';

    if (! file_exists($tokenPath)) {
        log_message('error', '[GoogleDrive] google_token.json tidak ditemukan. Hubungkan dulu via /auth/google');
        return null;
    }

    $client = new Client();
    $client->setAuthConfig(WRITEPATH . 'client_secret.json');
    $client->addScope(Drive::DRIVE_FILE);

    $token = json_decode(file_get_contents($tokenPath), true);
    $client->setAccessToken($token);

    // Refresh token jika sudah expired
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

            if (isset($newToken['error'])) {
                log_message('error', '[GoogleDrive] Gagal refresh token: ' . ($newToken['error_description'] ?? $newToken['error']));
                return null;
            }

            file_put_contents($tokenPath, json_encode($newToken));
            $client->setAccessToken($newToken);
        } else {
            log_message('error', '[GoogleDrive] Token expired dan tidak ada refresh token. Silakan hubungkan ulang via /auth/google');
            return null;
        }
    }

    return $client;
}

/**
 * Upload file ke Google Drive folder tertentu
 * Fallback ke lokal jika Drive gagal
 */
function uploadToGoogleDrive(string $filePath, string $fileName, string $mimeType, string $folderId): array
{
    try {
        $client = getOAuthClient();

        if (! $client) {
            throw new \Exception('OAuth client tidak tersedia. Silakan hubungkan Google Drive via /auth/google');
        }

        $service = new Drive($client);

        $fileMetadata = new DriveFile([
            'name'    => $fileName,
            'parents' => [$folderId],
        ]);

        $content = file_get_contents($filePath);

        $file = $service->files->create($fileMetadata, [
            'data'       => $content,
            'mimeType'   => $mimeType,
            'uploadType' => 'multipart',
            'fields'     => 'id, webViewLink, webContentLink',
        ]);

        // Set permission publik agar bisa diakses via link
        $permission = new \Google\Service\Drive\Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);
        $service->permissions->create($file->getId(), $permission);

        return [
            'file_id'       => $file->getId(),
            'view_link'     => $file->getWebViewLink(),
            'download_link' => $file->getWebContentLink(),
            'storage'       => 'drive',
        ];

    } catch (\Exception $e) {
        log_message('error', '[GoogleDrive] Upload gagal, fallback ke lokal: ' . $e->getMessage());
        return uploadToLocal($filePath, $fileName);
    }
}

/**
 * Simpan file ke penyimpanan lokal server
 */
function uploadToLocal(string $filePath, string $fileName): array
{
    $permanentDir = FCPATH . 'uploads/tugas/';

    if (! is_dir($permanentDir)) {
        mkdir($permanentDir, 0755, true);
    }

    $destination = $permanentDir . $fileName;

    if (file_exists($destination)) {
        $ext         = pathinfo($fileName, PATHINFO_EXTENSION);
        $baseName    = pathinfo($fileName, PATHINFO_FILENAME);
        $fileName    = $baseName . '_' . time() . '.' . $ext;
        $destination = $permanentDir . $fileName;
    }

    if (! copy($filePath, $destination)) {
        throw new \Exception('Gagal menyimpan file ke server lokal.');
    }

    @unlink($filePath);

    return [
        'file_id'       => null,
        'view_link'     => base_url('uploads/tugas/' . $fileName),
        'download_link' => base_url('uploads/tugas/' . $fileName),
        'storage'       => 'local',
    ];
}

/**
 * Hapus file dari Google Drive by file ID
 */
function deleteFromGoogleDrive(string $fileId): bool
{
    if (empty($fileId)) {
        return true;
    }

    try {
        $client = getOAuthClient();

        if (! $client) {
            return false;
        }

        $service = new Drive($client);
        $service->files->delete($fileId);
        return true;

    } catch (\Exception $e) {
        log_message('error', '[GoogleDrive] Gagal hapus file: ' . $e->getMessage());
        return false;
    }
}

/**
 * Hapus file lokal dari server
 */
function deleteLocalFile(string $filePath): bool
{
    $fullPath = FCPATH . $filePath;

    if (file_exists($fullPath)) {
        return @unlink($fullPath);
    }

    return false;
}

/**
 * Deteksi MIME type dari ekstensi file
 */
function getMimeType(string $ext): string
{
    $mimes = [
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls'  => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt'  => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    ];
    return $mimes[$ext] ?? 'application/octet-stream';
}