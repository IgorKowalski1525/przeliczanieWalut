-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 07, 2023 at 02:25 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `waluty`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kursy_walut`
--

CREATE TABLE `kursy_walut` (
  `currency` varchar(64) NOT NULL,
  `code` varchar(3) NOT NULL,
  `mid` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kursy_walut`
--

INSERT INTO `kursy_walut` (`currency`, `code`, `mid`) VALUES
('bat (Tajlandia)', 'THB', 0.1205),
('dolar amerykański', 'USD', 4.1887),
('dolar australijski', 'AUD', 2.8024),
('dolar Hongkongu', 'HKD', 0.5342),
('dolar kanadyjski', 'CAD', 3.1286),
('dolar nowozelandzki', 'NZD', 2.5464),
('dolar singapurski', 'SGD', 3.1079),
('euro', 'EUR', 4.479),
('forint (Węgry)', 'HUF', 0.012144),
('frank szwajcarski', 'CHF', 4.6211),
('funt szterling', 'GBP', 5.2109),
('hrywna (Ukraina)', 'UAH', 0.114),
('jen (Japonia)', 'JPY', 0.030055),
('korona czeska', 'CZK', 0.1897),
('korona duńska', 'DKK', 0.6012),
('korona islandzka', 'ISK', 0.029761),
('korona norweska', 'NOK', 0.3794),
('korona szwedzka', 'SEK', 0.3845),
('lej rumuński', 'RON', 0.9034),
('lew (Bułgaria)', 'BGN', 2.2901),
('lira turecka', 'TRY', 0.181),
('nowy izraelski szekel', 'ILS', 1.145),
('peso chilijskie', 'CLP', 0.00526),
('peso filipińskie', 'PHP', 0.0747),
('peso meksykańskie', 'MXN', 0.2413),
('rand (Republika Południowej Afryki)', 'ZAR', 0.2193),
('real (Brazylia)', 'BRL', 0.8525),
('ringgit (Malezja)', 'MYR', 0.9098),
('rupia indonezyjska', 'IDR', 0.00028155),
('rupia indyjska', 'INR', 0.050772),
('won południowokoreański', 'KRW', 0.003214),
('yuan renminbi (Chiny)', 'CNY', 0.5882),
('SDR (MFW)', 'XDR', 5.5724);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przewalutowania`
--

CREATE TABLE `przewalutowania` (
  `Id` int(11) NOT NULL,
  `podana_kwota` float NOT NULL,
  `waluta_zrodlowa` varchar(32) NOT NULL,
  `waluta_docelowa` varchar(32) NOT NULL,
  `wynik` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `przewalutowania`
--

INSERT INTO `przewalutowania` (`Id`, `podana_kwota`, `waluta_zrodlowa`, `waluta_docelowa`, `wynik`) VALUES
(1, 25, 'frank szwajcarski', 'dolar Hongkongu', 216.263),
(2, 25, 'frank szwajcarski', 'dolar Hongkongu', 216.263),
(3, 15, 'frank szwajcarski', 'dolar Hongkongu', 129.758),
(4, 15, 'frank szwajcarski', 'dolar Hongkongu', 129.758),
(5, 15, 'frank szwajcarski', 'dolar Hongkongu', 129.758),
(6, 52, 'frank szwajcarski', 'dolar Hongkongu', 449.826),
(7, 52, 'frank szwajcarski', 'dolar Hongkongu', 449.826),
(8, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(9, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(10, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(11, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(12, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(13, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(14, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(15, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(16, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(17, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(18, 175, 'frank szwajcarski', 'dolar Hongkongu', 1513.84),
(19, 25.6, 'frank szwajcarski', 'dolar Hongkongu', 221.453),
(20, 12, 'frank szwajcarski', 'dolar Hongkongu', 103.806),
(21, 165, 'frank szwajcarski', 'dolar Hongkongu', 1427.33),
(22, 24, 'frank szwajcarski', 'dolar Hongkongu', 207.612),
(23, 12, 'frank szwajcarski', 'dolar Hongkongu', 103.806),
(24, 12, 'frank szwajcarski', 'dolar Hongkongu', 103.806),
(25, 12, 'frank szwajcarski', 'dolar Hongkongu', 103.806),
(26, 12, 'frank szwajcarski', 'dolar Hongkongu', 103.806),
(27, 12, 'frank szwajcarski', 'dolar Hongkongu', 103.806),
(28, 12, 'frank szwajcarski', 'dolar Hongkongu', 103.806),
(29, 11.95, 'frank szwajcarski', 'dolar Hongkongu', 103.374),
(30, 346, 'frank szwajcarski', 'dolar Hongkongu', 2993.07),
(31, 266, 'frank szwajcarski', 'dolar Hongkongu', 2301.03),
(32, 345, 'frank szwajcarski', 'dolar Hongkongu', 2984.42),
(33, 345, 'dolar singapurski', 'euro', 239.389),
(34, 345, 'dolar singapurski', 'euro', 239.389),
(35, 2321, 'hrywna (Ukraina)', 'korona szwedzka', 688.151);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `przewalutowania`
--
ALTER TABLE `przewalutowania`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `przewalutowania`
--
ALTER TABLE `przewalutowania`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
