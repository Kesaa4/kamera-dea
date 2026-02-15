<?php
require "../app/core/Controller.php";

class AlatController extends Controller {

    private function cekAdmin()
    {
        session_start();

        if(!isset($_SESSION['user'])){
            header("Location:?url=auth");
            exit;
        }

        if($_SESSION['user']['role']!='admin'){
            die("Akses ditolak");
        }
    }

    // ======================
    // LIST DATA ALAT
    // ======================
    public function index()
    {
        session_start();

        if(!isset($_SESSION['user'])){
            header("Location:?url=auth");
            exit;
        }

        $data['alat']=$this->model("Alat")->getAll();

        $this->view("alat/index",$data);
    }

    // ======================
    // FORM TAMBAH
    // ======================
    public function tambah()
    {
        $this->cekAdmin();

        $data['kategori']=$this->model("Kategori")->getAll();

        $this->view("alat/tambah",$data);
    }

    // ======================
    // SIMPAN DATA
    // ======================
    public function simpan()
    {
        $this->cekAdmin();

        $this->model("Alat")->insert([
            'nama'=>$_POST['nama'],
            'stok'=>$_POST['stok'],
            'harga_sewa'=>$_POST['harga_sewa'],
            'kondisi'=>$_POST['kondisi'],
            'kategori'=>$_POST['kategori']
        ]);

        // Catat log
        LogHelper::catat('Tambah Alat', 'Menambahkan alat: ' . $_POST['nama']);

        header("Location:?url=alat");
    }

    // ======================
    // FORM EDIT
    // ======================
    public function edit($id)
    {
        $this->cekAdmin();

        $data['alat']=$this->model("Alat")->getById($id);
        $data['kategori']=$this->model("Kategori")->getAll();

        $this->view("alat/edit",$data);
    }

    // ======================
    // UPDATE DATA
    // ======================
    public function update()
    {
        $this->cekAdmin();

        $this->model("Alat")->update([
            'id'=>$_POST['id'],
            'nama'=>$_POST['nama'],
            'stok'=>$_POST['stok'],
            'harga_sewa'=>$_POST['harga_sewa'],
            'kondisi'=>$_POST['kondisi'],
            'kategori'=>$_POST['kategori']
        ]);

        // Catat log
        LogHelper::catat('Edit Alat', 'Mengubah data alat: ' . $_POST['nama']);

        header("Location:?url=alat");
    }

    // ======================
    // HAPUS DATA
    // ======================
    public function hapus($id)
    {
        $this->cekAdmin();
        
        // Ambil nama alat dulu sebelum dihapus
        $alat = $this->model("Alat")->getById($id);
        
        $this->model("Alat")->delete($id);

        // Catat log
        LogHelper::catat('Hapus Alat', 'Menghapus alat: ' . $alat['nama_alat']);

        header("Location:?url=alat");
    }

}
