-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2023 at 09:53 PM
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
-- Database: `tamuccdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `CollegeStudents`
--

CREATE TABLE `CollegeStudents` (
  `UIN` int(11) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `HispanicLatino` binary(1) NOT NULL,
  `Race` varchar(50) NOT NULL,
  `USCitizen` binary(1) NOT NULL,
  `First_Generation` binary(1) NOT NULL,
  `DoB` date NOT NULL,
  `GPA` float NOT NULL,
  `Major` varchar(150) NOT NULL,
  `Minor1` varchar(150) NOT NULL,
  `Minor2` varchar(150) NOT NULL,
  `Expected_Graduation` int(15) NOT NULL,
  `School` varchar(150) NOT NULL,
  `Current_Classification` varchar(150) NOT NULL,
  `Phone` int(15) NOT NULL,
  `Student_Type` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UIN` int(11) NOT NULL,
  `First_Name` varchar(255) NOT NULL,
  `M_Initial` varchar(1) DEFAULT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `Username` varchar(150) NOT NULL,
  `Passwords` varchar(255) NOT NULL,
  `User_Type` varchar(50) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Discord_Name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CollegeStudents`
--
ALTER TABLE `CollegeStudents`
  ADD PRIMARY KEY (`UIN`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UIN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
