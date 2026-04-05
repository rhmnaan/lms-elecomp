<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table            = 'quiz';
    protected $primaryKey       = 'id_quiz';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Soft Delete
    protected $useSoftDeletes   = true;

    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_modul',
        'id_materi',   // FK ke materi (boleh NULL)
        'id_kelas',
        'jenis_quiz',
        'judul_quiz',
        'deskripsi_quiz',
        'waktu_mulai_quiz',
        'waktu_selesai_quiz',
        'deskripsi',
    ];

    // Timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'id_modul'   => 'required|is_natural_no_zero',

        // id_materi FK → boleh kosong (NULL) tapi kalau diisi HARUS angka valid
        'id_materi'  => 'permit_empty|is_natural_no_zero',

        'jenis_quiz' => 'required|in_list[pretest,posttest]',
        'judul_quiz' => 'required|min_length[3]|max_length[150]',

        'waktu_mulai_quiz'   => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'waktu_selesai_quiz' => 'permit_empty|valid_date[Y-m-d H:i:s]',
    ];

    protected $validationMessages = [
        'jenis_quiz' => [
            'in_list' => 'Jenis quiz harus pretest atau posttest'
        ],
        'id_materi' => [
            'is_natural_no_zero' => 'ID materi tidak valid'
        ]
    ];

    protected $skipValidation = false;

    /* =====================================================
     * QUERY METHODS
     * ===================================================== */

    /**
     * Ambil quiz berdasarkan modul
     */
    public function getByModul(int $id_modul)
    {
        return $this->where('id_modul', $id_modul)
                    ->where('deleted_at', null)
                    ->orderBy('id_quiz', 'ASC')
                    ->findAll();
    }

    /**
     * Ambil quiz berdasarkan materi
     */
    public function getByMateri(int $id_materi)
    {
        return $this->where('id_materi', $id_materi)
                    ->where('deleted_at', null)
                    ->orderBy('id_quiz', 'ASC')
                    ->findAll();
    }

    /**
     * Ambil quiz + materi
     */
    public function getWithMateri(int $id_quiz)
    {
        return $this->select('quiz.*, materi.judul_materi')
                    ->join('materi', 'materi.id_materi = quiz.id_materi', 'left')
                    ->where('quiz.id_quiz', $id_quiz)
                    ->where('quiz.deleted_at', null)
                    ->first();
    }

    /**
     * Ambil quiz + soal
     */
    public function getWithQuestions(int $id_quiz)
    {
        $quiz = $this->where('deleted_at', null)->find($id_quiz);

        if (!$quiz) {
            return null;
        }

        $questionModel = new QuizQuestionsModel();
        $quiz['questions'] = $questionModel->getByQuiz($id_quiz);

        return $quiz;
    }

    /**
     * Quiz yang sedang aktif
     */
    public function getActiveQuizzes()
    {
        $now = date('Y-m-d H:i:s');

        return $this->where('waktu_mulai_quiz <=', $now)
                    ->where('waktu_selesai_quiz >=', $now)
                    ->where('deleted_at', null)
                    ->findAll();
    }
}