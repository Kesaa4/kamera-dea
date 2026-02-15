<?php

class LogHelper {
    
    public static function catat($aktivitas, $keterangan = '') {
        if(!isset($_SESSION['user'])) {
            return false;
        }

        $db = new Database();
        
        $db->query("
        INSERT INTO log_aktivitas
        (id_user, nama_user, role, aktivitas, keterangan, created_at)
        VALUES
        (:id_user, :nama_user, :role, :aktivitas, :keterangan, NOW())
        ");

        $db->bind('id_user', $_SESSION['user']['id']);
        $db->bind('nama_user', $_SESSION['user']['nama']);
        $db->bind('role', $_SESSION['user']['role']);
        $db->bind('aktivitas', $aktivitas);
        $db->bind('keterangan', $keterangan);

        return $db->execute();
    }
}
