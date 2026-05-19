<?php

namespace App\Models;

use CodeIgniter\Model;

class KalkulatorCifModel extends Model
{
    protected $table         = 'kalkulator_cif';
    protected $primaryKey    = 'id_cif';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_users', 'komponen_cif', 'biaya'];

    public function getByUser(int $userId): array
    {
        return $this->where('id_users', $userId)->orderBy('id_cif', 'ASC')->findAll();
    }
}
