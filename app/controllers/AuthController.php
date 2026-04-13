<?php
require __DIR__ . "/../core/Controller.php";

class AuthController extends Controller {

    public function index() {
        $this->view("auth/login");
    }

    public function login() {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $this->view("auth/login", ['error' => 'Email dan password harus diisi']);
            return;
        }

        $user = $this->model("User")->login($_POST['email']);

        if (!$user) {
            $this->view("auth/login", ['error' => 'Email tidak ditemukan']);
            return;
        }

        if (!password_verify($_POST['password'], $user['password'])) {
            $this->view("auth/login", ['error' => 'Password salah']);
            return;
        }

        $_SESSION['user'] = $user;
        LogHelper::catat('Login', 'User berhasil login ke sistem');

        header("Location:?url=dashboard");
        exit;
    }

    public function logout() {
        LogHelper::catat('Logout', 'User keluar dari sistem');
        session_destroy();
        header("Location:?url=auth");
        exit;
    }

}
