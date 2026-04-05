<?php // app/Views/Dashboard/Admin/users/index.php ?>
<?= $this->extend('Dashboard/Admin/layout_admin') ?>


<?= $this->section('meta') ?>
<title>Manajemen Pengguna — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .users-header {
        display: flex; justify-content: space-between;
        align-items: flex-start; margin-bottom: 24px;
        gap: 16px; flex-wrap: wrap;
    }
    .users-header h1 { font-size: 22px; font-weight: 800; color: #111; }
    .users-header p  { font-size: 13px; color: #6b7280; margin-top: 4px; }

    .role-tabs { display: flex; gap: 10px; margin-bottom: 22px; flex-wrap: wrap; }
    .role-tab {
        display: flex; align-items: center; gap: 9px;
        padding: 9px 16px; border-radius: 12px;
        background: #fff; border: 2px solid transparent;
        font-size: 13px; font-weight: 600; color: #6b7280;
        text-decoration: none; box-shadow: 0 1px 4px rgba(0,0,0,.05);
        transition: all .18s;
    }
    .role-tab:hover  { border-color: #dbeafe; color: #2563eb; background: #f0f6ff; }
    .role-tab.active { border-color: #2d6cdf; background: #eff4ff; color: #2d6cdf; }
    .rt-count {
        font-size: 11px; font-weight: 800; padding: 2px 7px;
        border-radius: 20px; background: #e0eaff; color: #2d6cdf;
    }
    .role-tab.active .rt-count { background: #2d6cdf; color: #fff; }
    .rt-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

    .toolbar {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; margin-bottom: 18px; flex-wrap: wrap;
    }
    .toolbar-left  { display: flex; align-items: center; gap: 10px; flex: 1; }
    .toolbar-right { display: flex; align-items: center; gap: 10px; }

    .search-box { position: relative; flex: 1; max-width: 340px; }
    .search-box i {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); color: #9ca3af; font-size: 14px;
    }
    .search-box input {
        width: 100%; padding: 9px 12px 9px 36px;
        border: 1px solid #e5e7eb; border-radius: 10px;
        font-size: 13px; color: #374151; background: #fff;
        outline: none; transition: border .2s;
        font-family: 'DM Sans', sans-serif;
    }
    .search-box input:focus { border-color: #2d6cdf; }

    .btn-add {
        display: flex; align-items: center; gap: 7px;
        background: #2d6cdf; color: #fff; border: none;
        border-radius: 10px; padding: 9px 18px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none; white-space: nowrap;
        font-family: 'DM Sans', sans-serif;
        transition: background .18s, transform .15s;
    }
    .btn-add:hover { background: #1d5bc7; color: #fff; transform: translateY(-1px); }

    .table-card {
        background: #fff; border-radius: 18px;
        box-shadow: 0 1px 8px rgba(0,0,0,.05); overflow: hidden;
    }

    .user-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .user-table thead tr { background: #f8faff; border-bottom: 1px solid #eef0f6; }
    .user-table thead th {
        padding: 13px 16px; text-align: left;
        font-size: 11px; font-weight: 700;
        letter-spacing: .6px; color: #9ca3af;
        text-transform: uppercase; white-space: nowrap;
    }
    .user-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background .12s; }
    .user-table tbody tr:last-child { border-bottom: none; }
    .user-table tbody tr:hover { background: #f9fbff; }
    .user-table tbody td { padding: 13px 16px; color: #374151; vertical-align: middle; }

    .user-cell  { display: flex; align-items: center; gap: 12px; }
    .user-ava   {
        width: 38px; height: 38px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 14px; flex-shrink: 0;
    }
    .ava-admin    { background: #ede9fe; color: #7c3aed; }
    .ava-pengajar { background: #d1fae5; color: #059669; }
    .ava-peserta  { background: #dbeafe; color: #2563eb; }
    .user-name  { font-weight: 700; color: #111; font-size: 13.5px; }
    .user-email { font-size: 12px; color: #9ca3af; margin-top: 1px; }

    .role-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 20px;
        font-size: 11.5px; font-weight: 700;
    }
    .role-badge.admin    { background: #ede9fe; color: #7c3aed; }
    .role-badge.pengajar { background: #d1fae5; color: #059669; }
    .role-badge.peserta  { background: #dbeafe; color: #2563eb; }

    .join-date { font-size: 12.5px; color: #6b7280; }
    .col-no    { width: 48px; text-align: center; color: #9ca3af; font-size: 12.5px; font-weight: 600; }

    .action-group { display: flex; align-items: center; gap: 6px; }
    .btn-action {
        width: 32px; height: 32px; border-radius: 8px; border: none;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; cursor: pointer; transition: all .15s;
    }
    .btn-edit   { background: #eff6ff; color: #2563eb; }
    .btn-reset  { background: #fef3c7; color: #d97706; }
    .btn-delete { background: #fee2e2; color: #ef4444; }
    .btn-edit:hover   { background: #2563eb; color: #fff; }
    .btn-reset:hover  { background: #d97706; color: #fff; }
    .btn-delete:hover { background: #ef4444; color: #fff; }

    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon  {
        width: 64px; height: 64px; background: #f3f4f6; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 26px; color: #9ca3af; margin-bottom: 16px;
    }
    .empty-title { font-size: 15px; font-weight: 700; color: #374151; margin-bottom: 6px; }
    .empty-sub   { font-size: 13px; color: #9ca3af; }

    .modal-card { border: none !important; border-radius: 20px !important; overflow: hidden; }
    .modal-header-custom {
        background: #fff; border-bottom: 1px solid #f3f4f6; padding: 20px 24px 16px;
    }
    .modal-title-custom { font-size: 16px; font-weight: 800; color: #111; }
    .modal-body-custom  { padding: 20px 24px; }
    .modal-foot-custom  {
        padding: 16px 24px; background: #f9fafb;
        border-top: 1px solid #f3f4f6;
        display: flex; justify-content: flex-end; gap: 10px;
    }

    .form-label-custom {
        font-size: 12px; font-weight: 700; color: #374151;
        letter-spacing: .3px; margin-bottom: 6px; display: block;
    }
    .form-input-custom {
        width: 100%; padding: 10px 14px;
        border: 1px solid #e5e7eb; border-radius: 10px;
        font-size: 13.5px; color: #111; outline: none;
        transition: border .2s; background: #fff;
        font-family: 'DM Sans', sans-serif;
    }
    .form-input-custom:focus {
        border-color: #2d6cdf; box-shadow: 0 0 0 3px rgba(45,108,223,.1);
    }
    .form-row  { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-hint { font-size: 11.5px; color: #9ca3af; margin-top: 5px; }

    .btn-cancel {
        padding: 9px 20px; border-radius: 10px; border: 1px solid #e5e7eb;
        background: #fff; color: #374151; font-size: 13px; font-weight: 600;
        cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background .15s;
    }
    .btn-cancel:hover { background: #f3f4f6; }

    .btn-submit {
        padding: 9px 22px; border-radius: 10px; border: none;
        background: #2d6cdf; color: #fff; font-size: 13px; font-weight: 700;
        cursor: pointer; font-family: 'DM Sans', sans-serif;
        display: inline-flex; align-items: center; gap: 6px;
        transition: background .18s;
    }
    .btn-submit:hover         { background: #1d5bc7; }
    .btn-submit.danger        { background: #ef4444; }
    .btn-submit.danger:hover  { background: #dc2626; }
    .btn-submit.warning       { background: #d97706; }
    .btn-submit.warning:hover { background: #b45309; }

    .alert-errors {
        background: #fee2e2; border-radius: 10px;
        padding: 10px 14px; margin-bottom: 16px;
        font-size: 12.5px; color: #dc2626;
    }
    .alert-errors ul { margin: 0; padding-left: 16px; }

    .confirm-body  { text-align: center; padding: 28px 24px; }
    .confirm-icon  {
        width: 60px; height: 60px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 26px; margin-bottom: 14px;
    }
    .confirm-title { font-size: 14.5px; font-weight: 700; color: #111; margin-bottom: 8px; }
    .confirm-desc  { font-size: 13px; color: #6b7280; line-height: 1.65; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- PAGE HEADER -->
<div class="users-header">
    <div>
        <h1>Manajemen Pengguna</h1>
        <p>Kelola semua akun admin, pengajar, dan peserta dalam sistem LMS.</p>
    </div>
</div>

<!-- ROLE TABS -->
<div class="role-tabs">
    <a href="<?= base_url('dashboard/admin/pengguna') ?>" class="role-tab <?= !$active_role ? 'active' : '' ?>">
        <i class="bi bi-people-fill" style="color:#2d6cdf;font-size:15px;"></i>
        Semua
        <span class="rt-count"><?= $count_all ?></span>
    </a>
    <a href="<?= base_url('dashboard/admin/pengguna?role=admin') ?>" class="role-tab <?= $active_role === 'admin' ? 'active' : '' ?>">
        <span class="rt-dot" style="background:#7c3aed;"></span>
        Admin
        <span class="rt-count" style="<?= $active_role === 'admin' ? '' : 'background:#ede9fe;color:#7c3aed;' ?>"><?= $count_admin ?></span>
    </a>
    <a href="<?= base_url('dashboard/admin/pengguna?role=pengajar') ?>" class="role-tab <?= $active_role === 'pengajar' ? 'active' : '' ?>">
        <span class="rt-dot" style="background:#059669;"></span>
        Pengajar
        <span class="rt-count" style="<?= $active_role === 'pengajar' ? '' : 'background:#d1fae5;color:#059669;' ?>"><?= $count_pengajar ?></span>
    </a>
    <a href="<?= base_url('dashboard/admin/pengguna?role=peserta') ?>" class="role-tab <?= $active_role === 'peserta' ? 'active' : '' ?>">
        <span class="rt-dot" style="background:#2563eb;"></span>
        Peserta
        <span class="rt-count" style="<?= $active_role === 'peserta' ? '' : 'background:#dbeafe;color:#2563eb;' ?>"><?= $count_peserta ?></span>
    </a>
</div>

<!-- TOOLBAR -->
<div class="toolbar">
    <div class="toolbar-left">
        <form method="get" action="<?= base_url('dashboard/admin/pengguna') ?>" style="display:flex;align-items:center;gap:10px;flex:1;">
            <?php if ($active_role): ?>
                <input type="hidden" name="role" value="<?= esc($active_role) ?>">
            <?php endif; ?>
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="search" placeholder="Cari nama atau email..."
                       value="<?= esc($search ?? '') ?>">
            </div>
            <button type="submit" class="btn-submit" style="padding:9px 16px;">
                <i class="bi bi-search"></i>
            </button>
            <?php if ($search): ?>
                <a href="<?= base_url('dashboard/admin/pengguna' . ($active_role ? '?role=' . $active_role : '')) ?>"
                   style="font-size:12.5px;color:#ef4444;text-decoration:none;font-weight:600;white-space:nowrap;">
                    <i class="bi bi-x-circle-fill"></i> Reset
                </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="toolbar-right">
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg"></i> Tambah Pengguna
        </button>
    </div>
</div>

<!-- TABLE -->
<div class="table-card">
    <?php if (empty($users)): ?>
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-people"></i></div>
            <div class="empty-title">Tidak ada pengguna ditemukan</div>
            <div class="empty-sub">
                <?= $search ? 'Coba kata kunci yang berbeda.' : 'Mulai dengan menambahkan pengguna baru.' ?>
            </div>
        </div>
    <?php else: ?>
        <table class="user-table">
            <thead>
                <tr>
                    <th class="col-no">#</th>
                    <th>Pengguna</th>
                    <th>Role</th>
                    <th>Tanggal Bergabung</th>
                    <th style="text-align:right;padding-right:20px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $roleIcon  = ['admin' => 'bi-shield-fill', 'pengajar' => 'bi-person-badge-fill', 'peserta' => 'bi-person-fill'];
                $roleLabel = ['admin' => 'Admin', 'pengajar' => 'Pengajar', 'peserta' => 'Peserta'];
                foreach ($users as $i => $u):
                    $joinDate = date('d M Y', strtotime($u['created_at']));
                ?>
                <tr>
                    <td class="col-no"><?= $i + 1 ?></td>
                    <td>
                        <div class="user-cell">
                            <div class="user-ava ava-<?= $u['role_users'] ?>">
                                <?= strtoupper(substr($u['nama_users'], 0, 1)) ?>
                            </div>
                            <div>
                                <div class="user-name"><?= esc($u['nama_users']) ?></div>
                                <div class="user-email"><?= esc($u['email_users']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge <?= $u['role_users'] ?>">
                            <i class="bi <?= $roleIcon[$u['role_users']] ?>"></i>
                            <?= $roleLabel[$u['role_users']] ?>
                        </span>
                    </td>
                    <td><span class="join-date"><?= $joinDate ?></span></td>
                    <td>
                        <div class="action-group" style="justify-content:flex-end;">
                            <button class="btn-action btn-edit" title="Edit"
                                onclick="openEdit(
                                    <?= $u['id_users'] ?>,
                                    '<?= esc($u['nama_users'],  'js') ?>',
                                    '<?= esc($u['email_users'], 'js') ?>',
                                    '<?= $u['role_users'] ?>'
                                )">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn-action btn-reset" title="Reset Password"
                                onclick="openReset(<?= $u['id_users'] ?>, '<?= esc($u['nama_users'], 'js') ?>')">
                                <i class="bi bi-key-fill"></i>
                            </button>
                            <?php if ((int)$u['id_users'] !== (int)session()->get('id_users')): ?>
                            <button class="btn-action btn-delete" title="Hapus"
                                onclick="openDelete(<?= $u['id_users'] ?>, '<?= esc($u['nama_users'], 'js') ?>')">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:500px;">
        <div class="modal-content modal-card">
            <div class="modal-header-custom">
                <div class="modal-title-custom">
                    <i class="bi bi-person-plus-fill" style="color:#2d6cdf;margin-right:8px;"></i>
                    Tambah Pengguna Baru
                </div>
            </div>
            <form action="<?= base_url('dashboard/admin/pengguna/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body-custom">
                    <?php if (session('errors')): ?>
                        <div class="alert-errors">
                            <ul><?php foreach (session('errors') as $err): ?><li><?= esc($err) ?></li><?php endforeach; ?></ul>
                        </div>
                    <?php endif; ?>
                    <div class="form-row" style="margin-bottom:14px;">
                        <div>
                            <label class="form-label-custom">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="nama_users" class="form-input-custom"
                                   placeholder="Contoh: Budi Santoso"
                                   value="<?= old('nama_users') ?>" required>
                        </div>
                        <div>
                            <label class="form-label-custom">Role <span style="color:#ef4444;">*</span></label>
                            <select name="role_users" class="form-input-custom" required>
                                <option value="" disabled selected>Pilih role</option>
                                <option value="admin"    <?= old('role_users') === 'admin'    ? 'selected' : '' ?>>Admin</option>
                                <option value="pengajar" <?= old('role_users') === 'pengajar' ? 'selected' : '' ?>>Pengajar</option>
                                <option value="peserta"  <?= old('role_users') === 'peserta'  ? 'selected' : '' ?>>Peserta</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label class="form-label-custom">Email <span style="color:#ef4444;">*</span></label>
                        <input type="email" name="email_users" class="form-input-custom"
                               placeholder="email@elecomp.id"
                               value="<?= old('email_users') ?>" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Password <span style="color:#ef4444;">*</span></label>
                        <input type="password" name="password" class="form-input-custom"
                               placeholder="Minimal 6 karakter" required>
                        <p class="form-hint">Password bisa direset kapan saja lewat tombol 🔑.</p>
                    </div>
                </div>
                <div class="modal-foot-custom">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit"><i class="bi bi-plus-lg"></i> Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:500px;">
        <div class="modal-content modal-card">
            <div class="modal-header-custom">
                <div class="modal-title-custom">
                    <i class="bi bi-pencil-fill" style="color:#2563eb;margin-right:8px;"></i>
                    Edit Pengguna
                </div>
            </div>
            <form id="formEdit" method="post">
                <?= csrf_field() ?>
                <div class="modal-body-custom">
                    <div class="form-row" style="margin-bottom:14px;">
                        <div>
                            <label class="form-label-custom">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="editNama" name="nama_users" class="form-input-custom" required>
                        </div>
                        <div>
                            <label class="form-label-custom">Role <span style="color:#ef4444;">*</span></label>
                            <select id="editRole" name="role_users" class="form-input-custom" required>
                                <option value="admin">Admin</option>
                                <option value="pengajar">Pengajar</option>
                                <option value="peserta">Peserta</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="form-label-custom">Email <span style="color:#ef4444;">*</span></label>
                        <input type="email" id="editEmail" name="email_users" class="form-input-custom" required>
                    </div>
                </div>
                <div class="modal-foot-custom">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit"><i class="bi bi-check-lg"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL RESET PASSWORD -->
<div class="modal fade" id="modalReset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content modal-card">
            <div class="modal-header-custom">
                <div class="modal-title-custom">
                    <i class="bi bi-key-fill" style="color:#d97706;margin-right:8px;"></i>
                    Reset Password
                </div>
            </div>
            <form id="formReset" method="post">
                <?= csrf_field() ?>
                <div class="confirm-body">
                    <div class="confirm-icon" style="background:#fef3c7;">🔑</div>
                    <div class="confirm-title">Reset password <span id="resetNama" style="color:#d97706;"></span>?</div>
                    <div class="confirm-desc">
                        Password akan direset ke default:<br>
                        <code style="background:#f3f4f6;padding:3px 10px;border-radius:6px;font-size:13.5px;font-weight:700;color:#374151;margin-top:6px;display:inline-block;">elecomp123</code>
                    </div>
                </div>
                <div class="modal-foot-custom">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit warning"><i class="bi bi-key-fill"></i> Ya, Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content modal-card">
            <div class="modal-header-custom">
                <div class="modal-title-custom">
                    <i class="bi bi-trash-fill" style="color:#ef4444;margin-right:8px;"></i>
                    Hapus Pengguna
                </div>
            </div>
            <form id="formHapus" method="post">
                <?= csrf_field() ?>
                <div class="confirm-body">
                    <div class="confirm-icon" style="background:#fee2e2;">🗑️</div>
                    <div class="confirm-title">Hapus <span id="hapusNama" style="color:#ef4444;"></span>?</div>
                    <div class="confirm-desc">
                        Data pengguna akan dihapus dari sistem.<br>
                        Tindakan ini <strong>tidak dapat dibatalkan</strong>.
                    </div>
                </div>
                <div class="modal-foot-custom">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit danger"><i class="bi bi-trash-fill"></i> Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function openEdit(id, nama, email, role) {
        document.getElementById('editNama').value  = nama;
        document.getElementById('editEmail').value = email;
        document.getElementById('editRole').value  = role;
        document.getElementById('formEdit').action = `<?= base_url('dashboard/admin/pengguna/update/') ?>${id}`;
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }

    function openReset(id, nama) {
        document.getElementById('resetNama').textContent = nama;
        document.getElementById('formReset').action = `<?= base_url('dashboard/admin/pengguna/reset-password/') ?>${id}`;
        new bootstrap.Modal(document.getElementById('modalReset')).show();
    }

    function openDelete(id, nama) {
        document.getElementById('hapusNama').textContent = nama;
        document.getElementById('formHapus').action = `<?= base_url('dashboard/admin/pengguna/delete/') ?>${id}`;
        new bootstrap.Modal(document.getElementById('modalHapus')).show();
    }

    <?php if (session('errors')): ?>
        document.addEventListener('DOMContentLoaded', () => {
            new bootstrap.Modal(document.getElementById('modalTambah')).show();
        });
    <?php endif; ?>
</script>
<?= $this->endSection() ?>