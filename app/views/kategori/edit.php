<div class="container">

<h2>Edit Kategori</h2>
<a href="?url=kategori">← Kembali</a>

<div class="card" style="margin-top: 20px;">
<form method="POST" action="?url=kategori/update">

<input type="hidden" name="id" value="<?= $data['kategori']['id'] ?>">

<label>Nama Kategori:</label>
<input type="text" name="nama" value="<?= $data['kategori']['nama_kategori'] ?>" required>

<button type="submit">💾 Simpan</button>

</form>
</div>

</div>
