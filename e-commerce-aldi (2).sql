-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 22 Jan 2025 pada 11.24
-- Versi server: 5.7.39
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-commerce-aldi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar_produk`
--

CREATE TABLE `gambar_produk` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Tandai gambar utama'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `gambar_produk`
--

INSERT INTO `gambar_produk` (`id`, `product_id`, `image`, `is_primary`) VALUES
(4, 3, '1728405317_7ea11a3784b1a2f8c7fc.jpg', 1),
(5, 4, '1728405526_13ff33db22b0a330d3b5.jpg', 1),
(6, 5, '1728405649_ff24df0e5aec846406a1.jpg', 1),
(20, 7, '1733061431_b344395c64b5ef3e657e.webp', 1),
(21, 7, '1733061431_5c037d1c105de2fe8092.webp', 0),
(23, 7, '1733062099_2ec40e5ba5358237e4dd.webp', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `name`, `description`) VALUES
(17, 'Fashion Wanita Muslim', 'fashion wanita muslim'),
(20, 'Fashion Anak', 'fashion untuk anak anak\r\n'),
(22, 'Fashion Pria', 'Fashion Pria');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_variant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id`, `user_id`, `product_variant_id`, `quantity`, `price`) VALUES
(1, 1, 7, 1, ' 37500');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(16, '2024-10-02-043850', 'App\\Database\\Migrations\\User', 'default', 'App', 1727850722, 1),
(17, '2024-10-02-044015', 'App\\Database\\Migrations\\Kategori', 'default', 'App', 1727850722, 1),
(18, '2024-10-02-044100', 'App\\Database\\Migrations\\Produk', 'default', 'App', 1727850722, 1),
(19, '2024-10-02-044210', 'App\\Database\\Migrations\\ProdukVarian', 'default', 'App', 1727850722, 1),
(20, '2024-10-02-044356', 'App\\Database\\Migrations\\Order', 'default', 'App', 1727850722, 1),
(21, '2024-10-02-044513', 'App\\Database\\Migrations\\OrderItem', 'default', 'App', 1727850722, 1),
(22, '2024-10-02-044658', 'App\\Database\\Migrations\\Pembayaran', 'default', 'App', 1727850722, 1),
(23, '2024-10-02-045844', 'App\\Database\\Migrations\\GambarProduk', 'default', 'App', 1727850722, 1),
(24, '2024-10-02-050419', 'App\\Database\\Migrations\\Keranjang', 'default', 'App', 1727850722, 1),
(25, '2024-10-02-050742', 'App\\Database\\Migrations\\Review', 'default', 'App', 1727850722, 1),
(26, '2024-10-02-061254', 'App\\Database\\Migrations\\Diskon', 'default', 'App', 1727850722, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `no_order` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `status` enum('pending','paid','shipped','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) NOT NULL,
  `shipping_address` text NOT NULL,
  `expedisi` varchar(255) NOT NULL,
  `estimasi` varchar(255) NOT NULL,
  `resi` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `order`
--

INSERT INTO `order` (`id`, `user_id`, `order_date`, `no_order`, `total`, `status`, `payment_method`, `shipping_address`, `expedisi`, `estimasi`, `resi`, `cost`) VALUES
(1, 2, '2024-12-31 20:29:07', 'INV-202412-4ffc', '123100', 'completed', 'Transfer Bank', 'Bali aja, Buleleng, 32112, Badung, Bali', 'jne', 'REG | 4-6 Hari', '12345', '34000'),
(2, 2, '2024-12-31 20:33:59', 'INV-202412-5e8a', '147000', 'cancelled', 'Transfer Bank', 'bandung, Bandung, 4321, Bandung, Jawa Barat', 'jne', 'YES | 1-1 Hari', '', '22000'),
(3, 2, '2025-01-01 00:36:51', 'INV-202501-d79b', '143000', 'pending', 'Transfer Bank', 'Jl Ciawilor, RT/RW 01/01 CIAWILOR, CIAWIGEBANG, KUNINGAN, JAWA BARAT, 45591', 'jne', 'CTC | 1 day', '', '8000'),
(4, 2, '2025-01-01 13:17:48', 'INV-202501-1584', '107000', 'pending', 'Transfer Bank', 'Jl Ciawilor, RT/RW 01/01 CIAWILOR, CIAWIGEBANG, KUNINGAN, JAWA BARAT, 45591', 'jne', 'CTC | 1 day', '', '8000'),
(8, 14, '2025-01-06 00:00:00', 'INV-202501-ef8c', '125000', 'completed', 'cash', '', '', '', '', '0'),
(9, 15, '2025-01-05 00:00:00', 'INV-202501-6db3', '188100', 'completed', 'cash', '', '', '', '', '0'),
(10, 2, '2025-01-12 16:28:41', 'INV-202501-fef6', '87800', 'pending', 'Transfer Bank', 'Jl Ciawilor, RT/RW 01/01 CIAWILOR, CIAWIGEBANG, KUNINGAN, JAWA BARAT, 45591', 'jne', 'CTC | 1 day', '', '8000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_variant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_variant_id`, `quantity`, `price`) VALUES
(2, 2, 7, 1, ' 125000 '),
(3, 3, 29, 1, ' 135000 '),
(6, 8, 7, 1, '125000'),
(9, 10, 124, 1, ' 79800');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `bukti_transfer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `order_id`, `payment_date`, `payment_method`, `payment_status`, `bukti_transfer`) VALUES
(1, 1, '2024-12-31 13:30:16', 'Transfer Bank', 'completed', '1735651816_9de814806e3b8c876795.webp'),
(5, 8, '2025-01-06 00:00:00', 'cash', 'completed', ''),
(6, 9, '2025-01-05 00:00:00', 'cash', 'completed', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `name`, `description`, `category_id`) VALUES
(3, 'Gamis Shakila Brukat', 'Gamis Shakila Brukat - Kenyamanan dan Gaya dalam Satu Paket\r\nIngin tampil fashionable tanpa mengorbankan kenyamanan? Atasan katun premium ini adalah jawabannya! Dengan bahan katun yang lembut dan adem, kamu akan merasa nyaman sepanjang hari.\r\n\r\nDesainnya yang unik dan modern membuat kamu terlihat lebih stylish. Kombinasi warna hitam dan putih yang klasik serta aksen garis-garis yang trendi membuat atasan ini cocok dipadukan dengan berbagai jenis bawahan.\r\n\r\nKenapa harus pilih produk ini?\r\n\r\nBahan katun premium yang berkualitas tinggi\r\nDesain yang unik dan modern\r\nPotongan oversize yang nyaman\r\nMultifungsi, cocok untuk berbagai acara', 17),
(4, 'Atasan Katun Premium', 'Atasan Katun Premium - Elegan dan Nyaman\r\nBosan dengan atasan yang itu-itu saja? Coba atasan katun premium ini! Desain modern dengan perpaduan warna hitam dan putih yang kontras serta aksen garis-garis memberikan kesan yang unik dan stylish.\r\n\r\nTerbuat dari bahan katun berkualitas tinggi, atasan ini sangat nyaman digunakan sehari-hari. Potongannya yang oversize memberikan ruang gerak yang bebas, sementara lengan panjangnya memberikan perlindungan ekstra.\r\n\r\nFitur:\r\n\r\nBahan: Katun premium, lembut di kulit dan menyerap keringat.\r\nDesain: Kombinasi warna hitam dan putih yang klasik, aksen garis-garis yang modern, dan potongan oversize yang trendi.\r\nDetail: Kancing depan memudahkan saat memakai dan melepas, saku patch yang fungsional untuk menyimpan barang-barang kecil.\r\nKesempatan: Cocok untuk berbagai acara, mulai dari hangout bersama teman hingga acara semi-formal.', 17),
(5, 'Gamis Linen Brukat', 'Gamis Linen Brukat - Elegan dan Nyaman\r\nBosan dengan atasan yang itu-itu saja? Coba atasan katun premium ini! Desain modern dengan perpaduan warna hitam dan putih yang kontras serta aksen garis-garis memberikan kesan yang unik dan stylish.\r\n\r\nTerbuat dari bahan katun berkualitas tinggi, atasan ini sangat nyaman digunakan sehari-hari. Potongannya yang oversize memberikan ruang gerak yang bebas, sementara lengan panjangnya memberikan perlindungan ekstra.\r\n\r\nFitur:\r\n\r\nBahan: Katun premium, lembut di kulit dan menyerap keringat.\r\nDesain: Kombinasi warna hitam dan putih yang klasik, aksen garis-garis yang modern, dan potongan oversize yang trendi.\r\nDetail: Kancing depan memudahkan saat memakai dan melepas, saku patch yang fungsional untuk menyimpan barang-barang kecil.\r\nKesempatan: Cocok untuk berbagai acara, mulai dari hangout bersama teman hingga acara semi-formal.', 17),
(7, 'Gamis Emma', 'Emma Dress \r\n\r\nAll Size S fit L (BB 40-70kg)\r\nMotif brukat random, sesuai persediaan yang ada\r\nGamis Elegan Kondangan Muslim Mewah Shakila Kombinasi Brokat Cantik Wanita Nyaman S fit L Busui Wudhu Friendly Lengan Manset Karet Tali Pinggang\r\nKeunggulan produk:\r\n• Elegan dan mewah dengan kombinasi brokat cantik \r\n• Nyaman dan adem dipakai \r\n• Busui friendly dan wudhu friendly \r\n• Lengan manset karet dan tali pinggang untuk menyesuaikan ukuran badan\r\nDeskripsi produk:\r\ngamis elegan dan mewah yang cocok untuk menghadiri acara kondangan atau acara formal lainnya. Gamis ini terbuat dari bahan shakila premium yang nyaman dan adem dipakai. Bagian depan gamis terdapat kombinasi brokat cantik yang membuat gamis ini terlihat lebih elegan dan mewah. Gamis ini juga memiliki desain busui friendly dan wudhu friendly, sehingga memudahkan Anda untuk beraktivitas. Lengan gamis ini memiliki model manset karet dan tali pinggang untuk menyesuaikan ukuran badan.\r\nUkuran:\r\n• S fit L\r\nCara perawatan:\r\n• Cuci dengan tangan atau mesin \r\n• Jangan gunakan pemutih \r\n• Jemur di tempat teduh\r\nCatatan:\r\n• Warna produk yang sebenarnya mungkin berbeda dengan foto karena faktor pencahayaan dan pengaturan layar Anda.\r\nYuk, tampil elegan dan mewah di acara kondangan Anda dengan Emma Dress!', 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_varian`
--

CREATE TABLE `produk_varian` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `price` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk_varian`
--

INSERT INTO `produk_varian` (`id`, `product_id`, `size`, `color`, `price`, `stock`, `discount`, `promotion_id`) VALUES
(5, 3, 'M', 'Hitam', '185000', 8, 0, 0),
(6, 3, 'L', 'Hitam', '185000', 10, 0, 0),
(7, 4, 'M', 'Hitam', '125000', 9, 0, 0),
(8, 4, 'L', 'Hitam', '125000', 10, 0, 0),
(29, 5, 'M', 'Hitam', '135000', 10, 0, 0),
(30, 5, 'L', 'Hitam', '135000', 7, 0, 0),
(124, 7, 'M', 'Sage', '399000', 10, 0, 0),
(125, 7, 'M', 'Hitam', '99000', 8, 0, 0),
(126, 7, 'M', 'Biru', '99000', 9, 0, 0),
(127, 7, 'L', 'Sage', '119000', 10, 0, 0),
(128, 7, 'L', 'Hitam', '119000', 10, 0, 0),
(129, 7, 'L', 'Biru', '119000', 10, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `promosi`
--

CREATE TABLE `promosi` (
  `id` int(11) NOT NULL,
  `promotion_name` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `review` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `address` text,
  `address_detail` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','owner','customer') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `address`, `address_detail`, `phone`, `role`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$smjVtOm1FC374BTH64QjZO2mtEEzb/OO.XM9gS5wUkzXHfD0Zidjm', 'Administrator', 'Ciawigebang', '', '08123456789', 'admin'),
(2, 'dadang', 'dadang@gmail.com', '$2y$10$RBcRBhuFDiCX0vi7RCzGwO6QXPJCQFUNixJrLQr70/Usr3TCo.bRO', 'Dadang', 'CIAWILOR, CIAWIGEBANG, KUNINGAN, JAWA BARAT, 45591', 'Jl Ciawilor, RT/RW 01/01', '+628212345678', 'customer'),
(3, 'pebi', 'pebi@gmail.com', '$2y$10$a9Ht62tSYGT6KwLelOto3up6W9Ls3xOEU/EfnXzY..HG2ejsoRojW', 'Pebi', NULL, '', NULL, 'customer'),
(4, 'pemilik', 'pemilik@admin.com', '$2y$10$vAQ.4uzpNlOrDTIiVrbYm.BI8hwmmpzRGK7elH23CFli0m4ZcrZGm', 'Pemilik', 'Ciawigebang', '', NULL, 'owner'),
(5, 'dadang2', 'dadang2@gmail.com', '$2y$10$a1lrq/8.80nlBkZ8QYQfke9mMt1dJldJPVRkCDJKWGKNAS4aSu.7S', 'dadang2', 'CIAWILOR, CIAWIGEBANG, KUNINGAN, JAWA BARAT, 45591', 'Jl Ciawilor, RT/RW 01/01', '08912345678', 'customer'),
(14, 'pebi', 'pebi@gmail.com', '$2y$10$krH44Qlspbie3zrv4R.w2.GhvmeFd7uXqQdPDKJ5s/w8Qidn3rvPW', 'Pebi', 'asasas', 'asasas', '09889192', 'customer'),
(15, 'pebiganteng', 'pebiganteng@gmail.com', '$2y$10$WCUQsQw701nc7mud.TSWzuQSOfuNWiWmvHhisdKoRpuMAd1180XiO', 'Pebi Ganteng', 'Kuningan', 'Kuningan', '+628512345678', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `gambar_produk`
--
ALTER TABLE `gambar_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gambar_produk_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keranjang_user_id_foreign` (`user_id`),
  ADD KEY `keranjang_product_variant_id_foreign` (`product_variant_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_order_id_foreign` (`order_id`),
  ADD KEY `order_item_product_variant_id_foreign` (`product_variant_id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_order_id_foreign` (`order_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `produk_varian`
--
ALTER TABLE `produk_varian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_varian_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `promosi`
--
ALTER TABLE `promosi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `gambar_produk`
--
ALTER TABLE `gambar_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `produk_varian`
--
ALTER TABLE `produk_varian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT untuk tabel `promosi`
--
ALTER TABLE `promosi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `gambar_produk`
--
ALTER TABLE `gambar_produk`
  ADD CONSTRAINT `gambar_produk_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `produk_varian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `keranjang_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `produk_varian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk_varian`
--
ALTER TABLE `produk_varian`
  ADD CONSTRAINT `produk_varian_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
