-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 08, 2024 at 03:49 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `das_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userid` bigint NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('CEO','Co-CEO','StarMember') NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `join_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `username`, `email`, `password`, `role`, `first_name`, `last_name`, `title`, `profile_image`, `join_date`) VALUES
(1, 1, 'ceo_user', 'contacthridoyjomadder@gmail.com', '$2y$10$ywQFtjdADjYwr96nmY4OO.KYSquGu0TV6qLnPbx2lgMcClj/vo0A.', 'CEO', 'Hridoy', 'Jomadder', 'CEO', '659ac3c6a0726_user.jpg', '2024-01-01'),
(2, 2, 'coceo_user', 'tuba@gmail.com', '$2y$10$3fZPS9OWSk87kPSsUVe3jOsyCoklqkclJX172kemfEMrweRLXLWBq', 'Co-CEO', 'Tuba', 'Islam', 'Co-CEO', 'coceo_profile.jpg', '2024-01-02'),
(3, 3, 'starmember_user', 'reza@gmail.com', '$2y$10$3fZPS9OWSk87kPSsUVe3jOsyCoklqkclJX172kemfEMrweRLXLWBq', 'StarMember', 'Reza', 'Islam', 'Star Member', 'starmember_profile.jpg', '1900-01-03');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
