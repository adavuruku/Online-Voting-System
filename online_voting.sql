-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 30, 2017 at 02:46 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `online_voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_record`
--

CREATE TABLE IF NOT EXISTS `admin_record` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `election_pin` varchar(10) NOT NULL,
  `election_status` varchar(10) NOT NULL,
  `date_end` date NOT NULL,
  `User_Name` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Full_Name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin_record`
--

INSERT INTO `admin_record` (`id`, `election_pin`, `election_status`, `date_end`, `User_Name`, `Password`, `Full_Name`) VALUES
(1, '0', '0', '2017-01-10', 'admin', 'admin', 'Joshua K. Okpanachi');

-- --------------------------------------------------------

--
-- Table structure for table `contestant_list`
--

CREATE TABLE IF NOT EXISTS `contestant_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(250) NOT NULL,
  `c_dept` varchar(100) NOT NULL,
  `c_regno` varchar(50) NOT NULL,
  `c_level` varchar(10) NOT NULL,
  `c_faculty` varchar(100) NOT NULL,
  `c_gender` varchar(10) NOT NULL,
  `c_phone` varchar(15) NOT NULL,
  `c_email` varchar(200) NOT NULL,
  `c_state` varchar(250) NOT NULL,
  `c_address` varchar(250) NOT NULL,
  `c_position` varchar(250) NOT NULL,
  `c_position_code` varchar(200) NOT NULL,
  `c_vote` int(11) NOT NULL,
  `c_vote_id` varchar(200) NOT NULL,
  `c_date_reg` date NOT NULL,
  `pics_ext` varchar(10) NOT NULL,
  `del_status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `contestant_list`
--

INSERT INTO `contestant_list` (`id`, `c_name`, `c_dept`, `c_regno`, `c_level`, `c_faculty`, `c_gender`, `c_phone`, `c_email`, `c_state`, `c_address`, `c_position`, `c_position_code`, `c_vote`, `c_vote_id`, `c_date_reg`, `pics_ext`, `del_status`) VALUES
(1, 'AbdulQudus Itopa', 'Mathematics', '14/37139D/1', '300', 'Science', 'Male', '08164377187', 'aabdulraheemsherif@gmail.com', 'Kogi', 'D41 Inike Okene Kogi State', 'President', '100563', 26, '184536', '2017-01-11', '.jpg', '0'),
(2, 'Hauwa Talma Sule', 'Architecture', '14/37139/U/3', '300', 'Environmental', 'Female', '08164377187', 'aabdulraheemsherif@gmail.com', 'Kogi', 'D41 Inike Okene Kogi State', 'President', '100563', 22, '181791', '2017-01-11', '.jpg', '0'),
(3, 'Janet Ojigi Joy', 'Physics', '13/345672/1', '300', 'Science', 'Female', '08164377187', 'aabdulraheemsherif@gmail.com', 'Kogi', 'D41 Inike Okene Kogi State', 'Vice President', '127645', 15, '104537', '2017-01-11', '.jpg', '1'),
(4, 'Usman Tohir Sanni', 'Electrical Engineering', '14/438721/1', '300', 'Engineering', 'Male', '08164377187', 'aabdulraheemsherif@gmail.com', 'Kogi', 'D41 Inike Okene Kogi State', 'Vice President', '127645', 10013, '187542', '2017-01-11', '.jpg', '0'),
(5, 'Danga James', 'Industrial Chemistry', '14/37180D/1', '300', 'Science', 'Male', '08164377187', 'aabdulraheemsherif@gmail.com', 'Kogi', 'D41 Inike Okene Kogi State', 'Secretary General', '136705', 828, '103536', '2017-01-11', '.jpg', '0'),
(6, 'Zuleihat Kadiru Juwa', 'Zoology', '14/37175/U/1', '200', 'Science', 'Female', '08164377187', 'aabdulraheemsherif@gmail.com', 'Kogi', 'D41 Inike Okene Kogi State', 'Secretary General', '136705', 58, '193036', '2017-01-11', '.jpg', '0'),
(7, 'Abdulhaqq Abdulraheem Adinoyi', 'Estate Management', '13/28793/U/3', '500', 'Environmental Studies', 'Male', '07034761741', 'aabdulraheemsherif@gmail.com', 'Kogi', 'D41 Inike Okene Kogi State', 'Secretary General', '136705', 1, '1494634809', '2017-01-28', '.jpg', '0'),
(8, 'Uchena Igbinabo', 'Mechanical Engineering', '13/28713D/3', '300', 'Engineering', 'Male', '07084522261', 'aabdulraheemsherif@gmail.com', 'Ebonyi', 'Flat 234D Oriokwu street Ebonyi state', 'Vice President', '127645', 12, '1494762542', '2017-01-28', '.jpeg', '0'),
(9, 'Jude Isaac', 'Microbiology', '13/378901/U/1', '300', 'Science', 'Female', '0816664747444', 'aaabdulraheemsherif@gmail.com', 'Kwara', 'Flat 24R Kwara', 'President', '100563', 80, '1494768352', '2017-01-28', '.jpg', '0'),
(10, 'Salami OKe', 'Architectural Technology', '11/28783/U/1', '400', 'Environmental Studies', 'Female', '08181153074', 'aabdulraheemsherif@gmail.com', 'Kogi', 'D41  Idoji Street, Okene Kogi State', 'Financial Secretary', '1959295887', 300, '1494064187', '2017-01-30', '.jpg', '0');

-- --------------------------------------------------------

--
-- Table structure for table `student_information`
--

CREATE TABLE IF NOT EXISTS `student_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Stud_Name` varchar(200) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Level` varchar(10) NOT NULL,
  `reg_No` varchar(15) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `p_word` text NOT NULL,
  `v_code_status` varchar(5) NOT NULL,
  `v_code` varchar(250) NOT NULL,
  `date_vote_code` datetime NOT NULL,
  `vote_status` varchar(5) NOT NULL,
  `faculty` varchar(200) NOT NULL,
  `pics_ext` varchar(10) NOT NULL,
  `vote_details` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `student_information`
--

INSERT INTO `student_information` (`id`, `Stud_Name`, `Department`, `Level`, `reg_No`, `Gender`, `Email`, `Phone`, `p_word`, `v_code_status`, `v_code`, `date_vote_code`, `vote_status`, `faculty`, `pics_ext`, `vote_details`) VALUES
(1, 'Abdulraheem Sherif Adavuruku', 'Mathematics', '200', '111', 'Male', 'aabdulraheemsherif@gmail.com', '08164377187', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', '0', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', '2017-01-30 07:48:17', '0', '', '.jpg', ''),
(2, 'Jay', 'Mathematics', '200', '123455', 'Male', 'aaabdulraheemsherif@gmail.com', '08164377187', 'ffdaf60e4a4aac1f0818f9ce027279785c924714', '0', '', '0000-00-00 00:00:00', '0', '', '', ''),
(3, 'Sherif', 'Mathematics', '200', '123455', 'Male', 'aabdulraheem@gmail.com', '08164377187', 'ffdaf60e4a4aac1f0818f9ce027279785c924714', '0', '', '0000-00-00 00:00:00', '0', '', '', ''),
(8, 'Mary Bello Ojo', 'Marketing', '300', '11/37834/U/1', 'Female', 'marrybello@gmail.com', '08194563277', 'ffdaf60e4a4aac1f0818f9ce027279785c924714', '0', '', '0000-00-00 00:00:00', '0', 'Bussiness Studies', '.jpg', ''),
(9, 'Yahaya Sherifat', 'Elect/Elect Engineering', '300', '13/28793/U/3', 'Female', 'joshuambanasor1992@gmail.com', '07030555349', 'ffdaf60e4a4aac1f0818f9ce027279785c924714', '1', '3efbd5fad413e9fad6b57a948872e58f0f7067de', '0000-00-00 00:00:00', '', 'Engineering', '.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `sug_post_list`
--

CREATE TABLE IF NOT EXISTS `sug_post_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sug_post` varchar(200) NOT NULL,
  `sug_post_code` varchar(100) NOT NULL,
  `del_status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sug_post_list`
--

INSERT INTO `sug_post_list` (`id`, `sug_post`, `sug_post_code`, `del_status`) VALUES
(1, 'President', '100563', '0'),
(2, 'Vice President', '127645', '0'),
(3, 'Secretary General', '136705', '0'),
(4, 'Auditor General', '2081924880', '0'),
(7, 'Financial Secretary', '1959295887', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
