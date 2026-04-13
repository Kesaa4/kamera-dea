<?php

class Alat {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("
            SELECT alat.*, kategori.nama_kategori
            FROM alat
            LEFT JOIN kategori ON alat.id_kategori = kategori.id
        ");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM alat WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getByKategori($id) {
        $this->db->query("SELECT * FROM alat WHERE id_kategori = :id");
        $this->db->bind('id', $id);
        return $this->db->resultSet();
    }

    public function insert($data) {
        $this->db->query("
            INSERT INTO alat (nama_alat, id_kategori, stok, kondisi, harga_sewa, foto)
            VALUES (:nama, :kategori, :stok, :kondisi, :harga_sewa, :foto)
        ");
        $this->db->bind('nama',      $data['nama']);
        $this->db->bind('kategori',  $data['kategori']);
        $this->db->bind('stok',      $data['stok']);
        $this->db->bind('kondisi',   $data['kondisi']);
        $this->db->bind('harga_sewa',$data['harga_sewa']);
        $this->db->bind('foto',      $data['foto'] ?? null);
        return $this->db->execute();
    }

    public function update($data) {
        $this->db->query("
            UPDATE alat SET
                nama_alat   = :nama,
                id_kategori = :kategori,
                stok        = :stok,
                kondisi     = :kondisi,
                harga_sewa  = :harga_sewa,
                foto        = :foto
            WHERE id = :id
        ");
        $this->db->bind('id',        $data['id']);
        $this->db->bind('nama',      $data['nama']);
        $this->db->bind('kategori',  $data['kategori']);
        $this->db->bind('stok',      $data['stok']);
        $this->db->bind('kondisi',   $data['kondisi']);
        $this->db->bind('harga_sewa',$data['harga_sewa']);
        $this->db->bind('foto',      $data['foto'] ?? null);
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM alat WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function sedangDipinjam($id) {
        $this->db->query("
            SELECT COUNT(*) AS total FROM peminjaman
            WHERE id_alat = :id
            AND status IN ('pending', 'disetujui', 'menunggu_pengembalian')
        ");
        $this->db->bind('id', $id);
        $result = $this->db->single();
        return $result['total'] > 0;
    }

    public function kurangiStok($id) {
        $this->db->query("UPDATE alat SET stok = stok - 1 WHERE id = :id AND stok > 0");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function tambahStok($id) {
        $this->db->query("UPDATE alat SET stok = stok + 1 WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

}
