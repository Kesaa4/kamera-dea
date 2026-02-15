<h2>Barang dalam kategori: <?= $data['kategori']['nama_kategori'] ?></h2>

<a href="?url=kategori">Kembali ke kategori</a>

<table border="1">

<tr>
<th>Nama Alat</th>
<th>Stok</th>
<th>Kondisi</th>
</tr>

<?php foreach($data['alat'] as $a): ?>

<tr>
<td><?= $a['nama_alat'] ?></td>
<td><?= $a['stok'] ?></td>
<td><?= $a['kondisi'] ?></td>
</tr>

<?php endforeach; ?>

</table>
