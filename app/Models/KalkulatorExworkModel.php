<?php

namespace App\Models;

use CodeIgniter\Model;

class KalkulatorExworkModel extends Model
{
    protected $table         = 'kalkulator_exwork';
    protected $primaryKey    = 'id_exwork';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_users', 'komponen_exwork', 'biaya'];

    public function getByUser(int $userId): array
    {
        return $this->where('id_users', $userId)->orderBy('id_exwork', 'ASC')->findAll();
    }
}
