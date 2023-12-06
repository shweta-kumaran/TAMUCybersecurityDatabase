-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 06, 2023 at 03:28 AM
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
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `App_NUM` int(11) NOT NULL,
  `Program_Num` int(11) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Uncom_Cert` varchar(255) DEFAULT NULL,
  `Com_Cert` varchar(255) DEFAULT NULL,
  `Purpose_Statement` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Dumping data for table `collegestudents`
--

INSERT INTO `collegestudents` (`UIN`, `Gender`, `HispanicLatino`, `Race`, `USCitizen`, `First_Generation`, `DoB`, `GPA`, `Major`, `Minor1`, `Minor2`, `Expected_Graduation`, `School`, `Current_Classification`, `Phone`, `Student_Type`) VALUES
(2, 'Male', 0x30, 'Caucasian', 0x31, 0x30, '1990-01-15', 3.5, 'Computer Science', 'Mathematics', 'Psychology', 2023, 'School of Science and Engineering', 'Senior', 1234567890, 'Undergraduate');

-- --------------------------------------------------------

--
-- Table structure for table `documentation`
--

CREATE TABLE `documentation` (
  `Doc_Num` int(11) NOT NULL,
  `App_Num` int(11) NOT NULL,
  `Student_Num` int(11) NOT NULL,
  `Link` varchar(255) NOT NULL,
  `Doc_Type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `Event_ID` int(10) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Program_Num` int(10) NOT NULL,
  `Start_Date` date NOT NULL,
  `Time` time NOT NULL,
  `Location` varchar(255) NOT NULL,
  `End_Date` date NOT NULL,
  `Event_Type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_tracking`
--

CREATE TABLE `event_tracking` (
  `ET_NUM` int(11) NOT NULL,
  `Event_ID` int(11) NOT NULL,
  `UIN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `Intern_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `is_Gov` binary(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intern_app`
--

CREATE TABLE `intern_app` (
  `IA_Num` int(10) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Intern_ID` int(10) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Year` int(4) NOT NULL
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
-- Table structure for table `track`
--

CREATE TABLE `track` (
  `Tracking_Num` int(11) NOT NULL,
  `Program_Num` int(11) NOT NULL,
  `Student_Num` int(11) NOT NULL
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
  `Discord_Name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UIN`, `First_Name`, `M_Initial`, `Last_Name`, `Username`, `Passwords`, `User_Type`, `Email`, `Discord_Name`) VALUES
(1, 'Admin', NULL, 'User', 'admin', 'admin', 'admin', 'admin@example.com', 'admin#1234'),
(2, 'John', 'M', 'Doe', 'john.doe', 'password', 'student', 'john.doe@example.com', 'john.doe#5678');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`App_NUM`),
  ADD KEY `Program_Num` (`Program_Num`),
  ADD KEY `UIN` (`UIN`);

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
-- Indexes for table `documentation`
--
ALTER TABLE `documentation`
  ADD PRIMARY KEY (`Doc_Num`),
  ADD KEY `App_Num` (`App_Num`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`Event_ID`),
  ADD KEY `UIN` (`UIN`),
  ADD KEY `Program_Num` (`Program_Num`);

--
-- Indexes for table `event_tracking`
--
ALTER TABLE `event_tracking`
  ADD PRIMARY KEY (`ET_NUM`),
  ADD KEY `Event_ID` (`Event_ID`),
  ADD KEY `UIN` (`UIN`);

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`Intern_ID`);

--
-- Indexes for table `intern_app`
--
ALTER TABLE `intern_app`
  ADD PRIMARY KEY (`IA_Num`),
  ADD KEY `UIN` (`UIN`),
  ADD KEY `Intern_ID` (`Intern_ID`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`Program_Num`);

--
-- Indexes for table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`Tracking_Num`),
  ADD KEY `Program_Num` (`Program_Num`),
  ADD KEY `Student_Num` (`Student_Num`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UIN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `App_NUM` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certification`
--
ALTER TABLE `certification`
  MODIFY `Cert_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cert_enrollment`
--
ALTER TABLE `cert_enrollment`
  MODIFY `CertE_Num` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `Class_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_enrollment`
--
ALTER TABLE `class_enrollment`
  MODIFY `CE_Num` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documentation`
--
ALTER TABLE `documentation`
  MODIFY `Doc_Num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `Event_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_tracking`
--
ALTER TABLE `event_tracking`
  MODIFY `ET_NUM` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `Intern_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intern_app`
--
ALTER TABLE `intern_app`
  MODIFY `IA_Num` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `Program_Num` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `track`
--
ALTER TABLE `track`
  MODIFY `Tracking_Num` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`Program_Num`) REFERENCES `programs` (`Program_Num`),
  ADD CONSTRAINT `application_ibfk_2` FOREIGN KEY (`UIN`) REFERENCES `collegestudents` (`UIN`);

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

--
-- Constraints for table `documentation`
--
ALTER TABLE `documentation`
  ADD CONSTRAINT `documentation_ibfk_1` FOREIGN KEY (`App_Num`) REFERENCES `application` (`App_NUM`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`UIN`) REFERENCES `users` (`UIN`),
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`Program_Num`) REFERENCES `programs` (`Program_Num`);

--
-- Constraints for table `event_tracking`
--
ALTER TABLE `event_tracking`
  ADD CONSTRAINT `event_tracking_ibfk_1` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`Event_ID`),
  ADD CONSTRAINT `event_tracking_ibfk_2` FOREIGN KEY (`UIN`) REFERENCES `users` (`UIN`);

--
-- Constraints for table `intern_app`
--
ALTER TABLE `intern_app`
  ADD CONSTRAINT `intern_app_ibfk_1` FOREIGN KEY (`UIN`) REFERENCES `collegestudents` (`UIN`),
  ADD CONSTRAINT `intern_app_ibfk_2` FOREIGN KEY (`Intern_ID`) REFERENCES `internship` (`Intern_ID`);

--
-- Constraints for table `track`
--
ALTER TABLE `track`
  ADD CONSTRAINT `track_ibfk_1` FOREIGN KEY (`Program_Num`) REFERENCES `programs` (`Program_Num`),
  ADD CONSTRAINT `track_ibfk_2` FOREIGN KEY (`Student_Num`) REFERENCES `collegestudents` (`UIN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
