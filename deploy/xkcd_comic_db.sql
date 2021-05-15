-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2021 at 06:25 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xkcd_comic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `sub_id` int(11) NOT NULL,
  `subscriber_name` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `OTP` text DEFAULT NULL,
  `unsubscribe_URL` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`sub_id`, `subscriber_name`, `email`, `is_activated`, `OTP`, `unsubscribe_URL`, `created_at`) VALUES
(7, 'Varad Patil', 'varadrpatil27@gmail.com', 0, '206000', 'f8f86f4b6099ca09fed831fb09a02b09', '2021-05-08 10:03:00'),
(10, 'Varad Patil', 'varadrpatil27@gmail.com1', 1, NULL, 'a1b8f2b0d2d5fd7f96011ddc439a7e25', '2021-05-08 10:19:26'),
(11, '', 'varadrpatil27@gmail.com2', 0, '937577', '58b29bd60a7429a3dfceb8294fddd8d9', '2021-05-08 15:42:14'),
(12, 'Varad Patil', 'varadrpatil27@gmail.com3', 1, NULL, '976a614d6d72064a44fab74a1b930ea2', '2021-05-08 15:44:02'),
(13, 'Varad Patil', 'varadrpatil27@gmail.com5', 0, NULL, '4', '2021-05-08 15:55:58'),
(14, '', 'varadrpatil27@gmail.com6', 0, '736256', '5', '2021-05-08 15:56:59'),
(15, '', 'varadrpatil227@gmail.com', 0, '740504', '6', '2021-05-08 15:57:48'),
(17, 'Varad Patil', 'test@test.test', 1, NULL, '7', '2021-05-09 03:10:31'),
(24, '', 'varadrpatil27@gmail.com4', 0, '327183', '65d6ec4d8510831bb724a305c5a768dd', '2021-05-09 06:45:11'),
(25, 'Varad Patil', 'varadrpatil27@gmail.com10', 0, NULL, '145160ea7bf71e4ef780a63af6fbaed3', '2021-05-09 06:46:53'),
(26, 'Varad Patil', 'varadrpatil27@gmail.com11', 0, NULL, 'bb37f3e0484565af4f58fffbb18cdf63', '2021-05-09 06:47:55'),
(27, 'Varad Patil', 'varadrpatil27@gmail.com12', 0, NULL, '3610b82469ef672485838fa27f8f0a14', '2021-05-09 06:51:22'),
(28, 'Hritik Lodu', 'kotharihritik1@gmail.com', 1, NULL, 'b6e268337f3b92317ee1ff8f5542425d', '2021-05-13 15:12:12'),
(29, 'Varad Patil1', 'varadrpatil271@gmail.com', 1, NULL, 'd9521fa712e1aab96a3eb48ed33d6f72', '2021-05-13 15:14:47'),
(30, 'Varad Patil', 'varadpatil@gmail.com', 1, NULL, '5a3d6393b65e8c55ee5513893f7ccf9d', '2021-05-15 07:03:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`sub_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
