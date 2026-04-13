<?php

class Peminjaman {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("
            SELECT p.*, u.nama, a.nama_alat
            FROM peminjaman p
            JOIN users u ON p.id_user = u.id
            JOIN alat a ON p.id_alat = a.id
            ORDER BY p.id DESC
        ");
        return $this->db->resultSet();
    }

    public function getByUser($id) {
        $this->db->query("
            SELECT p.*, u.nama, a.nama_alat
            FROM peminjaman p
            JOIN users u ON p.id_user = u.id
            JOIN alat a ON p.id_alat = a.id
            WHERE p.id_user = :id
            ORDER BY p.id DESC
        ");
        $this->db->bind('id', $id);
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM peminjaman WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function insert($data) {
        $this->db->query("
            INSERT INTO peminjaman (id_user, id_alat, tgl_pinjam, tgl_kembali, total_harga, bukti_tf, status, created_at)
            VALUES (:user, :alat, :pinjam, :kembali, :total_harga, :bukti_tf, 'pending', NOW())
        ");
        $this->db->bind('user',        $data['user']);
        $this->db->bind('alat',        $data['alat']);
        $this->db->bind('pinjam',      $data['pinjam']);
        $this->db->bind('kembali',     $data['kembali']);
        $this->db->bind('total_harga', $data['total_harga']);
        $this->db->bind('bukti_tf',    $data['bukti_tf']);
        return $this->db->execute();
    }

    public function updateStatus($id, $status) {
        $this->db->query("UPDATE peminjaman SET status = :status WHERE id = :id");
        $this->db->bind('id',     $id);
        $this->db->bind('status', $status);
        return $this->db->execute();
    }

    public function reject($id, $alasan = '') {
        $this->db->query("UPDATE peminjaman SET status = 'ditolak', alasan_tolak = :alasan WHERE id = :id");
        $this->db->bind('id',     $id);
        $this->db->bind('alasan', $alasan);
        return $this->db->execute();
    }

    public function ajukanKembali($id) {
        $this->db->query("UPDATE peminjaman SET status = 'menunggu_pengembalian' WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function konfirmasiKembali($data) {
        $this->db->query("
            UPDATE peminjaman SET
                status            = :status,
                kerusakan         = :kerusakan,
                denda_telat       = :denda_telat,
                denda_kerusakan   = :denda_kerusakan,
                total_denda       = :total_denda,
                pelunasan         = :pelunasan,
                bukti_pelunasan   = :bukti_pelunasan,
                status_pembayaran = :status_pembayaran,
                status_bayar      = :status_bayar
            WHERE id = :id
        ");
        $this->db->bind('id',               $data['id']);
        $this->db->bind('status',           $data['status']);
        $this->db->bind('kerusakan',        $data['kerusakan']);
        $this->db->bind('denda_telat',      $data['denda_telat']);
        $this->db->bind('denda_kerusakan',  $data['denda_kerusakan']);
        $this->db->bind('total_denda',      $data['total_denda']);
        $this->db->bind('pelunasan',        $data['pelunasan']);
        $this->db->bind('bukti_pelunasan',  $data['bukti_pelunasan']);
        $this->db->bind('status_pembayaran',$data['status_pembayaran']);
        $this->db->bind('status_bayar',     $data['status_bayar']);
        return $this->db->execute();
    }

    public function bayar($data) {
        $this->db->query("
            UPDATE peminjaman SET
                status     = 'dikembalikan',
                status_bayar = 'lunas',
                bukti_bayar  = :bukti
            WHERE id = :id
        ");
        $this->db->bind('id',    $data['id']);
        $this->db->bind('bukti', $data['bukti']);
        return $this->db->execute();
    }

    public function getLaporan($dari, $sampai, $status = 'semua') {
        $sql = "
            SELECT p.*, u.nama, a.nama_alat
            FROM peminjaman p
            JOIN users u ON p.id_user = u.id
            JOIN alat a ON p.id_alat = a.id
            WHERE DATE(p.created_at) BETWEEN :dari AND :sampai
        ";

        if ($status !== 'semua') {
            $sql .= " AND p.status = :status";
        }

        $sql .= " ORDER BY p.created_at DESC";

        $this->db->query($sql);
        $this->db->bind('dari',   $dari);
        $this->db->bind('sampai', $sampai);

        if ($status !== 'semua') {
            $this->db->bind('status', $status);
        }

        return $this->db->resultSet();
    }

    public function getLaporanDenda($dari, $sampai) {
        $this->db->query("
            SELECT p.*, u.nama, a.nama_alat
            FROM peminjaman p
            JOIN users u ON p.id_user = u.id
            JOIN alat a ON p.id_alat = a.id
            WHERE DATE(p.created_at) BETWEEN :dari AND :sampai
            AND p.total_denda > 0
            ORDER BY p.created_at DESC
        ");
        $this->db->bind('dari',   $dari);
        $this->db->bind('sampai', $sampai);
        return $this->db->resultSet();
    }

}
