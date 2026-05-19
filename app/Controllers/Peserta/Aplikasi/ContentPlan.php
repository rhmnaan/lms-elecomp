<?php

namespace App\Controllers\Peserta\Aplikasi;

use App\Controllers\BaseController;
use App\Models\ContentPlannerModel;
use App\Models\ContentPlatformModel;
use App\Models\PlatformModel;
use App\Models\JenisKontenModel;
use App\Models\ContentTypeModel;
use App\Models\AssetModel;

class ContentPlan extends BaseController
{
    protected $contentPlanner;
    protected $contentPlatform;
    protected $platformModel;
    protected $jenisModel;
    protected $typeModel;
    protected $assetModel;

    public function __construct()
    {
        $this->contentPlanner  = new ContentPlannerModel();
        $this->contentPlatform = new ContentPlatformModel();
        $this->platformModel   = new PlatformModel();
        $this->jenisModel      = new JenisKontenModel();
        $this->typeModel       = new ContentTypeModel();
        $this->assetModel      = new AssetModel();
    }

    /* ══════════════════════════════════════════
     * INDEX
     * ══════════════════════════════════════════ */
    public function index()
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return redirect()->to('/login');

        $contents = $this->contentPlanner->getAllWithRelationByUser($idUser);

        foreach ($contents as &$c) {
            $platforms         = $this->contentPlatform->getPlatformByContent($c['id']);
            $c['platform']     = $platforms ? implode(', ', array_column($platforms, 'nama_platform')) : '-';
            $c['platform_ids'] = $platforms ? array_map('intval', array_column($platforms, 'platform_id')) : [];

            // Ambil asset per content_platform
            // asset dikelompokkan: [ platform_id => [ {asset_nama, asset_link, keterangan, cp_id}, ... ] ]
            $assets = $this->assetModel->getAssetByContent($c['id']);
            $assetMap = [];
            foreach ($assets as $a) {
                // content_platform.platform_id ada di join
                $pid = (int)($a['platform_id'] ?? 0);
                if (! $pid) continue;
                if (! isset($assetMap[$pid])) $assetMap[$pid] = [];
                $assetMap[$pid][] = [
                    'id'           => (int)$a['id'],
                    'cp_id'        => (int)$a['content_platform_id'],
                    'asset_nama'   => $a['asset_nama']   ?? '',
                    'asset_link'   => $a['asset_link']   ?? '',
                    'keterangan'   => $a['keterangan']   ?? '',
                ];
            }
            $c['assets'] = $assetMap;
        }
        unset($c);

        return view('Dashboard/Peserta/Aplikasi/content_plan/index', [
            'title'        => 'Content Plan',
            'contents'     => $contents,
            'platforms'    => $this->platformModel->getByUser($idUser),
            'jenis'        => $this->jenisModel->getByUser($idUser),
            'contentTypes' => $this->typeModel->getByUser($idUser),
        ]);
    }

    /* ══════════════════════════════════════════
     * CONTENT PLAN — STORE
     * ══════════════════════════════════════════ */
    public function store()
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        $data = $this->request->getJSON(true) ?? [];

        $insertId = $this->contentPlanner->insert([
            'id_users'        => $idUser,
            'judul_konten'    => $data['judul_konten']    ?? '',
            'deskripsi'       => $data['deskripsi']       ?: null,
            'tanggal_publish' => $data['tanggal_publish'] ?? null,
            'status'          => $data['status']          ?? 'draft',
            'jenis_konten_id' => $data['jenis_konten_id'] ?: null,
            'content_type_id' => $data['content_type_id'] ?: null,
        ]);

        // Simpan platform + asset
        if (! empty($data['platform_ids'])) {
            $this->savePlatformAssets($insertId, $data['platform_ids'], $data['assets'] ?? []);
        }

        return $this->jsonOk(['id' => $insertId]);
    }

    /* ══════════════════════════════════════════
     * CONTENT PLAN — UPDATE
     * ══════════════════════════════════════════ */
    public function update($id)
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        $data = $this->request->getJSON(true) ?? [];

        $this->contentPlanner->update($id, [
            'judul_konten'    => $data['judul_konten']    ?? '',
            'deskripsi'       => $data['deskripsi']       ?: null,
            'tanggal_publish' => $data['tanggal_publish'] ?? null,
            'status'          => $data['status']          ?? 'draft',
            'jenis_konten_id' => $data['jenis_konten_id'] ?: null,
            'content_type_id' => $data['content_type_id'] ?: null,
        ]);

        // Hapus semua asset lama dulu (via content_platform)
        $oldCps = $this->contentPlatform->getPlatformByContent($id);
        foreach ($oldCps as $cp) {
            $this->assetModel->where('content_platform_id', $cp['id'])->delete();
        }

        // Hapus content_platform lama
        $this->contentPlatform->deleteByContent($id);

        // Simpan ulang platform + asset
        if (! empty($data['platform_ids'])) {
            $this->savePlatformAssets($id, $data['platform_ids'], $data['assets'] ?? []);
        }

        return $this->jsonOk(['id' => (int)$id]);
    }

    /* ══════════════════════════════════════════
     * CONTENT PLAN — DELETE
     * ══════════════════════════════════════════ */
    public function delete($id)
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        // Hapus asset dulu
        $oldCps = $this->contentPlatform->getPlatformByContent($id);
        foreach ($oldCps as $cp) {
            $this->assetModel->where('content_platform_id', $cp['id'])->delete();
        }

        $this->contentPlatform->deleteByContent($id);
        $this->contentPlanner->delete($id);

        return $this->jsonOk();
    }

    /* ══════════════════════════════════════════
     * HELPER — simpan platform + asset sekaligus
     *
     * $platformIds = [1, 3, 5]
     * $assets = [
     *   "1" => [ { nama, link, ket }, ... ],
     *   "3" => [ { nama, link, ket } ],
     * ]
     * ══════════════════════════════════════════ */
    private function savePlatformAssets(int $contentId, array $platformIds, array $assets): void
    {
        foreach ($platformIds as $pid) {
            $pid = (int)$pid;

            // insert ke content_platform, ambil id-nya
            $cpId = $this->contentPlatform->insertBatchPlatformSingle($contentId, $pid);

            // jika ada asset untuk platform ini
            $key = (string)$pid;
            if (! empty($assets[$key])) {
                foreach ($assets[$key] as $a) {
                    $nama = trim($a['nama'] ?? '');
                    $link = trim($a['link'] ?? '');
                    if (! $nama && ! $link) continue; // skip kosong

                    $this->assetModel->insert([
                        'content_platform_id' => $cpId,
                        'asset_nama'          => $nama ?: null,
                        'asset_link'          => $link ?: null,
                        'keterangan'          => trim($a['ket'] ?? '') ?: null,
                    ]);
                }
            }
        }
    }

    /* ══════════════════════════════════════════
     * MASTER — JENIS KONTEN
     * ══════════════════════════════════════════ */
    public function jenisStore()
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        $data = $this->request->getJSON(true) ?? [];
        $nama = trim($data['nama'] ?? '');
        $ket  = trim($data['ket']  ?? '');

        if (! $nama) return $this->jsonErr('Nama wajib diisi');

        $insertId = $this->jenisModel->insert([
            'id_users'   => $idUser,
            'nama_jenis' => $nama,
            'keterangan' => $ket ?: null,
        ]);

        return $this->jsonOk(['id' => $insertId]);
    }

    public function jenisUpdate($id)
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        if (! $this->jenisModel->getOneByUser($id, $idUser)) {
            return $this->jsonErr('Data tidak ditemukan', 404);
        }

        $data = $this->request->getJSON(true) ?? [];
        $nama = trim($data['nama'] ?? '');
        $ket  = trim($data['ket']  ?? '');

        if (! $nama) return $this->jsonErr('Nama wajib diisi');

        $this->jenisModel->update($id, [
            'nama_jenis' => $nama,
            'keterangan' => $ket ?: null,
        ]);

        return $this->jsonOk();
    }

    public function jenisDelete($id)
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        if (! $this->jenisModel->getOneByUser($id, $idUser)) {
            return $this->jsonErr('Data tidak ditemukan', 404);
        }

        $this->jenisModel->delete($id);
        return $this->jsonOk();
    }

    /* ══════════════════════════════════════════
     * MASTER — PLATFORM
     * ══════════════════════════════════════════ */
    public function platformStore()
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        $data   = $this->request->getJSON(true) ?? [];
        $nama   = trim($data['nama'] ?? '');
        $status = $data['status'] ?? 'aktif';

        if (! $nama) return $this->jsonErr('Nama wajib diisi');

        $insertId = $this->platformModel->insert([
            'id_users'      => $idUser,
            'nama_platform' => $nama,
            'status'        => in_array($status, ['aktif','nonaktif']) ? $status : 'aktif',
        ]);

        return $this->jsonOk(['id' => $insertId]);
    }

    public function platformUpdate($id)
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        $data = $this->request->getJSON(true) ?? [];
        $nama = trim($data['name'] ?? $data['nama'] ?? '');

        if (! $nama) return $this->jsonErr('Nama wajib diisi');

        $this->platformModel->update($id, ['nama_platform' => $nama]);
        return $this->jsonOk();
    }

    public function platformDelete($id)
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        $this->platformModel->delete($id);
        return $this->jsonOk();
    }

    /* ══════════════════════════════════════════
     * MASTER — TIPE KONTEN
     * ══════════════════════════════════════════ */
    public function typeStore()
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        $data = $this->request->getJSON(true) ?? [];
        $nama = trim($data['name'] ?? $data['nama'] ?? '');

        if (! $nama) return $this->jsonErr('Nama wajib diisi');

        $insertId = $this->typeModel->insert([
            'id_users'  => $idUser,
            'nama_type' => $nama,
        ]);

        return $this->jsonOk(['id' => $insertId]);
    }

    public function typeUpdate($id)
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        $data = $this->request->getJSON(true) ?? [];
        $nama = trim($data['name'] ?? $data['nama'] ?? '');

        if (! $nama) return $this->jsonErr('Nama wajib diisi');

        $this->typeModel->update($id, ['nama_type' => $nama]);
        return $this->jsonOk();
    }

    public function typeDelete($id)
    {
        $idUser = session()->get('id_users');
        if (! $idUser) return $this->jsonErr('Unauthorized', 401);

        $this->typeModel->delete($id);
        return $this->jsonOk();
    }

    /* ══════════════════════════════════════════
     * HELPERS
     * ══════════════════════════════════════════ */
    private function jsonOk(array $extra = [])
    {
        return $this->response->setJSON(array_merge(
            ['status' => 'ok', 'success' => true, 'csrf' => csrf_hash()],
            $extra
        ));
    }

    private function jsonErr(string $msg, int $code = 400)
    {
        return $this->response
            ->setStatusCode($code)
            ->setJSON(['status' => 'error', 'success' => false, 'message' => $msg, 'csrf' => csrf_hash()]);
    }
}