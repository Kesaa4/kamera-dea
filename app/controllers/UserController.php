<?php
require __DIR__ . "/../core/Controller.php";

class UserController extends Controller {

    public function index() {
        Middleware::adminOnly();
        $this->view("user/index", ['users' => $this->model("User")->getAll()]);
    }

    public function tambah() {
        Middleware::adminOnly();
        $this->view("user/tambah");
    }

    public function simpan() {
        Middleware::adminOnly();

        if ($this->model("User")->getByEmail($_POST['email'])) {
            die("Email " . htmlspecialchars($_POST['email']) . " sudah terdaftar.");
        }

        $this->model("User")->insert([
            'nama'     => $_POST['nama'],
            'email'    => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role'     => $_POST['role'],
        ]);

        LogHelper::catat('Tambah User', 'Menambahkan user: ' . $_POST['nama'] . ' (' . $_POST['role'] . ')');
        header("Location:?url=user");
        exit;
    }

    public function edit($id) {
        Middleware::adminOnly();
        $this->view("user/edit", ['user' => $this->model("User")->getById($id)]);
    }

    public function update() {
        Middleware::adminOnly();

        $data = [
            'id'    => $_POST['id'],
            'nama'  => $_POST['nama'],
            'email' => $_POST['email'],
            'role'  => $_POST['role'],
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $this->model("User")->update($data);

        LogHelper::catat('Edit User', 'Mengubah data user: ' . $_POST['nama']);
        header("Location:?url=user");
        exit;
    }

    public function hapus($id) {
        Middleware::adminOnly();

        if ($id == $_SESSION['user']['id']) {
            die("Tidak bisa menghapus akun sendiri.");
        }

        $user = $this->model("User")->getById($id);
        $this->model("User")->delete($id);

        LogHelper::catat('Hapus User', 'Menghapus user: ' . $user['nama']);
        header("Location:?url=user");
        exit;
    }

}
