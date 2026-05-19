<?php

namespace App\Models;

use CodeIgniter\Model;

class KalkulatorStateModel extends Model
{
    protected $table         = 'kalkulator_state';
    protected $primaryKey    = 'id_state';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_users', 'nama_produk', 'jumlah_barang', 'hpp', 'keuntungan', 'updated_at'];

    public function getByUser(int $userId): ?array
    {
        return $this->where('id_users', $userId)->first();
    }

    public function upsert(int $userId, array $data): bool
    {
        $row = $this->getByUser($userId);
        $data['updated_at'] = date('Y-m-d H:i:s');
        if ($row) {
            return $this->update($row['id_state'], $data);
        }
        $data['id_users'] = $userId;
        return (bool) $this->insert($data);
    }
}
