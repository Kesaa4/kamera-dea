<?php

class Kategori {

    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAll(){
        $this->db->query("SELECT * FROM kategori");
        return $this->db->resultSet();
    }

    public function getById($id){
        $this->db->query("SELECT * FROM kategori WHERE id=:id");
        $this->db->bind('id',$id);
        return $this->db->single();
    }

    public function insert($data){
        $this->db->query("
        INSERT INTO kategori VALUES('',:nama)
        ");

        $this->db->bind('nama',$data['nama']);
        return $this->db->execute();
    }

}
