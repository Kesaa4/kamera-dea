<div class="container">

<h2>Halaman Peminjaman</h2>

<a href="?url=dashboard" style="display: inline-block; margin-bottom: 20px;">← Kembali ke Dashboard</a>

<?php $role = $_SESSION['user']['role']; ?>

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

<label>Bukti Transfer:</label>
<input type="file" name="bukti_tf" required accept="image/*">

<button type="submit">Ajukan Peminjaman</button>

</form>
</div>

<script>
function hitungTotal() {
    const alatSelect = document.getElementById('alat');
    const tglPinjam  = document.getElementById('tgl_pinjam').value;
    const tglKembali = document.getElementById('tgl_kembali').value;
    const infoHarga  = document.getElementById('infoHarga');

    if(alatSelect.value && tglPinjam && tglKembali) {
        const hargaSewa = parseInt(alatSelect.options[alatSelect.selectedIndex].getAttribute('data-harga'));
        const date1 = new Date(tglPinjam);
        const date2 = new Date(tglKembali);
        const diffDays = Math.ceil(Math.abs(date2 - date1) / (1000 * 60 * 60 * 24));
        const durasi = diffDays === 0 ? 1 : diffDays;
        const total  = hargaSewa * durasi;

        document.getElementById('hargaPerHari').textContent = 'Rp ' + hargaSewa.toLocaleString('id-ID');
        document.getElementById('durasi').textContent = durasi + ' hari';
        document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('total_harga_input').value = total;
        infoHarga.style.display = 'block';
    } else {
        infoHarga.style.display = 'none';
    }
}

document.getElementById('tgl_kembali').addEventListener('change', function() {
    const tglPinjam  = document.getElementById('tgl_pinjam').value;
    const tglKembali = this.value;
    if(tglPinjam && tglKembali && new Date(tglKembali) < new Date(tglPinjam)) {
        alert('Tanggal kembali tidak boleh lebih awal dari tanggal pinjam!');
        this.value = '';
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
<?php
$statusClass = '';
switch($p['status']) {
    case 'pending':               $statusClass = 'status-pending';   break;
    case 'disetujui':             $statusClass = 'status-disetujui'; break;
    case 'menunggu_pengembalian': $statusClass = 'status-menunggu';  break;
    case 'dikembalikan':          $statusClass = 'status-tersedia';  break;
    default: $statusClass = '';
}
?>
<span class="<?= $statusClass ?>"><?= ucfirst(str_replace('_', ' ', $p['status'])) ?></span>

<?php if($p['status'] == 'ditolak' && !empty($p['alasan_tolak'])): ?>
<br><small style="color:#C62828; font-size:11px;">📝 <?= htmlspecialchars($p['alasan_tolak']) ?></small>
<?php endif; ?>

</td>

<td>
<span class="denda-amount">Rp <?= number_format($p['total_denda'] ?? 0, 0, ',', '.') ?></span>
</td>

<td>

<!-- PETUGAS APPROVE/REJECT -->
<?php if($role=="petugas" && $p['status']=="pending"): ?>
<a href="?url=peminjaman/approve/<?= $p['id'] ?>" class="btn-success" style="padding: 8px 16px; margin: 2px; font-size: 12px; display: inline-block; color: white; border-radius: 6px;">✓ Approve</a>

<button type="button" onclick="document.getElementById('form-tolak-<?= $p['id'] ?>').style.display='block'; this.style.display='none';" class="btn-danger" style="padding: 8px 16px; margin: 2px; font-size: 12px; color: white; border-radius: 6px;">✗ Reject</button>

<div id="form-tolak-<?= $p['id'] ?>" style="display:none; background:#fff3f3; padding:12px; border-radius:8px; margin-top:8px; border:1px solid #ffcdd2;">
    <form method="POST" action="?url=peminjaman/reject">
        <input type="hidden" name="id" value="<?= $p['id'] ?>">
        <label style="font-weight:600; color:#C62828; font-size:13px;">Alasan Penolakan:</label>
        <textarea name="alasan" required placeholder="Tulis alasan penolakan..." style="width:100%; padding:8px; border:1px solid #ffcdd2; border-radius:6px; margin:6px 0; font-size:13px; resize:vertical; min-height:70px;"></textarea>
        <button type="submit" class="btn-danger" style="padding:8px 16px; font-size:12px; color:white; border-radius:6px;">✗ Konfirmasi Tolak</button>
        <button type="button" onclick="document.getElementById('form-tolak-<?= $p['id'] ?>').style.display='none';" style="padding:8px 16px; font-size:12px; border-radius:6px; background:#aaa; color:white; border:none; cursor:pointer; margin-left:4px;">Batal</button>
    </form>
</div>
<?php endif; ?>

<!-- PEMINJAM BAYAR DENDA -->
<?php if($role=="peminjam" && $p['status']=="menunggu_pembayaran"): ?>
<div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin-top: 10px;">
<form action="?url=peminjaman/bayarDenda" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $p['id'] ?>">
<label style="display: block; margin-bottom: 8px; font-weight: 600;">Upload Bukti Pembayaran:</label>
<input type="file" name="bukti" required style="width: 100%; margin-bottom: 10px;">
<button type="submit" class="btn-success" style="width: 100%;">💳 Bayar Denda</button>
</form>
</div>
<?php endif; ?>

<!-- PEMINJAM AJUKAN PENGEMBALIAN -->
<?php if($role=="peminjam" && $p['status']=="disetujui"): ?>
<a href="?url=peminjaman/ajukanKembali/<?= $p['id'] ?>" class="btn-warning" style="padding: 8px 16px; margin: 2px; font-size: 12px; display: inline-block; color: white; border-radius: 6px;">
📦 Ajukan Pengembalian
</a>
<?php endif; ?>

<!-- STATUS MENUNGGU -->
<?php if($p['status']=="menunggu_pengembalian" && $role!="petugas"): ?>
<span class="status-menunggu">⏳ Menunggu Konfirmasi Petugas</span>
<?php endif; ?>

<!-- PETUGAS KONFIRMASI KEMBALI -->
<?php if($role=="petugas" && $p['status']=="menunggu_pengembalian"): ?>

<button type="button" onclick="document.getElementById('form-kembali-<?= $p['id'] ?>').style.display='block'; this.style.display='none';" class="btn-success" style="padding: 8px 16px; margin: 2px; font-size: 12px; color: white; border-radius: 6px;">
    📦 Proses Pengembalian
</button>

<div id="form-kembali-<?= $p['id'] ?>" style="display:none; background: #f8f9ff; padding: 15px; border-radius: 8px; margin-top: 10px;">
<form method="POST" action="?url=peminjaman/konfirmasiKembali" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $p['id'] ?>">

<label style="display:block; margin-bottom:5px; font-weight:600;">Kondisi Alat:</label>
<select name="kondisi_alat" onchange="toggleDenda(this, '<?= $p['id'] ?>')" style="width:100%; padding:8px; border:2px solid #D7CCC8; border-radius:6px; margin-bottom:10px;">
    <option value="baik">✅ Baik</option>
    <option value="rusak">⚠️ Rusak</option>
</select>

<div id="bagian-rusak-<?= $p['id'] ?>" style="display:none;">
    <label style="display:block; margin-bottom:5px; font-weight:600;">Denda Kerusakan (Rp):</label>
    <input type="number" name="denda_kerusakan" placeholder="Nominal denda" value="0" min="0" style="width:100%; margin-bottom:10px;">
</div>

<label style="display:block; margin-bottom:5px; font-weight:600;">Jumlah Pembayaran (Rp):</label>
<input type="number" name="pelunasan" placeholder="Jumlah pembayaran (Rp)" required min="0" style="width:100%; margin-bottom:10px;">
<label style="display:block; margin-bottom:5px; font-weight:600;">Bukti Transfer:</label>
<input type="file" name="bukti_pelunasan" required accept="image/*" style="width:100%; margin-bottom:10px;">
<button type="submit" style="width:100%;">✓ Konfirmasi Pengembalian</button>
<button type="button" onclick="document.getElementById('form-kembali-<?= $p['id'] ?>').style.display='none'; this.parentNode.parentNode.previousElementSibling.style.display='inline-block';" style="width:100%; margin-top:5px; background:#aaa; color:white; border:none; padding:8px; border-radius:6px; cursor:pointer;">Batal</button>
</form>
</div>

<script>
function toggleDenda(sel, id) {
    const bagian = document.getElementById('bagian-rusak-' + id);
    if(sel.value === 'rusak') {
        bagian.style.display = 'block';
        // aktifkan input denda dari bagian rusak, nonaktifkan hidden
        bagian.querySelectorAll('input,textarea').forEach(el => el.removeAttribute('disabled'));
    } else {
        bagian.style.display = 'none';
        // reset & disable input denda
        bagian.querySelectorAll('input').forEach(el => { el.value = '0'; el.setAttribute('disabled','disabled'); });
        bagian.querySelector('textarea').value = '';
    }
}
</script>

<?php endif; ?>

</td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

</div>
