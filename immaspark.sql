-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2026 at 12:54 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `immaspark`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(999) NOT NULL,
  `class_id` int NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_dark` tinyint(1) NOT NULL DEFAULT '0',
  `is_dyslexic` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `email`, `password`, `class_id`, `is_admin`, `is_dark`, `is_dyslexic`) VALUES
(1, 'TEST1', 'test.001@ski.sch.id', 'test', 7, 1, 1, 0),
(2, 'TEST2', 'test.002@ski.sch.id', 'test2', 7, 0, 1, 0),
(3, 'admin', 'admin@ski.sch.id', 'admin', 17, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int NOT NULL,
  `name` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`) VALUES
(17, 'Guru'),
(9, 'X AKL 1'),
(10, 'X AKL 2'),
(14, 'X BiD 1'),
(1, 'X TKJ 1'),
(4, 'X TKJ 2'),
(11, 'XI AKL 1'),
(15, 'XI BiD 1'),
(2, 'XI TKJ 1'),
(5, 'XI TKJ 2'),
(7, 'XI TKJ 3'),
(12, 'XII AKL 1'),
(13, 'XII AKL 2'),
(16, 'XII BiD 1'),
(3, 'XII TKJ 1'),
(6, 'XII TKJ 2'),
(8, 'XII TKJ 3');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `post_id` int NOT NULL,
  `description` varchar(9999) NOT NULL,
  `votes` int NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `account_id`, `post_id`, `description`, `votes`, `date`) VALUES
(32, 2, 106, 'Cool', 0, '2026-05-16'),
(35, 1, 99, 'TEST', 0, '2026-05-16'),
(36, 2, 106, 'TEST', 0, '2026-05-16'),
(37, 1, 114, 'Very awesome', 0, '2026-05-16'),
(38, 1, 108, 'TEST', 0, '2026-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `comment_votes`
--

CREATE TABLE `comment_votes` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `comment_id` int NOT NULL,
  `vote` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comment_votes`
--

INSERT INTO `comment_votes` (`id`, `account_id`, `comment_id`, `vote`) VALUES
(11, 1, 22, -1),
(12, 2, 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `comment_id` int DEFAULT NULL,
  `reply_id` int DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `account_id`, `comment_id`, `reply_id`, `date`) VALUES
(9, 2, 38, NULL, '2026-05-19'),
(10, 1, 39, NULL, '2026-05-19'),
(11, 1, 40, NULL, '2026-05-19'),
(12, 1, 41, NULL, '2026-05-19'),
(13, 1, 42, NULL, '2026-05-19'),
(14, 1, 43, NULL, '2026-05-19'),
(15, 1, 44, NULL, '2026-05-19'),
(16, 1, 45, NULL, '2026-05-19'),
(17, 1, 46, NULL, '2026-05-19'),
(18, 1, 47, NULL, '2026-05-19'),
(19, 1, 48, NULL, '2026-05-19'),
(20, 1, NULL, 16, '2026-05-19'),
(21, 1, 49, NULL, '2026-05-19'),
(22, 1, 50, NULL, '2026-05-19'),
(23, 1, NULL, 19, '2026-05-19'),
(24, 1, 51, NULL, '2026-05-19'),
(25, 1, 52, NULL, '2026-05-19'),
(26, 1, 53, NULL, '2026-05-19'),
(27, 1, 54, NULL, '2026-05-19'),
(28, 1, 55, NULL, '2026-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `account_id` int NOT NULL,
  `votes` int NOT NULL DEFAULT '0',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `model_3d` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `views` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `account_id`, `votes`, `description`, `model_3d`, `date`, `views`) VALUES
(99, 'TEST', 1, 0, '<h1 style=\"text-align: center;\">Very Nice</h1>', NULL, '2026-05-14', 2),
(100, 'TEST1', 1, 3, '<p>TEST1</p>', NULL, '2026-05-15', 2),
(106, 'Beautiful Landscape', 1, -1, '<p>Just a photo of a simple scenery.</p>', NULL, '2026-05-15', 2),
(108, 'NOTIF TEST', 2, 0, '<p>NOTIF TEST</p>', NULL, '2026-05-16', 2),
(109, '3D test', 1, 1, '<p>3D viewer test</p>', 'model_6a08708abc255.glb', '2026-05-16', 3),
(111, 'testtttt', 1, 0, '<p>test</p>', NULL, '2026-05-16', 1),
(112, 'test223', 1, 0, '<p>test</p>', NULL, '2026-05-16', 1),
(114, 'Test 3D', 1, 0, '<p>1 jam kerja ini jak</p>', 'model_6a0935e76cc5f.glb', '2026-05-16', 2),
(116, 'TEWDADWAD', 2, 0, '<p><span style=\"color: #e03e2d;\">TEASDW</span></p>', NULL, '2026-05-20', 1),
(117, 'teseewadaw', 2, 0, '<p>dwdwad</p>', NULL, '2026-05-20', 1),
(118, 'TEST 3D TANPA IMAGE', 1, 0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus dictum ornare urna ac porta. Sed feugiat at velit ut ullamcorper. Pellentesque sit amet nisl eu orci interdum semper in vel neque. Duis faucibus nulla magna, in sagittis neque aliquet vitae. Sed eu justo urna. Cras euismod aliquet velit, a consequat massa porta et. Ut eu convallis sem.</p>\r\n<p>Nulla egestas in diam sed volutpat. Nullam convallis augue dui, ut dapibus ipsum molestie vitae. In justo mauris, rhoncus vitae nibh id, mattis viverra erat. Nulla sed elementum ante. In feugiat, urna in efficitur semper, nibh erat efficitur lectus, eget sagittis nibh leo vitae metus. Vivamus blandit interdum finibus. Proin tempor et metus nec tempor. Praesent at purus nec augue egestas elementum id nec risus. Phasellus fermentum dui ac posuere fringilla. Etiam enim lectus, feugiat varius purus sit amet, varius sagittis ex. Morbi nec lacus a mauris hendrerit elementum sit amet vel tortor. Nam pellentesque risus a diam elementum, non tempus eros semper. Donec lobortis, arcu et accumsan aliquet, erat diam feugiat sapien, varius lobortis nisl mauris ut augue.</p>', 'model_6a0d4b6c5258d.glb', '2026-05-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_imgs`
--

CREATE TABLE `post_imgs` (
  `id` int NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_imgs`
--

INSERT INTO `post_imgs` (`id`, `file_name`, `post_id`) VALUES
(16, 'post_6a065dd85aebf8.04040176.jpg', 99),
(17, 'post_6a065dda435fa5.71599202.jpg', 99),
(18, 'post_6a065ddb58dde2.42505819.jpg', 99),
(25, 'post_6a06fe71ba094.webp', 106),
(27, 'post_6a086eb733dfb.webp', 109),
(29, 'post_6a092b4d81214.webp', 109),
(30, 'post_6a092b50d1f01.webp', 109),
(31, 'post_6a093566b7c1d.webp', 114),
(32, 'post_6a093569a0f72.webp', 114);

-- --------------------------------------------------------

--
-- Table structure for table `post_links`
--

CREATE TABLE `post_links` (
  `id` int NOT NULL,
  `link` varchar(255) NOT NULL,
  `link_text` varchar(255) DEFAULT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_links`
--

INSERT INTO `post_links` (`id`, `link`, `link_text`, `post_id`) VALUES
(21, 'https://youtu.be/wcaZcbain2s?si=J8f6RFpUjUOGdi9K', 'Test', 99),
(32, 'https://youtu.be/FV_-8DWuq5w?si=Vo6Knuke7H3GC1-c', 'Ploho - Вечер грустных пар', 109);

-- --------------------------------------------------------

--
-- Table structure for table `post_views`
--

CREATE TABLE `post_views` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_views`
--

INSERT INTO `post_views` (`id`, `account_id`, `post_id`) VALUES
(41, 1, 99),
(43, 1, 100),
(48, 1, 106),
(53, 1, 108),
(55, 1, 109),
(57, 1, 111),
(58, 1, 112),
(60, 1, 114),
(67, 1, 118),
(42, 2, 99),
(50, 2, 100),
(52, 2, 106),
(51, 2, 108),
(64, 2, 109),
(63, 2, 114),
(65, 2, 116),
(66, 2, 117),
(62, 3, 109);

-- --------------------------------------------------------

--
-- Table structure for table `post_votes`
--

CREATE TABLE `post_votes` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `post_id` int NOT NULL,
  `vote` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_votes`
--

INSERT INTO `post_votes` (`id`, `account_id`, `post_id`, `vote`) VALUES
(29, 1, 99, 1),
(30, 2, 99, -1),
(32, 1, 100, 1),
(34, 2, 106, -1),
(35, 2, 100, 1),
(36, 2, 109, 1);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `post_id` int NOT NULL,
  `comment_id` int NOT NULL,
  `description` varchar(9999) NOT NULL,
  `votes` int NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `account_id`, `post_id`, `comment_id`, `description`, `votes`, `date`) VALUES
(33, 1, 114, 37, 'TEST', 0, '2026-05-20');

-- --------------------------------------------------------

--
-- Table structure for table `reply_votes`
--

CREATE TABLE `reply_votes` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `reply_id` int NOT NULL,
  `vote` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reply_votes`
--

INSERT INTO `reply_votes` (`id`, `account_id`, `reply_id`, `vote`) VALUES
(6, 1, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `color_top` varchar(6) NOT NULL,
  `color_bottom` varchar(6) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `color_top`, `color_bottom`, `icon`, `post_id`) VALUES
(48, 'Test', '00fff0', '0083fe', 'lock', 99),
(58, 'Scenery', '00F260', '0575E6', 'happy', 106),
(62, 'Pinned', 'FFD700', 'FFA500', 'star', 106),
(72, '3D', 'B5B9FF', '2B2C49', 'cube', 109),
(74, '3Dih', 'fdcf58', 'ff0000', 'cube', 114),
(75, 'Pinned', 'FFD700', 'FFA500', 'star', 109),
(76, 'wada', '81ff8a', 'ff0000', 'archive', 117),
(77, 'Test', 'fdcf58', 'ff0000', 'clipboard', 117),
(78, 'wdadasfw', '81ff8a', 'ff0000', 'tag', 117),
(79, 'Test', '81ff8a', 'ff0000', 'tag', 117),
(80, 'Pinned', 'FFD700', 'FFA500', 'star', 118);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment_votes`
--
ALTER TABLE `comment_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_comment` (`account_id`,`comment_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `post_imgs`
--
ALTER TABLE `post_imgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_links`
--
ALTER TABLE `post_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_views`
--
ALTER TABLE `post_views`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_post` (`account_id`,`post_id`);

--
-- Indexes for table `post_votes`
--
ALTER TABLE `post_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_post` (`account_id`,`post_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reply_votes`
--
ALTER TABLE `reply_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_reply` (`account_id`,`reply_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `comment_votes`
--
ALTER TABLE `comment_votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `post_imgs`
--
ALTER TABLE `post_imgs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `post_links`
--
ALTER TABLE `post_links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `post_views`
--
ALTER TABLE `post_views`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `post_votes`
--
ALTER TABLE `post_votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `reply_votes`
--
ALTER TABLE `reply_votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
