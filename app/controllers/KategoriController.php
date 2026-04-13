<?php
require __DIR__ . "/../core/Controller.php";

class KategoriController extends Controller {

    public function index() {
        Middleware::auth();
        $this->view("kategori/index", ['kategori' => $this->model("Kategori")->getAll()]);
    }

    public function detail($id) {
        $this->view("kategori/detail", [
            'kategori' => $this->model("Kategori")->getById($id),
            'alat'     => $this->model("Alat")->getByKategori($id),
        ]);
    }

    public function tambah() {
        Middleware::adminOnly();
        $this->view("kategori/tambah");
    }

    public function simpan() {
        Middleware::adminOnly();
        $this->model("Kategori")->insert($_POST);
        header("Location:?url=kategori");
        exit;
    }

    public function edit($id) {
        Middleware::adminOnly();
        $this->view("kategori/edit", ['kategori' => $this->model("Kategori")->getById($id)]);
    }

    public function update() {
        Middleware::adminOnly();
        $this->model("Kategori")->update($_POST);
        LogHelper::catat('Edit Kategori', 'Mengubah kategori: ' . $_POST['nama']);
        header("Location:?url=kategori");
        exit;
    }

    public function hapus($id) {
        Middleware::adminOnly();
        $this->model("Kategori")->delete($id);
        LogHelper::catat('Hapus Kategori', 'Menghapus kategori ID: ' . $id);
        header("Location:?url=kategori");
        exit;
    }

}
