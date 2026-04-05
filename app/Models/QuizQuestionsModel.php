<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizQuestionsModel extends Model
{
    protected $table = 'quiz_questions';
    protected $primaryKey = 'id_quiz_questions';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_quiz',
        'pertanyaan_quiz_questions',
        'pilihan_a_quiz_questions',
        'pilihan_b_quiz_questions',
        'pilihan_c_quiz_questions',
        'pilihan_d_quiz_questions',
        'jawaban_benar_quiz_questions'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'id_quiz' => 'required|numeric',
        'pertanyaan_quiz_questions' => 'required',
        'jawaban_benar_quiz_questions' => 'required|in_list[A,B,C,D]'
    ];
    
    /**
     * Get questions by quiz
     */
    public function getByQuiz($id_quiz)
    {
        return $this->where('id_quiz', $id_quiz)->findAll();
    }
    
    /**
     * Get question with options as array
     */
    public function getWithOptions($id_quiz)
    {
        $questions = $this->getByQuiz($id_quiz);
        
        foreach ($questions as &$q) {
            $q['options'] = [
                'A' => $q['pilihan_a_quiz_questions'],
                'B' => $q['pilihan_b_quiz_questions'],
                'C' => $q['pilihan_c_quiz_questions'],
                'D' => $q['pilihan_d_quiz_questions']
            ];
        }
        
        return $questions;
    }
}