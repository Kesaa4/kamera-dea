<?php
require __DIR__ . "/../core/Controller.php";

class LaporanController extends Controller {

    public function index() {
        Middleware::petugasOnly();
        $this->view("laporan/index");
    }

    public function peminjaman() {
        Middleware::petugasOnly();

        $dari   = $_GET['dari'] ?? date('Y-m-01');
        $sampai = $_GET['sampai'] ?? date('Y-m-d');
        $status = $_GET['status'] ?? 'semua';
        $format = $_GET['format'] ?? 'print';

        LogHelper::catat('Cetak Laporan Peminjaman', 'Mencetak laporan periode ' . $dari . ' s/d ' . $sampai);

        $data = [
            'dari'       => $dari,
            'sampai'     => $sampai,
            'status'     => $status,
            'peminjaman' => $this->model("Peminjaman")->getLaporan($dari, $sampai, $status),
        ];

        if ($format === 'excel') {
            $this->exportExcelPeminjaman($data);
        } else {
            $this->view("laporan/peminjaman", $data);
        }
    }

    public function alat() {
        Middleware::petugasOnly();

        $format = $_GET['format'] ?? 'print';

        LogHelper::catat('Cetak Laporan Alat', 'Mencetak laporan data alat');

        $data = ['alat' => $this->model("Alat")->getAll()];

        if ($format === 'excel') {
            $this->exportExcelAlat($data);
        } else {
            $this->view("laporan/alat", $data);
        }
    }

    public function denda() {
        Middleware::petugasOnly();

        $dari   = $_GET['dari'] ?? date('Y-m-01');
        $sampai = $_GET['sampai'] ?? date('Y-m-d');
        $format = $_GET['format'] ?? 'print';

        LogHelper::catat('Cetak Laporan Denda', 'Mencetak laporan denda periode ' . $dari . ' s/d ' . $sampai);

        $data = [
            'dari'   => $dari,
            'sampai' => $sampai,
            'denda'  => $this->model("Peminjaman")->getLaporanDenda($dari, $sampai),
        ];

        if ($format === 'excel') {
            $this->exportExcelDenda($data);
        } else {
            $this->view("laporan/denda", $data);
        }
    }

    // =====================
    // EXPORT EXCEL
    // =====================

    private function exportExcelPeminjaman($data) {
        $filename = 'laporan_peminjaman_' . $data['dari'] . '_sd_' . $data['sampai'] . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $status = ucfirst(str_replace('_', ' ', $data['status']));
        $periode = date('d/m/Y', strtotime($data['dari'])) . ' s/d ' . date('d/m/Y', strtotime($data['sampai']));
        $dicetak = $_SESSION['user']['nama'] . ' (' . ucfirst($_SESSION['user']['role']) . ')';

        echo '<html><head><meta charset="UTF-8"></head><body>';
        echo '<table border="0">';
        echo '<tr><td colspan="7"><b>LAPORAN DATA PEMINJAMAN</b></td></tr>';
        echo '<tr><td colspan="7">Sistem Peminjaman Alat</td></tr>';
        echo '<tr><td colspan="7"></td></tr>';
        echo '<tr><td colspan="2">Periode</td><td colspan="5">: ' . $periode . '</td></tr>';
        echo '<tr><td colspan="2">Status</td><td colspan="5">: ' . $status . '</td></tr>';
        echo '<tr><td colspan="2">Dicetak oleh</td><td colspan="5">: ' . $dicetak . '</td></tr>';
        echo '<tr><td colspan="2">Tanggal Cetak</td><td colspan="5">: ' . date('d/m/Y H:i') . '</td></tr>';
        echo '<tr><td colspan="7"></td></tr>';
        echo '</table>';

        echo '<table border="1" cellpadding="5" cellspacing="0">';
        echo '<thead><tr style="background:#6D4C41;color:white;">';
        echo '<th>No</th><th>Peminjam</th><th>Alat</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Denda</th>';
        echo '</tr></thead><tbody>';

        if (empty($data['peminjaman'])) {
            echo '<tr><td colspan="7" align="center">Tidak ada data</td></tr>';
        } else {
            $no = 1;
            foreach ($data['peminjaman'] as $p) {
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . htmlspecialchars($p['nama']) . '</td>';
                echo '<td>' . htmlspecialchars($p['nama_alat']) . '</td>';
                echo '<td>' . date('d/m/Y', strtotime($p['tgl_pinjam'])) . '</td>';
                echo '<td>' . date('d/m/Y', strtotime($p['tgl_kembali'])) . '</td>';
                echo '<td>' . ucfirst(str_replace('_', ' ', $p['status'])) . '</td>';
                echo '<td>Rp ' . number_format($p['total_denda'] ?? 0, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        }

        echo '</tbody></table></body></html>';
        exit;
    }

    private function exportExcelAlat($data) {
        $filename = 'laporan_alat_' . date('Y-m-d') . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $dicetak = $_SESSION['user']['nama'] . ' (' . ucfirst($_SESSION['user']['role']) . ')';

        echo '<html><head><meta charset="UTF-8"></head><body>';
        echo '<table border="0">';
        echo '<tr><td colspan="5"><b>LAPORAN DATA ALAT</b></td></tr>';
        echo '<tr><td colspan="5">Sistem Peminjaman Alat</td></tr>';
        echo '<tr><td colspan="5"></td></tr>';
        echo '<tr><td colspan="2">Dicetak oleh</td><td colspan="3">: ' . $dicetak . '</td></tr>';
        echo '<tr><td colspan="2">Tanggal Cetak</td><td colspan="3">: ' . date('d/m/Y H:i') . '</td></tr>';
        echo '<tr><td colspan="5"></td></tr>';
        echo '</table>';

        echo '<table border="1" cellpadding="5" cellspacing="0">';
        echo '<thead><tr style="background:#6D4C41;color:white;">';
        echo '<th>No</th><th>Nama Alat</th><th>Kategori</th><th>Stok</th><th>Kondisi</th><th>Harga Sewa/Hari</th>';
        echo '</tr></thead><tbody>';

        if (empty($data['alat'])) {
            echo '<tr><td colspan="6" align="center">Tidak ada data</td></tr>';
        } else {
            $no = 1;
            foreach ($data['alat'] as $a) {
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . htmlspecialchars($a['nama_alat']) . '</td>';
                echo '<td>' . htmlspecialchars($a['nama_kategori']) . '</td>';
                echo '<td>' . $a['stok'] . ' unit</td>';
                echo '<td>' . ucfirst($a['kondisi']) . '</td>';
                echo '<td>Rp ' . number_format($a['harga_sewa'] ?? 0, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        }

        echo '</tbody></table></body></html>';
        exit;
    }

    private function exportExcelDenda($data) {
        $filename = 'laporan_denda_' . $data['dari'] . '_sd_' . $data['sampai'] . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $periode = date('d/m/Y', strtotime($data['dari'])) . ' s/d ' . date('d/m/Y', strtotime($data['sampai']));
        $dicetak = $_SESSION['user']['nama'] . ' (' . ucfirst($_SESSION['user']['role']) . ')';

        echo '<html><head><meta charset="UTF-8"></head><body>';
        echo '<table border="0">';
        echo '<tr><td colspan="7"><b>LAPORAN DENDA</b></td></tr>';
        echo '<tr><td colspan="7">Sistem Peminjaman Alat</td></tr>';
        echo '<tr><td colspan="7"></td></tr>';
        echo '<tr><td colspan="2">Periode</td><td colspan="5">: ' . $periode . '</td></tr>';
        echo '<tr><td colspan="2">Dicetak oleh</td><td colspan="5">: ' . $dicetak . '</td></tr>';
        echo '<tr><td colspan="2">Tanggal Cetak</td><td colspan="5">: ' . date('d/m/Y H:i') . '</td></tr>';
        echo '<tr><td colspan="7"></td></tr>';
        echo '</table>';

        echo '<table border="1" cellpadding="5" cellspacing="0">';
        echo '<thead><tr style="background:#6D4C41;color:white;">';
        echo '<th>No</th><th>Peminjam</th><th>Alat</th><th>Denda Telat</th><th>Denda Kerusakan</th><th>Total Denda</th><th>Status Bayar</th>';
        echo '</tr></thead><tbody>';

        $totalTelat     = 0;
        $totalKerusakan = 0;
        $totalSemua     = 0;

        if (empty($data['denda'])) {
            echo '<tr><td colspan="7" align="center">Tidak ada data denda</td></tr>';
        } else {
            $no = 1;
            foreach ($data['denda'] as $d) {
                $totalTelat     += $d['denda_telat'];
                $totalKerusakan += $d['denda_kerusakan'];
                $totalSemua     += $d['total_denda'];
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . htmlspecialchars($d['nama']) . '</td>';
                echo '<td>' . htmlspecialchars($d['nama_alat']) . '</td>';
                echo '<td>Rp ' . number_format($d['denda_telat'], 0, ',', '.') . '</td>';
                echo '<td>Rp ' . number_format($d['denda_kerusakan'], 0, ',', '.') . '</td>';
                echo '<td>Rp ' . number_format($d['total_denda'], 0, ',', '.') . '</td>';
                echo '<td>' . ucfirst(str_replace('_', ' ', $d['status_bayar'] ?? '-')) . '</td>';
                echo '</tr>';
            }
            echo '<tr style="font-weight:bold;background:#EFEBE9;">';
            echo '<td colspan="3" align="right">TOTAL:</td>';
            echo '<td>Rp ' . number_format($totalTelat, 0, ',', '.') . '</td>';
            echo '<td>Rp ' . number_format($totalKerusakan, 0, ',', '.') . '</td>';
            echo '<td>Rp ' . number_format($totalSemua, 0, ',', '.') . '</td>';
            echo '<td></td>';
            echo '</tr>';
        }

        echo '</tbody></table></body></html>';
        exit;
    }

}
