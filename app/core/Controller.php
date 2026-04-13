<?php

class Controller {

    public function model($model){
        return new $model;
    }

    public function view($view,$data=[]){
        require __DIR__ . "/../views/templates/header.php";
        require __DIR__ . "/../views/".$view.".php";
        require __DIR__ . "/../views/templates/footer.php";
    }

}
