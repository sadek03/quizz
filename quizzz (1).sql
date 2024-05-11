-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2024 at 05:21 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizzz`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `status` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`, `status`, `image`, `created_at`) VALUES
(1, 'Programming', 'Programming is fun', 'active', 'icons/code-icon-design-vector-png_125856.jpg', '2023-11-08 09:27:46'),
(2, 'hassan', 'test', 'active', 'icons/f.jpg', '2024-01-06 13:34:46'),
(3, 'imdad ', 'pula', 'active', 'icons/WhatsApp Image 2024-01-05 at 20.49.22_d6c68a5f.jpg', '2024-01-06 13:38:13');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `test_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `answer`, `test_id`, `created_at`) VALUES
(1, ' What does HTML stand for?', ' Hyper Text Markup Language', 'Hyperlink Text Markup Language', ' Hyper Text Markup Language', 'Hyperlink Markup Language', 'option_a', '1', '2023-11-08 14:59:37'),
(2, 'Which tag is used to define the main heading of a web page?', ' <h1>', ' <h2>', ' <h3>', ' <h4>', 'option_a', '1', '2023-11-08 15:00:00'),
(3, 'Which tag is used to create a line break?', ' <br>', ' <hr>', ' <p>', ' <div>', 'option_a', '1', '2023-11-08 15:00:22'),
(4, ' Which tag is used to create an ordered list?', '<ul>', ' <ol>', ' <li>', '<dl>', 'option_b', '1', '2023-11-08 15:00:45'),
(5, 'what is the color of mango', 'red', 'grr', 'ghj', 'hhbnj', 'option_a', '3', '2024-01-06 19:06:05'),
(6, 'zxvsfvbsvAfQW1111', '222', '333', '2111', 'yttw', 'option_c', '4', '2024-01-06 19:09:53'),
(7, '3434434', 'dfdfdf', 'asassaas', 'cvcvcvc', 'bnnbnbn', 'option_c', '4', '2024-01-06 19:10:24'),
(8, 'bbnbnnbn', '11', '22', '33', '44', 'option_a', '4', '2024-01-06 19:10:50');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `status` varchar(255) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `title`, `description`, `status`, `category_id`, `created_at`) VALUES
(1, 'HTML', 'HTML', 'active', '1', '2023-11-08 09:28:03'),
(2, 'CSS', 'CSS', 'active', '1', '2023-11-08 09:28:09'),
(3, 'ttt', 'ddfghj', 'active', '2', '2024-01-06 13:35:19'),
(4, 'hsbueyfvb', 'svdsf', 'active', '3', '2024-01-06 13:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `test_records`
--

CREATE TABLE `test_records` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `test_id` varchar(255) NOT NULL,
  `record_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'incomplete',
  `attempted_questions` varchar(255) NOT NULL DEFAULT '0',
  `skipped_questions` varchar(255) NOT NULL DEFAULT '0',
  `correct_answers` varchar(255) NOT NULL DEFAULT '0',
  `wrong_answers` varchar(255) NOT NULL DEFAULT '0',
  `marks_obtained` varchar(255) NOT NULL DEFAULT '0',
  `attmp_question_ids` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_records`
--

INSERT INTO `test_records` (`id`, `user_id`, `test_id`, `record_id`, `status`, `attempted_questions`, `skipped_questions`, `correct_answers`, `wrong_answers`, `marks_obtained`, `attmp_question_ids`, `created_at`) VALUES
(12, '5', '1', 'PP_7222814489', 'completed', '4', '0', '3', '3', '6', '1, 3, 4, 2', '2023-11-16 15:04:00'),
(13, '5', '1', 'PP_5901854149', 'completed', '4', '0', '3', '1', '6', '2, 4, 1, 3', '2023-11-16 15:09:51'),
(14, '5', '1', 'PP_3390218872', 'completed', '4', '0', '4', '0', '8', '2, 4, 3, 1', '2023-11-16 15:13:27'),
(15, '5', '1', 'PP_185569450', 'completed', '4', '0', '1', '3', '2', '3, 2, 4, 1', '2023-11-16 15:35:58'),
(16, '5', '1', 'PP_4772302391', 'completed', '4', '0', '2', '2', '4', '1, 4, 3, 2', '2023-11-16 15:38:09'),
(17, '5', '1', 'PP_9111945066', 'completed', '4', '2', '0', '2', '0', '3, 1, 4, 2', '2023-11-16 15:40:23'),
(18, '5', '1', 'PP_4913257991', 'completed', '4', '2', '1', '1', '2', '1, 3, 4, 2', '2023-11-16 15:41:14'),
(19, '5', '1', 'PP_6361185403', 'completed', '5', '5', '0', '0', '0', '3, 1, 2, 4, 4', '2023-11-16 15:44:00'),
(20, '5', '1', 'PP_5951357636', 'completed', '89', '1', '87', '1', '174', '3, 1, 4, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2', '2023-11-17 15:35:53'),
(21, '5', '1', 'PP_3880884388', 'completed', '4', '0', '1', '3', '2', '3, 3, 4, 2', '2023-11-17 15:38:46'),
(22, '5', '1', 'PP_1897744555', 'completed', '112', '2', '109', '1', '218', '1, 1, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 2', '2023-11-17 15:39:07'),
(23, '6', '1', 'PP_833714084', 'completed', '4', '0', '2', '2', '4', '3, 4, 2, 1', '2023-11-18 15:17:38'),
(24, '5', '1', 'PP_8439967760', 'completed', '4', '1', '1', '2', '2', '4, 1, 3, 2', '2023-11-18 15:23:56'),
(25, '5', '3', 'PP_4038513706', 'completed', '1', '0', '1', '0', '2', '5', '2024-01-06 19:06:34'),
(26, '5', '4', 'PP_3188822917', 'completed', '3', '0', '1', '2', '2', '8, 7, 6', '2024-01-06 19:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `status`, `created_at`) VALUES
(5, 'Imdad', 'imdad@penprogrammer.com', '3456789000', 'Imdad', 'admin', '2023-10-31 15:35:25'),
(6, 'Sadek', 'sa@gmail.com', '3456780', 'imdad', 'active', '2023-10-31 15:50:32'),
(7, 'hasan', 'shahariah33@gmail.com', '9494802774', 'imdadpula@1', 'active', '2024-01-06 19:16:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_records`
--
ALTER TABLE `test_records`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test_records`
--
ALTER TABLE `test_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
