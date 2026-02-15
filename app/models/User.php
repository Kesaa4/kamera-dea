<?php

class User {

    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function login($email){

        $this->db->query("SELECT * FROM users WHERE email=:email");
        $this->db->bind('email',$email);

        return $this->db->single();
    }

    // =========================
    // GET ALL USERS
    // =========================
    public function getAll(){
        $this->db->query("SELECT * FROM users ORDER BY id DESC");
        return $this->db->resultSet();
    }

    // =========================
    // GET USER BY ID
    // =========================
    public function getById($id){
        $this->db->query("SELECT * FROM users WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // =========================
    // INSERT USER
    // =========================
    public function insert($data){
        $this->db->query("
        INSERT INTO users (nama, email, password, role)
        VALUES (:nama, :email, :password, :role)
        ");

        $this->db->bind('nama', $data['nama']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('role', $data['role']);

        return $this->db->execute();
    }

    // =========================
    // UPDATE USER
    // =========================
    public function update($data){
        if(isset($data['password'])){
            $this->db->query("
            UPDATE users SET
            nama=:nama,
            email=:email,
            password=:password,
            role=:role
            WHERE id=:id
            ");
            $this->db->bind('password', $data['password']);
        } else {
            $this->db->query("
            UPDATE users SET
            nama=:nama,
            email=:email,
            role=:role
            WHERE id=:id
            ");
        }

        $this->db->bind('id', $data['id']);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('role', $data['role']);

        return $this->db->execute();
    }

    // =========================
    // DELETE USER
    // =========================
    public function delete($id){
        $this->db->query("DELETE FROM users WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

}

