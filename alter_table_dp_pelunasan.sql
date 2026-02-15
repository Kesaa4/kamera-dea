-- Tambah kolom untuk DP dan pelunasan
ALTER TABLE `peminjaman` ADD `dp` INT(11) NOT NULL DEFAULT 0 AFTER `total_harga`;
ALTER TABLE `peminjaman` ADD `bukti_dp` VARCHAR(255) NULL AFTER `dp`;
ALTER TABLE `peminjaman` ADD `sisa_bayar` INT(11) NOT NULL DEFAULT 0 AFTER `bukti_dp`;
ALTER TABLE `peminjaman` ADD `pelunasan` INT(11) NOT NULL DEFAULT 0 AFTER `sisa_bayar`;
ALTER TABLE `peminjaman` ADD `bukti_pelunasan` VARCHAR(255) NULL AFTER `pelunasan`;
ALTER TABLE `peminjaman` ADD `status_pembayaran` ENUM('belum_dp','dp_dibayar','lunas') NOT NULL DEFAULT 'belum_dp' AFTER `bukti_pelunasan`;
