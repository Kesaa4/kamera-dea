<div class="container">

<h2>Halaman Peminjaman</h2>

<a href="?url=dashboard" style="display: inline-block; margin-bottom: 20px;">← Kembali ke Dashboard</a>

<?php 
$role = $_SESSION['user']['role']; 
?>

<!-- ================= FORM AJUKAN ================= -->
<?php if($role=="peminjam"): ?>

<div class="card">
<h3>Ajukan Peminjaman</h3>

<form action="?url=peminjaman/ajukan" method="POST" id="formPeminjaman" enctype="multipart/form-data">

<label>Pilih Alat:</label>
<select name="alat" id="alat" required onchange="hitungTotal()">
<option value="">-- pilih alat --</option>

<?php foreach($data['alat'] as $a): ?>
<option value="<?= $a['id'] ?>" data-harga="<?= $a['harga_sewa'] ?? 0 ?>">
<?= $a['nama_alat'] ?> (stok: <?= $a['stok'] ?>) - Rp <?= number_format($a['harga_sewa'] ?? 0, 0, ',', '.') ?>/hari
</option>
<?php endforeach; ?>

</select>

<label>Tanggal Pinjam:</label>
<input type="date" name="tgl_pinjam" id="tgl_pinjam" required onchange="hitungTotal()">

<label>Tanggal Kembali:</label>
<input type="date" name="tgl_kembali" id="tgl_kembali" required onchange="hitungTotal()">

<div id="infoHarga" style="display: none; background: #FFF8E1; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #6D4C41;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
        <span style="color: #4E342E;">Harga Sewa/hari:</span>
        <strong id="hargaPerHari" style="color: #6D4C41;">Rp 0</strong>
    </div>
    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
        <span style="color: #4E342E;">Durasi:</span>
        <strong id="durasi" style="color: #6D4C41;">0 hari</strong>
    </div>
    <hr style="border-color: #D7CCC8; margin: 10px 0;">
    <div style="display: flex; justify-content: space-between;">
        <span style="color: #4E342E; font-weight: bold;">Total Harga:</span>
        <strong id="totalHarga" style="color: #5D4037; font-size: 18px;">Rp 0</strong>
    </div>
</div>

<input type="hidden" name="total_harga" id="total_harga_input" value="0">

<label>DP (Down Payment):</label>
<input type="number" name="dp" id="dp" placeholder="Masukkan jumlah DP" required min="0" onchange="hitungSisaBayar()">

<div id="infoDP" style="display: none; background: #E8F5E9; padding: 12px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #4CAF50;">
    <div style="display: flex; justify-content: space-between;">
        <span style="color: #2E7D32;">Sisa Bayar:</span>
        <strong id="sisaBayar" style="color: #1B5E20; font-size: 16px;">Rp 0</strong>
    </div>
</div>

<label>Bukti Transfer DP:</label>
<input type="file" name="bukti_dp" required accept="image/*">

<button type="submit">Ajukan Peminjaman</button>

</form>
</div>

<script>
function hitungTotal() {
    const alatSelect = document.getElementById('alat');
    const tglPinjam = document.getElementById('tgl_pinjam').value;
    const tglKembali = document.getElementById('tgl_kembali').value;
    const infoHarga = document.getElementById('infoHarga');
    
    if(alatSelect.value && tglPinjam && tglKembali) {
        const hargaSewa = parseInt(alatSelect.options[alatSelect.selectedIndex].getAttribute('data-harga'));
        
        // Hitung durasi
        const date1 = new Date(tglPinjam);
        const date2 = new Date(tglKembali);
        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        // Minimal 1 hari
        const durasi = diffDays === 0 ? 1 : diffDays;
        
        // Hitung total
        const total = hargaSewa * durasi;
        
        // Tampilkan info
        document.getElementById('hargaPerHari').textContent = 'Rp ' + hargaSewa.toLocaleString('id-ID');
        document.getElementById('durasi').textContent = durasi + ' hari';
        document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('total_harga_input').value = total;
        
        infoHarga.style.display = 'block';
        hitungSisaBayar();
    } else {
        infoHarga.style.display = 'none';
    }
}

function hitungSisaBayar() {
    const total = parseInt(document.getElementById('total_harga_input').value) || 0;
    const dp = parseInt(document.getElementById('dp').value) || 0;
    const infoDP = document.getElementById('infoDP');
    
    if(dp > 0 && total > 0) {
        if(dp > total) {
            alert('DP tidak boleh lebih besar dari total harga!');
            document.getElementById('dp').value = '';
            infoDP.style.display = 'none';
            return;
        }
        
        const sisa = total - dp;
        document.getElementById('sisaBayar').textContent = 'Rp ' + sisa.toLocaleString('id-ID');
        infoDP.style.display = 'block';
    } else {
        infoDP.style.display = 'none';
    }
}

// Validasi tanggal
document.getElementById('tgl_kembali').addEventListener('change', function() {
    const tglPinjam = document.getElementById('tgl_pinjam').value;
    const tglKembali = this.value;
    
    if(tglPinjam && tglKembali) {
        if(new Date(tglKembali) < new Date(tglPinjam)) {
            alert('Tanggal kembali tidak boleh lebih awal dari tanggal pinjam!');
            this.value = '';
        }
    }
});
</script>

<hr>

<?php endif; ?>


<!-- ================= TABEL DATA ================= -->

<h3>Data Peminjaman</h3>

<table>

<thead>
<tr>
<th>User</th>
<th>Alat</th>
<th>Total Harga</th>
<th>DP</th>
<th>Sisa Bayar</th>
<th>Status Pembayaran</th>
<th>Status</th>
<th>Denda</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php foreach($data['pinjam'] as $p): ?>

<tr>

<td><?= $p['nama'] ?? $_SESSION['user']['nama'] ?></td>
<td><?= $p['nama_alat'] ?></td>

<td>
    <span style="font-weight: bold; color: #6D4C41;">
        Rp <?= number_format($p['total_harga'] ?? 0, 0, ',', '.') ?>
    </span>
</td>

<td>
    <span style="color: #2E7D32;">
        Rp <?= number_format($p['dp'] ?? 0, 0, ',', '.') ?>
    </span>
</td>

<td>
    <span style="color: #D84315;">
        Rp <?= number_format($p['sisa_bayar'] ?? 0, 0, ',', '.') ?>
    </span>
</td>

<td>
<?php 
$statusPembayaran = $p['status_pembayaran'] ?? 'belum_dp';
$badgeColor = '';
switch($statusPembayaran) {
    case 'belum_dp': $badgeColor = '#FF5722'; break;
    case 'dp_dibayar': $badgeColor = '#FF9800'; break;
    case 'lunas': $badgeColor = '#4CAF50'; break;
}
?>
<span style="background: <?= $badgeColor ?>; color: white; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">
    <?= strtoupper(str_replace('_', ' ', $statusPembayaran)) ?>
</span>
</td>

<td>
<?php 
$statusClass = '';
switch($p['status']) {
    case 'pending': $statusClass = 'status-pending'; break;
    case 'disetujui': $statusClass = 'status-disetujui'; break;
    case 'menunggu_pengembalian': $statusClass = 'status-menunggu'; break;
    case 'dikembalikan': $statusClass = 'status-tersedia'; break;
    default: $statusClass = '';
}
?>
<span class="<?= $statusClass ?>"><?= ucfirst(str_replace('_', ' ', $p['status'])) ?></span>

<?php if(isset($p['status_bayar']) && $p['status_bayar']=="belum_bayar"): ?>
<br><br>
<span class="status-pending">
Belum Membayar Denda
</span>
<?php endif; ?>

</td>

<td>
<span class="denda-amount">Rp <?= number_format($p['total_denda'] ?? 0, 0, ',', '.') ?></span>
</td>

<td>

<!-- ================= PETUGAS APPROVE ================= -->
<?php if($role=="petugas" && $p['status']=="pending"): ?>

<a href="?url=peminjaman/approve/<?= $p['id'] ?>" class="btn-success" style="padding: 8px 16px; margin: 2px; font-size: 12px; display: inline-block; color: white; border-radius: 6px;">✓ Approve</a>
<a href="?url=peminjaman/reject/<?= $p['id'] ?>" class="btn-danger" style="padding: 8px 16px; margin: 2px; font-size: 12px; display: inline-block; color: white; border-radius: 6px;">✗ Reject</a>

<?php endif; ?>

<!-- PEMINJAM BAYAR DENDA -->
<?php if($role=="peminjam" && $p['status']=="menunggu_pembayaran"): ?>

<div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin-top: 10px;">
<form action="?url=peminjaman/bayarDenda" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $p['id'] ?>">

<label style="display: block; margin-bottom: 8px; font-weight: 600;">Upload Bukti Pembayaran:</label>
<input type="file" name="bukti" required style="width: 100%; margin-bottom: 10px;">

<button type="submit" class="btn-success" style="width: 100%;">
💳 Bayar Denda
</button>

</form>
</div>

<?php endif; ?>

<!-- ================= PEMINJAM AJUKAN PENGEMBALIAN ================= -->
<?php if($role=="peminjam" && $p['status']=="disetujui"): ?>

<a href="?url=peminjaman/ajukanKembali/<?= $p['id'] ?>" class="btn-warning" style="padding: 8px 16px; margin: 2px; font-size: 12px; display: inline-block; color: white; border-radius: 6px;">
📦 Ajukan Pengembalian
</a>

<?php endif; ?>


<!-- ================= STATUS MENUNGGU ================= -->
<?php if($p['status']=="menunggu_pengembalian"): ?>

<span class="status-menunggu">
⏳ Menunggu Konfirmasi Petugas
</span>

<?php endif; ?>

<!-- ================= PETUGAS KONFIRMASI ================= -->
<?php if($role=="petugas" && $p['status']=="menunggu_pengembalian"): ?>

<div style="background: #f8f9ff; padding: 15px; border-radius: 8px; margin-top: 10px;">
<form method="POST" action="?url=peminjaman/konfirmasiKembali" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $p['id'] ?>">

<textarea name="kerusakan" placeholder="Deskripsi kerusakan (opsional)" style="width: 100%; margin-bottom: 10px;"></textarea>

<input type="number" 
name="denda_kerusakan"
placeholder="Denda kerusakan (Rp)"
value="0"
min="0"
style="width: 100%; margin-bottom: 10px;">

<label style="display: block; margin-bottom: 5px; font-weight: 600;">Pelunasan (Sisa Bayar + Denda):</label>
<input type="number" 
name="pelunasan"
placeholder="Jumlah pelunasan (Rp)"
required
min="0"
style="width: 100%; margin-bottom: 10px;">

<label style="display: block; margin-bottom: 5px; font-weight: 600;">Bukti Transfer Pelunasan:</label>
<input type="file" 
name="bukti_pelunasan"
required
accept="image/*"
style="width: 100%; margin-bottom: 10px;">

<button type="submit" style="width: 100%;">
✓ Konfirmasi Pengembalian
</button>

</form>
</div>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>
