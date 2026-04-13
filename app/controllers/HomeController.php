<?php
require __DIR__ . "/../core/Controller.php";

class HomeController extends Controller {

    public function index() {
        $this->view('home');
    }

}
