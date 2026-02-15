<?php
require "../app/core/Controller.php";

class UserController extends Controller {

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
    // LIST USER
    // ======================
    public function index()
    {
        $this->cekAdmin();

        $data['users'] = $this->model("User")->getAll();

        $this->view("user/index", $data);
    }

    // ======================
    // FORM TAMBAH
    // ======================
    public function tambah()
    {
        $this->cekAdmin();

        $this->view("user/tambah");
    }

    // ======================
    // SIMPAN USER
    // ======================
    public function simpan()
    {
        $this->cekAdmin();

        // Hash password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $this->model("User")->insert([
            'nama' => $_POST['nama'],
            'email' => $_POST['email'],
            'password' => $password,
            'role' => $_POST['role']
        ]);

        // Catat log
        LogHelper::catat('Tambah User', 'Menambahkan user: ' . $_POST['nama'] . ' (' . $_POST['role'] . ')');

        header("Location:?url=user");
    }

    // ======================
    // FORM EDIT
    // ======================
    public function edit($id)
    {
        $this->cekAdmin();

        $data['user'] = $this->model("User")->getById($id);

        $this->view("user/edit", $data);
    }

    // ======================
    // UPDATE USER
    // ======================
    public function update()
    {
        $this->cekAdmin();

        $data = [
            'id' => $_POST['id'],
            'nama' => $_POST['nama'],
            'email' => $_POST['email'],
            'role' => $_POST['role']
        ];

        // Jika password diisi, update password
        if(!empty($_POST['password'])){
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $this->model("User")->update($data);

        // Catat log
        LogHelper::catat('Edit User', 'Mengubah data user: ' . $_POST['nama']);

        header("Location:?url=user");
    }

    // ======================
    // HAPUS USER
    // ======================
    public function hapus($id)
    {
        $this->cekAdmin();

        // Ambil data user dulu
        $user = $this->model("User")->getById($id);

        // Cek jangan hapus diri sendiri
        if($id == $_SESSION['user']['id']){
            die("Tidak bisa menghapus akun sendiri!");
        }

        $this->model("User")->delete($id);

        // Catat log
        LogHelper::catat('Hapus User', 'Menghapus user: ' . $user['nama']);

        header("Location:?url=user");
    }

}
