-- phpMyAdmin SQL Dump
-- Fake data for CV project
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2025
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `karate_test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;

-- Zmiana na nowo utworzoną bazę
USE `karate_test`;

-- Tworzenie użytkownika (zmień 'root' i '' na swoje dane jeśli trzeba)
CREATE USER IF NOT EXISTS 'karate_user'@'localhost' IDENTIFIED BY 'haslo123';

-- Nadanie wszystkich uprawnień do bazy karate_test
GRANT ALL PRIVILEGES ON `karate_test`.* TO 'karate_user'@'localhost';

-- Odświeżenie uprawnień
FLUSH PRIVILEGES;

-- --------------------------------------------------------
-- Table structure for table `camp`
-- --------------------------------------------------------
CREATE TABLE `camp` (
  `city` varchar(50) NOT NULL,
  `city_start` varchar(50) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `place` varchar(100) NOT NULL,
  `accommodation` text NOT NULL,
  `meals` text NOT NULL,
  `trips` text NOT NULL,
  `staff` text NOT NULL,
  `transport` text NOT NULL,
  `training` text NOT NULL,
  `insurance` text NOT NULL,
  `cost` int(11) NOT NULL,
  `advancePayment` int(11) NOT NULL,
  `advanceDate` date NOT NULL,
  `guesthouse` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

INSERT INTO `camp` VALUES
('Testowe Miasto 1', 'Start City A', '2025-06-01', '2025-06-10', '09:00:00', '17:00:00',
 'Testowy Dom Wypoczynkowy', 'Pokoje 2-4 osobowe', '3 posiłki dziennie', 'Wycieczka lokalna', 'Testowy personel', 'Autokar', 'Trening karate', 'Ubezpieczenie podstawowe', 2000, 500, '2025-02-01', 'Testowy Dom Wypoczynkowy');

-- --------------------------------------------------------
-- Table structure for table `contact`
-- --------------------------------------------------------
CREATE TABLE `contact` (
  `email` text NOT NULL,
  `phone` int(11) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

INSERT INTO `contact` VALUES
('test@example.com', 123456789, 'Testowa 1, Testowe Miasto');

-- --------------------------------------------------------
-- Table structure for table `fees`
-- --------------------------------------------------------
CREATE TABLE `fees` (
  `reduced_contribution_1_month` int(11) NOT NULL,
  `reduced_contribution_2_month` int(11) NOT NULL,
  `family_contribution_month` int(11) NOT NULL,
  `reduced_contribution_1_year` int(11) NOT NULL,
  `reduced_contribution_2_year` int(11) NOT NULL,
  `family_contribution_year` int(11) NOT NULL,
  `extra_information` text NOT NULL,
  `fees_information` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

INSERT INTO `fees` VALUES
(100, 180, 250, 1200, 2200, 3000, 'Informacje dodatkowe test', 'Informacje o składkach test');

-- --------------------------------------------------------
-- Table structure for table `gallery`
-- --------------------------------------------------------
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image_name` text NOT NULL,
  `description` varchar(50) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `position` int(11) NOT NULL DEFAULT 1,
  `category` enum('training','camp') DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

INSERT INTO `gallery` VALUES
(1, 'test_image1.jpg', 'Obóz testowy', '2025-01-01', '2025-01-01', 1, 'camp', 1),
(2, 'test_image2.jpg', 'Trening testowy', '2025-01-02', '2025-01-02', 2, 'training', 1);

ALTER TABLE `gallery` ADD PRIMARY KEY (`id`);
ALTER TABLE `gallery` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- --------------------------------------------------------
-- Table structure for table `important_posts`
-- --------------------------------------------------------
CREATE TABLE `important_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `created` date NOT NULL,
  `updated` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `important` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

INSERT INTO `important_posts` VALUES
(1, 'Testowy post ważny', 'Opis testowego posta', '2025-01-01', '2025-01-02', 1, 1, 1);

ALTER TABLE `important_posts` ADD PRIMARY KEY (`id`);
ALTER TABLE `important_posts` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- --------------------------------------------------------
-- Table structure for table `main_page_posts`
-- --------------------------------------------------------
CREATE TABLE `main_page_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `created` date NOT NULL,
  `updated` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

INSERT INTO `main_page_posts` VALUES
(1, 'Post na stronę główną', 'Opis posta testowego', '2025-01-01', '2025-01-01', 1, 1);

ALTER TABLE `main_page_posts` ADD PRIMARY KEY (`id`);
ALTER TABLE `main_page_posts` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- --------------------------------------------------------
-- Table structure for table `news`
-- --------------------------------------------------------
CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `created` date DEFAULT NULL,
  `updated` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

INSERT INTO `news` VALUES
(1, 'Aktualność testowa', 'Opis aktualności testowej', '2025-01-01', '2025-01-01', 1, 1);

ALTER TABLE `news` ADD PRIMARY KEY (`id`);
ALTER TABLE `news` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- --------------------------------------------------------
-- Table structure for table `timetable`
-- --------------------------------------------------------
CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `city` varchar(40) NOT NULL,
  `advancement_group` varchar(40) NOT NULL,
  `place` text NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `position` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

INSERT INTO `timetable` VALUES
(1, 'PON', 'Testowe Miasto', 'Początkująca', 'Sala testowa', '10:00:00', '11:00:00', 1, 1);

ALTER TABLE `timetable` ADD PRIMARY KEY (`id`);
ALTER TABLE `timetable` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- --------------------------------------------------------
-- Table structure for table `user`
-- --------------------------------------------------------
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

INSERT INTO `user` VALUES
(1, 'test', '$2y$10$brTQ3Hw6oZK5QC1K9qfj5u4gKIA4RsSyNV3b8g4cxLMHbj3do9HO.'); -- hash testowy

ALTER TABLE `user` ADD PRIMARY KEY (`id`);
ALTER TABLE `user` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;
