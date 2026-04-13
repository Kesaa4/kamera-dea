<div class="container">

<h2>Edit User</h2>
<a href="?url=user">← Kembali ke Data User</a>

<div class="card" style="margin-top: 20px;">
<form method="POST" action="?url=user/update">

<input type="hidden" name="id" value="<?= $data['user']['id'] ?>">

<label>Nama Lengkap:</label>
<input type="text" name="nama" value="<?= htmlspecialchars($data['user']['nama']) ?>" placeholder="Nama Lengkap" required>

<label>Email:</label>
<input type="email" name="email" value="<?= htmlspecialchars($data['user']['email']) ?>" placeholder="Email" required>

<label>Password Baru:</label>
<input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" minlength="6">
<small style="color: #6D4C41;">* Kosongkan jika tidak ingin mengubah password</small>

<label>Role:</label>
<select name="role" required>
    <option value="">-- Pilih Role --</option>
    <option value="admin" <?= ($data['user']['role']=='admin') ? 'selected' : '' ?>>Admin</option>
    <option value="petugas" <?= ($data['user']['role']=='petugas') ? 'selected' : '' ?>>Petugas</option>
    <option value="peminjam" <?= ($data['user']['role']=='peminjam') ? 'selected' : '' ?>>Peminjam</option>
</select>

<button type="submit">💾 Update</button>

</form>
</div>

</div>
