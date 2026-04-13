<?php

$baseDir = dirname(__DIR__, 2); // public

spl_autoload_register(function($class) use ($baseDir){

    if(file_exists($baseDir . "/app/core/".$class.".php")){
        require $baseDir . "/app/core/".$class.".php";
    }

    elseif(file_exists($baseDir . "/app/controllers/".$class.".php")){
        require $baseDir . "/app/controllers/".$class.".php";
    }

    elseif(file_exists($baseDir . "/app/models/".$class.".php")){
        require $baseDir . "/app/models/".$class.".php";
    }

});
