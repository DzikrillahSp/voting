-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 01:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evoting`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `candidate_id` int(11) NOT NULL,
  `candidate_name` varchar(100) NOT NULL,
  `candidate_description` text NOT NULL,
  `candidate_photo` text NOT NULL,
  `candidate_video` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`candidate_id`, `candidate_name`, `candidate_description`, `candidate_photo`, `candidate_video`) VALUES
(7, 'Candidate for Chairman of the Organization 1 - Vice Chairman of the Organization 1', '<p><strong>Vision</strong></p><ul><li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li><li>tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</li><li>quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</li><li>consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse</li><li>cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non</li><li>proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li></ul><p><strong>Mission</strong></p><ul><li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li><li>tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</li><li>quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</li><li>consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse</li><li>cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non</li><li>proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li></ul>', '929-logo msu.png', ''),
(8, 'Candidate for Chairman of the Organization 2 - Vice Chairman of the Organization 2', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '164-logo msu.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name` varchar(70) NOT NULL,
  `faculty_short` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`faculty_id`, `faculty_name`, `faculty_short`) VALUES
(1, 'No Faculty', 'No Faculty'),
(7, 'Faculty of Information Sciences & Engineering ', 'FISE'),
(8, 'Faculty of Business Management and Professional Studies ', 'FBMP'),
(9, 'Centre for Fundamental Studies', 'CFS'),
(10, 'Faculty of Health and Life Sciences', 'FHLS'),
(11, 'Graduate School of Management', 'GSM'),
(12, 'International Medical School ', 'IMS'),
(13, 'School of Education and Social Sciences ', 'SESS'),
(14, 'School of Graduate Studies', 'SGS'),
(15, 'School of Hospitality and Creative Arts ', 'SHCA'),
(16, 'School of Pharmacy ', 'SPH');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id_setting` int(11) NOT NULL,
  `setting_school_name` varchar(100) NOT NULL,
  `setting_description` text NOT NULL,
  `setting_keyword` text NOT NULL,
  `setting_favicon` text NOT NULL,
  `setting_email` varchar(50) NOT NULL,
  `setting_phone_number` varchar(50) NOT NULL,
  `setting_url` text NOT NULL,
  `setting_type` enum('osis','presma') NOT NULL,
  `setting_schedule` enum('open','closed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id_setting`, `setting_school_name`, `setting_description`, `setting_keyword`, `setting_favicon`, `setting_email`, `setting_phone_number`, `setting_url`, `setting_type`, `setting_schedule`) VALUES
(1, 'Organization Name Test', 'This E-Voting website aims to make it easier for students to vote online and in real time.', 'evoting, voting, chairman election, online voting', '977-logo msu.png', 'dzikrillah454@gmail.com', '0107655120', 'www.example.com', 'presma', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user_username` varchar(100) NOT NULL,
  `user_password` text NOT NULL,
  `user_nama` varchar(100) NOT NULL,
  `user_role` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `user_username`, `user_password`, `user_nama`, `user_role`) VALUES
(1, 'ilhambudiawan', '21232f297a57a5a743894a0e4a801fc3', 'Ilham Budiawan Sitorus', 'admin'),
(2, 'petugas', 'afb91ef692fd08c445e8cb1bab2ccf9c', 'Petugas', 'petugas'),
(7, 'dzikrillah', '888b65dafb7a68470bb721fa7a4b44a4', 'dzikrillah', 'admin'),
(8, 'TESTUSER', '827ccb0eea8a706c4c34a16891f84e7b', 'Test', 'admin'),
(9, 'royhan', '827ccb0eea8a706c4c34a16891f84e7b', 'Royhan', 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `voter`
--

CREATE TABLE `voter` (
  `id_voter` int(11) NOT NULL,
  `voter_nis` varchar(100) NOT NULL,
  `voter_name` varchar(100) NOT NULL,
  `voter_faculty` int(11) NOT NULL,
  `voter_phone_number` varchar(100) NOT NULL,
  `voter_email` varchar(100) NOT NULL,
  `voter_status` enum('0','1') NOT NULL,
  `voter_code` varchar(50) NOT NULL,
  `verification` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voter`
--

INSERT INTO `voter` (`id_voter`, `voter_nis`, `voter_name`, `voter_faculty`, `voter_phone_number`, `voter_email`, `voter_status`, `voter_code`, `verification`) VALUES
(23, '012023090093', 'Fairuz', 7, '', 'muhammadfairuz525@gmail.com', '0', 'ADBFT', 0),
(25, '012023090094', 'candra', 8, '', '', '1', 'NIS8H', 0),
(26, '012023090099', 'farah', 8, '', 'dzikrillah454@gmail.com ', '0', 'VS7ZK', 0),
(27, '012023090090', 'dzikrillah', 7, '', 'dzikrillahsp@gmail.com', '1', 'NXAD9', 0),
(29, '02802808018', 'putra', 7, '', '', '0', 'ONEB3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `voter_votes`
--

CREATE TABLE `voter_votes` (
  `id_vote` int(11) NOT NULL,
  `vote_candidate_id` int(11) NOT NULL,
  `vote_voter_id` int(11) NOT NULL,
  `vote_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voter_votes`
--

INSERT INTO `voter_votes` (`id_vote`, `vote_candidate_id`, `vote_voter_id`, `vote_time`) VALUES
(15, 8, 25, '2024-04-29 23:40:32'),
(16, 7, 27, '2024-05-23 16:37:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`candidate_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `voter`
--
ALTER TABLE `voter`
  ADD PRIMARY KEY (`id_voter`);

--
-- Indexes for table `voter_votes`
--
ALTER TABLE `voter_votes`
  ADD PRIMARY KEY (`id_vote`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `voter`
--
ALTER TABLE `voter`
  MODIFY `id_voter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `voter_votes`
--
ALTER TABLE `voter_votes`
  MODIFY `id_vote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
