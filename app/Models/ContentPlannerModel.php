<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentPlannerModel extends Model
{
    protected $table      = 'content_planner';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_users',         
        'judul_konten',
        'deskripsi',
        'tanggal_publish',
        'jenis_konten_id',
        'content_type_id',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    /**
     * Ambil semua content planner MILIK USER
     * + relasi jenis & content type
     */
    public function getAllWithRelationByUser($idUser)
    {
        return $this->select('
                content_planner.*,
                jenis_konten.nama_jenis,
                content_type.nama_type
            ')
            ->join(
                'jenis_konten',
                'jenis_konten.id = content_planner.jenis_konten_id
                 AND jenis_konten.id_users = content_planner.id_users',
                'left'
            )
            ->join(
                'content_type',
                'content_type.id = content_planner.content_type_id
                 AND content_type.id_users = content_planner.id_users',
                'left'
            )
            ->where('content_planner.id_users', $idUser)
            ->orderBy('content_planner.tanggal_publish', 'ASC')
            ->findAll();
    }
}