-- Tambah kolom total_harga di tabel peminjaman
ALTER TABLE `peminjaman` ADD `total_harga` INT(11) NOT NULL DEFAULT 0 AFTER `tgl_kembali`;
