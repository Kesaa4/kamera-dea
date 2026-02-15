<?php
require "../app/core/Controller.php";

class AuthController extends Controller {

    public function index(){
        $this->view("auth/login");
    }

    public function login()
    {
        session_start();

        $userModel = $this->model("User");
        $user = $userModel->login($_POST['email']);

        if($user && password_verify($_POST['password'],$user['password'])){

            $_SESSION['user']=$user;

            // Catat log login
            LogHelper::catat('Login', 'User berhasil login ke sistem');

            header("Location:?url=dashboard");
            exit;

        }else{
            echo "login gagal";
        }
    }

    public function logout(){
        session_start();
        
        // Catat log logout
        LogHelper::catat('Logout', 'User keluar dari sistem');
        
        session_destroy();
        header("Location: ?url=auth");
    }

}
