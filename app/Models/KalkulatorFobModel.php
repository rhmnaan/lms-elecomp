<?php

namespace App\Models;

use CodeIgniter\Model;

class KalkulatorFobModel extends Model
{
    protected $table         = 'kalkulator_fob';
    protected $primaryKey    = 'id_fob';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_users', 'komponen_fob', 'biaya'];

    public function getByUser(int $userId): array
    {
        return $this->where('id_users', $userId)->orderBy('id_fob', 'ASC')->findAll();
    }
}
