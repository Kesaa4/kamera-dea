<!DOCTYPE html>
<html>
<head>
    <title>Laporan Denda</title>
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
        .total {
            font-weight: bold;
            background-color: #EFEBE9 !important;
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
    <h2>LAPORAN DENDA</h2>
    <h3>Sistem Peminjaman Alat</h3>
</div>

<div class="info">
    <strong>Periode:</strong> <?= date('d/m/Y', strtotime($data['dari'])) ?> s/d <?= date('d/m/Y', strtotime($data['sampai'])) ?><br>
    <strong>Dicetak oleh:</strong> <?= $_SESSION['user']['nama'] ?> (<?= ucfirst($_SESSION['user']['role']) ?>)<br>
    <strong>Tanggal Cetak:</strong> <?= date('d/m/Y H:i') ?>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Alat</th>
            <th>Denda Telat</th>
            <th>Denda Kerusakan</th>
            <th>Total Denda</th>
            <th>Status Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($data['denda'])): ?>
        <tr>
            <td colspan="7" style="text-align: center;">Tidak ada data denda</td>
        </tr>
        <?php else: ?>
        <?php 
        $no = 1; 
        $totalDendaTelat = 0;
        $totalDendaKerusakan = 0;
        $totalSemua = 0;
        foreach($data['denda'] as $d): 
            $totalDendaTelat += $d['denda_telat'];
            $totalDendaKerusakan += $d['denda_kerusakan'];
            $totalSemua += $d['total_denda'];
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($d['nama']) ?></td>
            <td><?= htmlspecialchars($d['nama_alat']) ?></td>
            <td>Rp <?= number_format($d['denda_telat'], 0, ',', '.') ?></td>
            <td>Rp <?= number_format($d['denda_kerusakan'], 0, ',', '.') ?></td>
            <td>Rp <?= number_format($d['total_denda'], 0, ',', '.') ?></td>
            <td><?= ucfirst(str_replace('_', ' ', $d['status_bayar'] ?? '-')) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="total">
            <td colspan="3" style="text-align: right;"><strong>TOTAL:</strong></td>
            <td><strong>Rp <?= number_format($totalDendaTelat, 0, ',', '.') ?></strong></td>
            <td><strong>Rp <?= number_format($totalDendaKerusakan, 0, ',', '.') ?></strong></td>
            <td><strong>Rp <?= number_format($totalSemua, 0, ',', '.') ?></strong></td>
            <td></td>
        </tr>
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
