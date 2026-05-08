<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Google Drive Status</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
.card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 40px 36px; max-width: 460px; width: 100%; }
.header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
.header-icon { width: 48px; height: 48px; background: #e8f0fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
.header h2 { font-size: 20px; font-weight: 600; color: #1a1a2e; }
.header p { font-size: 13px; color: #888; margin-top: 2px; }
.alert { display: flex; align-items: center; gap: 10px; padding: 13px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.status-box { display: flex; align-items: center; gap: 14px; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; }
.status-box.connected    { background: #e6f9f0; border: 1px solid #b7ebd4; }
.status-box.disconnected { background: #fff3f3; border: 1px solid #ffc9c9; }
.status-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }
.connected    .status-dot { background: #28a745; box-shadow: 0 0 0 3px #a3e9be; }
.disconnected .status-dot { background: #dc3545; box-shadow: 0 0 0 3px #ffc9c9; }
.status-text strong { display: block; font-size: 15px; font-weight: 600; }
.connected    .status-text strong { color: #155724; }
.disconnected .status-text strong { color: #721c24; }
.status-text span { font-size: 12px; color: #888; margin-top: 2px; display: block; }
.btn { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 13px 24px; border-radius: 10px; text-decoration: none; font-size: 15px; font-weight: 600; width: 100%; transition: opacity 0.15s; }
.btn:hover { opacity: 0.88; }
.btn-primary { background: #4285f4; color: #fff; }
.btn-danger  { background: #dc3545; color: #fff; }
.divider { border: none; border-top: 1px solid #f0f0f0; margin: 24px 0; }
.info { font-size: 12px; color: #aaa; text-align: center; }
</style>
</head>
<body>
<div class="card">
  <div class="header">
    <div class="header-icon">☁️</div>
    <div>
      <h2>Google Drive</h2>
      <p>Integrasi penyimpanan file tugas</p>
    </div>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">❌ <?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <div class="status-box <?= $status ?>">
    <div class="status-dot"></div>
    <div class="status-text">
      <strong><?= $status === 'connected' ? 'Terkoneksi' : 'Belum Terkoneksi' ?></strong>
      <span><?= $message ?></span>
    </div>
  </div>

  <?php if ($status === 'disconnected'): ?>
    <a href="<?= base_url('auth/google/authorize') ?>" class="btn btn-primary">
      🔗 Hubungkan Google Drive
    </a>
  <?php else: ?>
    <a href="<?= base_url('auth/google/disconnect') ?>" class="btn btn-danger">
      🔌 Putuskan Koneksi
    </a>
  <?php endif; ?>

  <hr class="divider">
  <p class="info">File tugas peserta akan tersimpan otomatis di Google Drive admin</p>
</div>
</body>
</html>