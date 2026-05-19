<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KalkulatorSatuanModel;
use App\Models\KalkulatorStateModel;
use App\Models\KalkulatorExworkModel;
use App\Models\KalkulatorFobModel;
use App\Models\KalkulatorCfrModel;
use App\Models\KalkulatorCifModel;

class KalkulatorController extends BaseController
{
    // ─────────────────────────────────────────────────────
    // Helper: ambil id_users dari session
    // ─────────────────────────────────────────────────────
    private function userId(): int
    {
        return (int) session()->get('id_users');
    }

    // ─────────────────────────────────────────────────────
    // GET  dashboard/pengajar/kalkulator
    // ─────────────────────────────────────────────────────
    public function index(): string
    {
        $userId = $this->userId();

        $satuanModel  = new KalkulatorSatuanModel();
        $exworkModel  = new KalkulatorExworkModel();
        $fobModel     = new KalkulatorFobModel();
        $cfrModel     = new KalkulatorCfrModel();
        $cifModel     = new KalkulatorCifModel();

        $satuanRow   = $satuanModel->getByUser($userId);
        $labelSatuan = $satuanRow['satuan'] ?? '';

        return view('dashboard/pengajar/kalkulator/index', [
            'title'          => 'Kalkulator Ekspor',
            'labelSatuan'    => $labelSatuan,
            'satuanRow'      => $satuanRow,
            'ukuranKontainer'=> [], // bisa diisi dari tabel bila ada
            'exwork'         => $exworkModel->getByUser($userId),
            'fob'            => $fobModel->getByUser($userId),
            'cfr'            => $cfrModel->getByUser($userId),
            'cif'            => $cifModel->getByUser($userId),
        ]);
    }

    // ─────────────────────────────────────────────────────
    // POST  dashboard/pengajar/kalkulator/satuan/upsert-json
    // AJAX: simpan satuan
    // ─────────────────────────────────────────────────────
    public function upsertSatuanJson(): \CodeIgniter\HTTP\ResponseInterface
    {
        $userId = $this->userId();
        $satuan = trim((string) $this->request->getPost('satuan'));

        $model = new KalkulatorSatuanModel();
        $ok    = $model->upsert($userId, $satuan);

        return $this->response->setJSON(['ok' => $ok, 'satuan' => $satuan]);
    }

    // ─────────────────────────────────────────────────────
    // POST  dashboard/pengajar/kalkulator/state/save
    // AJAX: simpan state global (nama produk, hpp, dll)
    // ─────────────────────────────────────────────────────
    public function saveState(): \CodeIgniter\HTTP\ResponseInterface
    {
        $userId = $this->userId();
        $model  = new KalkulatorStateModel();

        $ok = $model->upsert($userId, [
            'nama_produk'   => $this->request->getPost('nama_produk')   ?? '',
            'jumlah_barang' => (int) $this->request->getPost('jumlah_barang'),
            'hpp'           => (int) $this->request->getPost('hpp'),
            'keuntungan'    => (int) $this->request->getPost('keuntungan'),
        ]);

        return $this->response->setJSON(['ok' => $ok]);
    }

    // ─────────────────────────────────────────────────────
    // GET   dashboard/pengajar/kalkulator/state/load
    // AJAX: load state global
    // ─────────────────────────────────────────────────────
    public function loadState(): \CodeIgniter\HTTP\ResponseInterface
    {
        $userId = $this->userId();
        $model  = new KalkulatorStateModel();
        $row    = $model->getByUser($userId);

        return $this->response->setJSON(['ok' => (bool) $row, 'data' => $row]);
    }

    // ══════════════════════════════════════════════════════
    //  EXWORK
    // ══════════════════════════════════════════════════════

    // POST  dashboard/pengajar/kalkulator/exwork/save-all
    public function saveAllExwork(): \CodeIgniter\HTTP\RedirectResponse
    {
        $userId = $this->userId();
        $model  = new KalkulatorExworkModel();
        $db     = \Config\Database::connect();

        // Update biaya komponen yang sudah ada
        $existing = $model->getByUser($userId);
        foreach ($existing as $row) {
            $key  = 'exwork_' . $row['id_exwork'];
            $val  = $this->request->getPost($key);
            if ($val !== null) {
                $model->update($row['id_exwork'], ['biaya' => (int) $val]);
            }
        }

        // Simpan komponen baru
        $namaArr  = $this->request->getPost('komponenExwork') ?? [];
        $biayaArr = $this->request->getPost('biayaExwork')    ?? [];

        foreach ($namaArr as $i => $nama) {
            $nama = trim($nama);
            if ($nama === '') continue;
            $model->insert([
                'id_users'        => $userId,
                'komponen_exwork' => $nama,
                'biaya'           => (int) ($biayaArr[$i] ?? 0),
            ]);
        }

        return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                         ->with('success', 'Komponen Exwork berhasil disimpan.');
    }

    // GET  dashboard/pengajar/kalkulator/exwork/delete/(:num)
    public function deleteExwork(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $userId = $this->userId();
        $model  = new KalkulatorExworkModel();
        $row    = $model->find($id);

        if ($row && (int) $row['id_users'] === $userId) {
            $model->delete($id);
            return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                             ->with('success', 'Komponen Exwork dihapus.');
        }
        return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                         ->with('error', 'Data tidak ditemukan.');
    }

    // ══════════════════════════════════════════════════════
    //  FOB
    // ══════════════════════════════════════════════════════

    public function saveAllFob(): \CodeIgniter\HTTP\RedirectResponse
    {
        $userId = $this->userId();
        $model  = new KalkulatorFobModel();

        $existing = $model->getByUser($userId);
        foreach ($existing as $row) {
            $val = $this->request->getPost('fob_' . $row['id_fob']);
            if ($val !== null) {
                $model->update($row['id_fob'], ['biaya' => (int) $val]);
            }
        }

        $namaArr  = $this->request->getPost('komponenFOB') ?? [];
        $biayaArr = $this->request->getPost('biayaFOB')    ?? [];
        foreach ($namaArr as $i => $nama) {
            $nama = trim($nama);
            if ($nama === '') continue;
            $model->insert([
                'id_users'     => $userId,
                'komponen_fob' => $nama,
                'biaya'        => (int) ($biayaArr[$i] ?? 0),
            ]);
        }

        return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                         ->with('success', 'Komponen FOB berhasil disimpan.');
    }

    public function deleteFob(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $userId = $this->userId();
        $model  = new KalkulatorFobModel();
        $row    = $model->find($id);

        if ($row && (int) $row['id_users'] === $userId) {
            $model->delete($id);
            return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                             ->with('success', 'Komponen FOB dihapus.');
        }
        return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                         ->with('error', 'Data tidak ditemukan.');
    }

    // ══════════════════════════════════════════════════════
    //  CFR
    // ══════════════════════════════════════════════════════

    public function saveAllCfr(): \CodeIgniter\HTTP\RedirectResponse
    {
        $userId = $this->userId();
        $model  = new KalkulatorCfrModel();

        $existing = $model->getByUser($userId);
        foreach ($existing as $row) {
            $val = $this->request->getPost('cfr_' . $row['id_cfr']);
            if ($val !== null) {
                $model->update($row['id_cfr'], ['biaya' => (int) $val]);
            }
        }

        $namaArr  = $this->request->getPost('komponenCFR') ?? [];
        $biayaArr = $this->request->getPost('biayaCFR')    ?? [];
        foreach ($namaArr as $i => $nama) {
            $nama = trim($nama);
            if ($nama === '') continue;
            $model->insert([
                'id_users'     => $userId,
                'komponen_cfr' => $nama,
                'biaya'        => (int) ($biayaArr[$i] ?? 0),
            ]);
        }

        return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                         ->with('success', 'Komponen CFR berhasil disimpan.');
    }

    public function deleteCfr(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $userId = $this->userId();
        $model  = new KalkulatorCfrModel();
        $row    = $model->find($id);

        if ($row && (int) $row['id_users'] === $userId) {
            $model->delete($id);
            return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                             ->with('success', 'Komponen CFR dihapus.');
        }
        return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                         ->with('error', 'Data tidak ditemukan.');
    }

    // ══════════════════════════════════════════════════════
    //  CIF
    // ══════════════════════════════════════════════════════

    public function saveAllCif(): \CodeIgniter\HTTP\RedirectResponse
    {
        $userId = $this->userId();
        $model  = new KalkulatorCifModel();

        $existing = $model->getByUser($userId);
        foreach ($existing as $row) {
            $val = $this->request->getPost('cif_' . $row['id_cif']);
            if ($val !== null) {
                $model->update($row['id_cif'], ['biaya' => (int) $val]);
            }
        }

        $namaArr  = $this->request->getPost('komponenCIF') ?? [];
        $biayaArr = $this->request->getPost('biayaCIF')    ?? [];
        foreach ($namaArr as $i => $nama) {
            $nama = trim($nama);
            if ($nama === '') continue;
            $model->insert([
                'id_users'     => $userId,
                'komponen_cif' => $nama,
                'biaya'        => (int) ($biayaArr[$i] ?? 0),
            ]);
        }

        return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                         ->with('success', 'Komponen CIF berhasil disimpan.');
    }

    public function deleteCif(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $userId = $this->userId();
        $model  = new KalkulatorCifModel();
        $row    = $model->find($id);

        if ($row && (int) $row['id_users'] === $userId) {
            $model->delete($id);
            return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                             ->with('success', 'Komponen CIF dihapus.');
        }
        return redirect()->to(base_url('dashboard/pengajar/kalkulator'))
                         ->with('error', 'Data tidak ditemukan.');
    }
}
