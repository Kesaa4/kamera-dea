<?php

class Controller {

    public function model($model){
        return new $model;
    }

    public function view($view,$data=[]){
        require "../app/views/templates/header.php";
        require "../app/views/".$view.".php";
        require "../app/views/templates/footer.php";
    }

}
