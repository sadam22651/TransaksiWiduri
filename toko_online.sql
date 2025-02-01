-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 16 Jan 2025 pada 13.49
-- Versi server: 8.0.30
-- Versi PHP: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_online`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `id_material` int NOT NULL,
  `harga_modal` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga`, `stok`, `id_material`, `harga_modal`) VALUES
(4, 'rantai medan 3,5', 122500, 16, 1, 38500),
(5, 'cincin onic 2', 70000, 20, 1, 22000),
(6, 'rantai medan 4', 140000, 30, 1, 44000),
(7, 'cincin anak anak kupu kupu 1', 35000, 27, 1, 11000),
(8, 'cincin anak polos 1', 35000, 30, 1, 11000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'sadam', 'sadam227', '2025-01-12 00:51:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `material`
--

CREATE TABLE `material` (
  `id_material` int NOT NULL,
  `material_name` varchar(50) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `material`
--

INSERT INTO `material` (`id_material`, `material_name`, `description`) VALUES
(1, 'Perak', 'Logam mulia dengan warna putih mengkilap.'),
(2, 'Kuningan', 'Logam campuran berwarna kuning keemasan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerja`
--

CREATE TABLE `pekerja` (
  `id_pekerja` int NOT NULL,
  `nama_pekerja` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pekerja`
--

INSERT INTO `pekerja` (`id_pekerja`, `nama_pekerja`, `alamat`) VALUES
(1, 'John Doe', 'Jl. Sudirman No. 10'),
(2, 'sadam', 'kubang bungkuak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `id_pekerja` int NOT NULL,
  `id_barang` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal` date DEFAULT NULL,
  `harga_total` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `nama_pelanggan`, `id_pekerja`, `id_barang`, `jumlah`, `tanggal`, `harga_total`) VALUES
(12, 'khodijah', 1, 4, 3, '2025-01-15', 367500),
(13, 'sadam', 1, 4, 3, '2025-01-01', 367500),
(14, 'khodijah', 1, 7, 3, '2025-01-15', 105000);

--
-- Trigger `transaksi`
--
DELIMITER $$
CREATE TRIGGER `hitung_harga_total_insert` BEFORE INSERT ON `transaksi` FOR EACH ROW BEGIN
    DECLARE harga_barang INT;

    -- Ambil harga dari tabel barang
    SELECT harga INTO harga_barang
    FROM barang
    WHERE id_barang = NEW.id_barang;

    -- Hitung harga_total
    SET NEW.harga_total = NEW.jumlah * harga_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hitung_harga_total_update` BEFORE UPDATE ON `transaksi` FOR EACH ROW BEGIN
    DECLARE harga_barang INT;

    -- Ambil harga dari tabel barang
    SELECT harga INTO harga_barang
    FROM barang
    WHERE id_barang = NEW.id_barang;

    -- Hitung harga_total
    SET NEW.harga_total = NEW.jumlah * harga_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kembalikan_stok_delete` AFTER DELETE ON `transaksi` FOR EACH ROW BEGIN
    -- Kembalikan stok barang
    UPDATE barang
    SET stok = stok + OLD.jumlah
    WHERE id_barang = OLD.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kurangi_stok_insert` BEFORE INSERT ON `transaksi` FOR EACH ROW BEGIN
    DECLARE stok_barang INT;

    -- Ambil stok barang dari tabel barang
    SELECT stok INTO stok_barang
    FROM barang
    WHERE id_barang = NEW.id_barang;

    -- Validasi apakah stok mencukupi
    IF stok_barang < NEW.jumlah THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Stok tidak mencukupi untuk transaksi ini';
    END IF;

    -- Kurangi stok
    UPDATE barang
    SET stok = stok - NEW.jumlah
    WHERE id_barang = NEW.id_barang;

    -- Hitung total harga
    SET NEW.harga_total = NEW.jumlah * (SELECT harga FROM barang WHERE id_barang = NEW.id_barang);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sesuaikan_stok_update` BEFORE UPDATE ON `transaksi` FOR EACH ROW BEGIN
    DECLARE stok_barang INT;

    -- Ambil stok barang dari tabel barang
    SELECT stok INTO stok_barang
    FROM barang
    WHERE id_barang = NEW.id_barang;

    -- Validasi stok mencukupi untuk perubahan
    IF stok_barang + OLD.jumlah < NEW.jumlah THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Stok tidak mencukupi untuk pembaruan transaksi ini';
    END IF;

    -- Sesuaikan stok
    UPDATE barang
    SET stok = stok + OLD.jumlah - NEW.jumlah
    WHERE id_barang = NEW.id_barang;

    -- Hitung total harga baru
    SET NEW.harga_total = NEW.jumlah * (SELECT harga FROM barang WHERE id_barang = NEW.id_barang);
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `fk_barang_material` (`id_material`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id_material`);

--
-- Indeks untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  ADD PRIMARY KEY (`id_pekerja`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_id_barang` (`id_barang`),
  ADD KEY `fk_pekerja` (`id_pekerja`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `material`
--
ALTER TABLE `material`
  MODIFY `id_material` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  MODIFY `id_pekerja` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_barang_material` FOREIGN KEY (`id_material`) REFERENCES `material` (`id_material`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_id_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pekerja` FOREIGN KEY (`id_pekerja`) REFERENCES `pekerja` (`id_pekerja`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
