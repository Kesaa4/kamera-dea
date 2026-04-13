<?php
require __DIR__ . "/../core/Controller.php";

class LogController extends Controller {

    public function index() {
        Middleware::auth();

        $isAdmin = $_SESSION['user']['role'] === 'admin';
        $logs = $isAdmin
            ? $this->model("Log")->getAll()
            : $this->model("Log")->getByUser($_SESSION['user']['id']);

        $this->view("log/index", ['logs' => $logs]);
    }

}
