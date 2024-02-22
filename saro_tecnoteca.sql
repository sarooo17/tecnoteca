-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2024 at 10:06 PM
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
-- Database: `saro_tecnoteca`
--

-- --------------------------------------------------------

--
-- Table structure for table `articoli`
--

CREATE TABLE `articoli` (
  `id_articolo` int(11) NOT NULL,
  `numero_inventario` int(11) NOT NULL,
  `stato` set('disponibile','guasto','in prestito','prenotato') NOT NULL,
  `fk_categoria` int(11) NOT NULL,
  `fk_centro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `tipologia` set('hardware','software') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `centri`
--

CREATE TABLE `centri` (
  `id_centro` int(11) NOT NULL,
  `nome` int(11) NOT NULL,
  `via` int(11) NOT NULL,
  `fk_città` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `città`
--

CREATE TABLE `città` (
  `id_città` int(30) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cap` varchar(30) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `stato` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `città`
--

INSERT INTO `città` (`id_città`, `nome`, `cap`, `provincia`, `stato`) VALUES
(1, 'Pordenone', '33170', 'PN', 'Italia');

-- --------------------------------------------------------

--
-- Table structure for table `prestiti`
--

CREATE TABLE `prestiti` (
  `id_prestito` int(11) NOT NULL,
  `data_inizio_prestito` date NOT NULL,
  `data_restituzione` date NOT NULL,
  `data_scadenza_prestito` date NOT NULL,
  `fk_utente` int(11) NOT NULL,
  `fk_articolo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `id_utente` int(20) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `indirizzo` varchar(30) NOT NULL,
  `fk_città` int(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `passmd5` varchar(80) NOT NULL,
  `tipologia_utente` set('cliente','operatore','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`id_utente`, `nome`, `cognome`, `indirizzo`, `fk_città`, `email`, `passmd5`, `tipologia_utente`) VALUES
(3, 'admin', 'admin', '', 1, 'admin@saro.com', '21232f297a57a5a743894a0e4a801fc3', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articoli`
--
ALTER TABLE `articoli`
  ADD PRIMARY KEY (`id_articolo`),
  ADD KEY `fk_categoria` (`fk_categoria`,`fk_centro`),
  ADD KEY `fk_centro` (`fk_centro`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `centri`
--
ALTER TABLE `centri`
  ADD PRIMARY KEY (`id_centro`),
  ADD KEY `fk_città` (`fk_città`);

--
-- Indexes for table `città`
--
ALTER TABLE `città`
  ADD PRIMARY KEY (`id_città`);

--
-- Indexes for table `prestiti`
--
ALTER TABLE `prestiti`
  ADD PRIMARY KEY (`id_prestito`),
  ADD KEY `fk_utente` (`fk_utente`,`fk_articolo`),
  ADD KEY `fk_articolo` (`fk_articolo`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id_utente`),
  ADD KEY `fk_città` (`fk_città`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articoli`
--
ALTER TABLE `articoli`
  MODIFY `id_articolo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `centri`
--
ALTER TABLE `centri`
  MODIFY `id_centro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `città`
--
ALTER TABLE `città`
  MODIFY `id_città` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prestiti`
--
ALTER TABLE `prestiti`
  MODIFY `id_prestito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articoli`
--
ALTER TABLE `articoli`
  ADD CONSTRAINT `articoli_ibfk_1` FOREIGN KEY (`fk_categoria`) REFERENCES `categorie` (`id_categoria`),
  ADD CONSTRAINT `articoli_ibfk_2` FOREIGN KEY (`fk_centro`) REFERENCES `centri` (`id_centro`);

--
-- Constraints for table `centri`
--
ALTER TABLE `centri`
  ADD CONSTRAINT `centri_ibfk_1` FOREIGN KEY (`fk_città`) REFERENCES `città` (`id_città`);

--
-- Constraints for table `prestiti`
--
ALTER TABLE `prestiti`
  ADD CONSTRAINT `prestiti_ibfk_1` FOREIGN KEY (`fk_utente`) REFERENCES `utenti` (`id_utente`),
  ADD CONSTRAINT `prestiti_ibfk_2` FOREIGN KEY (`fk_articolo`) REFERENCES `articoli` (`id_articolo`);

--
-- Constraints for table `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `utenti_ibfk_1` FOREIGN KEY (`fk_città`) REFERENCES `città` (`id_città`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
