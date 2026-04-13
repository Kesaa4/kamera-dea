<div class="dashboard-container">
    <div class="dashboard-header">
        <div>
            <h1>👨‍💼 Dashboard Admin</h1>
            <p>Selamat datang, <?= $_SESSION['user']['nama'] ?? 'Admin' ?></p>
        </div>
        <a href="?url=auth/logout" class="btn-logout">
            🚪 Logout
        </a>
    </div>

    <div class="dashboard-grid">
        <a href="?url=alat" class="dashboard-card card-blue">
            <div class="card-icon">📦</div>
            <h3>Kelola Data Alat</h3>
            <p>Tambah, edit, dan hapus data alat</p>
            <span class="card-arrow">→</span>
        </a>

        <a href="?url=peminjaman" class="dashboard-card card-green">
            <div class="card-icon">📋</div>
            <h3>Data Peminjaman</h3>
            <p>Monitor semua transaksi peminjaman</p>
            <span class="card-arrow">→</span>
        </a>

        <a href="?url=kategori" class="dashboard-card card-purple">
            <div class="card-icon">🏷️</div>
            <h3>Kelola Kategori</h3>
            <p>Atur kategori alat</p>
            <span class="card-arrow">→</span>
        </a>

        <a href="?url=user" class="dashboard-card card-blue">
            <div class="card-icon">👥</div>
            <h3>Manajemen User</h3>
            <p>Kelola data user sistem</p>
            <span class="card-arrow">→</span>
        </a>

        <a href="?url=log" class="dashboard-card card-green">
            <div class="card-icon">📋</div>
            <h3>Log Aktivitas</h3>
            <p>Lihat semua aktivitas sistem</p>
            <span class="card-arrow">→</span>
        </a>
    </div>
</div>
