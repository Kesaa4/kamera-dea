<?php
require "../app/core/Controller.php";

class LogController extends Controller {

    // ======================
    // LIST LOG AKTIVITAS
    // ======================
    public function index()
    {
        session_start();

        if(!isset($_SESSION['user'])){
            header("Location:?url=auth");
            exit;
        }

        // Hanya admin yang bisa lihat semua log
        if($_SESSION['user']['role'] == 'admin'){
            $data['logs'] = $this->model("Log")->getAll();
        } else {
            // User lain hanya bisa lihat log mereka sendiri
            $data['logs'] = $this->model("Log")->getByUser($_SESSION['user']['id']);
        }

        $this->view("log/index", $data);
    }

}
