<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulModel extends Model
{
    protected $table = 'modul';
    protected $primaryKey = 'id_modul';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_kelas',
        'judul_modul',
        'urutan_modul'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    /**
     * Get modul by kelas
     */
    public function getByKelas($id_kelas)
    {
        return $this->where('id_kelas', $id_kelas)
                    ->orderBy('urutan_modul', 'ASC')
                    ->findAll();
    }
    
    /**
     * Get modul with materi and quiz count
     */
    public function getWithCounts($id_kelas = null)
    {
        $builder = $this->select('
                modul.*,
                COUNT(DISTINCT materi.id_materi) as total_materi,
                COUNT(DISTINCT quiz.id_quiz) as total_quiz
            ')
            ->join('materi', 'materi.id_modul = modul.id_modul AND materi.deleted_at IS NULL', 'left')
            ->join('quiz', 'quiz.id_modul = modul.id_modul AND quiz.deleted_at IS NULL', 'left')
            ->groupBy('modul.id_modul')
            ->orderBy('modul.urutan_modul', 'ASC');
        
        if ($id_kelas) {
            $builder->where('modul.id_kelas', $id_kelas);
        }
        
        return $builder->findAll();
    }
    
    /**
     * Get modul with progress for a user (tanpa materi_progress)
     */
    public function getWithProgress($id_kelas, $id_users)
    {
        $moduls = $this->getWithCounts($id_kelas);
        $db = \Config\Database::connect();
        
        foreach ($moduls as &$modul) {
            // Hitung quiz yang sudah dikerjakan
            $quiz_done = $db->table('quiz_results qr')
                ->join('quiz q', 'q.id_quiz = qr.id_quiz')
                ->where('qr.id_users', $id_users)
                ->where('q.id_modul', $modul['id_modul'])
                ->where('qr.deleted_at', null)
                ->countAllResults();
            
            $modul['quiz_dikerjakan'] = $quiz_done;
            $modul['persen'] = $modul['total_materi'] > 0
                ? min(100, round(($quiz_done / max($modul['total_materi'], 1)) * 100))
                : 0;
        }
        
        return $moduls;
    }

    /**
     * Get modul beserta nama_kelas dan total_materi
     * (digunakan di halaman modul pengajar)
     */
    public function getWithMateriCount(int $id_kelas): array
    {
        return $this->select('modul.*, COUNT(DISTINCT materi.id_materi) AS total_materi')
                    ->join('materi', 'materi.id_modul = modul.id_modul AND materi.deleted_at IS NULL', 'left')
                    ->where('modul.id_kelas', $id_kelas)
                    ->where('modul.deleted_at', null)
                    ->groupBy('modul.id_modul')
                    ->orderBy('modul.urutan_modul', 'ASC')
                    ->findAll();
    }
}