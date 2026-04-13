<?php
require __DIR__ . "/../core/Controller.php";

class PeminjamanController extends Controller {

    private function uploadBukti($fileKey, $folder = null) {
        $folder = $folder ?? __DIR__ . "/../../bukti/";
        if (!is_dir($folder)) mkdir($folder, 0777, true);

        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === 0) {
            $namaFile = time() . "_" . $_FILES[$fileKey]['name'];
            move_uploaded_file($_FILES[$fileKey]['tmp_name'], $folder . $namaFile);
            return $namaFile;
        }

        return null;
    }

    public function index() {
        Middleware::auth();

        $role = $_SESSION['user']['role'];
        $pinjam = ($role === 'peminjam')
            ? $this->model("Peminjaman")->getByUser($_SESSION['user']['id'])
            : $this->model("Peminjaman")->getAll();

        $this->view("peminjaman/index", [
            'pinjam' => $pinjam,
            'alat'   => $this->model("Alat")->getAll(),
        ]);
    }

    public function ajukan() {
        Middleware::peminjamOnly();

        $totalHarga = (int) $_POST['total_harga'];
        $buktiTf    = $this->uploadBukti('bukti_tf');

        $this->model("Peminjaman")->insert([
            'user'        => $_SESSION['user']['id'],
            'alat'        => $_POST['alat'],
            'pinjam'      => $_POST['tgl_pinjam'],
            'kembali'     => $_POST['tgl_kembali'],
            'total_harga' => $totalHarga,
            'bukti_tf'    => $buktiTf,
        ]);

        $alat = $this->model("Alat")->getById($_POST['alat']);
        LogHelper::catat('Ajukan Peminjaman', 'Mengajukan peminjaman alat: ' . $alat['nama_alat'] . ' (Total: Rp ' . number_format($totalHarga, 0, ',', '.') . ')');

        header("Location:?url=peminjaman");
        exit;
    }

    public function approve($id) {
        Middleware::petugasOnly();

        $pinjam = $this->model("Peminjaman")->getById($id);
        $alat   = $this->model("Alat")->getById($pinjam['id_alat']);

        if ($alat['stok'] <= 0) {
            die("Stok alat habis.");
        }

        $this->model("Peminjaman")->updateStatus($id, "disetujui");
        $this->model("Alat")->kurangiStok($pinjam['id_alat']);

        LogHelper::catat('Approve Peminjaman', 'Menyetujui peminjaman alat: ' . $alat['nama_alat']);
        header("Location:?url=peminjaman");
        exit;
    }

    public function reject() {
        Middleware::petugasOnly();

        $id     = $_POST['id'];
        $alasan = $_POST['alasan'] ?? '';

        $pinjam = $this->model("Peminjaman")->getById($id);
        $alat   = $this->model("Alat")->getById($pinjam['id_alat']);

        $this->model("Peminjaman")->reject($id, $alasan);

        LogHelper::catat('Reject Peminjaman', 'Menolak peminjaman alat: ' . $alat['nama_alat'] . ' - Alasan: ' . $alasan);
        header("Location:?url=peminjaman");
        exit;
    }

    public function ajukanKembali($id) {
        Middleware::peminjamOnly();
        $this->model("Peminjaman")->ajukanKembali($id);
        header("Location:?url=peminjaman");
        exit;
    }

    public function konfirmasiKembali() {
        Middleware::petugasOnly();

        $pinjam = $this->model("Peminjaman")->getById($_POST['id']);

        if (!$pinjam['tgl_kembali']) {
            die("Tanggal kembali kosong.");
        }

        if ($pinjam['status'] !== 'menunggu_pengembalian') {
            die("Status peminjaman tidak valid.");
        }

        // Hitung denda telat
        $tglHarusKembali = strtotime($pinjam['tgl_kembali']);
        $tglSekarang     = strtotime(date('Y-m-d'));
        $hariTelat       = max(0, floor(($tglSekarang - $tglHarusKembali) / 86400));
        $dendaTelat      = $hariTelat * 10000;

        // Denda kerusakan
        $dendaKerusakan = 0;
        if (isset($_POST['kondisi_alat']) && $_POST['kondisi_alat'] === 'rusak') {
            $dendaKerusakan = (int) ($_POST['denda_kerusakan'] ?? 0);
        }

        $totalDenda          = $dendaTelat + $dendaKerusakan;
        $pelunasan           = (int) $_POST['pelunasan'];
        $totalYangHarusDibayar = $pinjam['total_harga'] + $totalDenda;
        $lunas               = $pelunasan >= $totalYangHarusDibayar;

        $buktiPelunasan = $this->uploadBukti('bukti_pelunasan');

        $this->model("Peminjaman")->konfirmasiKembali([
            'id'               => $_POST['id'],
            'kerusakan'        => $_POST['kerusakan'] ?? null,
            'denda_telat'      => $dendaTelat,
            'denda_kerusakan'  => $dendaKerusakan,
            'total_denda'      => $totalDenda,
            'pelunasan'        => $pelunasan,
            'bukti_pelunasan'  => $buktiPelunasan,
            'status'           => $lunas ? 'dikembalikan' : 'menunggu_pembayaran',
            'status_bayar'     => $lunas ? 'lunas' : 'belum_bayar',
            'status_pembayaran'=> $lunas ? 'lunas' : 'dp_dibayar',
        ]);

        if ($lunas) {
            $this->model("Alat")->tambahStok($pinjam['id_alat']);
        }

        header("Location:?url=peminjaman");
        exit;
    }

    public function bayarDenda() {
        Middleware::peminjamOnly();

        $id     = $_POST['id'];
        $bukti  = $this->uploadBukti('bukti');

        $this->model("Peminjaman")->bayar(['id' => $id, 'bukti' => $bukti]);

        $pinjam = $this->model("Peminjaman")->getById($id);
        $this->model("Alat")->tambahStok($pinjam['id_alat']);

        header("Location:?url=peminjaman");
        exit;
    }

}
