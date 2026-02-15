<?php
require "../app/core/Controller.php";

class LaporanController extends Controller {

    // ======================
    // HALAMAN LAPORAN
    // ======================
    public function index()
    {
        session_start();

        if(!isset($_SESSION['user'])){
            header("Location:?url=auth");
            exit;
        }

        // Hanya admin dan petugas yang bisa akses
        if($_SESSION['user']['role'] == 'peminjam'){
            die("Akses ditolak");
        }

        $this->view("laporan/index");
    }

    // ======================
    // CETAK LAPORAN PEMINJAMAN
    // ======================
    public function peminjaman()
    {
        session_start();

        if(!isset($_SESSION['user'])){
            header("Location:?url=auth");
            exit;
        }

        if($_SESSION['user']['role'] == 'peminjam'){
            die("Akses ditolak");
        }

        $tanggal_dari = $_GET['dari'] ?? date('Y-m-01');
        $tanggal_sampai = $_GET['sampai'] ?? date('Y-m-d');
        $status = $_GET['status'] ?? 'semua';

        $data['dari'] = $tanggal_dari;
        $data['sampai'] = $tanggal_sampai;
        $data['status'] = $status;
        $data['peminjaman'] = $this->model("Peminjaman")->getLaporan($tanggal_dari, $tanggal_sampai, $status);

        // Catat log
        LogHelper::catat('Cetak Laporan Peminjaman', 'Mencetak laporan periode ' . $tanggal_dari . ' s/d ' . $tanggal_sampai);

        $this->view("laporan/peminjaman", $data);
    }

    // ======================
    // CETAK LAPORAN ALAT
    // ======================
    public function alat()
    {
        session_start();

        if(!isset($_SESSION['user'])){
            header("Location:?url=auth");
            exit;
        }

        if($_SESSION['user']['role'] == 'peminjam'){
            die("Akses ditolak");
        }

        $data['alat'] = $this->model("Alat")->getAll();

        // Catat log
        LogHelper::catat('Cetak Laporan Alat', 'Mencetak laporan data alat');

        $this->view("laporan/alat", $data);
    }

    // ======================
    // CETAK LAPORAN DENDA
    // ======================
    public function denda()
    {
        session_start();

        if(!isset($_SESSION['user'])){
            header("Location:?url=auth");
            exit;
        }

        if($_SESSION['user']['role'] == 'peminjam'){
            die("Akses ditolak");
        }

        $tanggal_dari = $_GET['dari'] ?? date('Y-m-01');
        $tanggal_sampai = $_GET['sampai'] ?? date('Y-m-d');

        $data['dari'] = $tanggal_dari;
        $data['sampai'] = $tanggal_sampai;
        $data['denda'] = $this->model("Peminjaman")->getLaporanDenda($tanggal_dari, $tanggal_sampai);

        // Catat log
        LogHelper::catat('Cetak Laporan Denda', 'Mencetak laporan denda periode ' . $tanggal_dari . ' s/d ' . $tanggal_sampai);

        $this->view("laporan/denda", $data);
    }

}
