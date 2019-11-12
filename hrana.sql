-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 12, 2019 at 06:57 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrana`
--

-- --------------------------------------------------------

--
-- Table structure for table `Malica`
--

CREATE TABLE `Malica` (
  `id` int(11) NOT NULL,
  `vsebina` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `datum` date NOT NULL,
  `id_uporabnik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Malica`
--

INSERT INTO `Malica` (`id`, `vsebina`, `datum`, `id_uporabnik`) VALUES
(1, 'Zelenjavna juha, carski praženec s sadno omako, kompot, voda.\r\n\r\nZelenjavna juha, skutne ali marmeladne palačinke, kompot, voda.', '2025-12-29', 17),
(2, 'Zelenjavna juha, ocvrti lignji, brokoli na maslu, riževe kroglice, solata, voda', '2025-12-28', 17),
(3, 'polnjene sv. roladice, kruhov cmok, solata', '2025-12-30', 17);

-- --------------------------------------------------------

--
-- Table structure for table `Nivo`
--

CREATE TABLE `Nivo` (
  `id` int(11) NOT NULL,
  `naziv` varchar(32) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Nivo`
--

INSERT INTO `Nivo` (`id`, `naziv`) VALUES
(1, 'dijak'),
(2, 'skrbnik prehrane'),
(3, 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `Odjava`
--

CREATE TABLE `Odjava` (
  `id` int(11) NOT NULL,
  `id_uporabnik` int(11) NOT NULL,
  `id_malica` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `datum_cas` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Odjava`
--

INSERT INTO `Odjava` (`id`, `id_uporabnik`, `id_malica`, `status`, `datum_cas`) VALUES
(1, 18, 3, 1, '2019-10-31 20:34:02'),
(2, 18, 2, 1, '2019-10-31 20:36:23'),
(4, 18, 1, 0, '2019-10-31 20:36:21'),
(5, 19, 2, 0, '2019-10-31 20:37:52'),
(6, 19, 3, 0, '2019-10-31 21:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `Uporabnik`
--

CREATE TABLE `Uporabnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(64) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `priimek` varchar(64) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `eposta` varchar(64) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `geslo` varchar(255) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `ponastavitevGesla` varchar(128) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `ustvarjeno` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `selektor` varchar(64) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `kodiranValidator` varchar(60) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `potece` datetime DEFAULT CURRENT_TIMESTAMP,
  `aktiviran` tinyint(1) NOT NULL DEFAULT '0',
  `id_nivo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Uporabnik`
--

INSERT INTO `Uporabnik` (`id`, `ime`, `priimek`, `eposta`, `geslo`, `ponastavitevGesla`, `ustvarjeno`, `selektor`, `kodiranValidator`, `potece`, `aktiviran`, `id_nivo`) VALUES
(17, 'Peter', 'Klepec', 'peter.klepec@hrana.si', '$2y$10$oxFK30EoH/DSWbbvxs.RlePdw9apYwEq/lWfxDRB9mmBmSMkSoHca', 'r60DAQE00Pm717Fcd7dMvMKIiJ04SeON7XuklhsQtcz810paJ66KPw', '2019-10-25 15:32:38', 'r60DAQE00Pm717', '$2y$10$hizgrxaQEUgpVMBvcmtSdedCBvozEwHp/0jKPlT5B.tucShCbauOu', '2019-11-12 18:50:27', 1, 3),
(18, 'Martin', 'Krpan', 'martin.krpan@hrana.si', '$2y$10$zFE5QD3VZG9GMC15FAStX.ZBftVOGxBLep90IU/3LISYduj.kS4mu', NULL, '2019-10-26 21:07:18', 'TBPW88qNGCkU18', '$2y$10$T2S8j9Gv2k/ccDoQv8HCieFmAQAw2Ecpz8edjgRhNqMBkh6n.tgbe', '2019-11-12 18:52:25', 1, 1),
(19, 'Mojca', 'Pokrajculja', 'mojca.pokrajculja@hrana.si', '$2y$10$uAsAvqPm5calhr8DdS7k2O8scl.r6COYK4G3/MMKYq0e7DNdC5esC', NULL, '2019-10-31 20:36:53', '08zEa51vhpnL19', '$2y$10$GMX8NPGmHT3F36QrqFjLHO.49Aiilm7qDrCaPfJ8aUydd0MKpOigm', '2019-11-12 18:53:52', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Malica`
--
ALTER TABLE `Malica`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Nivo`
--
ALTER TABLE `Nivo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Odjava`
--
ALTER TABLE `Odjava`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Uporabnik`
--
ALTER TABLE `Uporabnik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nivo` (`id_nivo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Malica`
--
ALTER TABLE `Malica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Nivo`
--
ALTER TABLE `Nivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Odjava`
--
ALTER TABLE `Odjava`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `Uporabnik`
--
ALTER TABLE `Uporabnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
