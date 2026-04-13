<?php

class Middleware {

    public static function auth() {
        if (!isset($_SESSION['user'])) {
            header("Location:?url=auth");
            exit;
        }
    }

    public static function adminOnly() {
        self::auth();
        if ($_SESSION['user']['role'] !== 'admin') {
            self::aksesDitolak();
        }
    }

    public static function petugasOnly() {
        self::auth();
        if ($_SESSION['user']['role'] !== 'petugas') {
            self::aksesDitolak();
        }
    }

    public static function peminjamOnly() {
        self::auth();
        if ($_SESSION['user']['role'] !== 'peminjam') {
            self::aksesDitolak();
        }
    }

    public static function bukanPeminjam() {
        self::auth();
        if ($_SESSION['user']['role'] === 'peminjam') {
            self::aksesDitolak();
        }
    }

    private static function aksesDitolak() {
        http_response_code(403);
        die("Akses ditolak.");
    }

}
