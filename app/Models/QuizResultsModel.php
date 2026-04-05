<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizResultsModel extends Model
{
    protected $table = 'quiz_results';
    protected $primaryKey = 'id_quiz_results';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_quiz',
        'id_users',
        'jumlah_benar_quiz_results',
        'jumlah_salah_quiz_results',
        'nilai_quiz_results',
        'waktu_selesai_quiz_results'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    /**
     * Get results by user
     */
    public function getByUser($id_users)
    {
        return $this->where('id_users', $id_users)
            ->orderBy('waktu_selesai_quiz_results', 'DESC')
            ->findAll();
    }

    /**
     * Get results with quiz and kelas info
     */
    public function getWithQuizInfo($id_users = null, $limit = null)
    {
        $builder = $this->select('
                quiz_results.*,
                quiz.judul_quiz,
                kelas.nama_kelas,
                users.nama_users
            ')
            ->join('quiz', 'quiz.id_quiz = quiz_results.id_quiz')
            ->join('modul', 'modul.id_modul = quiz.id_modul')
            ->join('kelas', 'kelas.id_kelas = modul.id_kelas')
            ->join('users', 'users.id_users = quiz_results.id_users') // ✅ TAMBAHAN
            ->orderBy('quiz_results.waktu_selesai_quiz_results', 'DESC');

        if ($id_users) {
            $builder->where('quiz_results.id_users', $id_users);
        }

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->findAll();
    }

    /**
     * Get quiz completion count for user in specific kelas
     * TAMBAHKAN METHOD INI
     */
    public function getQuizDoneCountByKelas($id_users, $id_kelas)
    {
        $db = \Config\Database::connect();

        return $db->table('quiz_results qr')
            ->join('quiz q', 'q.id_quiz = qr.id_quiz')
            ->join('modul m', 'm.id_modul = q.id_modul')
            ->where('qr.id_users', $id_users)
            ->where('m.id_kelas', $id_kelas)
            ->where('qr.deleted_at', null)
            ->countAllResults();
    }

    /**
     * Get statistics for dashboard (distribution)
     */
    public function getDistribution()
    {
        $db = \Config\Database::connect();

        $lulus = $db->query("
            SELECT COUNT(*) as total FROM quiz_results
            WHERE nilai_quiz_results >= 70 AND deleted_at IS NULL
        ")->getRow()->total;

        $cukup = $db->query("
            SELECT COUNT(*) as total FROM quiz_results
            WHERE nilai_quiz_results >= 50 AND nilai_quiz_results < 70 AND deleted_at IS NULL
        ")->getRow()->total;

        $kurang = $db->query("
            SELECT COUNT(*) as total FROM quiz_results
            WHERE nilai_quiz_results < 50 AND deleted_at IS NULL
        ")->getRow()->total;

        return [
            'lulus' => $lulus,
            'cukup' => $cukup,
            'kurang' => $kurang
        ];
    }

    /**
     * Get leaderboard (top 5 by average score)
     */
    public function getLeaderboard($limit = 5)
    {
        $db = \Config\Database::connect();

        return $db->query("
            SELECT
                u.nama_users,
                ROUND(AVG(qr.nilai_quiz_results), 1) AS rata_nilai,
                COUNT(qr.id_quiz_results) AS total_quiz_dikerjakan
            FROM quiz_results qr
            JOIN users u ON u.id_users = qr.id_users
            WHERE u.role_users = 'peserta' AND u.deleted_at IS NULL AND qr.deleted_at IS NULL
            GROUP BY u.id_users, u.nama_users
            ORDER BY rata_nilai DESC
            LIMIT ?
        ", [$limit])->getResultArray();
    }

    /**
     * Get average score for user
     */
    public function getAverageScore($id_users)
    {
        $result = $this->selectAvg('nilai_quiz_results', 'average')
            ->where('id_users', $id_users)
            ->first();

        return $result ? round($result['average'], 1) : 0;
    }

    /**
     * Calculate and save quiz result
     */
    public function saveResult($id_quiz, $id_users, $answers, $questions)
    {
        $correct = 0;
        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? null;
            if ($userAnswer && $userAnswer == $question['jawaban_benar_quiz_questions']) {
                $correct++;
            }
        }

        $total = count($questions);
        $score = $total > 0 ? round(($correct / $total) * 100) : 0;

        return $this->insert([
            'id_quiz' => $id_quiz,
            'id_users' => $id_users,
            'jumlah_benar_quiz_results' => $correct,
            'jumlah_salah_quiz_results' => $total - $correct,
            'nilai_quiz_results' => $score,
            'waktu_selesai_quiz_results' => date('Y-m-d H:i:s')
        ]);
    }
}