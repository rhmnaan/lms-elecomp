<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Video extends Controller
{
    // public function stream($filename)
    // {
    //     // Lokasi video terenkripsi
    //     $path = WRITEPATH . 'uploads/encrypted/' . $filename . '.enc';

    //     if (!file_exists($path)) {
    //         return $this->response->setStatusCode(404, 'Video tidak ditemukan');
    //     }

    //     // =====================================================
    //     // 🔓 DEKRIPSI (SESUAIKAN DENGAN SISTEM KAMU)
    //     // =====================================================
    //     $encrypted = file_get_contents($path);

    //     /**
    //      * ⚠️ GANTI BAGIAN INI
    //      * Jika kamu punya fungsi decrypt sendiri
    //      */
    //     $videoData = $this->decryptVideo($encrypted);

    //     // =====================================================
    //     // 🎥 STREAM VIDEO (HTML5 FRIENDLY)
    //     // =====================================================
    //     return $this->response
    //         ->setHeader('Content-Type', 'video/mp4')
    //         ->setHeader('Accept-Ranges', 'bytes')
    //         ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate')
    //         ->setBody($videoData);
    // }

    // /**
    //  * CONTOH DEKRIPSI
    //  * GANTI sesuai metode enkripsi kamu
    //  */
    // private function decryptVideo($data)
    // {
    //     // contoh: base64 (hapus kalau beda)
    //     return base64_decode($data);
    // }
    
    public function stream($filename)
    {
        return 'TEST VIDEO ROUTE';
    }
}