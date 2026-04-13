<div class="container">

<div style="margin-bottom: 25px;">
    <a href="?url=kategori" style="color: #6D4C41; font-weight: 600;">← Kembali ke Kategori</a>
</div>

<h2>📂 Kategori: <?= $data['kategori']['nama_kategori'] ?></h2>

<?php if(empty($data['alat'])): ?>
<div style="text-align:center; padding: 60px 20px; color: #A1887F;">
    <div style="font-size: 60px; margin-bottom: 15px;">📭</div>
    <p style="font-size: 16px;">Belum ada alat dalam kategori ini.</p>
</div>

<?php else: ?>

<div class="alat-grid">
<?php
$colors = [
    ['#6D4C41', '#5D4037'],
    ['#5D4037', '#4E342E'],
    ['#8D6E63', '#6D4C41'],
    ['#A1887F', '#8D6E63'],
    ['#795548', '#5D4037'],
    ['#6D4C41', '#4E342E'],
];
$i = 0;
foreach($data['alat'] as $a):
    $c = $colors[$i % count($colors)];
    $i++;
?>
<div class="alat-card" style="border-top: 4px solid <?= $c[0] ?>;">
    <div class="alat-header" style="background: linear-gradient(135deg, <?= $c[0] ?> 0%, <?= $c[1] ?> 100%);">
        <h3 style="color: white; margin: 0; font-size: 15px;">📷 <?= $a['nama_alat'] ?></h3>
    </div>

    <div class="alat-body">
        <div class="alat-info">
            <div class="info-item">
                <span class="info-label">📦 Stok:</span>
                <span class="info-value" style="font-weight:bold; color: <?= $a['stok'] > 0 ? '#6D4C41' : '#C62828' ?>;">
                    <?= $a['stok'] ?> unit
                </span>
            </div>

            <div class="info-item">
                <span class="info-label">🔧 Kondisi:</span>
                <?php if($a['kondisi'] == 'baik'): ?>
                <span style="background:#b3c6b4; color:#54410f; padding:3px 10px; border-radius:12px; font-size:12px; font-weight:600;">
                    ✅ Baik
                </span>
                <?php else: ?>
                <span style="background:#FFCDD2; color:#C62828; padding:3px 10px; border-radius:12px; font-size:12px; font-weight:600;">
                    ⚠️ <?= ucfirst($a['kondisi']) ?>
                </span>
                <?php endif; ?>
            </div>

            <div class="info-item">
                <span class="info-label">💰 Harga Sewa:</span>
                <span class="info-value" style="font-weight:bold; color:#6D4C41;">
                    Rp <?= number_format($a['harga_sewa'] ?? 0, 0, ',', '.') ?>/hari
                </span>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>

<?php endif; ?>

</div>
