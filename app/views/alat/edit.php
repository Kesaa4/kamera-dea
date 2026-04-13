<div class="container">

<h2>Edit Alat</h2>
<a href="?url=alat">← Kembali ke Data Alat</a>

<div class="card" style="margin-top: 20px;">
<form method="POST" action="?url=alat/update" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $data['alat']['id'] ?>">

    <label>Nama Alat:</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($data['alat']['nama_alat']) ?>" required>

    <label>Stok:</label>
    <input type="number" name="stok" value="<?= $data['alat']['stok'] ?>" required min="0">

    <label>Harga Sewa (per hari):</label>
    <input type="number" name="harga_sewa" value="<?= $data['alat']['harga_sewa'] ?? 0 ?>" required min="0">

    <label>Kondisi:</label>
    <select name="kondisi" required>
        <option value="">-- Pilih Kondisi --</option>
        <option value="baik" <?= $data['alat']['kondisi'] === 'baik' ? 'selected' : '' ?>>Baik</option>
        <option value="rusak ringan" <?= $data['alat']['kondisi'] === 'rusak ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
        <option value="rusak berat" <?= $data['alat']['kondisi'] === 'rusak berat' ? 'selected' : '' ?>>Rusak Berat</option>
    </select>

    <label>Kategori:</label>
    <select name="kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($data['kategori'] as $k): ?>
        <option value="<?= $k['id'] ?>" <?= $data['alat']['id_kategori'] == $k['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['nama_kategori']) ?>
        </option>
        <?php endforeach; ?>
    </select>

    <label>Foto Alat: <small style="color:#999;">(kosongkan jika tidak ingin mengubah foto)</small></label>

    <?php if (!empty($data['alat']['foto'])): ?>
    <div style="margin-bottom:10px;">
        <p style="margin:0 0 5px; font-size:13px; color:#666;">Foto saat ini:</p>
        <img src="uploads/alat/<?= htmlspecialchars($data['alat']['foto']) ?>"
             alt="Foto Alat"
             style="max-width:200px; max-height:200px; border-radius:8px; border:1px solid #ddd;">
    </div>
    <?php endif; ?>

    <input type="file" name="foto" accept="image/*" id="fotoInput">
    <div id="fotoPreview" style="margin-top:10px; display:none;">
        <p style="margin:0 0 5px; font-size:13px; color:#666;">Foto baru:</p>
        <img id="previewImg" src="" alt="Preview" style="max-width:200px; max-height:200px; border-radius:8px; border:1px solid #ddd;">
    </div>

    <button type="submit">💾 Update</button>

</form>
</div>

</div>

<script>
document.getElementById('fotoInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('fotoPreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
