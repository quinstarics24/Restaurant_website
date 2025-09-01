-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2025 at 09:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aunty_cos_kitchen`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `active_reservations`
-- (See below for the actual view)
--
CREATE TABLE `active_reservations` (
`reservation_id` varchar(20)
,`name` varchar(100)
,`email` varchar(150)
,`phone` varchar(20)
,`guests` int(11)
,`reservation_date` date
,`reservation_time` time
,`special_requirements` text
,`special_requests` text
,`status` enum('pending','confirmed','cancelled','completed')
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `email`, `created_at`, `last_login`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@auntycoskitchen.com', '2025-08-19 18:40:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('new','read','responded') DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_inquiries`
--

INSERT INTO `contact_inquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `status`) VALUES
(2, 'Bashira', 'bashira@gmail.com', '654091559', 'reservation', 'i want to reserve for a birthday', '2025-07-26 15:50:44', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_filename` varchar(255) NOT NULL,
  `image_description` text DEFAULT NULL,
  `upload_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `image_name`, `image_filename`, `image_description`, `upload_date`, `created_at`) VALUES
(2, '1756533393_7294', '68b2a847b02aa_1756538951.jpeg', '', '2025-08-29', '2025-08-30 07:29:11'),
(3, '1756533393_7583', '68b2a85246508_1756538962.png', '', '2025-08-29', '2025-08-30 07:29:22'),
(5, '68a4b8ef3b4c1_1755625711', '68b2aa28a639a_1756539432.jpg', 'jtktu,h,uyl7il,j,yil', '2025-08-29', '2025-08-30 07:37:12'),
(6, 'yams', '68b2aa3686899_1756539446.jpeg', ',u;uo;.jhliy', '2025-08-29', '2025-08-30 07:37:26'),
(10, 'peppersoup', '68b2ae5ec9ae0_1756540510.jpeg', 'hot olrfe kfeg gw jg', '2025-08-29', '2025-08-30 07:55:10'),
(11, 'rice', '68b3ca782ff8f_1756613240.jpg', 'ttuotuot', '2025-08-30', '2025-08-31 04:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `image`, `is_available`, `created_at`) VALUES
(18, 'Sanga Traditional Meal', 'dgfhgjg hkjh', 1600.00, '1756615737_1195.png', 0, '2025-08-31 04:48:57'),
(19, 'Achu and Yellow Soup', 'hntd mrrerftbs rdr ee', 1500.00, '1756753084_3591.png', 1, '2025-09-01 18:58:04'),
(20, 'Eru & Waterfufu', 'hj gfs yittnef b t6s', 2000.00, '1756753084_2789.jpg', 1, '2025-09-01 18:58:04'),
(21, 'Sanga Traditional Meal', 'ynsbd   gfbydrsfyh jtdbrdd', 2500.00, '1756753084_7456.png', 1, '2025-09-01 18:58:04');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `reservation_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `guests` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `special_requirements` text DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `reservation_id`, `name`, `email`, `phone`, `guests`, `reservation_date`, `reservation_time`, `special_requirements`, `special_requests`, `status`, `created_at`, `updated_at`) VALUES
(3, 'RES-2025-9120', 'ALEXINE', 'Alexine@gmail.com', '654091559', 10, '2025-08-25', '13:30:00', 'Anniversary', '', 'pending', '2025-08-13 13:15:20', '2025-08-13 13:15:20'),
(6, 'RES-2025-8446', 'Quinstarics', 'quinngwina@gmail.com', '671319479', 4, '2025-09-06', '19:00:00', 'High Chair', 'gkhk fhfh', 'pending', '2025-08-31 04:57:52', '2025-08-31 04:57:52'),
(7, 'RES-2025-0930', 'Ngwina Quinstarics', 'ColetteAfugmegui@gmail.com', '671319479', 8, '2025-09-13', '18:30:00', 'Anniversary', 'sfghd fg', 'completed', '2025-08-31 05:01:38', '2025-08-31 05:23:24'),
(8, 'RES-2025-3839', 'Ngwin', 'quin@gmail.com', '671319479', 10, '2025-09-10', '18:00:00', 'High Chair', 'bkm bkuy', 'confirmed', '2025-08-31 05:02:08', '2025-09-01 18:58:48'),
(9, 'RES-2025-7995', 'Glory', 'ColetteAfugmegui@gmail.com', '654091559', 4, '2025-10-08', '13:00:00', 'Quiet Table', 'no salt and maggi in the meals', 'pending', '2025-09-01 19:39:11', '2025-09-01 19:39:11');

-- --------------------------------------------------------

--
-- Stand-in structure for view `upcoming_reservations`
-- (See below for the actual view)
--
CREATE TABLE `upcoming_reservations` (
`reservation_id` varchar(20)
,`name` varchar(100)
,`email` varchar(150)
,`phone` varchar(20)
,`guests` int(11)
,`reservation_date` date
,`reservation_time` time
,`special_requirements` text
,`status` enum('pending','confirmed','cancelled','completed')
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `active_reservations`
--
DROP TABLE IF EXISTS `active_reservations`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `active_reservations`  AS SELECT `reservations`.`reservation_id` AS `reservation_id`, `reservations`.`name` AS `name`, `reservations`.`email` AS `email`, `reservations`.`phone` AS `phone`, `reservations`.`guests` AS `guests`, `reservations`.`reservation_date` AS `reservation_date`, `reservations`.`reservation_time` AS `reservation_time`, `reservations`.`special_requirements` AS `special_requirements`, `reservations`.`special_requests` AS `special_requests`, `reservations`.`status` AS `status`, `reservations`.`created_at` AS `created_at` FROM `reservations` WHERE `reservations`.`reservation_date` >= curdate() ORDER BY `reservations`.`reservation_date` ASC, `reservations`.`reservation_time` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `upcoming_reservations`
--
DROP TABLE IF EXISTS `upcoming_reservations`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `upcoming_reservations`  AS SELECT `reservations`.`reservation_id` AS `reservation_id`, `reservations`.`name` AS `name`, `reservations`.`email` AS `email`, `reservations`.`phone` AS `phone`, `reservations`.`guests` AS `guests`, `reservations`.`reservation_date` AS `reservation_date`, `reservations`.`reservation_time` AS `reservation_time`, `reservations`.`special_requirements` AS `special_requirements`, `reservations`.`status` AS `status`, `reservations`.`created_at` AS `created_at` FROM `reservations` WHERE `reservations`.`reservation_date` >= curdate() ORDER BY `reservations`.`reservation_date` ASC, `reservations`.`reservation_time` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservation_id` (`reservation_id`),
  ADD KEY `idx_reservation_date` (`reservation_date`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_reservation_id` (`reservation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
