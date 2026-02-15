<?php

$url = $_GET['url'] ?? 'auth/index';
$url = explode('/', $url);

$controller = ucfirst($url[0])."Controller";
$method = $url[1] ?? 'index';

require "../app/controllers/$controller.php";

$object = new $controller;
$object->$method();
