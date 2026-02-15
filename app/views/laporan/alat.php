<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Alat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #6D4C41;
            padding-bottom: 15px;
        }
        .header h2 {
            margin: 5px 0;
            color: #4E342E;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #6D4C41;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h2>LAPORAN DATA ALAT</h2>
    <h3>Sistem Peminjaman Alat</h3>
</div>

<div class="info">
    <strong>Dicetak oleh:</strong> <?= $_SESSION['user']['nama'] ?> (<?= ucfirst($_SESSION['user']['role']) ?>)<br>
    <strong>Tanggal Cetak:</strong> <?= date('d/m/Y H:i') ?>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Alat</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Kondisi</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($data['alat'])): ?>
        <tr>
            <td colspan="5" style="text-align: center;">Tidak ada data</td>
        </tr>
        <?php else: ?>
        <?php $no = 1; foreach($data['alat'] as $a): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($a['nama_alat']) ?></td>
            <td><?= htmlspecialchars($a['nama_kategori']) ?></td>
            <td><?= $a['stok'] ?> unit</td>
            <td><?= ucfirst($a['kondisi']) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    <p>
        <br><br>
        Petugas,<br><br><br><br>
        <strong><?= $_SESSION['user']['nama'] ?></strong>
    </p>
</div>

<div class="no-print" style="text-align: center; margin-top: 30px;">
    <button onclick="window.print()" style="padding: 10px 30px; background: #6D4C41; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
        🖨️ Print
    </button>
    <button onclick="window.close()" style="padding: 10px 30px; background: #999; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-left: 10px;">
        ✖️ Tutup
    </button>
</div>

</body>
</html>
