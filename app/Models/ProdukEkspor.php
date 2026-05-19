<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukEkspor extends Model
{
    protected $table         = 'produk_ekspor';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'nama_produk', 'hs_code',
        'foto_1', 'foto_2', 'foto_3', 'foto_4',
    ];

    /**
     * Ambil semua produk beserta negara tujuan dan buyer (nested array).
     */
    public function getAllNested(): array
    {
        $produkList  = $this->findAll();
        $negaraModel = new Negaratujuan();
        $buyerModel  = new BuyerEkspor();

        foreach ($produkList as &$produk) {
            $negaraList = $negaraModel->where('produk_id', $produk['id'])->findAll();
            foreach ($negaraList as &$negara) {
                $negara['buyers'] = $buyerModel
                    ->where('negara_tujuan_id', $negara['id'])
                    ->findAll();
            }
            $produk['negara_list'] = $negaraList;
        }

        return $produkList;
    }
}