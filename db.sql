-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2019 at 06:42 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `training`
--
CREATE DATABASE IF NOT EXISTS `training` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `training`;

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preprovision` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateofbirth` date NOT NULL,
  `hiring_date` date NOT NULL,
  `salary` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `social_sec_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`id`, `username`, `password`, `roles`, `firstname`, `preprovision`, `lastname`, `dateofbirth`, `hiring_date`, `salary`, `social_sec_number`) VALUES
(1, 'instructor', '$2y$13$PkdMwRBPzS0HTPDSgRGMe.FDlzl7OhuHUhjM4/u9o63qZ4aNEaJWK', 'a:1:{i:0;s:15:\"ROLE_INSTRUCTOR\";}', 'Instructor', '50', 'Best', '2019-01-02', '2019-01-03', '50 euro', '2020202');

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `training_id` int(11) DEFAULT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `location` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_persons` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id`, `instructor_id`, `training_id`, `time`, `date`, `location`, `max_persons`, `member_id`) VALUES
(2, NULL, 2, '13:00:00', '2019-01-04', 'Straat 222', 33, NULL),
(3, NULL, 3, '11:00:00', '2019-01-05', 'Straat 3333', 144, NULL),
(7, NULL, 1, '09:00:00', '2019-01-31', 'Straat 3412', 20000, NULL),
(8, NULL, 1, '09:00:00', '2019-01-06', 'Tinwerf 10', 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preprovision` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateofbirth` date NOT NULL,
  `street` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `username`, `password`, `roles`, `firstname`, `preprovision`, `lastname`, `dateofbirth`, `street`, `place`) VALUES
(1, 'Michael', '$2y$13$tVij2cEVM6gb3SSm3A/s8uvJFRVPAKi993VP.x95vQsL/jFLbk/TC', 'a:1:{i:0;s:11:\"ROLE_MEMBER\";}', 'Michael', 'ho', 'Schaap', '2019-01-08', 'Ontwikkelaarstraat 3', 'Den Haag'),
(2, 'Piet', '$2y$13$tVij2cEVM6gb3SSm3A/s8uvJFRVPAKi993VP.x95vQsL/jFLbk/TC', 'a:1:{i:0;s:11:\"ROLE_MEMBER\";}', 'Michael', 'ho', 'Schaap', '2019-01-02', 'Ontwikkelaarstraat 3', 'Den Haag'),
(3, 'Anne', '$2y$13$2HTP0UrXLwYvnbSVurKDNeOuDAkUvu0JpgBV4TZsu6GtFW9cBeB6i', 'a:1:{i:0;s:11:\"ROLE_MEMBER\";}', 'Anne', 'something', 'Sand', '2019-01-31', 'Tinwerf 16', 'Amsterdam');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `payment` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `payment`, `member_id`, `lesson_id`) VALUES
(37, '4 euro', 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_costs` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`id`, `description`, `name`, `duration`, `extra_costs`, `image`) VALUES
(1, 'MMA oftwel Mixed Martial Arts is een sport dat je helpt met ...', 'MMA', '1 uur', 'Bokshandschoenen - 5 euro', '4c33e1bb6ad1f96d001c0862be2904da.jpeg'),
(2, 'Pijlboog schieten helpt jouw hand-oog coordinatie en ...', 'Pijlboog schieten', '1 uur', 'Pijlboog - 20 euro', '5af8bea9335fcdca0f6fa58ec4b66be6.png'),
(3, 'Boksen is een sport dat jouw handen gebruikt om te vechten...', 'Boksen', '1 uur', 'Bokshandschoenen - 5 euro', '9d5b6852bf4bce145d06d327b977881c.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_31FC43DDF85E0677` (`username`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F87474F38C4FC193` (`instructor_id`),
  ADD KEY `IDX_F87474F3BEFD98D1` (`training_id`),
  ADD KEY `IDX_F87474F37597D3FE` (`member_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_70E4FA78F85E0677` (`username`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_62A8A7A77597D3FE` (`member_id`),
  ADD KEY `IDX_62A8A7A7CDF80196` (`lesson_id`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `FK_F87474F37597D3FE` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`),
  ADD CONSTRAINT `FK_F87474F38C4FC193` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`id`),
  ADD CONSTRAINT `FK_F87474F3BEFD98D1` FOREIGN KEY (`training_id`) REFERENCES `training` (`id`);

--
-- Constraints for table `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `FK_62A8A7A77597D3FE` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`),
  ADD CONSTRAINT `FK_62A8A7A7CDF80196` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
