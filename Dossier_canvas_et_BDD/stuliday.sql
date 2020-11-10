-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 10 nov. 2020 à 14:21
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stuliday`
--

-- --------------------------------------------------------

--
-- Structure de la table `adverts`
--

DROP TABLE IF EXISTS `adverts`;
CREATE TABLE IF NOT EXISTS `adverts` (
  `ads_id` int(11) NOT NULL AUTO_INCREMENT,
  `ads_title` varchar(255) NOT NULL,
  `ads_content` mediumtext NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`ads_id`),
  KEY `user_fk` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `adverts`
--

INSERT INTO `adverts` (`ads_id`, `ads_title`, `ads_content`, `address`, `city`, `price`, `images`, `user_id`) VALUES
(1, 'Chambre Villa', 'Villa près de la plage', 'Boopbip les bains', 'Lamer', 5000, NULL, 9),
(2, 'Maison de Jean', 'Une maison medievale', '331 rue du pissenlit', 'Rouen', 12000, '5faa6b9d19644_microsoft-sql.jpg', 10),
(9, 'Maison du futur', 'Tellement futuriste qu\'elle reflete les etoiles de loin, tres loin', '123 avenue de Ceres', 'Lunopolis', 153200, NULL, 10),
(16, 'Chateau d\'eau', 'Un chateau tout liquide', '88 canal de la dorsale', 'New Atlantide', 952634, '', 10),
(23, 'zzz', 'zzz', 'zzz', 'zzz', 123, '5faa630de80eb_ARCLABS.jpg', 10),
(25, 'Animation studio', 'A small (yet full of content) studio that most developers hate because JS is just better', 'jQuery.com', '$undefined', 1, '5faa873298249_Jquery-logo.png', 10);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `reserv_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_client` int(11) NOT NULL,
  `book_advert_fk` int(11) NOT NULL,
  `bookname` varchar(255) NOT NULL,
  PRIMARY KEY (`reserv_id`),
  KEY `advert_fk` (`book_advert_fk`),
  KEY `client_fk` (`book_client`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`) VALUES
(9, 'zzzz@zzzz', '$2y$10$uRbiMINPZSQRGsl6tHbyZuWfLKrtYT2PGxe0iq3MM0U2HQ7JX41Qy', 'zzzz'),
(10, 'jean@gmail.com', '$2y$10$KVH1ownylZ716YJFJuin2.0vaOu9SmHsb0AC4nH8TTJBC98hQInta', 'Jean Dandelion');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adverts`
--
ALTER TABLE `adverts`
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `advert_fk` FOREIGN KEY (`book_advert_fk`) REFERENCES `adverts` (`ads_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_fk` FOREIGN KEY (`book_client`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
