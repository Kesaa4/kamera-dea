<?php
require "../app/core/Controller.php";

class DashboardController extends Controller {

    public function index(){

        Middleware::auth();

        $role = $_SESSION['user']['role'];

        if($role=="admin"){
            $this->view("dashboard/admin");
        }elseif($role=="petugas"){
            $this->view("dashboard/petugas");
        }else{
            $this->view("dashboard/peminjam");
        }

    }

}
