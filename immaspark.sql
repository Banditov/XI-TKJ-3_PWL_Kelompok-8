-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2026 at 04:25 PM
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
(1, 'test', 'test@test', 'test', 7, 1, 1, 0);

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
(1, 1, 1, 'Testststs', 0, '2026-05-08'),
(2, 1, 1, 'test agi', 0, '2026-05-08'),
(3, 1, 1, 'aye', 0, '2026-05-08'),
(5, 1, 1, 'bruh', 1, '2026-05-09');

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
(1, 1, 5, 1);

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
  `date` date NOT NULL,
  `views` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `account_id`, `votes`, `description`, `date`, `views`) VALUES
(1, 'TEST1', 1, 124, 'TEST SATU', '2026-04-22', 1),
(2, 'TEST2', 1, -122, 'TEST KEDUA', '2026-04-22', 1),
(9, 'Creaedadw', 1, 1, '<h1><em>Enter your</em><strong><span style=\"color: #ba372a;\"><em> idea</em> h</span>ere!</strong></h1>', '2026-05-04', 1),
(19, 'testtete', 1, 0, '<h1>tet<span style=\"color: #ba372a;\">s<em>ttetewdd</em></span></h1>', '2026-05-05', 1),
(20, 'Testttbro', 1, 0, '<p>d</p>', '2026-05-09', 1);

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
(1, 'posttest.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_links`
--

CREATE TABLE `post_links` (
  `id` int NOT NULL,
  `link` varchar(255) NOT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_links`
--

INSERT INTO `post_links` (`id`, `link`, `post_id`) VALUES
(1, 'www.test.com', 1);

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
(8, 1, 1),
(9, 1, 2),
(1, 1, 9),
(7, 1, 19),
(10, 1, 20);

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
(5, 1, 9, 1),
(6, 1, 2, 1),
(8, 1, 1, 1);

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
(1, 1, 1, 1, 'yo', 0, '2026-05-08'),
(2, 1, 1, 2, 'test', 0, '2026-05-08'),
(3, 1, 1, 1, 'testtttt', 0, '2026-05-08'),
(4, 1, 1, 1, 'wdwdw', 0, '2026-05-09'),
(5, 1, 1, 2, 'lmao', 0, '2026-05-09'),
(6, 1, 1, 1, 'testst', 0, '2026-05-09');

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
(1, 'Test', '313131', '8a8a8a', 'tag', 1),
(5, 'adawdad', 'FC466B', '3F5EFB', '', 9),
(6, 'tete', 'FC466B', '3F5EFB', '', 19),
(7, 'TEST', 'FC466B', '3F2B96', '', 20);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comment_votes`
--
ALTER TABLE `comment_votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `post_imgs`
--
ALTER TABLE `post_imgs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_links`
--
ALTER TABLE `post_links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_views`
--
ALTER TABLE `post_views`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_votes`
--
ALTER TABLE `post_votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reply_votes`
--
ALTER TABLE `reply_votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
