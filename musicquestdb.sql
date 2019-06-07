-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2019 at 02:03 AM
-- Server version: 8.0.13
-- PHP Version: 7.3.4

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
  `IDUserOrg` int(11) NOT NULL,
  `IDUserMus` int(11) NOT NULL,
  `Status` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RatingMusician` float DEFAULT NULL,
  `RatingOrganizer` float DEFAULT NULL,
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `proposalDescription` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Date` datetime NOT NULL,
  `IDReply` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cooperation`
--

INSERT INTO `cooperation` (`IDCoop`, `IDUserOrg`, `IDUserMus`, `Status`, `RatingMusician`, `RatingOrganizer`, `Description`, `proposalDescription`, `Date`, `IDReply`) VALUES
(1, 2, 3, 'PENDING', NULL, NULL, NULL, 'asdasdasd', '2019-06-19 14:22:00', 2),
(2, 2, 1, 'DONE', NULL, 4, 'qweqwrqwfwfwq', 'qweqwrqwrqw', '2019-06-06 22:04:00', 1),
(3, 2, 1, 'ENDED', NULL, 4, 'qweqwrqwrqwrqwrq', 'asdqwdqw', '2019-06-06 22:10:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `demovideos`
--

CREATE TABLE `demovideos` (
  `IDUserMus` int(11) NOT NULL,
  `YoutubeLink1` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `YoutubeLink2` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `YoutubeLink3` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `YoutubeLink4` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `demovideos`
--

INSERT INTO `demovideos` (`IDUserMus`, `YoutubeLink1`, `YoutubeLink2`, `YoutubeLink3`, `YoutubeLink4`) VALUES
(1, NULL, 'https://www.youtube.com/embed/efdrkTsLduw', 'https://www.youtube.com/embed/hFBDbDNLvKU', NULL),
(3, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locationpictures`
--

CREATE TABLE `locationpictures` (
  `IDUserOrg` int(11) NOT NULL,
  `pathToPicture1` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pathToPicture2` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pathToPicture3` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pathToPicture4` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `locationpictures`
--

INSERT INTO `locationpictures` (`IDUserOrg`, `pathToPicture1`, `pathToPicture2`, `pathToPicture3`, `pathToPicture4`) VALUES
(2, 'images/2/exitExplosiveImg.jpg', 'images/2/kukusImg.jpg', 'images/2/lavanImg.png', 'images/2/readingImg.jpg');

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
(1),
(3);

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
  `Username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Tip` int(11) NOT NULL,
  `TipUser` int(11) NOT NULL,
  `Active` int(11) NOT NULL,
  `ProfilePicture` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `TotalRating` int(11) DEFAULT NULL,
  `TotalVotes` int(11) NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`IDUser`, `Username`, `Password`, `Name`, `Tip`, `TipUser`, `Active`, `ProfilePicture`, `TotalRating`, `TotalVotes`, `Description`) VALUES
(1, 'dusancar11', 'mafeacuprija', 'DusanCar', 2, 0, 0, 'images/1/wembleyImg.jpg', NULL, 0, 'asdfg'),
(2, 'mickoni17', 'mickoslepac', 'mickoni17', 0, 1, 0, 'images/2/szigetImg.jpg', 0, 0, 'asfdfd'),
(3, 'MilosPetrovic', 'miloscuprija', 'milosp', 1, 0, 1, NULL, NULL, 0, '');

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
-- Constraints for dumped tables
--

--
-- Constraints for table `cooperation`
--
ALTER TABLE `cooperation`
  ADD CONSTRAINT `R_10` FOREIGN KEY (`IDUserOrg`) REFERENCES `organizer` (`iduserorg`),
  ADD CONSTRAINT `R_9` FOREIGN KEY (`IDUserMus`) REFERENCES `musician` (`idusermus`);

--
-- Constraints for table `demovideos`
--
ALTER TABLE `demovideos`
  ADD CONSTRAINT `R_11` FOREIGN KEY (`IDUserMus`) REFERENCES `musician` (`idusermus`) ON DELETE CASCADE;

--
-- Constraints for table `locationpictures`
--
ALTER TABLE `locationpictures`
  ADD CONSTRAINT `R_12` FOREIGN KEY (`IDUserOrg`) REFERENCES `organizer` (`iduserorg`) ON DELETE CASCADE;

--
-- Constraints for table `musician`
--
ALTER TABLE `musician`
  ADD CONSTRAINT `R_3` FOREIGN KEY (`IDUserMus`) REFERENCES `user` (`iduser`) ON DELETE CASCADE;

--
-- Constraints for table `organizer`
--
ALTER TABLE `organizer`
  ADD CONSTRAINT `R_4` FOREIGN KEY (`IDUserOrg`) REFERENCES `user` (`iduser`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
