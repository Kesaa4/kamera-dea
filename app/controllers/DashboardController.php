<?php
require __DIR__ . "/../core/Controller.php";

class DashboardController extends Controller {

    public function index() {
        Middleware::auth();

        $views = [
            'admin'    => 'dashboard/admin',
            'petugas'  => 'dashboard/petugas',
            'peminjam' => 'dashboard/peminjam',
        ];

        $role = $_SESSION['user']['role'];
        $this->view($views[$role] ?? 'dashboard/peminjam');
    }

}
