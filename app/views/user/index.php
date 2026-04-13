<div class="container">

<h2>👥 Manajemen User</h2>

<div style="display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap;">
    <a href="?url=dashboard" style="display: inline-block;">← Kembali ke Dashboard</a>
    <a href="?url=user/tambah" class="btn-add" style="padding: 10px 20px; background: linear-gradient(135deg, #6D4C41 0%, #5D4037 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">+ Tambah User</a>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($data['users'])): ?>
        <tr>
            <td colspan="5" style="text-align: center;">Tidak ada data user</td>
        </tr>
        <?php else: ?>
        <?php $no = 1; foreach($data['users'] as $u): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($u['nama']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td>
                <span class="user-role role-<?= $u['role'] ?>">
                    <?= ucfirst($u['role']) ?>
                </span>
            </td>
            <td>
                <a href="?url=user/edit/<?= $u['id'] ?>" class="btn-edit" style="padding: 8px 16px; margin: 2px; font-size: 12px; display: inline-block; color: white; border-radius: 6px; text-decoration: none;">✏️ Edit</a>
                
                <?php if($u['id'] != $_SESSION['user']['id']): ?>
                <a href="?url=user/hapus/<?= $u['id'] ?>" class="btn-delete" style="padding: 8px 16px; margin: 2px; font-size: 12px; display: inline-block; color: white; border-radius: 6px; text-decoration: none;" onclick="return confirm('Yakin ingin menghapus user ini?')">🗑️ Hapus</a>
                <?php else: ?>
                <span style="padding: 8px 16px; margin: 2px; font-size: 12px; display: inline-block; color: #999; border-radius: 6px; background: #f0f0f0;">🔒 Akun Anda</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</div>
