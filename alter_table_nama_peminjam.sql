-- Tambah kolom nama_peminjam di tabel peminjaman
ALTER TABLE `peminjaman` ADD `nama_peminjam` VARCHAR(100) NULL AFTER `id_user`;
