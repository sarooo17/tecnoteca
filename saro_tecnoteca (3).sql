-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2024 at 11:35 PM
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
  `numero_inventario` varchar(11) NOT NULL,
  `stato` set('disponibile','guasto','in prestito','prenotato') NOT NULL,
  `fk_categoria` int(11) NOT NULL,
  `fk_centro` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `colore` varchar(20) NOT NULL,
  `img` varchar(100) NOT NULL,
  `descrizione` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articoli`
--

INSERT INTO `articoli` (`id_articolo`, `numero_inventario`, `stato`, `fk_categoria`, `fk_centro`, `nome`, `colore`, `img`, `descrizione`) VALUES
(1, '123456', 'disponibile', 1, 1, 'hp', '919191', 'hp.png', 'descrizione di prova'),
(2, '111111', 'in prestito', 1, 1, 'macbook', '919191', 'hp.png', ''),
(4, '111112', 'disponibile', 1, 1, 'dell', 'DAA520', 'hp.png', ''),
(5, '111113', 'disponibile', 1, 1, 'acer', 'DAA520', 'hp.png', ''),
(6, '111114', 'disponibile', 1, 1, 'msi', 'DAA520', 'hp.png', ''),
(8, '111121', 'disponibile', 1, 1, 'msi', 'DAA520', 'hp.png', ''),
(9, '111122', 'disponibile', 1, 1, 'msi', 'DAA520', 'hp.png', ''),
(10, '111123', 'disponibile', 1, 1, 'msi', 'DAA520', 'hp.png', ''),
(11, '111124', 'disponibile', 1, 1, 'msi', 'DAA520', 'hp.png', ''),
(12, '111125', 'disponibile', 1, 1, 'msi', 'DAA520', 'hp.png', ''),
(13, '111126', 'disponibile', 1, 1, 'msi', 'DAA520', 'hp.png', ''),
(14, '111127', 'disponibile', 1, 1, 'msi', 'DAA520', 'hp.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `articoli_eliminati`
--

CREATE TABLE `articoli_eliminati` (
  `id_articolo` int(11) NOT NULL,
  `numero_inventario` varchar(255) DEFAULT NULL,
  `stato` varchar(255) DEFAULT NULL,
  `fk_categoria` int(11) DEFAULT NULL,
  `fk_centro` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `colore` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `descrizione` text DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articoli_eliminati`
--

INSERT INTO `articoli_eliminati` (`id_articolo`, `numero_inventario`, `stato`, `fk_categoria`, `fk_centro`, `nome`, `colore`, `img`, `descrizione`, `deleted_at`) VALUES
(7, '111112', 'guasto', 1, 1, 'microsoft', 'DAA520', 'hp.png', '', '2024-04-03 20:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `tipologia` set('hardware','software') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categoria`, `categoria`, `tipologia`) VALUES
(1, 'computer', 'hardware'),
(2, 'ebook', 'hardware'),
(4, 'monitor', 'hardware'),
(5, 'mouse', 'hardware'),
(8, 'tastiera', 'hardware'),
(9, 'laptop', 'hardware'),
(10, 'cuffie', 'hardware');

-- --------------------------------------------------------

--
-- Table structure for table `centri`
--

CREATE TABLE `centri` (
  `id_centro` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `via` varchar(30) NOT NULL,
  `fk_città` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `centri`
--

INSERT INTO `centri` (`id_centro`, `nome`, `via`, `fk_città`) VALUES
(1, 'centro 1', 'via pippo 25', 1);

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
(1, 'Pordenone', '33170', 'PN', 'Italia'),
(3, 'Fontanafredda', '33074', 'PN', 'Italia'),
(4, 'Maniago', '33085', 'PN', 'Italia');

-- --------------------------------------------------------

--
-- Table structure for table `prenotazioni`
--

CREATE TABLE `prenotazioni` (
  `id_prenotazione` int(20) NOT NULL,
  `fk_articolo` int(20) NOT NULL,
  `fk_utente` int(20) NOT NULL,
  `data_ritiro` date NOT NULL,
  `data_restituzione` date NOT NULL,
  `stato` set('da ritirare','ritirato') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prenotazioni`
--

INSERT INTO `prenotazioni` (`id_prenotazione`, `fk_articolo`, `fk_utente`, `data_ritiro`, `data_restituzione`, `stato`) VALUES
(5, 1, 3, '2024-05-19', '2024-05-25', 'ritirato'),
(6, 1, 3, '2024-04-21', '2024-04-27', 'ritirato'),
(7, 2, 5, '2024-05-12', '2024-05-18', 'da ritirare');

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
  `fk_articolo` int(11) NOT NULL,
  `stato` set('non restituito','restituito') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestiti`
--

INSERT INTO `prestiti` (`id_prestito`, `data_inizio_prestito`, `data_restituzione`, `data_scadenza_prestito`, `fk_utente`, `fk_articolo`, `stato`) VALUES
(1, '2024-04-21', '2024-04-04', '2024-04-27', 3, 1, 'restituito');

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
  `passmd5` varchar(500) NOT NULL,
  `tipologia_utente` set('cliente','operatore','admin') NOT NULL,
  `img` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`id_utente`, `nome`, `cognome`, `indirizzo`, `fk_città`, `email`, `passmd5`, `tipologia_utente`, `img`) VALUES
(3, 'Admin', 'Saro', 'Via Pippo 24', 1, 'admin@saro.com', 'b148d49f6bae4d9ad68f05886dad3290', 'admin', 'IMG_2240.jpeg'),
(5, 'Riccardo', 'Saro', 'Via P.Amalteo 25', 3, 'riccardo@saro.com', 'b148d49f6bae4d9ad68f05886dad3290', 'cliente', 'Risorsa 17@4x-100.jpg'),
(7, 'fabio', 'pauletta', 'via mona 12', 4, 'fabio@pauletta', 'a53bd0415947807bcb95ceec535820ee', 'cliente', ''),
(9, 'fabio', 'pauletta', 'via mona 12', 4, 'fabio@pauletta.com', 'a53bd0415947807bcb95ceec535820ee', 'cliente', ''),
(10, 'fabio', 'pauletta', 'via mona 12', 4, 'f@p.com', 'a53bd0415947807bcb95ceec535820ee', 'cliente', '');

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
-- Indexes for table `articoli_eliminati`
--
ALTER TABLE `articoli_eliminati`
  ADD PRIMARY KEY (`id_articolo`);

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
-- Indexes for table `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`id_prenotazione`);

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
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_città` (`fk_città`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articoli`
--
ALTER TABLE `articoli`
  MODIFY `id_articolo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `centri`
--
ALTER TABLE `centri`
  MODIFY `id_centro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `città`
--
ALTER TABLE `città`
  MODIFY `id_città` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prenotazioni`
--
ALTER TABLE `prenotazioni`
  MODIFY `id_prenotazione` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `prestiti`
--
ALTER TABLE `prestiti`
  MODIFY `id_prestito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
