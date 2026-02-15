<?php

class Alat {

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll()
    {
        $this->db->query("SELECT alat.*, kategori.nama_kategori 
                          FROM alat 
                          LEFT JOIN kategori 
                          ON alat.id_kategori = kategori.id");
        return $this->db->resultSet();
    }

    public function getByKategori($id)
    {
        $this->db->query("
            SELECT * FROM alat
            WHERE id_kategori=:id
        ");

        $this->db->bind('id',$id);
        return $this->db->resultSet();
    }

    public function insert($data)
    {
        $this->db->query("INSERT INTO alat 
                         (nama_alat, id_kategori, stok, kondisi, harga_sewa)
                         VALUES(:nama, :kategori, :stok, :kondisi, :harga_sewa)");

        $this->db->bind('nama',$data['nama']);
        $this->db->bind('kategori',$data['kategori']);
        $this->db->bind('stok',$data['stok']);
        $this->db->bind('kondisi',$data['kondisi']);
        $this->db->bind('harga_sewa',$data['harga_sewa']);

        return $this->db->execute();
    }

    public function getById($id)
    {
        $this->db->query("SELECT * FROM alat WHERE id=:id");
        $this->db->bind('id',$id);
        return $this->db->single();
    }

    public function update($data)
    {
        $this->db->query("UPDATE alat SET
            nama_alat=:nama,
            id_kategori=:kategori,
            stok=:stok,
            kondisi=:kondisi,
            harga_sewa=:harga_sewa
            WHERE id=:id");

        $this->db->bind('id',$data['id']);
        $this->db->bind('nama',$data['nama']);
        $this->db->bind('kategori',$data['kategori']);
        $this->db->bind('stok',$data['stok']);
        $this->db->bind('kondisi',$data['kondisi']);
        $this->db->bind('harga_sewa',$data['harga_sewa']);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM alat WHERE id=:id");
        $this->db->bind('id',$id);
        return $this->db->execute();
    }

    // kurangi stok
    public function kurangiStok($id){
        $this->db->query("UPDATE alat SET stok = stok - 1 WHERE id=:id AND stok > 0");
        $this->db->bind('id',$id);
        return $this->db->execute();
    }

    // tambah stok
    public function tambahStok($id){
        $this->db->query("UPDATE alat SET stok = stok + 1 WHERE id=:id");
        $this->db->bind('id',$id);
        return $this->db->execute();
    }


}
