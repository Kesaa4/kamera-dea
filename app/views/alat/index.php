<div class="container">

<h2>Data Alat</h2>

<div style="display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap;">
    <a href="?url=dashboard" style="display: inline-block;">← Kembali ke Dashboard</a>
    
    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?>
    <a href="?url=alat/tambah" class="btn-add" style="padding: 10px 20px; background: linear-gradient(135deg, #6D4C41 0%, #5D4037 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">+ Tambah Alat</a>
    <?php endif; ?>
</div>

<div class="alat-grid">
<?php 
$colors = [
    ['#6D4C41', '#5D4037'], // Coklat tua 1
    ['#5D4037', '#4E342E'], // Coklat tua 2
    ['#8D6E63', '#6D4C41'], // Coklat medium 1
    ['#A1887F', '#8D6E63'], // Coklat muda 1
    ['#795548', '#5D4037'], // Coklat 1
    ['#6D4C41', '#4E342E'], // Coklat tua 3
];
$index = 0;
foreach($data['alat'] as $a): 
    $color = $colors[$index % count($colors)];
    $index++;
?>
<div class="alat-card" style="border-top: 4px solid <?= $color[0] ?>;">
    <div class="alat-header" style="background: linear-gradient(135deg, <?= $color[0] ?> 0%, <?= $color[1] ?> 100%);">
        <h3 style="color: white; margin: 0; font-size: 15px;"><?= htmlspecialchars($a['nama_alat']) ?></h3>
    </div>

    <?php if (!empty($a['foto'])): ?>
    <div style="text-align:center; padding: 10px 10px 0;">
        <img src="uploads/alat/<?= htmlspecialchars($a['foto']) ?>"
             alt="<?= htmlspecialchars($a['nama_alat']) ?>"
             style="width:100%; max-height:160px; object-fit:cover; border-radius:6px;">
    </div>
    <?php endif; ?>

    <div class="alat-body">
        <div class="alat-info">
            <div class="info-item">
                <span class="info-label">📦 Kategori:</span>
                <span class="info-value"><?= $a['nama_kategori'] ?></span>
            </div>
            
            <div class="info-item">
                <span class="info-label">💰 Harga Sewa:</span>
                <span class="info-value" style="font-weight: bold; color: #6D4C41;">
                    Rp <?= number_format($a['harga_sewa'] ?? 0, 0, ',', '.') ?>/hari
                </span>
            </div>
            
            <div class="info-item">
                <span class="info-label">📊 Stok:</span>
                <span class="info-value" style="font-weight: bold; color: <?= $a['stok'] > 0 ? '#6D4C41' : '#4E342E' ?>;">
                    <?= $a['stok'] ?> unit
                </span>
            </div>
            
            <div class="info-item">
                <span class="info-label">🔧 Kondisi:</span>
                <span class="info-value"><?= ucfirst($a['kondisi']) ?></span>
            </div>

            <?php if(isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin','petugas'])): ?>
            <div class="info-item">
                <span class="info-label">📌 Status:</span>
                <?php if($a['sedang_dipinjam']): ?>
                <span style="background:#FFCDD2; color:#C62828; padding:3px 10px; border-radius:12px; font-size:12px; font-weight:600;">
                    🔴 Sedang Dipinjam
                </span>
                <?php else: ?>
                <span style="background:#b3c6b4; color:#54410f; padding:3px 10px; border-radius:12px; font-size:12px; font-weight:600;">
                    🟢 Tersedia
                </span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?>
        <div class="alat-actions">
            <a href="?url=alat/edit/<?= $a['id'] ?>" class="btn-edit">✏️ Edit</a>
            <?php if($a['sedang_dipinjam']): ?>
            <span class="btn-delete" style="opacity:0.4; cursor:not-allowed;" title="Tidak bisa dihapus, sedang dipinjam">🗑️ Hapus</span>
            <?php else: ?>
            <a href="?url=alat/hapus/<?= $a['id'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
</div>

</div>
