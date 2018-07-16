-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 16. Jul 2018 um 15:36
-- Server-Version: 10.1.33-MariaDB
-- PHP-Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `eshop`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order`
--

CREATE TABLE `order` (
  `id_order` int(10) NOT NULL,
  `id_user` int(5) DEFAULT NULL,
  `total_price` float NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('pending','sent','cancelled','delivered') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `order`
--

INSERT INTO `order` (`id_order`, `id_user`, `total_price`, `datetime`, `status`) VALUES
(1, 2, 59.99, '2018-07-16 12:17:26', 'pending');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order_details`
--

CREATE TABLE `order_details` (
  `id_order_details` int(20) NOT NULL,
  `id_order` int(10) DEFAULT NULL,
  `id_product` int(5) DEFAULT NULL,
  `quantity` int(3) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `order_details`
--

INSERT INTO `order_details` (`id_order_details`, `id_order`, `id_product`, `quantity`, `price`) VALUES
(1, 1, 2, 1, 59.99);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product`
--

CREATE TABLE `product` (
  `id_product` int(5) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `color` enum('black','white','red','blue','orange','yellow','green','brown','pink','purple','indigo') NOT NULL,
  `size` enum('xs','s','m','l','xl','xxl') NOT NULL,
  `gender` enum('m','f','u') NOT NULL,
  `picture` varchar(120) NOT NULL,
  `picture2` varchar(120) DEFAULT NULL,
  `price` float NOT NULL,
  `stock` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `product`
--

INSERT INTO `product` (`id_product`, `reference`, `category`, `title`, `description`, `color`, `size`, `gender`, `picture`, `picture2`, `price`, `stock`) VALUES
(2, '1345', 'shoes', 'sandals', 'Don\\\'t forget the white socks ;D\r\nSALE: Buy one get free socks !', 'brown', 'xl', 'm', 'sandals_-1345_1531318301_374_socks-with-sandals.jpg', NULL, 59.99, 99),
(3, '5461', 'clothes', 'Tshirt', 'Just a white TShirt', 'white', 'xs', 'm', 'Tshirt_-5461_1531392844_97_front_large_extended.jpg', NULL, 49.99, 150);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reset_request`
--

CREATE TABLE `reset_request` (
  `id_reset_request` int(5) NOT NULL,
  `id_user` int(5) DEFAULT NULL,
  `key` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `reset_request`
--

INSERT INTO `reset_request` (`id_reset_request`, `id_user`, `key`, `status`) VALUES
(1, 2, '169b0de6742ad35e66a430d0a', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id_user` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(70) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `gender` enum('m','f','o') NOT NULL,
  `city` varchar(20) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `privilege` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `firstname`, `lastname`, `email`, `picture`, `gender`, `city`, `zip_code`, `address`, `privilege`) VALUES
(2, 'SyfuxX', '$2y$10$HLj8P50jBwN9NxIHajlwe.eK/VO6j9dr5dwT1mJVCEmw1WWykGADe', 'Dany', 'T', 'dany.thill@live.com', 'SyfuxX_-_1531747030_963_emo-wallpaper_black.jpg', 'm', 'kayl', '1337', 'donotremember', 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`);

--
-- Indizes für die Tabelle `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id_order_details`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Indizes für die Tabelle `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Indizes für die Tabelle `reset_request`
--
ALTER TABLE `reset_request`
  ADD PRIMARY KEY (`id_reset_request`),
  ADD KEY `id_user` (`id_user`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `order`
--
ALTER TABLE `order`
  MODIFY `id_order` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id_order_details` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `reset_request`
--
ALTER TABLE `reset_request`
  MODIFY `id_reset_request` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `id_order` FOREIGN KEY (`id_order`) REFERENCES `order` (`id_order`) ON UPDATE CASCADE,
  ADD CONSTRAINT `id_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `reset_request`
--
ALTER TABLE `reset_request`
  ADD CONSTRAINT `id_user2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
