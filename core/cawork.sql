-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2021 at 12:54 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cawork`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities_db`
--

CREATE TABLE `activities_db` (
  `id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  `reg_id` int(11) NOT NULL,
  `activity_title` varchar(50) NOT NULL,
  `activity_description` varchar(500) NOT NULL,
  `activity_date_start` varchar(50) NOT NULL,
  `activity_date_end` varchar(50) NOT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activities_db`
--

INSERT INTO `activities_db` (`id`, `training_id`, `reg_id`, `activity_title`, `activity_description`, `activity_date_start`, `activity_date_end`, `delete_flg`) VALUES
(1, 31, 28, 'Dope Work', 'Create a dope work', '2021-08-27T09:59', '2021-08-27T10:00', 0),
(2, 31, 28, 'New Dope Work', 'New dope work', '2021-08-28T10:00', '2021-08-28T11:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `clientid` int(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `age` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientid`, `firstname`, `lastname`, `middlename`, `birthday`, `age`, `address`, `username`, `password`) VALUES
(1, 'Kenny', 'Jepollo', 'Montesa', '2021-02-28', '20', 'wellington tanza cavite', 'johnkieffer15', '12345'),
(3, 'john kieffer', 'jepollo', 'buenavides', '2021-01-15', '3', 'wellington residences tanza', 'jk@gmail.com', 'johnkieffer'),
(4, 'john kieffer', 'kieffer', 'buenavides', '2021-02-27', '3', 'wellington residences tanza', 'jk@gmail.comss', 'johnkieffer'),
(7, 'Jewelson', 'Esteron', 'Del Mundo', '1999-07-24', '21', 'Cavite', 'east', 'a'),
(8, 'john kieffer', 'jepollo', 'buenavides', '2021-02-10', '3', 'wellington residences tanza', 'ken', 'a'),
(9, 'Test 1', 'Test', 'Test', '7070-07-07', '3', 'wellington residences tanza', 'ken', 'q'),
(10, 'try1', 'try1', 'try1', '2021-02-26', '9', 'wellington residences tanza', 'qwerty', 'asd'),
(11, 'try2', 'try2', 'try2', '2021-03-05', '21', 'Cavite', 'ken', 'asd'),
(12, 'try2', 'try2', 'try2', '2021-03-05', '21', 'Cavite', 'ken', 'asd'),
(13, 'asd', 'asd', 'asd', '2021-03-03', 'asd', 'asd', 'asd', 'sad'),
(14, '', '', '', '0000-00-00', '', '', '', ''),
(15, '', '', '', '0000-00-00', '', '', '', 'asdsad'),
(16, 'Donn Frederick', 'Lucas', 'Vidad', '1999-08-02', '21', 'B7 Lt7 Hoteliers Village 2, Bucandala 5, Imus City, Cavite', 'donnfredericklucas@gmail.com', 'JonnaMarie26');

-- --------------------------------------------------------

--
-- Table structure for table `events_db`
--

CREATE TABLE `events_db` (
  `id` int(11) NOT NULL,
  `reg_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `training_type` varchar(50) NOT NULL,
  `training_price` int(11) NOT NULL,
  `mode_of_payment` varchar(50) NOT NULL,
  `date_start` varchar(50) NOT NULL,
  `participants` int(11) NOT NULL,
  `field` varchar(50) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `payment_description` varchar(500) NOT NULL,
  `payment_start_date` varchar(50) NOT NULL,
  `payment_end_date` varchar(50) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flg` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events_db`
--

INSERT INTO `events_db` (`id`, `reg_id`, `title`, `description`, `training_type`, `training_price`, `mode_of_payment`, `date_start`, `participants`, `field`, `platform`, `payment_description`, `payment_start_date`, `payment_end_date`, `visible`, `delete_flg`, `created`) VALUES
(1, 28, 'TI10', '35m price pool', '', 0, '', '', 0, '', '', '', '', '', 1, 2, '2021-08-26 09:11:52'),
(2, 28, 'TI10', '35m Price Pool', '', 0, '', '', 0, '', '', '', '', '', 1, 2, '2021-08-26 09:11:52'),
(3, 28, 'TI10', '35m Price Pool', '', 0, '', '', 0, '', '', '', '', '', 1, 2, '2021-08-26 09:11:52'),
(4, 28, 'TI11', '35m Price Pool', '', 0, '', '', 0, '', '', '', '', '', 1, 2, '2021-08-26 09:11:52'),
(5, 28, 'TI10', '35m Price Pool', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-26 09:11:52'),
(6, 28, 'TechBuild', 'Perspective of a new world', 'Face to face', 0, 'Bank', '', 0, '', '', '', '', '', 1, 2, '2021-08-26 09:11:52'),
(7, 28, 'TechBuild', 'A path through modern technology', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-26 09:11:52'),
(8, 28, 'Innovate', 'Seminar', 'Face to face', 500, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-26 09:11:52'),
(9, 28, 'Innov8', 'For future innovations seminar', 'Face to face', 350, 'GCash', '2021-08-28', 25, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-26 09:22:22'),
(10, 9, 'Innov8', 'Now', 'Face to face', 2, 'Paypal', '2022-01-01', 1, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:41:09'),
(11, 9, 'Innov8', 'Now', 'Face to face', 2, 'Paypal', '2022-01-01', 1, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:41:10'),
(12, 9, 'Innov8', 'Now', 'Face to face', 2, 'Paypal', '2022-01-01', 1, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:41:13'),
(13, 9, 'Innov8', 'Now', 'Face to face', 2, 'Paypal', '2022-01-01', 1, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:41:14'),
(14, 9, 'Innov8', 'Now', 'Face to face', 2, 'Paypal', '2022-01-01', 1, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:41:17'),
(15, 9, 'Innov8', 'Now', 'Face to face', 2, 'Paypal', '2022-01-01', 1, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:41:18'),
(16, 28, 'Innov8', 'Innovation Seminar', 'Face to face', 350, 'GCash', '2021-08-28', 25, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:44:21'),
(17, 28, 'Innov8', 'Innovation Seminar', 'Face to face', 350, 'GCash', '2021-08-28', 25, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:44:34'),
(18, 28, 'Innov8', 'Innovation Seminar', 'Face to face', 350, 'GCash', '2021-08-28', 25, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:45:29'),
(19, 28, 'Innov8', 'Innovation Seminar', 'Face to face', 350, 'GCash', '2021-08-28', 25, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:45:42'),
(20, 19, '', '', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-27 01:52:55'),
(21, 19, '', '', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-27 01:53:04'),
(22, 19, '', '', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-27 01:53:25'),
(23, 19, '', '', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-27 01:54:21'),
(24, 19, '', '', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-27 01:54:42'),
(25, 19, '', '', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-27 01:56:17'),
(26, 19, '', '', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-27 01:56:27'),
(27, 19, '', '', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-27 01:56:29'),
(28, 19, '', '', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-27 01:56:31'),
(29, 19, '', '', 'Face to face', 0, 'GCash', '', 0, '', '', '', '', '', 1, 2, '2021-08-27 01:56:31'),
(30, 19, 'Innov8', 'Innovation Training', 'Face to face', 350, 'GCash', '2021-08-28', 25, 'IT', 'Skype', '', '', '', 1, 2, '2021-08-27 01:58:00'),
(31, 28, 'Innov8', 'Innovation Training', 'Face to face', 350, 'GCash', '2021-09-10', 25, 'IT', 'Skype', 'Please pay immediately', '', '', 1, 0, '2021-08-27 02:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `events_participants_db`
--

CREATE TABLE `events_participants_db` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `reg_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flg` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events_participants_db`
--

INSERT INTO `events_participants_db` (`id`, `event_id`, `reg_id`, `status`, `created_at`, `delete_flg`) VALUES
(1, 5, 26, 0, '2021-08-13 14:05:41', 1),
(2, 5, 50, 0, '2021-08-14 02:47:49', 1),
(3, 7, 26, 0, '2021-08-20 14:10:05', 1),
(4, 7, 50, 1, '2021-08-20 14:52:27', 1),
(5, 7, 26, 2, '2021-08-20 15:28:41', 1),
(6, 31, 50, 1, '2021-08-27 06:36:31', 1),
(7, 31, 50, 1, '2021-08-27 08:06:01', 1),
(8, 31, 26, 1, '2021-08-27 09:30:26', 1),
(9, 31, 50, 2, '2021-08-28 04:18:40', 1),
(10, 31, 26, 2, '2021-08-28 04:18:53', 1),
(11, 31, 26, 0, '2021-09-08 08:51:53', 1),
(12, 31, 50, 1, '2021-09-08 09:05:10', 1),
(13, 31, 50, 1, '2021-09-09 13:00:33', 1),
(14, 31, 50, 1, '2021-09-09 13:02:05', 1),
(15, 31, 50, 1, '2021-09-09 13:19:47', 1),
(16, 31, 50, 1, '2021-09-09 13:21:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `freelance`
--

CREATE TABLE `freelance` (
  `flid` int(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `age` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `skills` varchar(100) NOT NULL,
  `deleted` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `freelance`
--

INSERT INTO `freelance` (`flid`, `firstname`, `lastname`, `middlename`, `birthday`, `age`, `address`, `skills`, `deleted`) VALUES
(1, 'Kenny', 'jepollo', 'Montesa', '2021-02-09', '23', 'tanza cavite', 'taga tapon s', ''),
(2, 'michael', 'kenny', 'jepollo', '2021-02-03', '20', 'wellington tanza cavite', 'taga luto ', '1'),
(3, 'Kenny', 'jepollo', 'Montesa', '2021-02-09', '23', 'tanza cavite', 'taga tapon ng', ''),
(4, 'john', 'kieffer', 'jepollo', '2021-02-03', '3', 'wellington residences tanza', 'programmers', ''),
(5, 'john kieffer', 'jepollo', 'buenavides', '2021-02-27', '3', 'wellington residences tanza', 'programmer', '');

-- --------------------------------------------------------

--
-- Table structure for table `issues_db`
--

CREATE TABLE `issues_db` (
  `id` int(11) NOT NULL,
  `until` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT 0,
  `delete_flg` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `issues_db`
--

INSERT INTO `issues_db` (`id`, `until`, `user_id`, `status`, `valid`, `delete_flg`) VALUES
(1, '', 50, 1, 0, 1),
(2, '09', 50, 1, 0, 1),
(3, '2021-09-14', 50, 1, 0, 1),
(4, '', 50, 3, 0, 1),
(5, '', 26, 4, 1, 1),
(6, '2021-10-19', 50, 2, 1, 1),
(7, '2021-09-19', 26, 1, 1, 1),
(8, '2021-11-19', 50, 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_db`
--

CREATE TABLE `job_db` (
  `id` int(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(500) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type_of_project` enum('one-time project','ongoing project') NOT NULL,
  `no_of_freelance` enum('one freelancer','two or more freelancers') NOT NULL,
  `experience` enum('entry','intermediate','expert','') NOT NULL,
  `payment_freelance` enum('pay per hour','pay a fixed price','','') NOT NULL,
  `budget` int(25) NOT NULL,
  `mode_of_payment` enum('gcash','paypal','bank','remittance') NOT NULL,
  `time_posted` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `job_id` int(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_db`
--

INSERT INTO `job_db` (`id`, `firstname`, `middlename`, `lastname`, `title`, `category`, `description`, `type_of_project`, `no_of_freelance`, `experience`, `payment_freelance`, `budget`, `mode_of_payment`, `time_posted`, `job_id`) VALUES
(30, 'kenny', 'montesa', 'jepollo', 'Photo editor', 'Dog handler or trainor, Programmer (general), Vehicle body builder', 'i have an old photo i need to restore the quality of the picture.', 'one-time project', 'one freelancer', 'intermediate', 'pay a fixed price', 1000, 'gcash', '2021-09-29 15:10:54.030395', 26),
(31, 'kenny', 'montesa', 'jepollo', 'Sail Project Development', 'Dog handler or trainor, Programmer (general), Vehicle body builder', 'Learning Management System for JLPT', 'one-time project', 'one freelancer', 'expert', 'pay per hour', 300, 'gcash', '2021-09-29 15:10:55.070240', 26),
(32, 'kenny', 'montesa', 'jepollo', 'Barimo', 'Dog handler or trainor, Programmer (general), Vehicle body builder', 'Online Bar', 'one-time project', 'one freelancer', 'entry', 'pay a fixed price', 1500, 'gcash', '2021-09-29 15:10:56.765409', 26);

-- --------------------------------------------------------

--
-- Table structure for table `post_db`
--

CREATE TABLE `post_db` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` enum('Graphic Designer','Brand Identity Design','Fashion Design','UI/UX Design','3D Animation') NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` enum('One-Time Project','Ongoing Project','I am not sure') NOT NULL,
  `see` enum('Anyone','Only Cawork freelancers','Invite-only') NOT NULL,
  `need` enum('One freelancers','More than One freelancers') NOT NULL,
  `level` enum('Entry','Intermediate','Expert') NOT NULL,
  `pay` enum('Pay by the hour (for ongoing projects)','Pay a fixed price (for One-time projects)') NOT NULL,
  `budget` varchar(255) NOT NULL,
  `btype` enum('/hr','/week') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `profile_db`
--

CREATE TABLE `profile_db` (
  `id` varchar(55) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `age` int(10) NOT NULL,
  `place_birth` varchar(100) NOT NULL,
  `street_no` varchar(50) NOT NULL,
  `subdivision` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `zipcode` int(10) NOT NULL,
  `number` int(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `education` varchar(255) NOT NULL,
  `skills` varchar(255) NOT NULL,
  `rate` int(20) NOT NULL,
  `time_availability` int(20) NOT NULL,
  `day_week` enum('day','week') NOT NULL,
  `experience` enum('entry','experience','expert') NOT NULL,
  `certificate` varchar(255) NOT NULL,
  `primary_id` blob NOT NULL,
  `secondary_id` varchar(255) NOT NULL,
  `police_clearance` varchar(255) NOT NULL,
  `diploma` varchar(255) NOT NULL,
  `barangay_clearance` varchar(255) NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile_db`
--

INSERT INTO `profile_db` (`id`, `fname`, `mname`, `lname`, `birthday`, `gender`, `age`, `place_birth`, `street_no`, `subdivision`, `barangay`, `municipality`, `zipcode`, `number`, `email`, `education`, `skills`, `rate`, `time_availability`, `day_week`, `experience`, `certificate`, `primary_id`, `secondary_id`, `police_clearance`, `diploma`, `barangay_clearance`, `status`) VALUES
('', '', '', '', '0000-00-00', '', 0, '', '', '', '', '', 0, 0, '', '', '', 0, 0, '', '', '', '', '', '', '', '', ''),
('', '', '', '', '0000-00-00', '', 0, '', '', '', '', '', 0, 0, '', '', '', 0, 0, '', '', '', '', '', '', '', '', ''),
('', 'asdas', '', 'asdasdsadas', '0000-00-00', 'male', 0, '', '', '', '', '', 0, 0, '', '', '', 0, 0, 'day', 'entry', '', '', '', '', '', '', ''),
('', 'asdsad', '', 'asdsadsaasd', '0000-00-00', 'male', 0, '', '', '', '', '', 0, 0, '', '', 'asdasdsadsad', 0, 0, 'day', 'expert', '', '', '', '', '', '', ''),
('', '', '', '', '0000-00-00', '', 0, '', '', '', '', '', 0, 0, '', '', '', 0, 0, '', '', '', '', '', '', '', '', ''),
('', 'Kenny Michael', '', 'jepollo', '2021-04-01', 'male', 22, '', 'asds', 'wellington', '', '', 4108, 2123123123, '2123123123', '', '', 2500, 0, '', '', '', '', '', '', '', '', ''),
('', 'jhorgie', '', 'buenavides', '2021-05-01', 'female', 15, '', '', '', '', '', 0, 0, '', '', '', 0, 0, '', 'entry', '', '', '', '', '', '', ''),
('', '', '', 'jepolo', '0000-00-00', 'male', 0, '', '', '', '', '', 0, 0, '', '', '', 0, 0, '', 'entry', '', '', '', '', '', '', ''),
('', '', '', 'asdasdsad', '0000-00-00', 'male', 0, '', '', '', '', '', 0, 0, '', '', '', 0, 0, '', 'entry', '', '', '', '', '', '', ''),
('', '', '', 'asdasd', '0000-00-00', 'male', 0, '', '', '', '', '', 0, 0, '', '', '', 0, 0, '', 'entry', '', '', '', '', '', '', ''),
('', '', '', '', '0000-00-00', 'male', 0, '', '', '', '', '', 0, 0, '', '', '', 0, 0, '', '', '', '', '', '', '', '', ''),
('', 'Juan Ponce ', '', 'Enrile', '0000-00-00', 'male', 150, '', 'malacanang', 'palace', '', '', 1108, 2147483647, '9909091091', '', '', 0, 0, '', '', '', '', '', '', '', '', ''),
('', 'Juan Ponce ', '', 'Enrile', '0000-00-00', 'male', 150, '', 'malacanang', 'palace', '', '', 1108, 2147483647, '9909091091', '', '', 0, 0, '', '', '', '', '', '', '', '', ''),
('', '', '', '', '0000-00-00', 'male', 120, '', 'malacanang', 'palace', '', '', 1108, 2147483647, 'enrileponce@gmail.com', '', '', 0, 0, '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `proposal_db`
--

CREATE TABLE `proposal_db` (
  `id` int(100) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `budget` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `experience_level` varchar(255) NOT NULL,
  `project_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `availability` varchar(50) NOT NULL,
  `level` varchar(255) NOT NULL,
  `skills` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `proposal_id` varchar(100) NOT NULL,
  `user_id` int(55) NOT NULL,
  `status` varchar(20) NOT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proposal_db`
--

INSERT INTO `proposal_db` (`id`, `job_title`, `budget`, `description`, `experience_level`, `project_type`, `name`, `rate`, `availability`, `level`, `skills`, `message`, `proposal_id`, `user_id`, `status`, `delete_flg`) VALUES
(3, 'Photo editor', '₱2500.00', 'Please read carefully,\r\n                      I need to compare two files using column A. Compare master file 1 to Y file 2 using column A. any data that is in Y file 2 that is not in Master file 1 i like to move that data to master File 1.', 'Intermediate', 'One-time project', 'Ladily Ayo', '₱50.00 /hr', '30+hrs /week', 'Intermediate', 'Software Engineer', 'I hope you will accept my proposals.', '', 0, '1', 0),
(16, 'looking for mangagamot', '1', 'asdasdsadasd', 'entry', '', 'kenny jepollo', '', '', '', '', '', '', 0, '1', 0),
(18, 'website redesign', '500', 'redesign website front end', 'expert', 'one-time project', 'ladilyeee ayooo', '500', '12 hours week', '', 'programmer', 'TEST ULIT', '', 0, '0', 0),
(19, 'website redesign', '500', 'redesign website front end', 'expert', 'one-time project', 'ladilyeee ayooo', '500', '12 hours week', '', 'programmer', 'Send ulit', '', 0, '0', 0),
(20, 'taga hugas ng plato', '500', 'sample 1', 'intermediate', 'ongoing project', 'ladilyeee ayooo', '500', '12 hours week', 'intermediate', 'programmer', 'Ilabas ang plato\r\n', '', 0, '1', 0),
(21, 'car wirings', '1000', 'my car is not running please check the wirings of my car', 'expert', 'one-time project', 'Ladily Ayo', '500', '10 hours day', 'expert', 'programmer', 'i hope you like me!', '24', 0, '', 0),
(23, 'car wirings', '1000', 'my car is not running please check the wirings of my car', 'expert', 'one-time project', 'Ladily Ayo', '500', '10 hours day', 'expert', 'programmer', 'i hope its working', '4', 0, '', 0),
(25, 'car wirings', '1000', 'my car is not running please check the wirings of my car', 'expert', 'one-time project', 'Ladily Ayo', '500', '10 hours day', 'expert', 'programmer', 'TANGGAPIN NYO KO\r\n', '30', 0, '1', 0),
(26, 'photo editor', '5000', 'sample description', 'intermediate', 'one-time project', 'Jane De leon', '1000', '10 hours day', 'intermediate', 'Actress', 'hi i like it', '30', 0, '1', 0),
(27, 'car wirings', '1000', 'my car is not running please check the wirings of my car', 'expert', 'one-time project', 'Jane De leon', '1000', '10 hours day', 'intermediate', 'Actress', ' i like it too\r\n', '30', 0, '1', 0),
(28, 'car wirings', '1000', 'my car is not running please check the wirings of my car', 'expert', 'one-time project', 'Ladily Ayo', '500', '10 hours day', 'expert', 'programmer', 'hi there\r\n', '30', 0, '1', 0),
(31, 'photo editor', '2000', 'sample description', 'intermediate', 'one-time project', 'Ladily Ayo', '500', '10 hours day', 'expert', 'programmer', 'please accept me.', '30', 0, '1', 0),
(32, 'Photo editor', '1000', 'i have an old photo i need to restore the quality of the picture.', 'intermediate', 'one-time project', 'Ladily Ayo', '500', '10 hours day', 'expert', 'programmer', 'hi guys welcome to my vlog', '30', 4, '1', 0),
(34, 'Photo editor', '1000', 'i have an old photo i need to restore the quality of the picture.', 'intermediate', 'one-time project', 'Donn Frederick Lucas', '1000', '3 hours day', 'entry', 'graphic designer', 'I\'m good at this', '30', 50, '1', 0),
(35, 'Sail Project Development', '300', 'Learning Management System for JLPT', 'expert', 'one-time project', 'Donn Frederick Lucas', '1000', '3 hours day', 'entry', 'programmer', 'Hi', '26', 50, '1', 0),
(36, 'Sail Project Development', '300', 'Learning Management System for JLPT', 'expert', 'one-time project', 'Donn Frederick Lucas', '1000', '3 hours day', 'entry', 'programmer', 'Thank you', '26', 50, '0', 0),
(37, 'Sail Project Development', '300', 'Learning Management System for JLPT', 'expert', 'one-time project', 'Donn Frederick Lucas', '1000', '3 hours day', 'entry', 'programmer', 'Nice one', '31', 50, '2', 1),
(38, 'Sail Project Development', '300', 'Learning Management System for JLPT', 'expert', 'one-time project', 'Donn Frederick Lucas', '1000', '3 hours day', 'entry', 'programmer', 'I\'m good at this', '31', 50, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rating` varchar(50) NOT NULL,
  `review` varchar(255) NOT NULL,
  `user_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `name`, `rating`, `review`, `user_id`) VALUES
(25, 'john kiefffer jepollo', '5', 'mabilis magtrabaho at hindi mahal maningil', 0),
(26, '', '3.6', 'very good', 0),
(27, '', '0', '', 0),
(28, '', '', '', 0),
(29, '', '3.5', '', 0),
(30, '', '0', '', 0),
(31, '', '', '', 0),
(32, '', '', '', 0),
(33, '', '', '', 0),
(34, '', '', '', 0),
(35, '', '', '', 0),
(36, '', '', '', 0),
(37, '', '3.2', '', 0),
(38, '', '', '', 0),
(39, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reg_db`
--

CREATE TABLE `reg_db` (
  `id` int(20) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `age` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `clear` varchar(255) NOT NULL,
  `place_birth` varchar(255) NOT NULL,
  `street_no` varchar(255) NOT NULL,
  `subdivision` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `zipcode` int(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_picture` varchar(500) DEFAULT NULL,
  `course` varchar(100) NOT NULL,
  `year_section` varchar(100) NOT NULL,
  `student_no` varchar(100) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `budget` varchar(100) NOT NULL,
  `mode_payment` varchar(100) NOT NULL,
  `education` varchar(255) NOT NULL,
  `skills` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `time_availability` varchar(255) NOT NULL,
  `day_week` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `certificate` varchar(255) NOT NULL,
  `primary_id` varchar(500) NOT NULL,
  `secondary_id` varchar(500) NOT NULL,
  `police_clearance` varchar(500) NOT NULL,
  `diploma` varchar(500) NOT NULL,
  `barangay_clearance` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `status` int(20) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `birthday` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reg_db`
--

INSERT INTO `reg_db` (`id`, `firstname`, `middlename`, `lastname`, `age`, `gender`, `clear`, `place_birth`, `street_no`, `subdivision`, `barangay`, `municipality`, `province`, `region`, `zipcode`, `number`, `email`, `profile_picture`, `course`, `year_section`, `student_no`, `student_id`, `position`, `budget`, `mode_payment`, `education`, `skills`, `rate`, `time_availability`, `day_week`, `experience`, `certificate`, `primary_id`, `secondary_id`, `police_clearance`, `diploma`, `barangay_clearance`, `address`, `username`, `password`, `user_type_id`, `status`, `longitude`, `latitude`, `birthday`) VALUES
(4, 'Ladily', '', 'Ayo', '22', 'female', '', '', 'tanza cavite', 'amaya homes', '', '', '', '', 4108, '922887766', 'ladilyayo@gmail.com', NULL, '', '', '', '', '', '', '', 'Cavite state University CCAT Campus', 'programmer', '500', '10', 'day', 'expert', '', '', '', '', '', '', 'Tanza Cavite', 'freelance', '12345', 2, 0, '', '', NULL),
(26, 'kenny', 'montesa', 'jepollo', '22', 'male', '', 'Dasmarinas Cavite', 'blk 36 lot 11', 'wellington residences', 'tres cruses', 'tanza', '', '', 4108, '2147483647', 'kenny@gmail.com', '20210914100139.193183676_1404436026600881_6556208517610138991_n.jpg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '20210914100139.1.jpg', '20210914100139.2.jpg', '', '', '20210914100139.3.jpg', 'Wellington residences', 'client', '12345', 1, 2, '14.4451', '120.9509', NULL),
(28, 'Jonna Marie', 'Narvaja', 'Faderguya', '22', 'male', '', 'Mandaluyong', '24', 'ACM', 'Apalan 1A', 'Imus City', '', '', 4103, '09121242183', 'jonnafaderguya@gmail.com', '20210910104720.235392257_855319128476498_1494072460407210993_n.jpg', 'BSOA', '2021', '201510721', '20210910104720.1.jpg', '', '', '', '', '', '', '', '', '', '', '20210910104720.2.jpg', '20210910104720.3.jpg', '', '', '20210910104720.4.jpg', 'general trias', 'trainor', '12345', 3, 0, '', '', NULL),
(29, 'Cawork', 'Admin', 'Admin', '22', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'rosario cavite', 'admin', '12345', 4, 0, '', '', NULL),
(30, 'Gerrymie', '', 'Lumawag', '24', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'rosario,cavite', 'client2', '12345', 1, 0, '', '', NULL),
(31, 'jhon lou', '', 'pejan', '22', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'sahud ulan cavite', 'client3', '12345', 1, 0, '', '', NULL),
(32, 'michael vincent', '', 'bajao', '24', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'rosario cavite', 'client4', '12345', 1, 0, '', '', NULL),
(33, 'john junar', '', 'tamondong', '24', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'general trias cavite', 'client5', '12345', 1, 0, '', '', NULL),
(34, 'sonny', '', 'lozano', '21', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'rosario cavite', 'client6', '12345', 1, 0, '', '', NULL),
(35, 'kevin', '', 'marvas', '22', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'rosario cavite', 'client7', '12345', 1, 0, '', '', NULL),
(37, 'marc', '', 'arellano', '24', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'sitio postema', 'client8', '12345', 1, 0, '', '', NULL),
(38, 'kelly mark', '', 'montesa', '25', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'sahud ulan ', 'client9', '12345', 1, 0, '', '', NULL),
(39, 'rod anthony', '', 'rosanes', '22', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'wellington ', 'client10', '112345', 1, 0, '', '', NULL),
(40, 'Jane', '', 'De leon', '21', 'female', '', '', 'Blk 36 Lot 11', 'wellington residences', '', '', '', '', 4108, '2147483647', 'kenny@gmail.com', NULL, '', '', '', '', '', '', '', 'Bachelor of Science in Information Technology CCAT Campus', 'Actress', '1000', '10', 'day', 'intermediate', '', '', '', '', '', '', 'naic cavite', 'freelance2', '12345', 2, 0, '', '', NULL),
(41, 'aeron', '', 'dicon', '24', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'maragondon', 'freelance3', '12345', 2, 0, '', '', NULL),
(42, 'sara', '', 'colita', '24', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'hillsview royale', 'freelance4', '12345', 2, 0, '', '', NULL),
(43, 'jhorgie', '', 'buenavides', '21', 'female', '', '', 'blk 35 lot 25', 'Wellington Residences', '', '', '', '', 4108, '2147483647', 'jhiebuenavides@gmail.com', NULL, '', '', '', '', '', '', '', 'Bachelor of Science in Tourism Management', 'Graphic Editor', '500', '5', 'day', 'expert', '', '', '', '', '', '', 'wellington', 'freelance5', '12345', 2, 0, '', '', NULL),
(44, 'john kieffer', 'buenavides', 'jepollo', '21', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'wellington residences tanza', 'trainor2', '12345', 3, 0, '', '', NULL),
(45, 'Juan Ponce', '', 'Enrile', '123', 'male', '', '', 'malacanang', 'palace', '', '', '', '', 1108, '999911992', 'enrileponce@gmail.com', '', 'BS Criminology', '4th year', '12312321321', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'malacanang', 'trainor3', '12345', 3, 0, '', '', NULL),
(46, 'sheila mae', 'lizardo', 'gunio', '30', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'naic cavite', 'shiellamae_gunio', '12345', 1, 0, '', '', NULL),
(48, 'jose', 'protacio', 'rizal', '15', '', '', '', '', '', '', '', '', '', 0, '0', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'rizal123', '12345', 1, 0, '', '', NULL),
(50, 'Donn Frederick', 'Vidad', 'Lucas', '22', 'male', '', 'Ermita, Manila', 'B7 Lt7', 'Hoteliers', 'BUCANDALA V', 'IMUS CITY', 'CAVITE', 'REGION IV-A', 4103, '09262392383', 'donnfredericklucas@gmail.com', '20210929044224.1.jpg', 'BS IT', '4th year', '201510724', '201510724', 'Junior Software Developer', '', '', 'Bachelor\'s Degree', 'Dog handler or trainor, Programmer (general), Vehicle body builder', '', '5', 'day', 'Intermediate', '20210929044224.2.jpg', '20210929044224.3.jpg', '20210929044224.4.jpg', '', '20210929044224.5.jpg', '20210929044224.6.jpg', 'Imus, Cavite', 'donnfredericklucas@gmail.com', 'JonnaMarie26', 2, 2, '14.39726', '120.9301697', NULL),
(57, 'Batman', 'And', 'Robin', '21', 'male', '', '3', 'B7 Lt7', 'Hoteliers', 'BUCANDALA V', 'IMUS CITY', 'CAVITE', 'REGION IV-A', 4103, '09262392383', 'batman@email.com', '20210927054942.1.jpg', '', '', '', '', '', '', '', 'Bachelor\'s Degree', 'Graphic Designer, Programmer, Web Developer', '', '5', 'day', 'Entry', '20210927054942.2.jpg', '20210927054942.3.jpg', '20210927054942.4.jpg', '', '20210927054942.5.jpg', '20210927054942.6.jpg', '', 'batmanandrobin', 'batmanandrobin', 2, 1, '14.39726', '120.9301697', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports_db`
--

CREATE TABLE `reports_db` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `additional_comment` mediumtext NOT NULL,
  `report_photo` varchar(500) NOT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports_db`
--

INSERT INTO `reports_db` (`id`, `from_id`, `user_id`, `subject`, `additional_comment`, `report_photo`, `delete_flg`) VALUES
(1, 26, 50, '', '', '', 1),
(2, 50, 26, '', '', '', 1),
(3, 50, 26, 'Not Responding', 'He ain\'t responding men', 'no_file', 1),
(4, 50, 26, 'Not Responding', 'He ain\'t respondin men', 'no_file', 1),
(5, 50, 26, 'Not Responding', 'He ain\'t responding', '20210929042626.login (4).php', 1),
(6, 50, 26, 'Not Responding', 'He ain\'t respondin', 'no_file', 1),
(7, 50, 26, 'Not Responding', 'He ain\'t respondin', '20210929043040.login (4).php', 1),
(8, 50, 26, 'Not Responding', 'Ain\'t respondin', '20210929091844.login (4).php', 1),
(9, 50, 26, 'Not Responding', 'Ain\'t respondin', '20210929091914.skilled-worker.docx', 1),
(10, 50, 26, 'Not Responding', 'Ain\'t respondin', '20210929094157.capture.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews_db`
--

CREATE TABLE `reviews_db` (
  `id` int(11) NOT NULL,
  `reg_id` int(11) NOT NULL,
  `rating` varchar(10) NOT NULL,
  `review` varchar(5000) NOT NULL,
  `from_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flg` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews_db`
--

INSERT INTO `reviews_db` (`id`, `reg_id`, `rating`, `review`, `from_id`, `service_id`, `created_at`, `delete_flg`) VALUES
(1, 1, '0.90000000', 'He is good', 0, 0, '2021-09-29 14:46:11', 1),
(2, 1, '0.90000000', 'He\'s good', 26, 23, '2021-09-29 14:46:11', 1),
(3, 1, '0.90000000', 'He\'s agile', 26, 24, '2021-09-29 14:46:11', 1),
(4, 1, '0.90000000', 'Hello', 26, 23, '2021-09-29 14:46:11', 1),
(5, 1, '0.90000000', 'Nice', 26, 23, '2021-09-29 14:46:11', 1),
(6, 1, '0.90000000', 'Nice', 26, 23, '2021-09-29 14:46:11', 1),
(7, 1, '0.90000000', 'Nice', 26, 23, '2021-09-29 14:46:11', 1),
(8, 1, '0.90000000', 'Nice', 26, 23, '2021-09-29 14:46:11', 1),
(9, 1, '0.90000000', 'Hey', 26, 23, '2021-09-29 14:46:11', 1),
(10, 1, '0.90000000', 'Hope', 26, 23, '2021-09-29 14:46:11', 1),
(11, 1, '0.90000000', 'Nice', 26, 23, '2021-09-29 14:46:11', 1),
(12, 1, '0.90000000', 'Hello', 26, 23, '2021-09-29 14:46:11', 1),
(13, 1, '0.90000000', 'Nice', 26, 23, '2021-09-29 14:46:11', 1),
(14, 1, '0.90000000', 'Hello', 26, 23, '2021-09-29 14:46:11', 1),
(15, 50, '4.2', 'Hey', 26, 23, '2021-09-29 14:46:11', 1),
(16, 50, '4.3', 'Nice work', 26, 23, '2021-09-29 14:46:11', 0),
(17, 50, '4.6', 'Nice job', 26, 24, '2021-09-29 14:46:11', 0),
(18, 26, '3.5', 'Kulang kulang details', 50, 30, '2021-09-29 14:46:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_db`
--

CREATE TABLE `service_db` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `skills` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `day_week` varchar(255) NOT NULL,
  `services` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `reg_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_db`
--

INSERT INTO `service_db` (`id`, `name`, `skills`, `rate`, `day_week`, `services`, `description`, `reg_id`, `time`) VALUES
(22, 'Ladily Ayo', 'photo manipulation', '800', 'day', '- photo restoration, photo enhance, tarpaulin designer, logo maker', 'i am good in adobe photoshop.', 4, '0000-00-00 00:00:00'),
(23, 'Donn Frederick Lucas', 'Programmer', '500', 'day', 'Web Development', 'PHP, HTML&CSS, Ajax, Ruby on Rails, React-Typescript, React Native, Javascript', 50, '0000-00-00 00:00:00'),
(24, 'Donn Frederick Lucas', 'Programming', '300', 'day', 'Web Services', 'Web Developmen', 50, '2021-08-14 03:03:45'),
(25, 'Donn Frederick Lucas', 'Driver', '300', 'day', 'Nationwide Driving', 'Drive services', 50, '2021-08-14 07:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `service_proposal`
--

CREATE TABLE `service_proposal` (
  `id` int(11) NOT NULL,
  `reg_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flg` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_proposal`
--

INSERT INTO `service_proposal` (`id`, `reg_id`, `service_id`, `status`, `datetime`, `delete_flg`) VALUES
(1, 26, 23, 2, '2021-07-24 06:30:21', 0),
(2, 50, 23, 0, '2021-07-24 14:26:28', 1),
(3, 50, 0, 0, '2021-07-24 14:27:25', 1),
(4, 50, 26, 0, '2021-07-24 14:28:03', 1),
(5, 26, 24, 2, '2021-08-14 03:04:07', 0),
(6, 26, 22, 0, '2021-08-15 04:57:18', 0),
(7, 26, 25, 1, '2021-08-18 12:56:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `training_db`
--

CREATE TABLE `training_db` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `training_title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `training_type` enum('face to face','module','online') NOT NULL,
  `payment_method` enum('gcash','paypal','bank','remittance') NOT NULL,
  `training_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `training_db`
--

INSERT INTO `training_db` (`id`, `name`, `training_title`, `description`, `training_type`, `payment_method`, `training_id`) VALUES
(11, 'Patricia Malajito', 'programming language', 'sample description', 'face to face', 'gcash', 28),
(12, 'Patricia  Malajito', '', '', 'face to face', 'gcash', 28);

-- --------------------------------------------------------

--
-- Table structure for table `trainor_ratings_db`
--

CREATE TABLE `trainor_ratings_db` (
  `id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  `trainor_id` int(11) NOT NULL,
  `reg_id` int(11) NOT NULL,
  `rate` varchar(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trainor_ratings_db`
--

INSERT INTO `trainor_ratings_db` (`id`, `training_id`, `trainor_id`, `reg_id`, `rate`, `comment`, `created_at`, `delete_flg`) VALUES
(1, 31, 28, 50, '4.5', 'He\'s good', '2021-09-29 14:47:27', 0),
(2, 31, 28, 26, '4.2', 'Nice experience', '2021-09-29 14:47:27', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities_db`
--
ALTER TABLE `activities_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientid`);

--
-- Indexes for table `events_db`
--
ALTER TABLE `events_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events_participants_db`
--
ALTER TABLE `events_participants_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `freelance`
--
ALTER TABLE `freelance`
  ADD PRIMARY KEY (`flid`);

--
-- Indexes for table `issues_db`
--
ALTER TABLE `issues_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_db`
--
ALTER TABLE `job_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_db`
--
ALTER TABLE `post_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proposal_db`
--
ALTER TABLE `proposal_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reg_db`
--
ALTER TABLE `reg_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports_db`
--
ALTER TABLE `reports_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews_db`
--
ALTER TABLE `reviews_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_db`
--
ALTER TABLE `service_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_proposal`
--
ALTER TABLE `service_proposal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_db`
--
ALTER TABLE `training_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainor_ratings_db`
--
ALTER TABLE `trainor_ratings_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities_db`
--
ALTER TABLE `activities_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `events_db`
--
ALTER TABLE `events_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `events_participants_db`
--
ALTER TABLE `events_participants_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `freelance`
--
ALTER TABLE `freelance`
  MODIFY `flid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `issues_db`
--
ALTER TABLE `issues_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `job_db`
--
ALTER TABLE `job_db`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `post_db`
--
ALTER TABLE `post_db`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposal_db`
--
ALTER TABLE `proposal_db`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `reg_db`
--
ALTER TABLE `reg_db`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `reports_db`
--
ALTER TABLE `reports_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews_db`
--
ALTER TABLE `reviews_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `service_db`
--
ALTER TABLE `service_db`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `service_proposal`
--
ALTER TABLE `service_proposal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `training_db`
--
ALTER TABLE `training_db`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `trainor_ratings_db`
--
ALTER TABLE `trainor_ratings_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
