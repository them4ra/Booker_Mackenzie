-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 14.06.2024 klo 12:06
-- Server Version: 8.0.37-0ubuntu0.20.04.3
-- PHP Version: 7.4.3-4ubuntu2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booker`
--

-- --------------------------------------------------------

--
--
--

CREATE TABLE `links` (
  `linkid` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `thedate` int NOT NULL,
  `private` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=COMPACT;

--
-- 
--

INSERT INTO `links` (`linkid`, `name`, `link`, `thedate`, `private`) VALUES
(1, 'First Sample Link', 'https://eff.org', 1644618012, NULL);

-- --------------------------------------------------------

--
--
--

CREATE TABLE `linktags` (
  `linktagid` int NOT NULL,
  `linkid` int NOT NULL,
  `tagid` int NOT NULL,
  `timecreated` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vedos taulusta `linktags`
--

INSERT INTO `linktags` (`linktagid`, `linkid`, `tagid`, `timecreated`) VALUES
(1, 1, 1, 1644618012);

-- --------------------------------------------------------

--
--
--

CREATE TABLE `tags` (
  `tagid` int NOT NULL,
  `tagName` text NOT NULL,
  `tagCreated` int NOT NULL,
  `tagInfo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=COMPACT;

--
--
--

INSERT INTO `tags` (`tagid`, `tagName`, `tagCreated`, `tagInfo`) VALUES
(1, 'Read Later', 1645686390, 'Things to read later when I have the time.');

-- --------------------------------------------------------

--
--
--

CREATE TABLE `users` (
  `userid` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `date` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
--
--

INSERT INTO `users` (`userid`, `username`, `hash`, `date`) VALUES
(1, 'user', ' $2a$12$2qTeS2zcZ93iklgdgmTdeuMLrbxFtS/FWtYSGEuTQuIUAoH1hkyf2', 1644616925);

--
--
--

--
--
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`linkid`);

--
--
--
ALTER TABLE `linktags`
  ADD PRIMARY KEY (`linktagid`);

--
--
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tagid`);

--
--
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
--
--

--
--
--
ALTER TABLE `links`
  MODIFY `linkid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=657;

--
--
--
ALTER TABLE `linktags`
  MODIFY `linktagid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=660;

--
--
--
ALTER TABLE `tags`
  MODIFY `tagid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
--
--
ALTER TABLE `users`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
