<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AplikasiPendukungModel;
use App\Models\KalkulatorSatuanModel;
use App\Models\KalkulatorStateModel;
use App\Models\KalkulatorExworkModel;
use App\Models\KalkulatorFobModel;
use App\Models\KalkulatorCfrModel;
use App\Models\KalkulatorCifModel;

/**
 * KalkulatorPeserta
 * Kalkulator Ekspor yang diakses peserta via menu Aplikasi Pendukung.
 * Akses dikontrol: hanya peserta yang diberi izin oleh pengajar.
 */
class KalkulatorPeserta extends BaseController
{
    // ─── Helper: id_users dari session ───────────────────────
    private function userId(): int
    {
        return (int) session()->get('id_users');
    }

    // ─── Middleware: cek akses aplikasi ──────────────────────
    private function cekAkses(): bool
    {
        $userId      = $this->userId();
        $appModel    = new AplikasiPendukungModel();
        $kalkulator  = $appModel->findInternal('Kalkulator Ekspor');

        if (!$kalkulator) return false;
        return $appModel->hasAccess($userId, (int) $kalkulator['id_aplikasi']);
    }

    // ─────────────────────────────────────────────────────────
    // GET  dashboard/peserta/kalkulator
    // ─────────────────────────────────────────────────────────
    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->cekAkses()) {
            return redirect()->to(base_url('dashboard/peserta/aplikasi'))
                             ->with('error', 'Anda belum memiliki akses ke Kalkulator Ekspor.');
        }

        $userId = $this->userId();

        $satuanModel = new KalkulatorSatuanModel();
        $exworkModel = new KalkulatorExworkModel();
        $fobModel    = new KalkulatorFobModel();
        $cfrModel    = new KalkulatorCfrModel();
        $cifModel    = new KalkulatorCifModel();

        $satuanRow   = $satuanModel->getByUser($userId);
        $labelSatuan = $satuanRow['satuan'] ?? '';

        return view('dashboard/peserta/kalkulator/index', [
            'title'           => 'Kalkulator Ekspor',
            'labelSatuan'     => $labelSatuan,
            'ukuranKontainer' => [],
            'exwork'          => $exworkModel->getByUser($userId),
            'fob'             => $fobModel->getByUser($userId),
            'cfr'             => $cfrModel->getByUser($userId),
            'cif'             => $cifModel->getByUser($userId),
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // POST  dashboard/peserta/kalkulator/satuan/upsert-json
    // ─────────────────────────────────────────────────────────
    public function upsertSatuanJson(): \CodeIgniter\HTTP\ResponseInterface
    {
        if (!$this->cekAkses()) {
            return $this->response->setStatusCode(403)->setJSON(['ok' => false, 'msg' => 'Akses ditolak']);
        }
        $satuan = trim((string) $this->request->getPost('satuan'));
        $model  = new KalkulatorSatuanModel();
        $ok     = $model->upsert($this->userId(), $satuan);
        return $this->response->setJSON(['ok' => $ok, 'satuan' => $satuan]);
    }

    // ─────────────────────────────────────────────────────────
    // POST  dashboard/peserta/kalkulator/state/save
    // ─────────────────────────────────────────────────────────
    public function saveState(): \CodeIgniter\HTTP\ResponseInterface
    {
        if (!$this->cekAkses()) {
            return $this->response->setStatusCode(403)->setJSON(['ok' => false]);
        }
        $model = new KalkulatorStateModel();
        $ok    = $model->upsert($this->userId(), [
            'nama_produk'   => $this->request->getPost('nama_produk')   ?? '',
            'jumlah_barang' => (int) $this->request->getPost('jumlah_barang'),
            'hpp'           => (int) $this->request->getPost('hpp'),
            'keuntungan'    => (int) $this->request->getPost('keuntungan'),
        ]);
        return $this->response->setJSON(['ok' => $ok]);
    }

    // ─────────────────────────────────────────────────────────
    // GET  dashboard/peserta/kalkulator/state/load
    // ─────────────────────────────────────────────────────────
    public function loadState(): \CodeIgniter\HTTP\ResponseInterface
    {
        if (!$this->cekAkses()) {
            return $this->response->setStatusCode(403)->setJSON(['ok' => false]);
        }
        $model = new KalkulatorStateModel();
        $row   = $model->getByUser($this->userId());
        return $this->response->setJSON(['ok' => (bool) $row, 'data' => $row]);
    }

    // ══════════════════════════════════════════════════════════
    //  EXWORK
    // ══════════════════════════════════════════════════════════
    public function saveAllExwork(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->cekAkses()) {
            return redirect()->to(base_url('dashboard/peserta/aplikasi'))->with('error', 'Akses ditolak.');
        }
        $userId = $this->userId();
        $model  = new KalkulatorExworkModel();

        foreach ($model->getByUser($userId) as $row) {
            $val = $this->request->getPost('exwork_' . $row['id_exwork']);
            if ($val !== null) $model->update($row['id_exwork'], ['biaya' => (int) $val]);
        }
        foreach ((array)($this->request->getPost('komponenExwork') ?? []) as $i => $nama) {
            $nama = trim($nama);
            if (!$nama) continue;
            $model->insert([
                'id_users'        => $userId,
                'komponen_exwork' => $nama,
                'biaya'           => (int) ($this->request->getPost('biayaExwork')[$i] ?? 0),
            ]);
        }
        return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('success', 'Komponen Exwork disimpan.');
    }

    public function deleteExwork(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new KalkulatorExworkModel();
        $row   = $model->find($id);
        if ($row && (int)$row['id_users'] === $this->userId()) {
            $model->delete($id);
            return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('success', 'Komponen dihapus.');
        }
        return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('error', 'Data tidak ditemukan.');
    }

    // ══════════════════════════════════════════════════════════
    //  FOB
    // ══════════════════════════════════════════════════════════
    public function saveAllFob(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->cekAkses()) {
            return redirect()->to(base_url('dashboard/peserta/aplikasi'))->with('error', 'Akses ditolak.');
        }
        $userId = $this->userId();
        $model  = new KalkulatorFobModel();

        foreach ($model->getByUser($userId) as $row) {
            $val = $this->request->getPost('fob_' . $row['id_fob']);
            if ($val !== null) $model->update($row['id_fob'], ['biaya' => (int) $val]);
        }
        foreach ((array)($this->request->getPost('komponenFOB') ?? []) as $i => $nama) {
            $nama = trim($nama);
            if (!$nama) continue;
            $model->insert([
                'id_users'     => $userId,
                'komponen_fob' => $nama,
                'biaya'        => (int) ($this->request->getPost('biayaFOB')[$i] ?? 0),
            ]);
        }
        return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('success', 'Komponen FOB disimpan.');
    }

    public function deleteFob(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new KalkulatorFobModel();
        $row   = $model->find($id);
        if ($row && (int)$row['id_users'] === $this->userId()) {
            $model->delete($id);
            return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('success', 'Komponen dihapus.');
        }
        return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('error', 'Data tidak ditemukan.');
    }

    // ══════════════════════════════════════════════════════════
    //  CFR
    // ══════════════════════════════════════════════════════════
    public function saveAllCfr(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->cekAkses()) {
            return redirect()->to(base_url('dashboard/peserta/aplikasi'))->with('error', 'Akses ditolak.');
        }
        $userId = $this->userId();
        $model  = new KalkulatorCfrModel();

        foreach ($model->getByUser($userId) as $row) {
            $val = $this->request->getPost('cfr_' . $row['id_cfr']);
            if ($val !== null) $model->update($row['id_cfr'], ['biaya' => (int) $val]);
        }
        foreach ((array)($this->request->getPost('komponenCFR') ?? []) as $i => $nama) {
            $nama = trim($nama);
            if (!$nama) continue;
            $model->insert([
                'id_users'     => $userId,
                'komponen_cfr' => $nama,
                'biaya'        => (int) ($this->request->getPost('biayaCFR')[$i] ?? 0),
            ]);
        }
        return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('success', 'Komponen CFR disimpan.');
    }

    public function deleteCfr(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new KalkulatorCfrModel();
        $row   = $model->find($id);
        if ($row && (int)$row['id_users'] === $this->userId()) {
            $model->delete($id);
            return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('success', 'Komponen dihapus.');
        }
        return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('error', 'Data tidak ditemukan.');
    }

    // ══════════════════════════════════════════════════════════
    //  CIF
    // ══════════════════════════════════════════════════════════
    public function saveAllCif(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->cekAkses()) {
            return redirect()->to(base_url('dashboard/peserta/aplikasi'))->with('error', 'Akses ditolak.');
        }
        $userId = $this->userId();
        $model  = new KalkulatorCifModel();

        foreach ($model->getByUser($userId) as $row) {
            $val = $this->request->getPost('cif_' . $row['id_cif']);
            if ($val !== null) $model->update($row['id_cif'], ['biaya' => (int) $val]);
        }
        foreach ((array)($this->request->getPost('komponenCIF') ?? []) as $i => $nama) {
            $nama = trim($nama);
            if (!$nama) continue;
            $model->insert([
                'id_users'     => $userId,
                'komponen_cif' => $nama,
                'biaya'        => (int) ($this->request->getPost('biayaCIF')[$i] ?? 0),
            ]);
        }
        return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('success', 'Komponen CIF disimpan.');
    }

    public function deleteCif(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new KalkulatorCifModel();
        $row   = $model->find($id);
        if ($row && (int)$row['id_users'] === $this->userId()) {
            $model->delete($id);
            return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('success', 'Komponen dihapus.');
        }
        return redirect()->to(base_url('dashboard/peserta/kalkulator'))->with('error', 'Data tidak ditemukan.');
    }
}