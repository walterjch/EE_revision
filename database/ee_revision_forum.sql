-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 03 Septembre 2018 à 09:11
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ee_revision_forum`
--
CREATE DATABASE IF NOT EXISTS `ee_revision_forum` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ee_revision_forum`;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `idNews` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastEditDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `news`
--

INSERT INTO `news` (`idNews`, `title`, `description`, `creationDate`, `lastEditDate`, `idUser`) VALUES
(1, 'Message du createur du site', 'Mon nom est Jauch Walter. Je suis l&#39;administrateur du forum. Celui-ci est un forum pour tous les etudiants voulant le rejoindre. Sur ce, bonne semaine a tous :)', '2018-09-02 18:27:44', '2018-09-02 18:27:44', 4),
(3, 'Test depuis Tewex', 'Ici, je teste le création de news depuis un autre utilisateur.', '2018-09-02 18:27:44', '2018-09-02 18:27:44', 1),
(17, 'Bienvenue a tous', 'Vous etes tous bienvenue dans la communauté du CFPT, nous repondans à vos questions !!!', '2018-09-02 18:27:44', '2018-09-02 18:27:44', 3),
(18, 'Bonjour', 'Bonjour à tous, je suis nouveau ici. Je vous souhaite une belle journée à tous ! :) EDIT: Je passerai sur le forum 3 fois par semaine', '2018-09-03 05:50:00', '2018-09-03 05:50:00', 5);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `login` varchar(30) NOT NULL,
  `pwd` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`idUser`, `name`, `surname`, `login`, `pwd`) VALUES
(1, 'Hurlimann', 'Theo', 'tewex', '235ea5279f42c4e4ffbcaa2be3783c89e9d10b2a'),
(2, 'test', 'test', 'test', '9bc34549d565d9505b287de0cd20ac77be1d3f2c'),
(3, 'Machado', 'Jean Daniel', 'xel', '203f8de17a6d7183d5a14b30269ab1641cf49774'),
(4, 'Jauch', 'Walter', 'xeus', '6a8ed956a0437942d92feff7b1534a54ea4804e4'),
(5, 'Huber', 'Fabian Stephane', 'stowy', '489bc50fcca645ec3e668b66095cb7f1b54a9644'),
(6, 'EE', 'professeur', 'professor', '2c34b93dd8a5fb46cf371f2f625cd553b219d7e9');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`idNews`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `idNews` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
