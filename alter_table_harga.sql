-- Tambah kolom harga_sewa di tabel alat
ALTER TABLE `alat` ADD `harga_sewa` INT(11) NOT NULL DEFAULT 0 AFTER `kondisi`;
