-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 31, 2025 at 09:02 AM
-- Server version: 8.4.6-0ubuntu0.25.04.3
-- PHP Version: 8.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attempt`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `name`, `description`, `images`, `created_at`) VALUES
(1, 'Sage Carney', 'Quasi earum accusamu', NULL, '2025-10-31 05:03:00'),
(2, 'Brody Marsh', 'Assumenda rerum inci', NULL, '2025-10-31 05:05:50'),
(3, '', 'At w3schools.com you will learn how to make a website. They offer free tutorials in all web development technologies.\r\n', NULL, '2025-10-31 05:23:16'),
(4, 'Nora Fox', 'Laborum qui labore r', 'uploads/img_69044a1d234604.68990517.jpg', '2025-10-31 05:33:17'),
(5, 'Maia Herring', 'Ea sint ad et amet ', 'uploads/img_69044a2eb168a5.60998615.webp', '2025-10-31 05:33:34'),
(6, 'Ira Gomez', 'In ea quo dolores ir', NULL, '2025-10-31 05:33:44'),
(7, 'Merritt Glass', 'Esse id quia doloru', 'uploads/img_69044e80642d30.23962768.jpg', '2025-10-31 05:52:00'),
(8, 'Aubrey Grimes', 'Repellendus Aut aut', 'uploads/img_69044ef4c21737.00016094.jfif', '2025-10-31 05:53:56'),
(9, 'William Mcfadden', 'Enim voluptatibus ul', 'uploads/img_690465d1291508.75353297.jfif', '2025-10-31 07:31:29'),
(10, 'Vanna Foster', 'Quibusdam consequat', 'uploads/img_69046a18335dd7.14262419.png', '2025-10-31 07:49:44'),
(11, 'asdasd', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est iusto ut voluptates sunt quas tenetur, quod atque sint doloremque! Error earum commodi nisi. Quam corrupti dolores iure, error aliquam quasi.', 'uploads/img_69046a262ca879.66127890.png', '2025-10-31 07:49:58'),
(14, 'Peter Mayer', 'Qui quod atque eveni', 'uploads/img_69046e456682f3.38792684.png', '2025-10-31 08:07:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `gmail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` int UNSIGNED DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gmail`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'attemmyanmaradmin', 1, '2025-10-29 08:52:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
