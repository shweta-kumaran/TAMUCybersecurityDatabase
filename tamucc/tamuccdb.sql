-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2023 at 10:33 PM
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
-- Stand-in structure for view `admin_users`
-- (See below for the actual view)
--
CREATE TABLE `admin_users` (
`UIN` int(11)
,`First_Name` varchar(255)
,`M_Initial` varchar(1)
,`Last_Name` varchar(255)
,`Username` varchar(150)
,`Passwords` varchar(255)
,`User_Type` varchar(50)
,`Email` varchar(150)
,`Discord_Name` varchar(150)
);

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `App_Num` int(11) NOT NULL,
  `Program_Num` int(11) NOT NULL,
  `UIN` int(11) NOT NULL,
  `Uncom_Cert` varchar(255) DEFAULT NULL,
  `Com_Cert` varchar(255) DEFAULT NULL,
  `Purpose_Statement` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`App_Num`, `Program_Num`, `UIN`, `Uncom_Cert`, `Com_Cert`, `Purpose_Statement`) VALUES
(5, 3, 2, 'cert', 'cert', 'cert'),
(7, 3, 5, 'cert', 'cert', 'cert\r\n'),
(8, 3, 2, NULL, NULL, '');

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
  `Minor1` varchar(150) DEFAULT NULL,
  `Minor2` varchar(150) DEFAULT NULL,
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
(2, 'Male', 0x30, 'Caucasian', 0x31, 0x30, '1990-01-15', 3.5, 'Computer Science', 'Mathematics', 'Psychology', 2023, 'School of Science and Engineering', 'Senior', 1234567890, 'Undergraduate'),
(5, 'female', 0x01, 'a', 0x01, 0x0a, '2023-12-05', 3, 'a', 'a', 'a', 2023, 'a', 'a', 979, 'student');

-- --------------------------------------------------------

--
-- Table structure for table `documentation`
--

CREATE TABLE `documentation` (
  `Doc_Num` int(11) NOT NULL,
  `App_Num` int(11) NOT NULL,
  `Link` varchar(255) NOT NULL,
  `Doc_Type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documentation`
--

INSERT INTO `documentation` (`Doc_Num`, `App_Num`, `Link`, `Doc_Type`) VALUES
(1, 1, 'doc.com', 'google doc'),
(2, 2, 'onedrive.com', 'onedrive'),
(3, 3, 'doc1.com', 'drive'),
(4, 5, 'link', 'doc'),
(6, 8, 'docforapp6.com', 'pdf'),
(7, 8, 'docforapp8.com', 'EXCEL'),
(8, 7, 'janedoc.doc', 'docx'),
(9, 7, 'janedoc2.docx', 'DOC');

-- --------------------------------------------------------

--
-- Stand-in structure for view `documents_with_users`
-- (See below for the actual view)
--
CREATE TABLE `documents_with_users` (
`App_Num` int(11)
,`Doc_Num` int(11)
,`UIN` int(11)
,`Link` varchar(255)
,`Doc_Type` varchar(255)
);

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

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`Event_ID`, `UIN`, `Program_Num`, `Start_Date`, `Time`, `Location`, `End_Date`, `Event_Type`) VALUES
(1, 1, 1, '2019-05-21', '12:12:12', 'CSTAT', '2019-06-21', 'party'),
(3, 1, 3, '2020-05-21', '12:12:12', 'CSTAT', '2020-06-21', 'party'),
(5, 1, 4, '2023-05-21', '12:12:12', 'CSTAT', '2023-06-21', 'dinner'),
(6, 1, 5, '2023-12-04', '22:26:00', 'CSTAT', '2023-12-04', 'party'),
(10, 1, 1, '2023-12-05', '20:32:00', 'CSTAT', '2023-12-05', 'exam');

-- --------------------------------------------------------

--
-- Stand-in structure for view `event_attendance`
-- (See below for the actual view)
--
CREATE TABLE `event_attendance` (
`Event_ID` int(11)
,`UIN` int(11)
,`First_Name` varchar(255)
,`Last_Name` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `event_tracking`
--

CREATE TABLE `event_tracking` (
  `ET_NUM` int(11) NOT NULL,
  `Event_ID` int(11) NOT NULL,
  `UIN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_tracking`
--

INSERT INTO `event_tracking` (`ET_NUM`, `Event_ID`, `UIN`) VALUES
(1, 1, 2),
(2, 1, 5),
(3, 3, 2),
(4, 3, 5),
(5, 5, 5),
(6, 6, 2),
(7, 6, 5);

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

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`Program_Num`, `Prog_Name`, `Prog_Des`) VALUES
(1, 'Program one', 'the program that is one'),
(2, 'program 2', '2'),
(3, 'program 3', '3');

-- --------------------------------------------------------

--
-- Stand-in structure for view `student_users`
-- (See below for the actual view)
--
CREATE TABLE `student_users` (
`UIN` int(11)
,`First_Name` varchar(255)
,`M_Initial` varchar(1)
,`Last_Name` varchar(255)
,`Username` varchar(150)
,`Passwords` varchar(255)
,`User_Type` varchar(50)
,`Email` varchar(150)
,`Discord_Name` varchar(150)
);

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
(2, 'John', 'M', 'Doe', 'john.doe', 'password', 'Student', 'john.doe@example.com', 'john.doe#5678'),
(4, 'Admin', NULL, 'User', 'admin2', 'admin2', 'admin', 'admin@example.com', 'admin#1234'),
(5, 'Jane', 'M', 'Doe', 'Jane.doe', 'password', 'student', 'Jane.doe@example.com', 'Jane.doe#5678'),
(8, 'John', NULL, 'Doe', 'johndoe1', 'password', 'admin', 'johndoe@gmail.com', 'johndoe2023');

-- --------------------------------------------------------

--
-- Structure for view `admin_users`
--
DROP TABLE IF EXISTS `admin_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `admin_users`  AS SELECT `users`.`UIN` AS `UIN`, `users`.`First_Name` AS `First_Name`, `users`.`M_Initial` AS `M_Initial`, `users`.`Last_Name` AS `Last_Name`, `users`.`Username` AS `Username`, `users`.`Passwords` AS `Passwords`, `users`.`User_Type` AS `User_Type`, `users`.`Email` AS `Email`, `users`.`Discord_Name` AS `Discord_Name` FROM `users` WHERE `users`.`User_Type` = 'admin' ;

-- --------------------------------------------------------

--
-- Structure for view `documents_with_users`
--
DROP TABLE IF EXISTS `documents_with_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `documents_with_users`  AS SELECT `application`.`App_Num` AS `App_Num`, `documentation`.`Doc_Num` AS `Doc_Num`, `application`.`UIN` AS `UIN`, `documentation`.`Link` AS `Link`, `documentation`.`Doc_Type` AS `Doc_Type` FROM (`application` join `documentation` on(`application`.`App_Num` = `documentation`.`App_Num`)) ORDER BY `application`.`App_Num` ASC, `documentation`.`Doc_Num` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `event_attendance`
--
DROP TABLE IF EXISTS `event_attendance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event_attendance`  AS SELECT `event_tracking`.`Event_ID` AS `Event_ID`, `event_tracking`.`UIN` AS `UIN`, `users`.`First_Name` AS `First_Name`, `users`.`Last_Name` AS `Last_Name` FROM (`event_tracking` join `users` on(`event_tracking`.`UIN` = `users`.`UIN`)) ;

-- --------------------------------------------------------

--
-- Structure for view `student_users`
--
DROP TABLE IF EXISTS `student_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_users`  AS SELECT `users`.`UIN` AS `UIN`, `users`.`First_Name` AS `First_Name`, `users`.`M_Initial` AS `M_Initial`, `users`.`Last_Name` AS `Last_Name`, `users`.`Username` AS `Username`, `users`.`Passwords` AS `Passwords`, `users`.`User_Type` AS `User_Type`, `users`.`Email` AS `Email`, `users`.`Discord_Name` AS `Discord_Name` FROM `users` WHERE `users`.`User_Type` = 'student' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`App_Num`),
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
  ADD PRIMARY KEY (`Doc_Num`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`Program_Num`),
  ADD KEY `prog_name_idx` (`Prog_Name`);

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
  MODIFY `App_Num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `Doc_Num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `track`
--
ALTER TABLE `track`
  MODIFY `Tracking_Num` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

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
