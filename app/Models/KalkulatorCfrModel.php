<?php

namespace App\Models;

use CodeIgniter\Model;

class KalkulatorCfrModel extends Model
{
    protected $table         = 'kalkulator_cfr';
    protected $primaryKey    = 'id_cfr';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_users', 'komponen_cfr', 'biaya'];

    public function getByUser(int $userId): array
    {
        return $this->where('id_users', $userId)->orderBy('id_cfr', 'ASC')->findAll();
    }
}
