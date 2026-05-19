<?php

namespace App\Models;

use CodeIgniter\Model;

class KalkulatorSatuanModel extends Model
{
    protected $table         = 'kalkulator_satuan';
    protected $primaryKey    = 'id_satuan';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_users', 'satuan'];

    public function getByUser(int $userId): ?array
    {
        return $this->where('id_users', $userId)->first();
    }

    public function upsert(int $userId, string $satuan): bool
    {
        $row = $this->getByUser($userId);
        if ($row) {
            return $this->update($row['id_satuan'], ['satuan' => $satuan]);
        }
        return (bool) $this->insert(['id_users' => $userId, 'satuan' => $satuan]);
    }
}
