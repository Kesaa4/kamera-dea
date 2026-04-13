<?php

class Flash {

    public static function set($pesan, $tipe = 'success') {
        if(session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = ['pesan' => $pesan, 'tipe' => $tipe];
    }

    public static function get() {
        if(session_status() === PHP_SESSION_NONE) session_start();
        if(isset($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

}
