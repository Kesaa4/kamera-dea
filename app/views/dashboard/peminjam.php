<div class="dashboard-container">
    <div class="dashboard-header">
        <div>
            <h1>👤 Dashboard Peminjam</h1>
            <p>Selamat datang, <?= $_SESSION['user']['nama'] ?? 'Peminjam' ?></p>
        </div>
        <a href="?url=auth/logout" class="btn-logout">
            🚪 Logout
        </a>
    </div>

    <div class="dashboard-grid">
        <a href="?url=alat" class="dashboard-card card-blue">
            <div class="card-icon">📦</div>
            <h3>Lihat Data Alat</h3>
            <p>Cek alat yang tersedia</p>
            <span class="card-arrow">→</span>
        </a>

        <a href="?url=peminjaman" class="dashboard-card card-green">
            <div class="card-icon">📝</div>
            <h3>Peminjaman Saya</h3>
            <p>Ajukan dan lihat status peminjaman</p>
            <span class="card-arrow">→</span>
        </a>

        <a href="?url=kategori" class="dashboard-card card-purple">
            <div class="card-icon">🏷️</div>
            <h3>Lihat Kategori</h3>
            <p>Browse kategori alat</p>
            <span class="card-arrow">→</span>
        </a>
    </div>
</div>
