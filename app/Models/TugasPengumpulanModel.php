<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasPengumpulanModel extends Model
{
    protected $table            = 'tugas_pengumpulan';
    protected $primaryKey       = 'id_pengumpulan';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_tugas',
        'id_users',
        'tipe_jawaban',
        'link_file',
        'jawaban_text',
        'catatan_peserta',
        'status',
        'created_at'
    ];

    protected $useTimestamps = false;

    // Ambil submission terakhir
    public function getLastSubmission($id_tugas, $id_users)
    {
        return $this->where('id_tugas', $id_tugas)
                    ->where('id_users', $id_users)
                    ->orderBy('created_at', 'DESC')
                    ->first();
    }

    // Ambil semua history submission
    public function getHistory($id_tugas, $id_users)
    {
        return $this->where('id_tugas', $id_tugas)
                    ->where('id_users', $id_users)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}