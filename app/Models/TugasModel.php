<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $table            = 'tugas';
    protected $primaryKey       = 'id_tugas';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_kelas',
        'id_modul',
        'judul_tugas',
        'deskripsi_tugas',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $useTimestamps = false;

    // Ambil tugas per kelas
    public function getByKelas($id_kelas)
    {
        return $this->where('id_kelas', $id_kelas)
                    ->where('deleted_at', null)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}