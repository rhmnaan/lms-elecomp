<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdukEkspor;
use App\Models\NegaraTujuan;
use App\Models\BuyerEkspor;

class RisetEkspor extends BaseController
{
    protected $produkModel;
    protected $negaraModel;
    protected $buyerModel;
    protected $uploadPath;
    protected $uploadUrl;

    public function __construct()
    {
        $this->produkModel = new ProdukEkspor();
        $this->negaraModel = new NegaraTujuan();
        $this->buyerModel  = new BuyerEkspor();
        $this->uploadPath  = WRITEPATH . 'uploads/riset_ekspor/';
        $this->uploadUrl   = base_url('uploads/riset_ekspor/');

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
    }

    // ─────────────────────────────────────────────────────────
    // GET /dashboard/peserta/riset-ekspor
    //   → Halaman form input (untuk peserta mengisi data)
    // ─────────────────────────────────────────────────────────
    public function index()
    {
        return view('Dashboard/Peserta/RisetEkspor/form', [
            'title' => 'Riset Pasar Ekspor',
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // POST /dashboard/peserta/riset-ekspor/simpan  (AJAX JSON)
    //   → Simpan semua data produk + negara + buyer sekaligus
    // ─────────────────────────────────────────────────────────
    public function simpan()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $json       = $this->request->getJSON(true);
        $produkList = $json['produk'] ?? [];

        if (empty($produkList)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada data produk yang dikirim.']);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($produkList as $produk) {
            // Simpan foto base64 → file fisik
            $fotos = [];
            for ($i = 1; $i <= 4; $i++) {
                $fotos['foto_' . $i] = $this->simpanBase64($produk['foto_' . $i] ?? null);
            }

            $produkId = $this->produkModel->insert([
                'nama_produk' => trim($produk['nama_produk'] ?? ''),
                'hs_code'     => trim($produk['hs_code']     ?? '') ?: null,
                'foto_1'      => $fotos['foto_1'],
                'foto_2'      => $fotos['foto_2'],
                'foto_3'      => $fotos['foto_3'],
                'foto_4'      => $fotos['foto_4'],
            ]);

            foreach ($produk['negara_list'] ?? [] as $negara) {
                $negaraId = $this->negaraModel->insert([
                    'produk_id'          => $produkId,
                    'negara'             => trim($negara['negara']             ?? ''),
                    'alasan_pemilihan'   => trim($negara['alasan_pemilihan']   ?? '') ?: null,
                    'persyaratan_ekspor' => trim($negara['persyaratan_ekspor'] ?? '') ?: null,
                ]);

                foreach ($negara['buyers'] ?? [] as $buyer) {
                    $this->buyerModel->insert([
                        'negara_tujuan_id' => $negaraId,
                        'nama_perusahaan'  => trim($buyer['nama_perusahaan'] ?? '') ?: null,
                        'alamat'           => trim($buyer['alamat']          ?? '') ?: null,
                        'website'          => trim($buyer['website']         ?? '') ?: null,
                        'email'            => trim($buyer['email']           ?? '') ?: null,
                        'no_hp'            => trim($buyer['no_hp']           ?? '') ?: null,
                        'nama_pic'         => trim($buyer['nama_pic']        ?? '') ?: null,
                    ]);
                }
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan data. Silakan coba lagi.',
            ]);
        }

        return $this->response->setJSON([
            'success'   => true,
            'message'   => 'Data riset berhasil disimpan!',
            'csrf_hash' => csrf_hash(),
            'redirect'  => base_url('dashboard/peserta/riset-ekspor/hasil'),
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // GET /dashboard/peserta/riset-ekspor/hasil
    //   → Tabel hasil semua data yang sudah tersimpan
    // ─────────────────────────────────────────────────────────
    public function hasil()
    {
        $produkList = $this->produkModel->getAllNested();

        return view('Dashboard/Peserta/RisetEkspor/hasil', [
            'title'      => 'Hasil Riset Pasar Ekspor',
            'produkList' => $produkList,
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // GET /dashboard/pengajar/riset-ekspor
    //   → Pengajar melihat semua hasil riset peserta (read-only)
    // ─────────────────────────────────────────────────────────
    public function hasilPengajar()
    {
        $produkList = $this->produkModel->getAllNested();

        return view('Dashboard/Pengajar/RisetEkspor/hasil', [
            'title'      => 'Hasil Riset Pasar Ekspor Peserta',
            'produkList' => $produkList,
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // POST /dashboard/peserta/riset-ekspor/hapus/{id}
    //   → Hapus satu produk (cascade ke negara + buyer)
    // ─────────────────────────────────────────────────────────
    public function hapus($id)
    {
        $this->produkModel->delete($id);
        return redirect()
            ->to('/dashboard/peserta/riset-ekspor/hasil')
            ->with('success', 'Data produk berhasil dihapus.');
    }

    // ─────────────────────────────────────────────────────────
    // Helper: decode base64 image → simpan ke disk → return URL
    // ─────────────────────────────────────────────────────────
    private function simpanBase64(?string $base64): ?string
    {
        if (!$base64 || !str_contains($base64, ',')) return null;

        [$meta, $data] = explode(',', $base64, 2);
        $ext = 'jpg';
        if (str_contains($meta, 'png'))  $ext = 'png';
        if (str_contains($meta, 'webp')) $ext = 'webp';
        if (str_contains($meta, 'gif'))  $ext = 'gif';

        $decoded = base64_decode($data);
        if (!$decoded) return null;

        $filename = uniqid('foto_', true) . '.' . $ext;
        file_put_contents($this->uploadPath . $filename, $decoded);

        return $this->uploadUrl . $filename;
    }
}