<?php

namespace App\Models;

use CodeIgniter\Model;

class UserMateriProgressModel extends Model
{
    protected $table      = 'user_materi_progress';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_users',
        'id_materi',
        'is_completed',
        'completed_at',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    /* =========================
       🔹 CEK SUDAH SELESAI
    ========================= */
    public function isCompleted($idUser, $idMateri)
    {
        return $this->where('id_users', $idUser)
                    ->where('id_materi', $idMateri)
                    ->where('is_completed', 1)
                    ->first();
    }

    /* =========================
       🔹 TANDAI SELESAI
    ========================= */
    public function markAsCompleted($idUser, $idMateri)
    {
        return $this->replace([
            'id_users'     => $idUser,
            'id_materi'    => $idMateri,
            'is_completed' => 1,
            'completed_at' => date('Y-m-d H:i:s')
        ]);
    }

    /* =========================
       🔹 HITUNG JUMLAH SELESAI
    ========================= */
    public function countCompleted($idUser, $materiIds = [])
    {
        return $this->where('id_users', $idUser)
                    ->whereIn('id_materi', $materiIds)
                    ->where('is_completed', 1)
                    ->countAllResults();
    }

    /* =========================
       🔹 CEK SEMUA SELESAI
    ========================= */
    public function isAllCompleted($idUser, $materiIds = [])
    {
        if (empty($materiIds)) return false;

        $completed = $this->countCompleted($idUser, $materiIds);

        return $completed === count($materiIds);
    }

    /* =========================
       🔹 GET SEMUA PROGRESS USER
    ========================= */
    public function getUserProgress($idUser)
    {
        return $this->where('id_users', $idUser)->findAll();
    }
}