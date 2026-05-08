<?php

namespace App\Models;

use CodeIgniter\Model;

class AplikasiUserModel extends Model
{
    protected $table      = 'aplikasi_user';
    protected $primaryKey = 'id_aplikasi_user';

    protected $allowedFields = [
        'id_aplikasi',
        'id_users',
    ];

    // Ambil semua aplikasi yang boleh diakses oleh user tertentu
    public function getAplikasiByUser(int $idUsers): array
    {
        return $this->db->table('aplikasi_user au')
            ->select('ap.id_aplikasi, ap.nama_aplikasi, ap.link_aplikasi')
            ->join('aplikasi_pendukung ap', 'ap.id_aplikasi = au.id_aplikasi')
            ->where('au.id_users', $idUsers)
            ->get()->getResultArray();
    }
}