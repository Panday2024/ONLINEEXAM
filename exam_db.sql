-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 07, 2021 at 10:18 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `mcq`
--

DROP TABLE IF EXISTS `mcq`;
CREATE TABLE IF NOT EXISTS `mcq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `choices` json NOT NULL,
  `answer` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mcq_subjects_id` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mcq`
--

INSERT INTO `mcq` (`id`, `question`, `choices`, `answer`, `subject_id`) VALUES
(1, 'What is the capital of China?', '[\"Shengai\", \"Beijing\", \"Tokyo\", \"Delhi\"]', 2, 1),
(3, 'What is 5 + 3?', '[\"4\", \"6\", \"7\", \"8\"]', 4, 4),
(4, 'Which is the longest river in Africa?', '[\"dsafa\", \"Saddsa\", \"Nile\", \"asdfa\"]', 3, 1),
(5, 'Who formulated e = mc^2?', '[\"Mark Robinson\", \"Albert Cameu\", \"Michio Kaku\", \"Albert Einstein\"]', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`) VALUES
(1, 'General Knowledge'),
(3, 'Science'),
(4, 'Math'),
(5, 'Geography'),
(6, 'History');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `examinee_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `test_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_marks` int(11) NOT NULL,
  `secured_marks` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tests_users_examinee_id` (`examinee_id`),
  KEY `tests_subjects_id` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `examinee_id`, `subject_id`, `test_date`, `total_marks`, `secured_marks`) VALUES
(8, 2, 1, '2021-05-07 09:39:48', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'examinee',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `type`) VALUES
(1, 'codegenes', 'codegenes@gmail.com', '$2y$10$F0s8zhRLtjLMZVodKdTZhuvIeoEbUUIaWvt6R3qS2XsLtWAdt.Tae', 'examinee'),
(2, 'admin', 'admin@gmail.com', '$2y$10$ek57JlAgAzW52bjMjgurruZ2cG9eDxa7iI0iEr4BLKrxO9pOM/TMK', 'examiner');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mcq`
--
ALTER TABLE `mcq`
  ADD CONSTRAINT `mcq_subjects_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_subjects_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `tests_users_examinee_id` FOREIGN KEY (`examinee_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
