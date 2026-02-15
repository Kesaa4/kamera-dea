<?php
require "../app/core/Controller.php";

class KategoriController extends Controller {

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
    // LIST KATEGORI
    // ======================
    public function index()
    {
        session_start();

        if(!isset($_SESSION['user'])){
            header("Location:?url=auth");
            exit;
        }

        $data['kategori']=$this->model("Kategori")->getAll();

        $this->view("kategori/index",$data);
    }

    // ======================
    // LIHAT ALAT PER KATEGORI
    // ======================
    public function detail($id)
    {
        $data['kategori']=$this->model("Kategori")->getById($id);
        $data['alat']=$this->model("Alat")->getByKategori($id);

        $this->view("kategori/detail",$data);
    }

    // ======================
    // FORM TAMBAH
    // ======================
    public function tambah()
    {
        $this->cekAdmin();
        $this->view("kategori/tambah");
    }

    // ======================
    // SIMPAN
    // ======================
    public function simpan()
    {
        $this->cekAdmin();

        $this->model("Kategori")->insert($_POST);

        header("Location:?url=kategori");
    }

}
