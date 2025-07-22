-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 21, 2025 at 03:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kkn`
--

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_utama`
--

CREATE TABLE `fasilitas_utama` (
  `id` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas_utama`
--

INSERT INTO `fasilitas_utama` (`id`, `icon`, `title`, `description`, `color`) VALUES
(1, 'fas fa-car', 'Parkir Luas', 'Area parkir yang luas untuk motor dan mobil dengan kapasitas hingga 200 kendaraan. Tersedia penjaga parkir dan CCTV untuk keamanan.', 'primary'),
(2, 'fas fa-wifi', 'WiFi Gratis', 'Koneksi internet WiFi gratis dengan kecepatan tinggi di seluruh area SWK Semolowaru untuk kenyamanan pengunjung.', 'success'),
(3, 'fas fa-music', 'Live Music', 'Pertunjukan musik live setiap malam dengan berbagai genre musik untuk menghibur pengunjung sambil menikmati kuliner.', 'warning'),
(4, 'fas fa-skating', 'Skateboard Area', 'Area khusus skateboard dan BMX yang dapat digunakan gratis oleh pengunjung, dilengkapi dengan berbagai rintangan.', 'info'),
(5, 'fas fa-child', 'Area Bermain Anak', 'Playground khusus anak-anak dengan permainan yang aman dan menyenangkan, diawasi oleh petugas khusus.', 'danger'),
(6, 'fas fa-restroom', 'Toilet Bersih', 'Fasilitas toilet yang bersih dan terawat dengan air mengalir, tersebar di beberapa lokasi strategis.', 'secondary'),
(7, 'fas fa-futbol', 'Lapangan Futsal', 'Lapangan futsal standar dengan permukaan aman dan pencahayaan baik untuk pertandingan malam hari.', 'success'),
(8, 'fas fa-basketball-ball', 'Lapangan Basket', 'Area lapangan basket terbuka untuk umum, cocok untuk latihan dan pertandingan komunitas.', 'info');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `title`, `description`, `icon`, `is_active`, `created_at`) VALUES
(1, '20+ tenant kuliner beragam', 'Berbagai pilihan makanan dan minuman dari seluruh nusantara', 'fas fa-store', 1, '2025-07-02 14:24:24'),
(2, 'Suasana outdoor yang nyaman', 'Tempat makan terbuka dengan udara segar dan pemandangan menarik', 'fas fa-tree', 1, '2025-07-02 14:24:24'),
(3, 'Hiburan live music setiap malam', 'Pertunjukan musik live setiap malam untuk menghibur pengunjung', 'fas fa-music', 1, '2025-07-02 14:24:24'),
(4, 'Fasilitas skateboard gratis', 'Area skateboard gratis untuk anak muda dan remaja', 'fas fa-skating', 1, '2025-07-02 14:24:24'),
(5, 'Parkir luas motor & mobil', 'Area parkir yang luas dan aman untuk kendaraan bermotor dan mobil', 'fas fa-parking', 1, '2025-07-02 14:24:24'),
(6, 'WiFi gratis untuk pengunjung', 'Akses internet gratis untuk semua pengunjung', 'fas fa-wifi', 1, '2025-07-02 14:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `fitur_fasilitas`
--

CREATE TABLE `fitur_fasilitas` (
  `id` int(11) NOT NULL,
  `fasilitas_id` int(11) NOT NULL,
  `fitur` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fitur_fasilitas`
--

INSERT INTO `fitur_fasilitas` (`id`, `fasilitas_id`, `fitur`) VALUES
(1, 1, 'Kapasitas 200+ kendaraan'),
(2, 1, 'Penjaga parkir 24 jam'),
(3, 1, 'CCTV keamanan'),
(4, 1, 'Akses mudah keluar masuk'),
(5, 2, 'Kecepatan tinggi'),
(6, 2, 'Coverage seluruh area'),
(7, 2, 'Password mudah diingat'),
(8, 2, 'Stabil dan reliable'),
(9, 3, 'Setiap malam mulai 19:00'),
(10, 3, 'Berbagai genre musik'),
(11, 3, 'Musisi lokal berkualitas'),
(12, 3, 'Sound system premium'),
(13, 4, 'Gratis untuk umum'),
(14, 4, 'Berbagai rintangan'),
(15, 4, 'Area yang aman'),
(16, 4, 'Cocok untuk pemula & ahli'),
(17, 5, 'Permainan aman'),
(18, 5, 'Pengawasan ketat'),
(19, 5, 'Bersih dan higienis'),
(20, 5, 'Cocok usia 3-12 tahun'),
(21, 6, 'Selalu bersih'),
(22, 6, 'Air mengalir lancar'),
(23, 6, 'Tersebar di area'),
(24, 6, 'Akses mudah');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `alt` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `description`, `category`, `image_url`, `alt`) VALUES
(1, 'Suasana Malam Hari', 'Pengunjung menikmati kuliner di malam hari dengan live music', 'Suasana', 'images/gallery/suasana-malam.jpg', 'Suasana malam SWK Semolowaru'),
(2, 'Live Music Performance', 'Pertunjukan musik live yang menghibur pengunjung', 'Hiburan', 'images/gallery/live-music.jpg', 'Live music di SWK Semolowaru'),
(3, 'Area Skateboard', 'Fasilitas skateboard yang gratis untuk semua pengunjung', 'Fasilitas', 'images/gallery/skateboard-area.jpg', 'Area skateboard SWK Semolowaru'),
(4, 'Keluarga Bahagia', 'Keluarga menikmati waktu bersama di SWK Semolowaru', 'Pengunjung', 'images/gallery/keluarga-bahagia.jpg', 'Keluarga di SWK Semolowaru'),
(5, 'Aneka Kuliner', 'Berbagai pilihan makanan dari tenant-tenant terbaik', 'Kuliner', 'images/gallery/aneka-kuliner2.jpg', 'Aneka kuliner SWK Semolowaru'),
(6, 'Suasana Siang', 'Aktivitas siang hari yang ramai dengan pengunjung', 'Suasana', 'images/gallery/suasana-siang.jpg', 'Suasana siang SWK Semolowaru'),
(7, 'Event Spesial', 'Acara khusus yang diselenggarakan di SWK Semolowaru', 'Event', 'images/gallery/event-spesial.jpg', 'Event khusus SWK Semolowaru'),
(10, 'Area Futsal dan Basket', 'Fasilitas lapangan futsal dan basket yang dapat disewa oleh pengunjung', 'Fasilitas', 'images/gallery/futsal-area.jpg', 'Futsal dan Basket SWK Semolowaru'),
(11, 'Aktivitas Anak', 'Anak-anak bermain dengan gembira di area bermain', 'Pengunjung', 'images/gallery/aktivitas-anak.jpg', 'Aktivitas anak SWK Semolowaru'),
(12, 'Pemandangan Outdoor', 'Pemandangan outdoor yang nyaman dan asri', 'Suasana', 'images/gallery/pemandangan-outdoor.jpg', 'Pemandangan outdoor SWK Semolowaru'),
(13, 'Area Toilet', 'Fasilitas Toilet yang dapat digunakan oleh pengunjung', 'Fasilitas', 'images/gallery/toilet-area.jpg', 'Toilet SWK Semolowaru'),
(14, 'Momen Kebersamaan', 'Momen kebersamaan bersama teman-teman', 'Pengunjung', 'images/gallery/momen-kebersamaan2.jpg', 'Momen Kebersamaan SWK Semolowaru'),
(15, 'Area Mushola', 'Fasilitas Mushola yang dapat digunakan oleh pengunjung', 'Fasilitas', 'images/gallery/mushola-area.jpg', 'Mushola SWK Semolowaru'),
(16, 'Area Bermain Anak-anak', 'Fasilitas Bermain Anak-anak yang dapat digunakan oleh pengunjung', 'Fasilitas', 'images/gallery/kids-area.jpg', 'Bermain Anak-anak SWK Semolowaru');

-- --------------------------------------------------------

--
-- Table structure for table `menu_andalan`
--

CREATE TABLE `menu_andalan` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_andalan`
--

INSERT INTO `menu_andalan` (`id`, `nama_menu`, `kategori`, `created_at`) VALUES
(1, 'Soto Daging', 'Soto & Sup', '2025-07-02 14:32:16'),
(2, 'Mie Ayam', 'Mie', '2025-07-02 14:32:16'),
(3, 'Nasi Sambal Teri', 'Nasi', '2025-07-02 14:32:16'),
(4, 'Nasi Pecel', 'Nasi', '2025-07-02 14:32:16'),
(5, 'Sego Kucing', 'Nasi', '2025-07-02 14:32:16'),
(6, 'Aneka Sate Angkringan', 'Sate', '2025-07-02 14:32:16'),
(7, 'Tahu & Tempe Bacem', 'Lauk', '2025-07-02 14:32:16'),
(8, 'Nasi Gudeg DIY IVA', 'Nasi', '2025-07-02 14:32:16'),
(9, 'Bakmi Goreng Jawa', 'Mie', '2025-07-02 14:32:16'),
(10, 'Soto Ayam Pacitan', 'Soto & Sup', '2025-07-02 14:32:16'),
(11, 'Mie Pangsit Jakarta', 'Mie', '2025-07-02 14:32:16'),
(12, 'Nasi Ayam Rempah Sambal Matah', 'Nasi', '2025-07-02 14:32:16'),
(13, 'Nasi Sate Kulit Sambal Matah', 'Nasi', '2025-07-02 14:32:16'),
(14, 'Nasi Kulit', 'Nasi', '2025-07-02 14:32:16'),
(15, 'Kwetiau Goreng', 'Mie', '2025-07-02 14:32:16'),
(16, 'Nasi Rawon', 'Nasi', '2025-07-02 14:32:16'),
(17, 'Nasi Krengsengan', 'Nasi', '2025-07-02 14:32:16'),
(18, 'Mie Nyemek', 'Mie', '2025-07-02 14:32:16'),
(19, 'Aneka Pentol Fan (Ayam, Telor, Lele)', 'Pentol', '2025-07-02 14:32:16'),
(20, 'Batagor', 'Snack', '2025-07-02 14:32:16'),
(21, 'Kare Ayam', 'Lauk', '2025-07-02 14:32:16'),
(22, 'Pempek Palembang', 'Pempek', '2025-07-02 14:32:16'),
(23, 'Lenggang Palembang', 'Palembang', '2025-07-02 14:32:16'),
(24, 'Rujak Tahu Palembang', 'Palembang', '2025-07-02 14:32:16'),
(25, 'Ketan Bubuk/Sambel', 'Snack', '2025-07-02 14:32:16'),
(26, 'Ketan Susu + Keju', 'Snack', '2025-07-02 14:32:16'),
(27, 'Kacang Ijo', 'Minuman', '2025-07-02 14:32:16'),
(28, 'Bakso', 'Bakso', '2025-07-02 14:32:16'),
(29, 'Tahu Telor/Tek', 'Lauk', '2025-07-02 14:32:16'),
(30, 'Magicbat', 'Minuman', '2025-07-02 14:32:16'),
(31, 'Nasi Ayam Geprek', 'Nasi', '2025-07-02 14:32:16'),
(32, 'Nasi Ikan Klotok', 'Nasi', '2025-07-02 14:32:16'),
(33, 'Nasi Telor Ijo', 'Nasi', '2025-07-02 14:32:16'),
(34, 'Gado Gado', 'Salad', '2025-07-02 14:32:16'),
(35, 'Fire Chicken', 'Ayam', '2025-07-02 14:32:16'),
(36, 'Martabak Balungan', 'Martabak', '2025-07-02 14:32:16'),
(37, 'Nasi Gila', 'Nasi', '2025-07-02 14:32:16'),
(38, 'Seblak', 'Seblak', '2025-07-02 14:32:16'),
(39, 'Ceker Mercon', 'Lauk', '2025-07-02 14:32:16'),
(40, 'Sempol', 'Snack', '2025-07-02 14:32:16'),
(41, 'Ayam Bakar', 'Ayam', '2025-07-02 14:32:16'),
(42, 'Ayam Rica-Rica', 'Ayam', '2025-07-02 14:32:16'),
(43, 'Steak Ayam', 'Ayam', '2025-07-02 14:32:16'),
(44, 'Lontong Balap', 'Lontong', '2025-07-02 14:32:16'),
(45, 'Bebek Hitam', 'Bebek', '2025-07-02 14:32:16'),
(46, 'Nasi Kebuli', 'Nasi', '2025-07-02 14:32:16'),
(47, 'Nasi Kuning', 'Nasi', '2025-07-02 14:32:16'),
(48, 'Angsle', 'Minuman', '2025-07-02 14:32:16'),
(49, 'Nasi Campur', 'Nasi', '2025-07-02 14:32:16'),
(50, 'Tahu Campur', 'Lauk', '2025-07-02 14:32:16'),
(51, 'Soto Ayam', 'Soto & Sup', '2025-07-02 14:32:16'),
(52, 'Lontong Sayur', 'Lontong', '2025-07-02 14:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `operating_hours`
--

CREATE TABLE `operating_hours` (
  `id` int(11) NOT NULL,
  `day_name` varchar(20) NOT NULL,
  `day_number` int(11) NOT NULL,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL,
  `is_open` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operating_hours`
--

INSERT INTO `operating_hours` (`id`, `day_name`, `day_number`, `open_time`, `close_time`, `is_open`, `created_at`) VALUES
(1, 'Minggu', 0, '17:00:00', '23:00:00', 1, '2025-07-02 14:24:24'),
(2, 'Senin', 1, '17:00:00', '23:00:00', 1, '2025-07-02 14:24:24'),
(3, 'Selasa', 2, '17:00:00', '23:00:00', 1, '2025-07-02 14:24:24'),
(4, 'Rabu', 3, '17:00:00', '23:00:00', 1, '2025-07-02 14:24:24'),
(5, 'Kamis', 4, '17:00:00', '23:00:00', 1, '2025-07-02 14:24:24'),
(6, 'Jumat', 5, '17:00:00', '23:00:00', 1, '2025-07-02 14:24:24'),
(7, 'Sabtu', 6, '17:00:00', '23:00:00', 1, '2025-07-02 14:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `site_info`
--

CREATE TABLE `site_info` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `hours` varchar(50) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `reviews` int(11) NOT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `established` year(4) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_info`
--

INSERT INTO `site_info` (`id`, `name`, `full_name`, `address`, `hours`, `rating`, `reviews`, `instagram`, `phone`, `established`, `area`, `capacity`, `created_at`, `updated_at`) VALUES
(1, 'SWK Semolowaru', 'Sentra Wisata Kuliner Semolowaru', 'Jl. Sukosemolo 181, Semolowaru, Kota Surabaya', '17:00 - 23:00', 4.4, 778, '@swk_semolowaru', '+6282233914519', '2014', 3500, 500, '2025-07-02 14:24:24', '2025-07-19 19:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `tenan`
--

CREATE TABLE `tenan` (
  `id_tenan` int(11) NOT NULL,
  `nama_tenan` varchar(100) NOT NULL,
  `range_harga` varchar(50) NOT NULL,
  `menu` text NOT NULL,
  `foto_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenan`
--

INSERT INTO `tenan` (`id_tenan`, `nama_tenan`, `range_harga`, `menu`, `foto_url`) VALUES
(1, 'Warung \"Mbak Febi\"', 'Rp 4.000 – Rp 17.000', 'Makanan: Soto Daging Madura, Mie Ayam Bakso, Nasi Sambel Teri, Nasi Pecel, Aneka Camilan (Tahu Bulat, Roti Maryam, Pisang Roll, Keju Roll, Coklat Roll, Kentang Goreng). Minuman: Es Milo, Es Pop Ice, Es Nutrisari, Es Goodday, Es Soda Gembira, Es Joshua, Es Teh, Es Bobba, Es Jeruk, Es Cao Susu, Es Susu/Susu Hangat, Kopi Hitam Racik/Kemasan, Wedang Jahe, Minuman Kemasan/Soft Drink, Aneka Juice Buah', 'tenan1.jpeg'),
(2, 'Warung \"GUTEH\"', 'Rp 3.000 – Rp 15.000', 'Makanan: Sate Ayam, Sate Kambing, Sate SULE, Tahu Isi, Pentol Bumbu. Minuman: Es Milo, Es Pop Ice, Es Nutrisari, Es Goodday, Es Soda Gembira, Es Joshua, Es Teh Kekinian, Es Bobba, Kopi Racik, Wedang Jahe', 'tenan2.jpeg'),
(3, 'Warung \"IKI ANGKRINGAN\"', 'Rp 3.000 – Rp 10.000', 'Makanan: Sego Kucing, Aneka Sate, Tahu & Tempe Bacem. Minuman: Kopi Jozz, Kopi Racik, Kopi Jahe, Kopi Susu, Kopi Kemasan, Teh Hangat, Teh Tarik, Wedang Jahe, Jahe Susu, White Coffee, Susu Dancow Putih/Coklat, Es Milo, Es Pop Ice, Es Nutrisari, Es Good Day Freeze, Es Good Day Cappuccino, Es Beng Beng, Es Soda Gembira, Es Joshua, Es Extra Joss, Es Chocolatos', 'tenan3.jpeg'),
(4, 'Warung \"Jowo\"', 'Rp 10.000 – Rp 15.000', 'Makanan: Nasi Goreng Jawa, Bakmie Goreng Jawa, Bakmie Kuah Jawa, Soto Ayam Pacitan, Aneka Mie Instan (Goreng/Kuah), Camilan (Tahu Krispy, Jamur Krispy, Kentang Krispy). Minuman: Es Teh/Teh Hangat, Es Jeruk, Kopi Hitam Racik/Susu Racik, Wedang Jahe/Susu Jahe, Es Soda Gembira, Aneka Nutrisari, Aneka Pop Ice, Susu Kemasan, Extra Joss/Kukubima/Hemaviton', 'tenan4.jpeg'),
(5, 'Warung \"Pawon Eco Dewe\"', 'Rp 5.000 – Rp 15.000', 'Makanan: Nasi Ayam Rempah Sambal Matah, Nasi Sate Lilit Sambal Matah, Nasi Kulit, Kwetiau Goreng, Camilan (Sempol, French Fries, Cireng Salju, Sosis, Kekian). Minuman: Es Kuwut, Es/Panas Teh, Es/Panas Teh Kampul, Es/Panas Jeruk Peras, Wedang Uwuh, Wedang Jahe, Aneka Good Day, Nutrisari, Pop Ice, Kopi Racik, Kopi Toraja, Kopi Bali, Extra Joss, Joshua, Hemaviton/+ Susu', 'tenan5.jpeg'),
(6, 'Warung \"K-RISMA\"', 'Rp 5.000 – Rp 17.000', 'Makanan: Nasi Rawon, Nasi Krengsengan, Mie Nyemek, Aneka Penyetan, Camilan (Ceker Pedas, Pentol Mercon, Pisang Ori Keju/Coklat/Crispy). Minuman: Es Susu Dancow, Aneka Nutrisari, Pop Ice, Aneka Juice Buah, Joshua, Soda Gembira, Mega Mendung, Kopi Racik/Kemasan, Wedang Jahe, Es Jeruk Peras, Es Goodday Freeze/Cappuccino, Es Drink Beng Beng, Chocolatos, Es Milo, Es Susu Kental Manis', 'tenan6.jpeg'),
(7, 'Batagor dan STMJ', 'Rp 5.000 – Rp 20.000', 'Makanan: Batagor, Tahu Gejrot, Indomie (Aneka Rasa). Minuman: STMJ (Susu Telor Madu Jahe), Es Teh, Es Jeruk, Kopi, Serbat (Kobuk)', 'tenan7.jpeg'),
(8, 'Warung \"Japung\"', 'Rp 5.000 – Rp 20.000', 'Makanan: Kare Ayam, Empek-empek Palembang, Lenggang Palembang, Rujak Tahu Palembang, Cimol, Cireng, Lumpia, Kentang Krispi, Jamur Krispi, Tahu Krispi, Aneka Mie Instan. Minuman: Es Teh, Es Jeruk Peras, Kopi Racik Lampung, Wedang Jahe, Jahe Susu, Joshua, Soda Gembira, Aneka Pop Ice, Aneka Nutrisari, Aneka Kopi Kemasan', 'tenan8.jpeg'),
(9, 'Warkop Gilang 27', 'Rp 5.000 – Rp 20.000', 'Makanan: Ketan Bubuk/Sambel, Ketan Susu + Keju, Kacang Ijo, Mie Yamin Original, Mie Yamin Jamur, Mie Yamin Karage, Mie Yamin Katsu, Tahu Bulat, Tahu Crispy, Kentang, Jamur Krispi, Cireng, Sosis, Tempura. Minuman: Es Teh/Teh Panas, Nutrisari, Kopi Panas/Dingin, Susu Panas/Dingin', 'tenan9.jpeg'),
(10, 'Shintya Cus', 'Rp 5.000 – Rp 15.000', 'Makanan: Soto Daging, Jagung Bakar, Kerang Rebus, Kol/Kreco Rebus, Cecek Bakar, Kerang Bakar, Col Bakar, Usus Bakar, Ceker Bakar, Pentol Bakar, Roti Bakar. Minuman: Kopi Racik, Kopi Jahe, Teh Hangat, Es Teh, Pop Ice, Air Mineral', 'tenan10.jpeg'),
(11, 'Kedai \"Afika\"', 'Rp 5.000 – Rp 15.000', 'Makanan: Bakso, Tahu Tek-Tek, Tahu Telor, Aneka Gorengan. Minuman: Es Milo, Joshua, Soda Gembira, Es Jeruk Peras, Es Good Day Freeze, Es Beng-Beng, Es Teh Hangat, Kopi Racik, Aneka Nutrisari, Aneka Pop Ice, Aneka Susu, Aneka Kopi, Teh Tarik, Es Teh/Hangat', 'tenan11.jpeg'),
(12, 'Warung \"Chamim & Ndut\"', 'Rp 5.000 – Rp 15.000', 'Makanan: Nasi Goreng Jawa, Bakmie Jawa, Bihun Goreng, Pecel, Camilan (Mendoan, Omelet, Tahu Petis). Minuman: Es Milo, Joshua, Soda Gembira, Es Jeruk Peras, Es Good Day Freeze, Es Beng-Beng, Es Teh/Panas, Kopi Racik, Aneka Nutrisari, Aneka Pop Ice', 'tenan12.jpeg'),
(13, 'Kedai \"Seru\"', 'Rp 5.000 – Rp 15.000', 'Makanan: Nasi Babat, Nasi Ayam Geprek, Nasi Cumi-Cumi, Nasi Ikan Klotok, Nasi Telur Ijo, Camilan (Pisang Keju, Pisang Goreng, Tempe Mendoan, Tahu Crispy). Minuman: Kopi Tubruk, Es/Panas Teh, Es Timun Serut, Es Nutrisari, Es Teh/Panas, Es Kopi, Es Susu/Panas, Es Milo, Es Good Day Cappuccino, Es Good Day Freeze, Es Beng-Beng, Es Pop Ice, Kopi Racik, Jahe (Geprek/Susu), Energen', 'tenan15.jpeg'),
(14, 'DUNIA JUICE', 'Rp 5.000 – Rp 20.000', 'Makanan: Gado-Gado, Ayam Krispi, Fire Chicken/Hot Korean Spicy, Sego Sambel (varian: ayam, telur), Camilan (Tahu Gobyos, Kentang Krispi, Salad Buah). Minuman: Aneka Juice Buah, Sop Buah/Kuah Sirsak, Es Campur, Es Manado, Es Doger, Es Semangsu (Semangka Susu), Es Alpucok, Es Buah Fantasi, Es Coklat Lali Jiwo, Es Tape, Juice Tapes, Es Sirup, Es Blewah, Es Milo, Es Nutrisari, Es Good Day, Es Beng-Beng, Es Soda Gembira, Es Joshua, Es Kopi RACK, Es Lemon Tea, Es Kopvor KW', 'tenan17.jpeg'),
(15, 'HANZ & Z\'CRISPY', 'Rp 5.000 – Rp 20.000', 'Makanan: Martabak Balungan, Nasi Gila, Aneka Seblak Mercon, Ceker Mercon, Camilan (Kentang Crispy, Tahu Crispy, Cireng Rujak, Cireng Bumbu Tabur, Roti Maryam, Sosis Bakar, Sionay Ayam, Udang Rambutan, Lumpia Udang, Tahu Bakso). Minuman: Es Teh, Es Milo, Es Pop Ice, Es Nutrisari, Es Good Day Freeze, Es Good Day Capuccino, Es Beng-Beng, Es Soda Gembira, Es Joshua, Kopi RACK, Es Lemon Tea', 'tenan18.jpeg'),
(16, 'Warung \"AL-EL\"', 'Rp 4.000 – Rp 15.000', 'Makanan: Pempek Ikan Palembang, Sempol Ayam, Pentol & Sosis Bakar, Jamur Crispy, Kentang Crispy, Tahu Crispy, Cireng Isi (Ayam/Bumbu Tabur), Aneka Mie Instan, Omelet Mie, Seafood Bakar, Aneka Dimsum. Minuman: Es Jeruk Peras, Es Teh, Es Telo, Es Pop Ice, Es Nutrisari, Es Good Day Freeze, Es Susu (Putih & Coklat), Es Joshua/Kukubima, Kopi Racik/Kopi Susu', 'tenan19.jpeg'),
(17, 'Warung \"Dewi\"', 'Rp 4.000 – Rp 18.000', 'Makanan: Ayam Bakar, Aneka Penyetan, Ayam Rica-Rica, Tahu Crispy, Kentang Crispy, Cireng Rujak/Tabur, Pisang Bakar, Pisang Goreng Keju, Pisang Coklat/Crispy, Sosis Bakar Kecil/Besar, Omelette Mie, Roti Bakar. Minuman: Kopi Racik, Es Teh, Jeruk Peras, Lemon Tea, Soda Gembira, Joshua, Milo, Susu Putih/Coklat, Matcha Greentea, Goodday Frezz/Capuccino', 'tenan20.jpeg'),
(18, 'Café \"Yuvenz Coffee\"', 'Rp 5.000 – Rp 15.000', 'Makanan: Lontong Balap, Aneka Mie Instan, Aneka Pentol, Kentang Crispy, Tahu Crispy, Tahu Baxo, Pisang Keju. Minuman: Es Jeruk Peras/Lemon, Es Good Day Freeze, Es Good Day Capuccino, Es Joshua, Es Soda Gembira, Es Mega Mendung, Es Aneka Nutrisari, Es Aneka Pop Ice, Es Dancow Putih/Coklat, Es Milo', 'tenan22.jpeg'),
(19, 'Bebek Goreng Bumbu Hitam Khas Madura', 'Rp 10.000 – Rp 20.000', 'Makanan: Bebek Bumbu Hitam, Bebek Goreng Serundeng. Minuman: Teh (Panas/Dingin), Kopi, Nutrisari, Good Day, DLL', 'tenan23.jpeg'),
(20, 'Kedai \"Maestro\"', 'Rp 10.000 – Rp 15.000', 'Makanan: Bakso Solo, Mi Pangsit Jakarta, Soto Daging Madura, Dim Sum, Kentang Goreng. Minuman: Kopi Hitam, Teh, Wedang Jahe, Es Teh, Pop Ice, Es Nutrisari, Es Milo', 'tenan26.jpeg'),
(21, 'Kedai \"ST Maharani\"', 'Rp 5.000 – Rp 12.000', 'Minuman: Wedang Jarak, Wedang Sare, Wedang Uwuh, Wedang Secang, Kopi Robusta, Es Nutrisari, Es Teh/Panas, Kopi Hitam/Susu, Sungat', 'tenan28.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fasilitas_utama`
--
ALTER TABLE `fasilitas_utama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fitur_fasilitas`
--
ALTER TABLE `fitur_fasilitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fasilitas_id` (`fasilitas_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_andalan`
--
ALTER TABLE `menu_andalan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operating_hours`
--
ALTER TABLE `operating_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_info`
--
ALTER TABLE `site_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenan`
--
ALTER TABLE `tenan`
  ADD PRIMARY KEY (`id_tenan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fasilitas_utama`
--
ALTER TABLE `fasilitas_utama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fitur_fasilitas`
--
ALTER TABLE `fitur_fasilitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `menu_andalan`
--
ALTER TABLE `menu_andalan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `operating_hours`
--
ALTER TABLE `operating_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `site_info`
--
ALTER TABLE `site_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tenan`
--
ALTER TABLE `tenan`
  MODIFY `id_tenan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fitur_fasilitas`
--
ALTER TABLE `fitur_fasilitas`
  ADD CONSTRAINT `fitur_fasilitas_ibfk_1` FOREIGN KEY (`fasilitas_id`) REFERENCES `fasilitas_utama` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
