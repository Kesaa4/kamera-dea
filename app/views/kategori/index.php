<div class="container">

<h2>Data Kategori</h2>

<div style="display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap;">
    <a href="?url=dashboard" style="display: inline-block;">← Kembali ke Dashboard</a>
    
    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?>
    <a href="?url=kategori/tambah" class="btn-add" style="padding: 10px 20px; background: linear-gradient(135deg, #6D4C41 0%, #5D4037 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">+ Tambah Kategori</a>
    <?php endif; ?>
</div>

<div class="kategori-grid">
<?php 
$colors = [
    ['#1565C0', '#1976D2', '📘'], // Biru
    ['#2E7D32', '#388E3C', '📗'], // Hijau
    ['#6A1B9A', '#7B1FA2', '📕'], // Ungu
    ['#C62828', '#D32F2F', '📙'], // Merah
    ['#F57C00', '#FB8C00', '📔'], // Orange
    ['#00838F', '#0097A7', '📓'], // Cyan
];
$index = 0;
foreach($data['kategori'] as $k): 
    $color = $colors[$index % count($colors)];
    $index++;
?>
<div class="kategori-card" style="border-left: 5px solid <?= $color[0] ?>;">
    <div class="kategori-icon" style="color: <?= $color[0] ?>;">
        <?= $color[2] ?>
    </div>
    
    <div class="kategori-content">
        <h3 style="color: <?= $color[0] ?>; margin: 0 0 15px 0; font-size: 20px;">
            <?= $k['nama_kategori'] ?>
        </h3>
        
        <a href="?url=kategori/detail/<?= $k['id'] ?>" 
           class="btn-view-kategori" 
           style="background: linear-gradient(135deg, <?= $color[0] ?> 0%, <?= $color[1] ?> 100%);">
            👁️ Lihat Barang
        </a>
    </div>
</div>
<?php endforeach; ?>
</div>

</div>
