-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2019 at 09:23 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `musicquestdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cooperation`
--

CREATE TABLE `cooperation` (
  `IDCoop` int(11) NOT NULL,
  `IDUserOrg` int(11) DEFAULT NULL,
  `IDUserMus` int(11) DEFAULT NULL,
  `Status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RatingMusician` float DEFAULT NULL,
  `RatingOrganizer` float DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demovideos`
--

CREATE TABLE `demovideos` (
  `IDUserMus` int(11) NOT NULL,
  `YoutubeLink1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `YoutubeLink2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `YoutubeLink3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `YoutubeLink4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `demovideos`
--

INSERT INTO `demovideos` (`IDUserMus`, `YoutubeLink1`, `YoutubeLink2`, `YoutubeLink3`, `YoutubeLink4`) VALUES
(1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locationpictures`
--

CREATE TABLE `locationpictures` (
  `IDUserOrg` int(11) NOT NULL,
  `pathToPicture1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pathToPicture2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pathToPicture3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pathToPicture4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `locationpictures`
--

INSERT INTO `locationpictures` (`IDUserOrg`, `pathToPicture1`, `pathToPicture2`, `pathToPicture3`, `pathToPicture4`) VALUES
(2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `musician`
--

CREATE TABLE `musician` (
  `IDUserMus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `musician`
--

INSERT INTO `musician` (`IDUserMus`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `organizer`
--

CREATE TABLE `organizer` (
  `IDUserOrg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `organizer`
--

INSERT INTO `organizer` (`IDUserOrg`) VALUES
(2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `IDUser` int(11) NOT NULL,
  `Username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Tip` int(11) NOT NULL,
  `TipUser` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Active` int(11) DEFAULT NULL,
  `ProfilePicture` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TotalRating` int(11) DEFAULT NULL,
  `TotalVotes` int(11) DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`IDUser`, `Username`, `Password`, `Name`, `Tip`, `TipUser`, `Active`, `ProfilePicture`, `TotalRating`, `TotalVotes`, `Description`) VALUES
(1, 'dusan', 'mafeacuprija', 'dusancar', 2, 'Musician', 1, NULL, NULL, NULL, NULL),
(2, 'mickoni17', 'mafeavracar', 'milodar', 2, 'Organizer', 1, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cooperation`
--
ALTER TABLE `cooperation`
  ADD PRIMARY KEY (`IDCoop`),
  ADD KEY `R_9` (`IDUserMus`),
  ADD KEY `R_10` (`IDUserOrg`);

--
-- Indexes for table `demovideos`
--
ALTER TABLE `demovideos`
  ADD PRIMARY KEY (`IDUserMus`);

--
-- Indexes for table `locationpictures`
--
ALTER TABLE `locationpictures`
  ADD PRIMARY KEY (`IDUserOrg`);

--
-- Indexes for table `musician`
--
ALTER TABLE `musician`
  ADD PRIMARY KEY (`IDUserMus`);

--
-- Indexes for table `organizer`
--
ALTER TABLE `organizer`
  ADD PRIMARY KEY (`IDUserOrg`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`IDUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cooperation`
--
ALTER TABLE `cooperation`
  MODIFY `IDCoop` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `demovideos`
--
ALTER TABLE `demovideos`
  ADD CONSTRAINT `demovideos_ibfk_1` FOREIGN KEY (`IDUserMus`) REFERENCES `musician` (`IDUserMus`);

--
-- Constraints for table `locationpictures`
--
ALTER TABLE `locationpictures`
  ADD CONSTRAINT `locationpictures_ibfk_1` FOREIGN KEY (`IDUserOrg`) REFERENCES `organizer` (`IDUserOrg`);

--
-- Constraints for table `musician`
--
ALTER TABLE `musician`
  ADD CONSTRAINT `musician_ibfk_1` FOREIGN KEY (`IDUserMus`) REFERENCES `user` (`IDUser`);

--
-- Constraints for table `organizer`
--
ALTER TABLE `organizer`
  ADD CONSTRAINT `organizer_ibfk_1` FOREIGN KEY (`IDUserOrg`) REFERENCES `user` (`IDUser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
