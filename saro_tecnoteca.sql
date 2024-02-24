-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 24, 2024 alle 12:54
-- Versione del server: 10.4.8-MariaDB
-- Versione PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Struttura della tabella `articoli`
--

CREATE TABLE `articoli` (
  `id_articolo` int(11) NOT NULL,
  `numero_inventario` varchar(11) NOT NULL,
  `stato` set('disponibile','guasto','in prestito','prenotato') NOT NULL,
  `fk_categoria` int(11) NOT NULL,
  `fk_centro` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `colore` varchar(20) NOT NULL,
  `img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `articoli`
--

INSERT INTO `articoli` (`id_articolo`, `numero_inventario`, `stato`, `fk_categoria`, `fk_centro`, `nome`, `colore`, `img`) VALUES
(1, '123456', 'disponibile', 1, 1, 'hp', '919191', 'hp.png'),
(2, '111111', 'in prestito', 1, 1, 'macbook', '919191', 'hp.png'),
(4, '111112', 'disponibile', 1, 1, 'dell', 'DAA520', 'hp.png'),
(5, '111113', 'disponibile', 1, 1, 'acer', 'DAA520', 'hp.png'),
(6, '111114', 'disponibile', 1, 1, 'msi', 'DAA520', 'hp.png'),
(7, '111112', 'disponibile', 1, 1, 'microsoft', 'DAA520', 'hp.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `tipologia` set('hardware','software') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categorie`
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
-- Struttura della tabella `centri`
--

CREATE TABLE `centri` (
  `id_centro` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `via` varchar(30) NOT NULL,
  `fk_città` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `centri`
--

INSERT INTO `centri` (`id_centro`, `nome`, `via`, `fk_città`) VALUES
(1, 'centro 1', 'via pippo 25', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `città`
--

CREATE TABLE `città` (
  `id_città` int(30) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cap` varchar(30) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `stato` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `città`
--

INSERT INTO `città` (`id_città`, `nome`, `cap`, `provincia`, `stato`) VALUES
(1, 'Pordenone', '33170', 'PN', 'Italia');

-- --------------------------------------------------------

--
-- Struttura della tabella `prestiti`
--

CREATE TABLE `prestiti` (
  `id_prestito` int(11) NOT NULL,
  `data_inizio_prestito` date NOT NULL,
  `data_restituzione` date NOT NULL,
  `data_scadenza_prestito` date NOT NULL,
  `fk_utente` int(11) NOT NULL,
  `fk_articolo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id_utente`, `nome`, `cognome`, `indirizzo`, `fk_città`, `email`, `passmd5`, `tipologia_utente`) VALUES
(3, 'admin', 'admin', '', 1, 'admin@saro.com', '21232f297a57a5a743894a0e4a801fc3', 'admin');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `articoli`
--
ALTER TABLE `articoli`
  ADD PRIMARY KEY (`id_articolo`),
  ADD KEY `fk_categoria` (`fk_categoria`,`fk_centro`),
  ADD KEY `fk_centro` (`fk_centro`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indici per le tabelle `centri`
--
ALTER TABLE `centri`
  ADD PRIMARY KEY (`id_centro`),
  ADD KEY `fk_città` (`fk_città`);

--
-- Indici per le tabelle `città`
--
ALTER TABLE `città`
  ADD PRIMARY KEY (`id_città`);

--
-- Indici per le tabelle `prestiti`
--
ALTER TABLE `prestiti`
  ADD PRIMARY KEY (`id_prestito`),
  ADD KEY `fk_utente` (`fk_utente`,`fk_articolo`),
  ADD KEY `fk_articolo` (`fk_articolo`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id_utente`),
  ADD KEY `fk_città` (`fk_città`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `articoli`
--
ALTER TABLE `articoli`
  MODIFY `id_articolo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `centri`
--
ALTER TABLE `centri`
  MODIFY `id_centro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `città`
--
ALTER TABLE `città`
  MODIFY `id_città` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `prestiti`
--
ALTER TABLE `prestiti`
  MODIFY `id_prestito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `articoli`
--
ALTER TABLE `articoli`
  ADD CONSTRAINT `articoli_ibfk_1` FOREIGN KEY (`fk_categoria`) REFERENCES `categorie` (`id_categoria`),
  ADD CONSTRAINT `articoli_ibfk_2` FOREIGN KEY (`fk_centro`) REFERENCES `centri` (`id_centro`);

--
-- Limiti per la tabella `centri`
--
ALTER TABLE `centri`
  ADD CONSTRAINT `centri_ibfk_1` FOREIGN KEY (`fk_città`) REFERENCES `città` (`id_città`);

--
-- Limiti per la tabella `prestiti`
--
ALTER TABLE `prestiti`
  ADD CONSTRAINT `prestiti_ibfk_1` FOREIGN KEY (`fk_utente`) REFERENCES `utenti` (`id_utente`),
  ADD CONSTRAINT `prestiti_ibfk_2` FOREIGN KEY (`fk_articolo`) REFERENCES `articoli` (`id_articolo`);

--
-- Limiti per la tabella `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `utenti_ibfk_1` FOREIGN KEY (`fk_città`) REFERENCES `città` (`id_città`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
