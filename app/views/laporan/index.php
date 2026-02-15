<div class="container">

<h2>📊 Cetak Laporan</h2>

<div style="display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap;">
    <a href="?url=dashboard" style="display: inline-block;">← Kembali ke Dashboard</a>
</div>

<div class="laporan-grid">
    
    <!-- Laporan Peminjaman -->
    <div class="laporan-card">
        <div class="laporan-icon" style="background: linear-gradient(135deg, #6D4C41 0%, #5D4037 100%);">
            📋
        </div>
        <h3>Laporan Peminjaman</h3>
        <p>Cetak laporan data peminjaman berdasarkan periode dan status</p>
        
        <form action="?url=laporan/peminjaman" method="GET" target="_blank">
            <input type="hidden" name="url" value="laporan/peminjaman">
            
            <label>Dari Tanggal:</label>
            <input type="date" name="dari" value="<?= date('Y-m-01') ?>" required>
            
            <label>Sampai Tanggal:</label>
            <input type="date" name="sampai" value="<?= date('Y-m-d') ?>" required>
            
            <label>Status:</label>
            <select name="status">
                <option value="semua">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
                <option value="menunggu_pengembalian">Menunggu Pengembalian</option>
                <option value="menunggu_pembayaran">Menunggu Pembayaran</option>
                <option value="dikembalikan">Dikembalikan</option>
            </select>
            
            <button type="submit" class="btn-cetak">🖨️ Cetak Laporan</button>
        </form>
    </div>

    <!-- Laporan Alat -->
    <div class="laporan-card">
        <div class="laporan-icon" style="background: linear-gradient(135deg, #8D6E63 0%, #6D4C41 100%);">
            📦
        </div>
        <h3>Laporan Data Alat</h3>
        <p>Cetak laporan semua data alat dan stok</p>
        
        <a href="?url=laporan/alat" target="_blank" class="btn-cetak" style="display: block; text-align: center; margin-top: 20px;">
            🖨️ Cetak Laporan
        </a>
    </div>

    <!-- Laporan Denda -->
    <div class="laporan-card">
        <div class="laporan-icon" style="background: linear-gradient(135deg, #A1887F 0%, #8D6E63 100%);">
            💰
        </div>
        <h3>Laporan Denda</h3>
        <p>Cetak laporan denda berdasarkan periode</p>
        
        <form action="?url=laporan/denda" method="GET" target="_blank">
            <input type="hidden" name="url" value="laporan/denda">
            
            <label>Dari Tanggal:</label>
            <input type="date" name="dari" value="<?= date('Y-m-01') ?>" required>
            
            <label>Sampai Tanggal:</label>
            <input type="date" name="sampai" value="<?= date('Y-m-d') ?>" required>
            
            <button type="submit" class="btn-cetak">🖨️ Cetak Laporan</button>
        </form>
    </div>

</div>

</div>
