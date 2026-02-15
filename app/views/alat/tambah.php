<div class="container">

<h2>Tambah Alat</h2>
<a href="?url=alat">← Kembali ke Data Alat</a>

<div class="card" style="margin-top: 20px;">
<form method="POST" action="?url=alat/simpan">

<label>Nama Alat:</label>
<input type="text" name="nama" placeholder="Nama Alat" required>

<label>Stok:</label>
<input type="number" name="stok" placeholder="Jumlah Stok" required min="0">

<label>Harga Sewa (per hari):</label>
<input type="number" name="harga_sewa" placeholder="Harga Sewa" required min="0">

<label>Kondisi:</label>
<select name="kondisi" required>
    <option value="">-- Pilih Kondisi --</option>
    <option value="baik">Baik</option>
    <option value="rusak ringan">Rusak Ringan</option>
    <option value="rusak berat">Rusak Berat</option>
</select>

<label>Kategori:</label>
<select name="kategori" required>
    <option value="">-- Pilih Kategori --</option>
    <?php foreach($data['kategori'] as $k): ?>
    <option value="<?= $k['id'] ?>">
        <?= $k['nama_kategori'] ?>
    </option>
    <?php endforeach; ?>
</select>

<button type="submit">💾 Simpan</button>

</form>
</div>

</div>
