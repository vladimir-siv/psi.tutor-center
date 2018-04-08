-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2018 at 04:04 PM
-- Server version: 10.1.30-MariaDB
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
-- Database: `psi.tutor-center`
--
CREATE DATABASE IF NOT EXISTS `psi.tutor-center` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `psi.tutor-center`;

-- --------------------------------------------------------

--
-- Table structure for table `action`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `action`;
CREATE TABLE `action` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `action`:
--

-- --------------------------------------------------------

--
-- Table structure for table `actor`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `actor`;
CREATE TABLE `actor` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(64) NOT NULL,
  `LastName` varchar(64) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Username` varchar(64) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `BirthDate` date NOT NULL,
  `Tokens` decimal(10,0) NOT NULL DEFAULT '0',
  `Banned` bit(1) NOT NULL DEFAULT b'0',
  `ActorRank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `actor`:
--   `ActorRank`
--       `actorrank` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `actorrank`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `actorrank`;
CREATE TABLE `actorrank` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Rank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `actorrank`:
--

-- --------------------------------------------------------

--
-- Table structure for table `actorreview`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `actorreview`;
CREATE TABLE `actorreview` (
  `ID` int(11) NOT NULL,
  `Grade` int(11) NOT NULL,
  `Description` varchar(64) NOT NULL,
  `Reviewer` int(11) NOT NULL,
  `Reviewee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `actorreview`:
--   `Reviewer`
--       `actor` -> `ID`
--   `Reviewee`
--       `actor` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `ID` int(11) NOT NULL,
  `Actor` int(11) NOT NULL,
  `Seen` bit(1) NOT NULL DEFAULT b'0',
  `Title` varchar(64) NOT NULL,
  `Content` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `notification`:
--   `Actor`
--       `actor` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `post`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `ID` int(11) NOT NULL,
  `Title` varchar(64) NOT NULL,
  `PostedOn` date NOT NULL,
  `OriginalPoster` int(11) NOT NULL,
  `Active` bit(1) NOT NULL DEFAULT b'1',
  `Deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `post`:
--   `OriginalPoster`
--       `actor` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `postsections`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `postsections`;
CREATE TABLE `postsections` (
  `Post` int(11) NOT NULL,
  `Section` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `postsections`:
--   `Post`
--       `post` -> `ID`
--   `Section`
--       `section` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `privileges`;
CREATE TABLE `privileges` (
  `ActorRank` int(11) NOT NULL,
  `Action` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `privileges`:
--   `ActorRank`
--       `actorrank` -> `ID`
--   `Action`
--       `action` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `promotionrequests`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `promotionrequests`;
CREATE TABLE `promotionrequests` (
  `ID` int(11) NOT NULL,
  `Title` varchar(64) NOT NULL,
  `Description` varchar(64) NOT NULL,
  `SubmittedOn` date NOT NULL,
  `Accepted` bit(1) DEFAULT NULL,
  `Actor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `promotionrequests`:
--   `Actor`
--       `actor` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `qapost`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `qapost`;
CREATE TABLE `qapost` (
  `ID` int(11) NOT NULL,
  `Description` varchar(64) NOT NULL,
  `AcceptedAnswer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `qapost`:
--   `ID`
--       `post` -> `ID`
--   `AcceptedAnswer`
--       `reply` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `reply`;
CREATE TABLE `reply` (
  `ID` int(11) NOT NULL,
  `Message` varchar(64) NOT NULL,
  `PostedOn` date NOT NULL,
  `Post` int(11) NOT NULL,
  `Actor` int(11) NOT NULL,
  `Deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `reply`:
--   `Post`
--       `post` -> `ID`
--   `Actor`
--       `actor` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `section`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `section`;
CREATE TABLE `section` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Description` varchar(64) DEFAULT NULL,
  `Subject` int(11) NOT NULL,
  `Deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `section`:
--   `Subject`
--       `subject` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `sectionsubscriptions`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `sectionsubscriptions`;
CREATE TABLE `sectionsubscriptions` (
  `Actor` int(11) NOT NULL,
  `Section` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `sectionsubscriptions`:
--   `Actor`
--       `actor` -> `ID`
--   `Section`
--       `section` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Description` varchar(64) DEFAULT NULL,
  `Deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `subject`:
--

-- --------------------------------------------------------

--
-- Table structure for table `workpost`
--
-- Creation: Apr 08, 2018 at 02:00 PM
--

DROP TABLE IF EXISTS `workpost`;
CREATE TABLE `workpost` (
  `ID` int(11) NOT NULL,
  `Description` varchar(64) NOT NULL,
  `Worker` int(11) DEFAULT NULL,
  `ComittedTokens` decimal(10,0) DEFAULT NULL,
  `WorkerAccepted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `workpost`:
--   `ID`
--       `post` -> `ID`
--   `Worker`
--       `actor` -> `ID`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `ActorRank` (`ActorRank`);

--
-- Indexes for table `actorrank`
--
ALTER TABLE `actorrank`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `actorreview`
--
ALTER TABLE `actorreview`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Reviewer` (`Reviewer`),
  ADD KEY `Reviewee` (`Reviewee`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Actor` (`Actor`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `OriginalPoster` (`OriginalPoster`);

--
-- Indexes for table `postsections`
--
ALTER TABLE `postsections`
  ADD PRIMARY KEY (`Post`,`Section`),
  ADD KEY `Section` (`Section`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`ActorRank`,`Action`),
  ADD KEY `Action` (`Action`);

--
-- Indexes for table `promotionrequests`
--
ALTER TABLE `promotionrequests`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Actor` (`Actor`);

--
-- Indexes for table `qapost`
--
ALTER TABLE `qapost`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AcceptedAnswer` (`AcceptedAnswer`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Post` (`Post`),
  ADD KEY `Actor` (`Actor`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Subject` (`Subject`);

--
-- Indexes for table `sectionsubscriptions`
--
ALTER TABLE `sectionsubscriptions`
  ADD PRIMARY KEY (`Actor`,`Section`),
  ADD KEY `Section` (`Section`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `workpost`
--
ALTER TABLE `workpost`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Worker` (`Worker`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action`
--
ALTER TABLE `action`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `actor`
--
ALTER TABLE `actor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `actorrank`
--
ALTER TABLE `actorrank`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `actorreview`
--
ALTER TABLE `actorreview`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotionrequests`
--
ALTER TABLE `promotionrequests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actor`
--
ALTER TABLE `actor`
  ADD CONSTRAINT `actor_ibfk_1` FOREIGN KEY (`ActorRank`) REFERENCES `actorrank` (`ID`);

--
-- Constraints for table `actorreview`
--
ALTER TABLE `actorreview`
  ADD CONSTRAINT `actorreview_ibfk_1` FOREIGN KEY (`Reviewer`) REFERENCES `actor` (`ID`),
  ADD CONSTRAINT `actorreview_ibfk_2` FOREIGN KEY (`Reviewee`) REFERENCES `actor` (`ID`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`Actor`) REFERENCES `actor` (`ID`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`OriginalPoster`) REFERENCES `actor` (`ID`);

--
-- Constraints for table `postsections`
--
ALTER TABLE `postsections`
  ADD CONSTRAINT `postsections_ibfk_1` FOREIGN KEY (`Post`) REFERENCES `post` (`ID`),
  ADD CONSTRAINT `postsections_ibfk_2` FOREIGN KEY (`Section`) REFERENCES `section` (`ID`);

--
-- Constraints for table `privileges`
--
ALTER TABLE `privileges`
  ADD CONSTRAINT `privileges_ibfk_1` FOREIGN KEY (`ActorRank`) REFERENCES `actorrank` (`ID`),
  ADD CONSTRAINT `privileges_ibfk_2` FOREIGN KEY (`Action`) REFERENCES `action` (`ID`);

--
-- Constraints for table `promotionrequests`
--
ALTER TABLE `promotionrequests`
  ADD CONSTRAINT `promotionrequests_ibfk_1` FOREIGN KEY (`Actor`) REFERENCES `actor` (`ID`);

--
-- Constraints for table `qapost`
--
ALTER TABLE `qapost`
  ADD CONSTRAINT `qapost_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `post` (`ID`),
  ADD CONSTRAINT `qapost_ibfk_2` FOREIGN KEY (`AcceptedAnswer`) REFERENCES `reply` (`ID`);

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`Post`) REFERENCES `post` (`ID`),
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`Actor`) REFERENCES `actor` (`ID`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`Subject`) REFERENCES `subject` (`ID`);

--
-- Constraints for table `sectionsubscriptions`
--
ALTER TABLE `sectionsubscriptions`
  ADD CONSTRAINT `sectionsubscriptions_ibfk_1` FOREIGN KEY (`Actor`) REFERENCES `actor` (`ID`),
  ADD CONSTRAINT `sectionsubscriptions_ibfk_2` FOREIGN KEY (`Section`) REFERENCES `section` (`ID`);

--
-- Constraints for table `workpost`
--
ALTER TABLE `workpost`
  ADD CONSTRAINT `workpost_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `post` (`ID`),
  ADD CONSTRAINT `workpost_ibfk_2` FOREIGN KEY (`Worker`) REFERENCES `actor` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
