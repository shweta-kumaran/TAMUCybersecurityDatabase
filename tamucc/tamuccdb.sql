-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 03:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `certification`
--

CREATE TABLE `certification` (
  `Cert_ID` int(10) NOT NULL,
  `Cert_Level` varchar(255) NOT NULL,
  `Cert_Name` varchar(255) NOT NULL,
  `Cert_Des` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cert_enrollment`
--

CREATE TABLE `cert_enrollment` (
  `CertE_Num` int(10) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Cert_ID` int(10) NOT NULL,
  `Stat` varchar(255) NOT NULL,
  `Training_Stat` varchar(255) NOT NULL,
  `Program_Num` int(10) NOT NULL,
  `Semester` varchar(255) NOT NULL,
  `Cert_Year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `Class_ID` int(10) NOT NULL,
  `Class_Name` varchar(255) NOT NULL,
  `Class_Desc` varchar(255) NOT NULL,
  `Class_Type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_enrollment`
--

CREATE TABLE `class_enrollment` (
  `CE_Num` int(10) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Class_ID` int(10) NOT NULL,
  `Stat` varchar(255) NOT NULL,
  `Semester` varchar(255) NOT NULL,
  `Year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collegestudents`
--

CREATE TABLE `collegestudents` (
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
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `Program_Num` int(10) NOT NULL,
  `Prog_Name` varchar(255) NOT NULL,
  `Prog_Des` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UIN` int(11) NOT NULL,
  `First_Name` varchar(255) NOT NULL,
  `M_Initial` varchar(1) DEFAULT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `Username` varchar(150) NOT NULL,
  `Passwords` varchar(255) NOT NULL,
  `User_Type` varchar(50) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Discord_Name` varchar(150) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certification`
--
ALTER TABLE `certification`
  ADD PRIMARY KEY (`Cert_ID`);

--
-- Indexes for table `cert_enrollment`
--
ALTER TABLE `cert_enrollment`
  ADD PRIMARY KEY (`CertE_Num`),
  ADD KEY `UIN` (`UIN`),
  ADD KEY `Cert_ID` (`Cert_ID`),
  ADD KEY `Program_Num` (`Program_Num`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`Class_ID`);

--
-- Indexes for table `class_enrollment`
--
ALTER TABLE `class_enrollment`
  ADD PRIMARY KEY (`CE_Num`),
  ADD KEY `UIN` (`UIN`),
  ADD KEY `Class_ID` (`Class_ID`);

--
-- Indexes for table `collegestudents`
--
ALTER TABLE `collegestudents`
  ADD PRIMARY KEY (`UIN`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`Program_Num`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UIN`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cert_enrollment`
--
ALTER TABLE `cert_enrollment`
  ADD CONSTRAINT `cert_enrollment_ibfk_1` FOREIGN KEY (`UIN`) REFERENCES `collegestudents` (`UIN`),
  ADD CONSTRAINT `cert_enrollment_ibfk_2` FOREIGN KEY (`Cert_ID`) REFERENCES `certification` (`Cert_ID`),
  ADD CONSTRAINT `cert_enrollment_ibfk_3` FOREIGN KEY (`Program_Num`) REFERENCES `programs` (`Program_Num`);

--
-- Constraints for table `class_enrollment`
--
ALTER TABLE `class_enrollment`
  ADD CONSTRAINT `class_enrollment_ibfk_1` FOREIGN KEY (`UIN`) REFERENCES `collegestudents` (`UIN`),
  ADD CONSTRAINT `class_enrollment_ibfk_2` FOREIGN KEY (`Class_ID`) REFERENCES `classes` (`Class_ID`);

--
-- Constraints for table `collegestudents`
--
ALTER TABLE `collegestudents`
  ADD CONSTRAINT `collegestudents_ibfk_1` FOREIGN KEY (`UIN`) REFERENCES `users` (`UIN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO `users` (
    `UIN`,
    `First_Name`,
    `M_Initial`,
    `Last_Name`,
    `Username`,
    `Passwords`,
    `User_Type`,
    `Email`,
    `Discord_Name`
) VALUES (
    1, -- Replace with a suitable unique UIN
    'Admin',
    NULL,
    'User',
    'admin',
    'admin', -- Replace with the actual hashed password (e.g., bcrypt)
    'admin', -- Assuming 'Admin' is the user type for administrators
    'admin@example.com', -- Replace with a valid email address
    'admin#1234', -- Replace with a valid Discord name and discriminator
);

INSERT INTO `users` (
    `UIN`,
    `First_Name`,
    `M_Initial`,
    `Last_Name`,
    `Username`,
    `Passwords`,
    `User_Type`,
    `Email`,
    `Discord_Name`
) VALUES (
    2, -- Replace with a suitable unique UIN
    'John',
    'M',
    'Doe',
    'john.doe',
    'password', -- Replace with the actual hashed password (e.g., bcrypt)
    'student', -- Assuming 'Student' is the user type for college students
    'john.doe@example.com', -- Replace with a valid email address
    'john.doe#5678' -- Replace with a valid Discord name and discriminator
);

INSERT INTO `collegestudents` (
    `UIN`,
    `Gender`,
    `HispanicLatino`,
    `Race`,
    `USCitizen`,
    `First_Generation`,
    `DoB`,
    `GPA`,
    `Major`,
    `Minor1`,
    `Minor2`,
    `Expected_Graduation`,
    `School`,
    `Current_Classification`,
    `Phone`,
    `Student_Type`
) VALUES (
    2, -- Same UIN as in the users table
    'Male',
    0, -- 0 for false, assuming not Hispanic/Latino
    'Caucasian',
    1, -- 1 for true, assuming US citizen
    0, -- 0 for false, assuming not first generation
    '1990-01-15', -- Replace with the actual date of birth
    3.5, -- Replace with the actual GPA
    'Computer Science',
    'Mathematics',
    'Psychology',
    2023, -- Replace with the actual expected graduation year
    'School of Science and Engineering',
    'Senior',
    1234567890, -- Replace with the actual phone number
    'Undergraduate' -- Replace with the actual student type
);
