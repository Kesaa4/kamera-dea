<?php

class Log {

    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // =========================
    // SIMPAN LOG AKTIVITAS
    // =========================
    public function insert($data){
        $this->db->query("
        INSERT INTO log_aktivitas
        (id_user, nama_user, role, aktivitas, keterangan, created_at)
        VALUES
        (:id_user, :nama_user, :role, :aktivitas, :keterangan, NOW())
        ");

        $this->db->bind('id_user', $data['id_user']);
        $this->db->bind('nama_user', $data['nama_user']);
        $this->db->bind('role', $data['role']);
        $this->db->bind('aktivitas', $data['aktivitas']);
        $this->db->bind('keterangan', $data['keterangan']);

        return $this->db->execute();
    }

    // =========================
    // AMBIL SEMUA LOG
    // =========================
    public function getAll(){
        $this->db->query("
        SELECT * FROM log_aktivitas
        ORDER BY created_at DESC
        ");

        return $this->db->resultSet();
    }

    // =========================
    // AMBIL LOG PER USER
    // =========================
    public function getByUser($id_user){
        $this->db->query("
        SELECT * FROM log_aktivitas
        WHERE id_user = :id_user
        ORDER BY created_at DESC
        ");

        $this->db->bind('id_user', $id_user);

        return $this->db->resultSet();
    }

    // =========================
    // HAPUS LOG LAMA (OPSIONAL)
    // =========================
    public function deleteOld($days = 30){
        $this->db->query("
        DELETE FROM log_aktivitas
        WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)
        ");

        $this->db->bind('days', $days);

        return $this->db->execute();
    }

}
