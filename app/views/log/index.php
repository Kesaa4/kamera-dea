<div class="container">

<h2>📋 Log Aktivitas</h2>

<div style="display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap;">
    <a href="?url=dashboard" style="display: inline-block;">← Kembali ke Dashboard</a>
</div>

<?php if(empty($data['logs'])): ?>
    <div style="text-align: center; padding: 40px; background: white; border-radius: 12px;">
        <p style="color: #6D4C41; font-size: 16px;">Belum ada aktivitas yang tercatat</p>
    </div>
<?php else: ?>

<div class="log-container">
    <?php foreach($data['logs'] as $log): ?>
    <div class="log-item">
        <div class="log-header">
            <div class="log-user">
                <span class="user-icon">👤</span>
                <div>
                    <strong><?= htmlspecialchars($log['nama_user']) ?></strong>
                    <span class="user-role role-<?= $log['role'] ?>"><?= ucfirst($log['role']) ?></span>
                </div>
            </div>
            <div class="log-time">
                <?php
                $time = strtotime($log['created_at']);
                $diff = time() - $time;
                
                if($diff < 60) {
                    echo "Baru saja";
                } elseif($diff < 3600) {
                    echo floor($diff / 60) . " menit lalu";
                } elseif($diff < 86400) {
                    echo floor($diff / 3600) . " jam lalu";
                } else {
                    echo date('d M Y H:i', $time);
                }
                ?>
            </div>
        </div>
        
        <div class="log-body">
            <div class="log-activity">
                <?php
                // Icon berdasarkan aktivitas
                $icon = '📝';
                if(strpos($log['aktivitas'], 'Login') !== false) $icon = '🔐';
                elseif(strpos($log['aktivitas'], 'Logout') !== false) $icon = '🚪';
                elseif(strpos($log['aktivitas'], 'Tambah') !== false) $icon = '➕';
                elseif(strpos($log['aktivitas'], 'Edit') !== false || strpos($log['aktivitas'], 'Update') !== false) $icon = '✏️';
                elseif(strpos($log['aktivitas'], 'Hapus') !== false) $icon = '🗑️';
                elseif(strpos($log['aktivitas'], 'Approve') !== false) $icon = '✅';
                elseif(strpos($log['aktivitas'], 'Reject') !== false) $icon = '❌';
                elseif(strpos($log['aktivitas'], 'Ajukan') !== false) $icon = '📤';
                elseif(strpos($log['aktivitas'], 'Bayar') !== false) $icon = '💳';
                ?>
                <span class="activity-icon"><?= $icon ?></span>
                <strong><?= htmlspecialchars($log['aktivitas']) ?></strong>
            </div>
            
            <?php if(!empty($log['keterangan'])): ?>
            <div class="log-detail">
                <?= htmlspecialchars($log['keterangan']) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>

</div>
