<?php
class PeminjamanController extends Controller {

    public function index()
    {
        session_start();

        if(!isset($_SESSION['user'])){
            header("Location:?url=auth");
            exit;
        }

        $role = $_SESSION['user']['role'];

        if($role=="peminjam"){
            $data['pinjam']=$this->model("Peminjaman")
            ->getByUser($_SESSION['user']['id']);
        }else{
            $data['pinjam']=$this->model("Peminjaman")
            ->getAll();
        }

        // semua role tetap dapat alat
        $data['alat']=$this->model("Alat")->getAll();

        $this->view("peminjaman/index",$data);
    }

    // ======================
    // PEMINJAM AJUKAN
    // ======================
    public function ajukan(){

        session_start();

        if($_SESSION['user']['role']!="peminjam"){
            die("akses ditolak");
        }

        // Upload bukti DP
        $buktiDP = null;
        if(isset($_FILES['bukti_dp']) && $_FILES['bukti_dp']['error'] == 0){
            $namaFile = $_FILES['bukti_dp']['name'];
            $tmp = $_FILES['bukti_dp']['tmp_name'];
            $folder = "../public/bukti/";

            if(!is_dir($folder)){
                mkdir($folder, 0777, true);
            }

            $buktiDP = time() . "_" . $namaFile;
            move_uploaded_file($tmp, $folder . $buktiDP);
        }

        // Hitung sisa bayar
        $totalHarga = (int)$_POST['total_harga'];
        $dp = (int)$_POST['dp'];
        $sisaBayar = $totalHarga - $dp;

        $this->model("Peminjaman")->insert([
            'user'=>$_SESSION['user']['id'],
            'alat'=>$_POST['alat'],
            'pinjam'=>$_POST['tgl_pinjam'],
            'kembali'=>$_POST['tgl_kembali'],
            'total_harga'=>$totalHarga,
            'dp'=>$dp,
            'bukti_dp'=>$buktiDP,
            'sisa_bayar'=>$sisaBayar
        ]);

        // Ambil nama alat
        $alat = $this->model("Alat")->getById($_POST['alat']);
        
        // Catat log
        LogHelper::catat('Ajukan Peminjaman', 'Mengajukan peminjaman alat: ' . $alat['nama_alat'] . ' (Total: Rp ' . number_format($totalHarga, 0, ',', '.') . ', DP: Rp ' . number_format($dp, 0, ',', '.') . ')');

        header("Location:?url=peminjaman");
    }

    // ======================
    // PETUGAS APPROVE
    // ======================
    public function approve($id)
    {
        session_start();

        if($_SESSION['user']['role']!="petugas"){
            die("akses ditolak");
        }

        // ambil data peminjaman
        $pinjam = $this->model("Peminjaman")->getById($id);

        // 🔥 ambil data alat
        $alat = $this->model("Alat")->getById($pinjam['id_alat']);

        // 🔴 CEK STOK DISINI
        if($alat['stok'] <= 0){
            die("stok habis");
        }

        // update status
        $this->model("Peminjaman")->updateStatus($id,"disetujui");

        // kurangi stok
        $this->model("Alat")->kurangiStok($pinjam['id_alat']);

        // Catat log
        LogHelper::catat('Approve Peminjaman', 'Menyetujui peminjaman alat: ' . $alat['nama_alat']);

        header("Location:?url=peminjaman");
    }

    // ======================
    // PETUGAS REJECT
    // ======================
    public function reject($id){

        session_start();

        if($_SESSION['user']['role']!="petugas"){
            die("akses ditolak");
        }

        // Ambil data peminjaman
        $pinjam = $this->model("Peminjaman")->getById($id);
        $alat = $this->model("Alat")->getById($pinjam['id_alat']);

        $this->model("Peminjaman")->reject($id);

        // Catat log
        LogHelper::catat('Reject Peminjaman', 'Menolak peminjaman alat: ' . $alat['nama_alat']);

        header("Location:?url=peminjaman");
    }

    // ======================
    // PEMINJAM AJUKAN KEMBALI
    // ======================
    public function ajukanKembali($id)
    {
        session_start();

        if($_SESSION['user']['role']!="peminjam"){
            die("akses ditolak");
        }

        $this->model("Peminjaman")->ajukanKembali($id);

        header("Location:?url=peminjaman");
    }

    // ==========================
    // PETUGAS KONFIRMASI KEMBALI
    // ==========================
    public function konfirmasiKembali()
    {
        session_start();

        if($_SESSION['user']['role']!="petugas"){
            die("akses ditolak");
        }

        $pinjam = $this->model("Peminjaman")
        ->getById($_POST['id']);

        if(!$pinjam['tgl_kembali']){
            die("tanggal kembali kosong");
        }

        // ========================
        // VALIDASI STATUS
        // ========================
        if($pinjam['status']!="menunggu_pengembalian"){
            die("status tidak valid");
        }

        // ========================
        // HITUNG DENDA TELAT (PER HARI)
        // ========================
        $tglHarusKembali = strtotime($pinjam['tgl_kembali']);
        $tglSekarang = strtotime(date('Y-m-d'));

        $hariTelat = 0;

        if($tglSekarang > $tglHarusKembali){
            $selisih = $tglSekarang - $tglHarusKembali;
            $hariTelat = floor($selisih / 86400);
        }

        $dendaTelat = $hariTelat * 10000;

        // ========================
        // DENDA KERUSAKAN
        // ========================
        $dendaKerusakan = 0;
        if(isset($_POST['denda_kerusakan']) && $_POST['denda_kerusakan'] !== ""){
            $dendaKerusakan = (int)$_POST['denda_kerusakan'];
        }

        // ========================
        // TOTAL DENDA
        // ========================
        $totalDenda = $dendaTelat + $dendaKerusakan;

        // ========================
        // PELUNASAN
        // ========================
        $pelunasan = (int)$_POST['pelunasan'];
        
        // Upload bukti pelunasan
        $buktiPelunasan = null;
        if(isset($_FILES['bukti_pelunasan']) && $_FILES['bukti_pelunasan']['error'] == 0){
            $namaFile = $_FILES['bukti_pelunasan']['name'];
            $tmp = $_FILES['bukti_pelunasan']['tmp_name'];
            $folder = "../public/bukti/";

            if(!is_dir($folder)){
                mkdir($folder, 0777, true);
            }

            $buktiPelunasan = time() . "_pelunasan_" . $namaFile;
            move_uploaded_file($tmp, $folder . $buktiPelunasan);
        }

        // Total yang harus dibayar = sisa bayar + denda
        $totalYangHarusDibayar = $pinjam['sisa_bayar'] + $totalDenda;

        // Status pembayaran
        $statusPembayaran = ($pelunasan >= $totalYangHarusDibayar) ? 'lunas' : 'dp_dibayar';
        $status = ($statusPembayaran == 'lunas') ? 'dikembalikan' : 'menunggu_pembayaran';
        $statusBayar = ($statusPembayaran == 'lunas') ? 'lunas' : 'belum_bayar';

        // ========================
        // UPDATE DATABASE
        // ========================
        $this->model("Peminjaman")->konfirmasiKembali([
            'id'=>$_POST['id'],
            'kerusakan'=>isset($_POST['kerusakan']) ? $_POST['kerusakan'] : null,
            'denda_telat'=>$dendaTelat,
            'denda_kerusakan'=>$dendaKerusakan,
            'total_denda'=>$totalDenda,
            'pelunasan'=>$pelunasan,
            'bukti_pelunasan'=>$buktiPelunasan,
            'status'=>$status,
            'status_bayar'=>$statusBayar,
            'status_pembayaran'=>$statusPembayaran
        ]);

        // ========================
        // STOK KEMBALI
        // ========================
        if($statusPembayaran == 'lunas'){
            // langsung kembali jika lunas
            $this->model("Alat")
            ->tambahStok($pinjam['id_alat']);
        }

        header("Location:?url=peminjaman");
    }

    public function bayarDenda()
    {
        session_start();

        if($_SESSION['user']['role']!="peminjam"){
            die("akses ditolak");
        }

        $id = $_POST['id'];

        // upload gambar
        $namaFile = $_FILES['bukti']['name'];
        $tmp = $_FILES['bukti']['tmp_name'];

        $folder = "../public/bukti/";

        if(!is_dir($folder)){
            mkdir($folder,0777,true);
        }

        $namaBaru = time()."_".$namaFile;

        move_uploaded_file($tmp,$folder.$namaBaru);

        // update status bayar
        $this->model("Peminjaman")->bayar([
            'id'=>$id,
            'bukti'=>$namaBaru
        ]);

        // ambil data alat
        $pinjam = $this->model("Peminjaman")->getById($id);

        // stok kembali setelah bayar
        $this->model("Alat")->tambahStok($pinjam['id_alat']);

        header("Location:?url=peminjaman");
    }

}
