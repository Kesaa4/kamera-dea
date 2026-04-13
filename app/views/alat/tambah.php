<div class="container">

<h2>Tambah Alat</h2>
<a href="?url=alat">← Kembali ke Data Alat</a>

<div class="card" style="margin-top: 20px;">
<form method="POST" action="?url=alat/simpan" enctype="multipart/form-data">

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
        <?php foreach ($data['kategori'] as $k): ?>
        <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Foto Alat: <small style="color:#999;">(opsional, JPG/PNG/WEBP)</small></label>
    <input type="file" name="foto" accept="image/*" id="fotoInput">
    <div id="fotoPreview" style="margin-top:10px; display:none;">
        <img id="previewImg" src="" alt="Preview" style="max-width:200px; max-height:200px; border-radius:8px; border:1px solid #ddd;">
    </div>

    <button type="submit">💾 Simpan</button>

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
