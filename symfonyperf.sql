-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 03 juil. 2019 à 12:01
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `symfonyperf`
--

-- --------------------------------------------------------
--
-- Déchargement des données de la table `app_user`
--

INSERT INTO `app_user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'toto@g.com', '[]', '$argon2i$v=19$m=1024,t=2,p=2$ZjJaTGJnSlZsRU1ubHhRZA$7PdlUxPR1ID2e/UTvvjNanNothxz4f5+1ywwsIO0Tj8'),
(2, 'tata@g.com', '[]', '$argon2i$v=19$m=1024,t=2,p=2$ZnZua0F3SEFmRlZoV0Y1Vg$3/Cn0onyqWoXydN8sLhpWcOPAfAGax6c3tqDeSfmf6w'),
(3, 'titi@g.com', '[]', '$argon2i$v=19$m=1024,t=2,p=2$WWtXa3NFM1pSQXJkN1NxQQ$UAEIY3tD2ROWTDTJ8WthfDJwZ5VYTmSTmzRlA+IGVEA'),
(4, 'tutu@tutu.tutu', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=1024,t=2,p=2$ZHNXNU9wL1R0Z3Q3eFBsMA$NwpaR50EMfVFCDwQ80PngY7tiDl9KTD2BY3AoOytwMo'),
(5, 'yaya@g.com', '[\"ROLE_SUPER_ADMIN\"]', '$argon2i$v=19$m=1024,t=2,p=2$d2RFWTJ3NWMubGh6VjZRMQ$rq4KmAwzv11+B3VwL/JwrBeg9YcnvWNDGgzbIH6p7fo');

-- --------------------------------------------------------

-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'vacances'),
(2, 'Cuisine'),
(3, 'Déco maison');
-- --------------------------------------------------------

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `description`, `price`, `nb_views`, `date_creation`, `date_modification`, `etat_publication`, `image_name`, `slug`, `publisher_id`) VALUES
(1, 1, 'Hamac', 'Pour se reposer après de long mois de code', '55.99', 0, '2019-07-01 08:22:35', NULL, 1, 'hamac.jpg', 'hamac', 1),
(2, 1, 'Parasol', 'Pour se protéger des rayons du soleil pendant cette canicule.', '29.99', 0, '2019-07-01 08:23:33', NULL, 1, 'parasol.jpg', 'parasol', 2),
(4, 1, 'Ballon de plage', 'Comment aller à la plage sans prendre le ballon qui va avec ?', '4.99', 0, '2019-07-01 08:26:56', NULL, 1, 'ballon.jpg', 'ballon-de-plage', 3);

-- --------------------------------------------------------
--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`id`, `label`) VALUES
(2, 'Sport'),
(3, 'Cinéma'),
(5, 'vacance');

commit;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
