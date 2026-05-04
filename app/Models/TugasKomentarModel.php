<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasKomentarModel extends Model
{
    protected $table            = 'tugas_komentar';
    protected $primaryKey       = 'id_komentar';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_pengumpulan',
        'id_users',
        'komentar',
        'created_at'
    ];

    protected $useTimestamps = false;

    // Ambil komentar per submission
    public function getByPengumpulan($id_pengumpulan)
    {
        return $this->select('tugas_komentar.*, users.nama_users')
                    ->join('users', 'users.id_users = tugas_komentar.id_users')
                    ->where('id_pengumpulan', $id_pengumpulan)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
}