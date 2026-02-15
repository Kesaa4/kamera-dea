<div class="container">

<h2>Edit Alat</h2>
<a href="?url=alat">← Kembali ke Data Alat</a>

<div class="card" style="margin-top: 20px;">
<form method="POST" action="?url=alat/update">

<input type="hidden" name="id" value="<?= $data['alat']['id'] ?>">

<label>Nama Alat:</label>
<input type="text" name="nama"
value="<?= $data['alat']['nama_alat'] ?>"
placeholder="Nama Alat" required>

<label>Stok:</label>
<input type="number" name="stok"
value="<?= $data['alat']['stok'] ?>"
placeholder="Stok" required min="0">

<label>Harga Sewa (per hari):</label>
<input type="number" name="harga_sewa"
value="<?= $data['alat']['harga_sewa'] ?? 0 ?>"
placeholder="Harga Sewa" required min="0">

<label>Kondisi:</label>
<select name="kondisi" required>
    <option value="">-- Pilih Kondisi --</option>
    <option value="baik" <?= ($data['alat']['kondisi']=='baik') ? 'selected' : '' ?>>Baik</option>
    <option value="rusak ringan" <?= ($data['alat']['kondisi']=='rusak ringan') ? 'selected' : '' ?>>Rusak Ringan</option>
    <option value="rusak berat" <?= ($data['alat']['kondisi']=='rusak berat') ? 'selected' : '' ?>>Rusak Berat</option>
</select>

<label>Kategori:</label>
<select name="kategori" required>
    <option value="">-- Pilih Kategori --</option>
    <?php foreach($data['kategori'] as $k): ?>
    <option 
    value="<?= $k['id'] ?>"
    <?= ($data['alat']['id_kategori']==$k['id']) ? 'selected' : '' ?>>
        <?= $k['nama_kategori'] ?>
    </option>
    <?php endforeach; ?>
</select>

<button type="submit">💾 Update</button>

</form>
</div>

</div>
