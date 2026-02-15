<?php
require_once "../app/config/config.php";

class Database {

    private $dbh;
    private $stmt;

    public function __construct(){

        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;

        try{
            $this->dbh = new PDO($dsn,DB_USER,DB_PASS);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    // query
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }

    // bind
    public function bind($param,$value){
        $this->stmt->bindValue(':'.$param,$value);
    }

    // execute
    public function execute(){
        return $this->stmt->execute();
    }

    // result set
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // single
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

}
