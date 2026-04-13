<div class="container">

<h2>Tambah User</h2>
<a href="?url=user">← Kembali ke Data User</a>

<div class="card" style="margin-top: 20px;">
<form method="POST" action="?url=user/simpan">

<label>Nama Lengkap:</label>
<input type="text" name="nama" placeholder="Nama Lengkap" required>

<label>Email:</label>
<input type="email" name="email" placeholder="Email" required>

<label>Password:</label>
<input type="password" name="password" placeholder="Password" required minlength="6">

<label>Role:</label>
<select name="role" required>
    <option value="">-- Pilih Role --</option>
    <option value="admin">Admin</option>
    <option value="petugas">Petugas</option>
    <option value="peminjam">Peminjam</option>
</select>

<button type="submit">💾 Simpan</button>

</form>
</div>

</div>
