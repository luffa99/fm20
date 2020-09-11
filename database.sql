-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 11, 2020 at 04:38 PM
-- Server version: 10.1.45-MariaDB
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sh85387_ge19`
--
-- --------------------------------------------------------

--
-- Table structure for table `soldi`
--

CREATE TABLE `soldi` (
  `id_soldi` int(11) NOT NULL,
  `id_spesa` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `debito` float NOT NULL DEFAULT '0',
  `credito` float NOT NULL DEFAULT '0',
  `debito_chf` float NOT NULL DEFAULT '0',
  `credito_chf` float NOT NULL DEFAULT '0',
  `valuta` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `spesa`
--

CREATE TABLE `spesa` (
  `id_spesa` int(11) NOT NULL,
  `nome` varchar(128) NOT NULL,
  `dataora` datetime NOT NULL,
  `luogo` varchar(128) NOT NULL,
  `descrizione` text NOT NULL,
  `spesa_totale` float NOT NULL,
  `valuta` varchar(3) NOT NULL,
  `cambio` float NOT NULL,
  `spesa_totale_chf` float NOT NULL,
  `id_utente_pagante` int(11) NOT NULL,
  `id_utente_inserimento` int(11) NOT NULL,
  `timestamp_inserimento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `id_utenti` int(11) NOT NULL,
  `nome_utente` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome` varchar(64) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `soldi`
--
ALTER TABLE `soldi`
  ADD PRIMARY KEY (`id_soldi`);

--
-- Indexes for table `spesa`
--
ALTER TABLE `spesa`
  ADD PRIMARY KEY (`id_spesa`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id_utenti`),
  ADD UNIQUE KEY `nome_utente` (`nome_utente`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `soldi`
--
ALTER TABLE `soldi`
  MODIFY `id_soldi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spesa`
--
ALTER TABLE `spesa`
  MODIFY `id_spesa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utenti` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
