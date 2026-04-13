<?php
require __DIR__ . "/../core/Controller.php";

class AlatController extends Controller {

    private function uploadFoto($fileKey) {
        if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== 0) {
            return null;
        }

        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $mime    = mime_content_type($_FILES[$fileKey]['tmp_name']);

        if (!in_array($mime, $allowed)) {
            die("Format foto tidak didukung. Gunakan JPG, PNG, atau WEBP.");
        }

        $folder = __DIR__ . "/../../uploads/alat/";
        if (!is_dir($folder)) mkdir($folder, 0777, true);

        $ext      = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
        $namaFile = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES[$fileKey]['tmp_name'], $folder . $namaFile);

        return $namaFile;
    }

    public function index() {
        Middleware::auth();

        $alat = $this->model("Alat")->getAll();
        foreach ($alat as &$a) {
            $a['sedang_dipinjam'] = $this->model("Alat")->sedangDipinjam($a['id']);
        }

        $this->view("alat/index", ['alat' => $alat]);
    }

    public function tambah() {
        Middleware::adminOnly();
        $this->view("alat/tambah", ['kategori' => $this->model("Kategori")->getAll()]);
    }

    public function simpan() {
        Middleware::adminOnly();

        $foto = $this->uploadFoto('foto');

        $this->model("Alat")->insert([
            'nama'      => $_POST['nama'],
            'stok'      => $_POST['stok'],
            'harga_sewa'=> $_POST['harga_sewa'],
            'kondisi'   => $_POST['kondisi'],
            'kategori'  => $_POST['kategori'],
            'foto'      => $foto,
        ]);

        LogHelper::catat('Tambah Alat', 'Menambahkan alat: ' . $_POST['nama']);
        header("Location:?url=alat");
        exit;
    }

    public function edit($id) {
        Middleware::adminOnly();

        $this->view("alat/edit", [
            'alat'     => $this->model("Alat")->getById($id),
            'kategori' => $this->model("Kategori")->getAll(),
        ]);
    }

    public function update() {
        Middleware::adminOnly();

        $alat = $this->model("Alat")->getById($_POST['id']);
        $foto = $alat['foto']; // pertahankan foto lama

        // Jika ada upload foto baru
        $fotoBaru = $this->uploadFoto('foto');
        if ($fotoBaru) {
            // Hapus foto lama jika ada
            if ($foto) {
                $pathLama = __DIR__ . "/../../uploads/alat/" . $foto;
                if (file_exists($pathLama)) unlink($pathLama);
            }
            $foto = $fotoBaru;
        }

        $this->model("Alat")->update([
            'id'        => $_POST['id'],
            'nama'      => $_POST['nama'],
            'stok'      => $_POST['stok'],
            'harga_sewa'=> $_POST['harga_sewa'],
            'kondisi'   => $_POST['kondisi'],
            'kategori'  => $_POST['kategori'],
            'foto'      => $foto,
        ]);

        LogHelper::catat('Edit Alat', 'Mengubah data alat: ' . $_POST['nama']);
        header("Location:?url=alat");
        exit;
    }

    public function hapus($id) {
        Middleware::adminOnly();

        if ($this->model("Alat")->sedangDipinjam($id)) {
            die("Alat ini sedang dalam proses peminjaman dan tidak bisa dihapus.");
        }

        $alat = $this->model("Alat")->getById($id);

        // Hapus foto jika ada
        if (!empty($alat['foto'])) {
            $path = __DIR__ . "/../../uploads/alat/" . $alat['foto'];
            if (file_exists($path)) unlink($path);
        }

        $this->model("Alat")->delete($id);

        LogHelper::catat('Hapus Alat', 'Menghapus alat: ' . $alat['nama_alat']);
        header("Location:?url=alat");
        exit;
    }

}
