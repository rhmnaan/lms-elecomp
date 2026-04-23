<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class FileController extends BaseController
{
    /**
     * Serve gambar kelas dari writable/uploads/kelas/
     * Route: GET /kelas/gambar/(:segment)
     *
     * Tambahkan di app/Config/Routes.php:
     * $routes->get('kelas/gambar/(:segment)', 'FileController::kelasGambar/$1');
     */
    public function kelasGambar(string $filename): void
    {
        // Sanitasi nama file — cegah path traversal
        $filename = basename($filename);

        $path = WRITEPATH . 'uploads/kelas/' . $filename;

        if (! file_exists($path) || ! is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Gambar tidak ditemukan.'
            );
        }

        $mime = mime_content_type($path);

        // Hanya izinkan tipe gambar
        $allowedMime = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
        if (! in_array($mime, $allowedMime, true)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Tipe file tidak diizinkan.'
            );
        }

        header('Content-Type: '   . $mime);
        header('Content-Length: ' . filesize($path));
        header('Cache-Control: public, max-age=86400');  // cache 1 hari
        header('X-Content-Type-Options: nosniff');

        readfile($path);
        exit;
    }
}