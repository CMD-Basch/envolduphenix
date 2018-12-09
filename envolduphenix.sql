-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 09 déc. 2018 à 13:33
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `envolduphenix`
--

-- --------------------------------------------------------

--
-- Structure de la table `activity`
--

DROP TABLE IF EXISTS `activity`;
CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_id` int(11) DEFAULT NULL,
  `activity_type_id` int(11) DEFAULT NULL,
  `round_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `game` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slots` int(11) NOT NULL,
  `local_start` datetime DEFAULT NULL,
  `local_end` datetime DEFAULT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AC74095A13B3DB11` (`master_id`),
  KEY `IDX_AC74095AA6005CA0` (`round_id`),
  KEY `IDX_AC74095AC51EFA73` (`activity_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `activity`
--

INSERT INTO `activity` (`id`, `master_id`, `activity_type_id`, `round_id`, `name`, `description`, `game`, `style`, `slots`, `local_start`, `local_end`, `tag`) VALUES
(6, NULL, 3, 5, 'Soirée loup garou', 'Uns soirée ambiance !!!', 'Loup garou de thiercelieux', 'Ambiance', 90, '2018-05-11 19:00:00', NULL, 'LGT'),
(7, NULL, 4, 7, 'Murder du Samedi', 'Murder du Samedi', 'Murder', 'Enquête', 20, NULL, NULL, 'MU-S'),
(8, NULL, 4, 8, 'Murder du Dimanche', 'Murder du Dimanche', 'Murder du Dimanche', 'Enquête', 20, NULL, NULL, 'MU-D'),
(9, NULL, 3, 5, 'Partie de Carcassonne', 'qsdqsdqsdqsd', 'Carcassonne', 'Stratégie', 6, NULL, NULL, NULL),
(10, NULL, 3, 6, 'zerzer', 'rzerze', 'ezrze', 'rzerze', 5, NULL, NULL, NULL),
(11, NULL, 3, 6, 'Test', 'azeazeaze', 'SmallWorld', 'azeaze', 9, '2018-05-12 22:30:00', NULL, NULL),
(12, 2, 1, 1, 'Table 2', 'fddgdfgdfgdg', 'dfgdfg', 'dfgdfg', 6, NULL, NULL, NULL),
(13, 5, 1, 1, 'dsjhlidjhfds', 'sdfsdflsk dfmskdnfmks dnjfksdjf kdhjksdflsfsf\r\n sk fmskfjj msiffeihmzemizemioze jmi ezomzeioh mzeiih zei hzemh zmeoi hzemoi hezm io he zmoihemoihem oioem ihemg ihermg iohemgo ihemg oiheg oiherm oihe iohermoi herl i huerl k irhgleruih glekruh gieu hrlgie hrliehr lg', 'sdfs', 'fsdf', 6, NULL, NULL, NULL),
(14, 18, 1, 1, 'xcvfggfh', 'hfgn<br>\r\nsdfdfsdfddsf<br>\r\ndsfsdlkfsdmk<br>\r\nfheljkflzekjhf<br>', 'h', 'nhg', 9, NULL, NULL, NULL),
(15, 17, 1, 1, 'pppp', 'ppp', 'p', 'p', 4, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `activity_type`
--

DROP TABLE IF EXISTS `activity_type`;
CREATE TABLE IF NOT EXISTS `activity_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `activity_type`
--

INSERT INTO `activity_type` (`id`, `name`, `slug`, `tag`) VALUES
(1, 'roleplay', '', ''),
(2, 'wargame', '', ''),
(3, 'boardgame', '', ''),
(4, 'murder', 'murder', 'murder');

-- --------------------------------------------------------

--
-- Structure de la table `activity_user`
--

DROP TABLE IF EXISTS `activity_user`;
CREATE TABLE IF NOT EXISTS `activity_user` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`,`user_id`),
  KEY `IDX_8E570DDB81C06096` (`activity_id`),
  KEY `IDX_8E570DDBA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `event`
--

INSERT INTO `event` (`id`, `name`, `start`, `end`) VALUES
(1, 'Envol 2', '2019-01-01 00:00:00', '2019-01-03 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `event_user`
--

DROP TABLE IF EXISTS `event_user`;
CREATE TABLE IF NOT EXISTS `event_user` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`event_id`,`user_id`),
  KEY `IDX_92589AE271F7E88B` (`event_id`),
  KEY `IDX_92589AE2A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `event_user`
--

INSERT INTO `event_user` (`event_id`, `user_id`) VALUES
(6, 7),
(6, 565),
(7, 2),
(7, 9),
(8, 2),
(8, 3),
(8, 5),
(8, 6),
(8, 9),
(11, 20),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(12, 11);

-- --------------------------------------------------------

--
-- Structure de la table `global_param`
--

DROP TABLE IF EXISTS `global_param`;
CREATE TABLE IF NOT EXISTS `global_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`id`, `name`, `color`, `pic`, `weight`, `active`, `slug`) VALUES
(1, 'L\'événement', 'bd-bleu', 'blk', 0, 1, 'evt'),
(2, 'Jeu de rôle', 'bd-orange', 'jdr', 1, 1, 'jdr'),
(3, 'Wargame', 'bd-orange', 'wg', 2, 1, 'wg'),
(4, 'Jeu de société', 'bd-bleu', 'jds', 3, 1, 'jds'),
(5, 'Joutes médiévales', 'bd-orange', 'blk', 4, 1, 'esc');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180408120508'),
('20180408122307'),
('20180409114033'),
('20180409114407'),
('20180409194855'),
('20180409195037'),
('20180409202307'),
('20180409203050'),
('20180415144746'),
('20180415144910'),
('20180415153935'),
('20180415161110'),
('20180415161509'),
('20180416181250'),
('20180416200906');

-- --------------------------------------------------------

--
-- Structure de la table `parrainer`
--

DROP TABLE IF EXISTS `parrainer`;
CREATE TABLE IF NOT EXISTS `parrainer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parrainer`
--

INSERT INTO `parrainer` (`id`, `name`, `link`, `picture_link`, `weight`) VALUES
(1, 'Mairie Cahors', 'http://www.mairie-cahors.fr/', 'cahors.png', 2),
(2, 'Grand Cahors', 'http://www.grandcahors.fr/', 'grand_cahors.gif', 5),
(3, 'MJC Cahors', 'http://www.mjc-cahors.fr/', 'mjc.jpg', 1),
(4, 'Alkemy', 'https://alkemy-the-game.com/fr/', 'alkemy-the-game.jpg', 50),
(5, 'France Blood Bowl', 'http://teamfrancebb.positifforum.com/', 'bbfrance.jpg', 50),
(6, 'Ludotheque', 'http://www.grandcahors.fr/servir/enfance/la-ludotheque/article/acces-au-service', 'ludotheque.jpg', 6),
(7, 'La loutre roliste', 'http://www.laloutreroliste.fr/', 'loutre-roliste.png', 50),
(8, 'Region Occitanie', 'https://www.laregion.fr/', 'occitanie.png', 4),
(9, 'Service Jeunesse', 'http://www.mairie-cahors.fr/Ville/jeunesse/AccueilJeunes.html', 'servicejeunesse.jpg', 3),
(10, 'Banque Popuplaire', 'https://www.banquepopulaire.fr', 'bpop.png', 100),
(11, 'Agora', 'https://www.facebook.com/pages/Agora-Kebab/328972713870707', 'agora.png', 100),
(12, 'Alliance pub', 'http://www.alliancepub46.fr/', 'alliance-pub.jpg', 100),
(13, 'Au quercy bio', 'http://www.au-quercy-bio.fr/', 'au-quercy-bio.png', 100),
(14, 'Best Western', 'http://www.divona-hotel-cahors.com/', 'best-western.jpg', 100),
(15, 'Cadurchien', 'https://www.facebook.com/pages/Le-Cadurchien/1565247233485554?ref=br_rs', 'cadurchien.png', 100),
(16, 'Cahors Funeraire', 'https://www.pompes-funebres-lot-cahors-funeraires.fr/', 'cahors-funeraire.png', 100),
(17, 'Catakombe', 'http://catacombesleregnesombre.id.st/', 'catakombe.jpg', 100),
(18, 'CER Crespo', 'http://www.auto-ecole-crespo-cahors.fr/', 'cer-crespo.png', 100),
(19, 'CSX', 'http://www.cahors-informatique.com/FR/', 'csx.png', 100),
(20, 'Days of Wonder', 'https://www.daysofwonder.com/fr/', 'days-wonder.jpg', 50),
(21, 'Decapage 46', 'http://www.decapage-nettoyage-46.fr/', 'decapage.png', 100),
(22, 'Delice de valentré', '#', 'delice.jpg', 100),
(23, 'Foirfouille', 'https://magasins.lafoirfouille.fr/fr_FR/decoration/cahors/0209', 'foirfouille.png', 100),
(24, 'Golem', 'https://golem-miniatures.com/fr/', 'golem.jpg', 100),
(25, 'Iello', 'https://www.iello.fr/', 'iello.png', 100),
(26, 'Intersport', 'http://www.intersport.fr/Lot-46/CAHORS-46000/INTERSPORT-CAHORS/00207_000/', 'intersport.png', 100),
(27, 'King Jouet', 'https://www.king-jouet.com/magasins/46-Lot/magasin-CAHORS-0331.htm', 'king-jouet.jpg', 50),
(28, 'Les halles du pech biel', '#', 'les-halles-du-pech-biel.png', 100),
(29, 'Libellud', 'http://www.libellud.com/', 'libellud.jpg', 100),
(30, 'Pro Securite', 'https://www.prosecurite46.com/', 'logo-securite-1.png', 100),
(31, 'Maison de la presse', '#', 'maison-presse.png', 100),
(32, 'Maow', 'https://www.maow-miniatures.fr/', 'maow.jpg', 100),
(33, 'Mr K Escape Game', 'http://www.mrkescapegame.com/', 'mr-k-game.jpg', 100),
(34, 'Racine en tete', 'https://www.facebook.com/Racine-en-tete-761904260577940/', 'racine-en-tete.png', 100),
(35, 'Symbiose', 'https://fr.mappy.com/poi/4d6c8842fc6925073c9910d7#/1/M2/TGeoentity/F4d6c8842fc6925073c9910d7/N151.12061,6.11309,1.44232,44.44704/Z15/', 'symbiose.png', 100),
(36, 'Terre gourmande', 'http://www.terregourmande.fr/', 'terre-gourmande.png', 100),
(37, 'Touajin', 'https://www.facebook.com/touajintraiteur.cahors/', 'touajin.png', 100);

-- --------------------------------------------------------

--
-- Structure de la table `round`
--

DROP TABLE IF EXISTS `round`;
CREATE TABLE IF NOT EXISTS `round` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_type_id` int(11) DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C5EEEA34C51EFA73` (`activity_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `round`
--

INSERT INTO `round` (`id`, `activity_type_id`, `code`, `name`, `start`, `end`, `slug`) VALUES
(1, 1, 'vendredi-soir-jdr', 'Vendredi Soir', '2018-05-11 21:00:00', '2018-05-12 04:00:00', 'vendredi-soir'),
(2, 1, 'samedi-journee-jdr', 'Samedi journée', '2018-05-12 11:00:00', '2018-05-12 19:00:00', 'samedi-journee'),
(3, 1, 'samedi-soir-jdr', 'Samedi soir', '2018-05-12 21:00:00', '2018-05-13 04:00:00', 'samedi-soir'),
(4, 1, 'dimanche-journee-jdr', 'Dimanche journée', '2018-05-13 11:00:00', '2018-05-13 16:00:00', 'dimanche-journee'),
(5, 3, 'vendredi-soir-jds', 'Vendredi Soir', '2018-05-11 20:00:00', '2018-05-12 04:00:00', 'vendredi-soir'),
(6, 3, 'samedi-soir-jds', 'Samedi Soir', '2018-05-12 21:00:00', '2018-05-13 04:00:00', 'samedi-soir'),
(7, 4, 'murder-samedi', 'Murder du Samedi', '2018-05-12 14:00:00', '2018-05-12 18:00:00', 'murder-samedi'),
(8, 4, 'murder-dimanche', 'Murder du Dimanche', '2018-05-13 11:00:00', '2018-05-13 15:00:00', 'murder-dimanche');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `roles` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `sleep` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `hash`, `valid`, `is_active`, `created`, `updated`, `roles`, `sleep`) VALUES
(1, 'Basch', 'Cedric', 'Molines', 'ced_46000@hotmail.com', '$2y$13$O20BMdGs2..CA0XZtVVKXuCvUrPCXkpDLiteLAZ6z9IvGCzX/Z4cq', '$2y$13$jcwH7Jb8mzevk3VR8XMisO/qEqd/pmOtDac9K9gQscTiDV2zcmyi2', 1, 0, '2018-04-16 20:45:00', '2018-04-16 20:45:00', 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 'nope'),
(2, 'Jdr', 'Admin', 'JDR', 'admin.jdr@example.com', '$2y$13$O20BMdGs2..CA0XZtVVKXuCvUrPCXkpDLiteLAZ6z9IvGCzX/Z4cq', '$2y$13$R6aJlPR8cLPNzMP6NNr4q.6Q3HLikoAjrf7IdCXjzj/CYTNmL0LrK', 1, 0, '2018-04-16 21:19:00', '2018-04-16 21:19:00', 'a:2:{i:0;s:10:\"ROLE_ADMIN\";i:1;s:8:\"ROLE_JDR\";}', 'nope'),
(3, 'Morora', 'Marion', 'Hamard', 'marion.hamardvasnier@gmail.com', '$2y$13$BPOorTB/M4kDvELbA0eIDu67Y6QAsgXHtJvAjeEjDj.skCmnFLEky', '$2y$13$hWgV.6O3.FOp9XmsmL2ZRO./sqglX1kvLHleQqVV5toTIi0WMSEj6', 1, 0, '2018-04-17 06:14:51', '2018-04-17 06:14:51', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'nope'),
(4, 'Fenouil', 'Alice', 'Tailliar', 'fey.aery@gmail.com', '$2y$13$uoNaBIRjdtzci.1wkxHc9OhvaVPXl9yzvf0SP7gB0v3LAs/LIHHni', '$2y$13$wGE0ERBKbN3XvDOVF7tfC.7fTu2t.6ER0WEv9R4.4tRncBYTP1SN6', 1, 0, '2018-04-17 06:15:58', '2018-04-17 06:15:58', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'nope'),
(5, 'Nicolas', 'Nicolas', 'Guérin', 'nicolas.guerin.31@gmail.com', '$2y$13$0CFvRvs/uYCnOBz.9iLUCeKrdVkNoi1M5uTy9.UQEULR7JeSDM2fi', '$2y$13$z/Ohri5VFwD86Ss6TQlDKeFjBqukVytHESc5rMmdnmaJrDddxWUUm', 1, 0, '2018-04-17 12:51:53', '2018-04-17 12:51:53', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'nope'),
(6, 'Sid', 'Benjamin', 'Vdpk', 'benj.vdpk@gmail.com', '$2y$13$UhwhAbhBljS216G6oiTNKODdaHehlLj.WNFgUK9s5u9eFSa0dbgRu', '$2y$13$5Qi3g3w.2cqyXLj2kGt8FO3deJ1DWIji8xLFhX7FKsBA37HajB8E.', 1, 0, '2018-04-18 15:53:22', '2018-04-18 15:53:22', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'ven & sam'),
(7, 'alyssa', 'Alyssa', 'De bruyne', 'alyssa.debruyne@sfr.fr', '$2y$13$FEaGT7i9NtaOMaWLbEdQeeTPKGXzt12XY81yxUGwK2j8OEChyUjdG', '$2y$13$dpXJbzlpvETWCbWo7VjufOxx/9UyvZKkGs76bjy4tlIyP9c2B0Yvu', 1, 0, '2018-04-18 17:41:11', '2018-04-18 17:41:11', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'ven & sam'),
(8, 'SARYEKAD', 'amaury', 'ithier', 'guizmomog@hotmail.fr', '$2y$13$XKT8PK2zUfr004vsEuWWcuu.Tsh6EFqfIfdfYIWWjnc7tUt7h39l6', '$2y$13$/I1r2XPhV8Yc24kufzlNSOojE/SkggF/jinpYmlf8JD8bezGhh59G', 1, 0, '2018-04-18 22:00:24', '2018-04-18 22:00:24', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'ven & sam'),
(9, 'Nymphétamine', 'Emmanuelle', 'POUZIN', 'e.pouzin@gmail.com', '$2y$13$6EiaaYnkBxuohSjHJ1qynOWIzKlLnScvKkVCINtV60Rji/768u4MC', '$2y$13$5ysPl5O/kRBLkDlCKkhpHejJcX6Db1aXw2WPHUxIeSStq/kc2C0BW', 1, 0, '2018-04-18 22:16:43', '2018-04-18 22:16:43', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'ven & sam'),
(10, 'Onan', 'Jean', 'Monnom', 'campredon.jean@yahoo.fr', '$2y$13$icmongTlnBcPASKReBJ1b.GWU0guP1rfjaogib1DK51cRbkxXSh2u', '$2y$13$oYvRmZFCmcm/6ae.VUHIVORUy/dzASP67xYc6BKQumvdnFND4Rs8G', 1, 0, '2018-04-19 13:09:09', '2018-04-19 13:09:09', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'nope'),
(11, 'LoFredou', 'Frédéric', 'Grimardia', 'frederic.grimardia@wanadoo.fr', '$2y$13$SbpBLb8w3IZJWrB.5IFk.ecQqukFSDQlq6KlVAxeF.10pEJmJHJcK', '$2y$13$Ilb2o1.cOwgTzXt4V7U99OX.uR9Sm9P5meWJrZISt0QXr7lBGfFuS', 1, 0, '2018-04-19 16:45:53', '2018-04-19 16:45:53', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'nope'),
(12, 'nightwish', 'CEDRIC', 'TANA', 'cedric.tana@gmail.com', '$2y$13$HO6T/7DcWt41fEQijxXJze/p49nUIzWVrHoNz0MbMuEWDSXWcNR1m', '$2y$13$C6KW8uxWVEOmeueNyGyki.g4JgWBbCAOf5Lfy3eWkMuQq2lJxmcq6', 1, 0, '2018-04-19 19:30:18', '2018-04-19 19:30:18', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'ven & sam'),
(13, 'solene', 'solene', 'DUBOIS', 's.dubois584@laposte.net', '$2y$13$CklaaPQGPz5MXjjE1I8bEOYw9ybJE5hNlydms15Nu/WhXrID4Wmta', '$2y$13$zdATLvmhoyvruw67BVFovelMQOzZ.lMowoiE7W1ulNO/GfO0LZoAu', 1, 0, '2018-04-19 21:29:00', '2018-04-19 21:29:00', 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'nope'),
(14, 'Mug Max', 'Maxime', 'Puyo', 'maxime.puyo@gmail.com', '$2y$13$Mc0i0RSZh0pk2kPElik8tOU8Rg.sv9h9AKwhbNRFnQUm3oNCTbhD.', '$2y$13$hMi31OUMPBdj1U8rO/Mxoedn8qKgoM5xHudfLxdboJXOHGcyG1/hK', 1, 0, '2018-04-23 19:10:55', '2018-04-23 19:10:55', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'nope'),
(15, 'krugger', 'frederic', 'padro', 'frederic.padro@wanadoo.fr', '$2y$13$F9vt412lFqWWQcWVouS0bOwdIHmGXm/brOjZY8p72o4MinzOUA6mS', '$2y$13$kEYkOBDEUzpNB2sb116X8Ocklk4kqPBSqnBQLYEK55FBBpnKY4PDa', 1, 0, '2018-04-23 21:01:14', '2018-04-23 21:01:14', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'ven & sam'),
(16, 'Kaelpyros', 'Floriant', 'Vigne', 'kaimitsu@hotmail.fr', '$2y$13$F5Y6zHD/fjraTLdHSbZRmuisMTBVPSx2L4ohlhUr/zmG9vssKorF2', '$2y$13$zi8leXjH/vRNfr7s.N2Nn.ExORSDX1Ab/2/8wZW.iv.wi9./TEIsi', 1, 0, '2018-04-24 14:43:22', '2018-04-24 14:43:22', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'nope'),
(17, 'Seb', 'Sébastien', 'Gayraud', 'vignou1411@gmail.com', '$2y$13$zahSbUDEmcB.EFIZhnWTWOMBJ3l9EdfA51jzrMG8uQHVqacTLEyF.', '$2y$13$./OWz8rL785knn.nS3MdQuBbIDDJicBag0LMgZJn9vJK/oosskl8G', 1, 0, '2018-04-24 17:18:05', '2018-04-24 17:18:05', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'ven & sam'),
(18, 'Pyrus', 'Aladin', 'Claise', 'alclaise@hotmail.fr', '$2y$13$NJkwcQ9YNGxQ2H4ZLvpim.PB65CpPYMLMWPrlV7.A2ZUfNAwY4iQK', '$2y$13$hhkTR4wwsgJwcxdiGldTXurpKDOCWG28HI.l8wMfMK1frCi2XR.MK', 1, 0, '2018-04-24 19:50:40', '2018-04-24 19:50:40', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 'nope'),
(19, 'Skwyrrel', 'Kévin', 'JOUET', 'kevin.jouet@gmail.com', '$2y$13$e1RpUW1B65vR1ub1bXEzHOFcJ7rDZDFXIwWRa/39n4ZNTl3K8uvlq', '$2y$13$VGmeIhtOHGMLcGuhJsIB5eIJRpwAS6hJVXffRQbXr8ZFpce93oDIa', 1, 0, '2018-04-25 11:16:00', '2018-04-25 11:16:00', 'a:2:{i:0;s:9:\"ROLE_USER\";i:1;s:8:\"ROLE_JDS\";}', 'nope'),
(20, 'Test', 'Test', 'Test', 'test@mail.com', '$2y$13$1.YYGMY0fmBlAdL/q/q9Ce8hBg/vQtNQIeUrXcbjo8NtGW5/XgohO', '$2y$13$1.YYGMY0fmBlAdL/q/q9Ce8hBg/vQtNQIeUrXcbjo8NtGW5/XgohO', 1, 1, '2013-01-01 00:00:00', '2013-01-01 00:00:00', 'a:1:{i:0;s:9:\"ROLE_USER\";}', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_event`
--

DROP TABLE IF EXISTS `user_event`;
CREATE TABLE IF NOT EXISTS `user_event` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`event_id`),
  KEY `IDX_D96CF1FFA76ED395` (`user_id`),
  KEY `IDX_D96CF1FF71F7E88B` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_menu`
--

DROP TABLE IF EXISTS `user_menu`;
CREATE TABLE IF NOT EXISTS `user_menu` (
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`menu_id`),
  KEY `IDX_784765AA76ED395` (`user_id`),
  KEY `IDX_784765ACCD7E912` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_menu`
--

INSERT INTO `user_menu` (`user_id`, `menu_id`) VALUES
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `view`
--

DROP TABLE IF EXISTS `view`;
CREATE TABLE IF NOT EXISTS `view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `weight` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `image_dimensions` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:simple_array)',
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FEFDAB8ECCD7E912` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `view`
--

INSERT INTO `view` (`id`, `menu_id`, `name`, `link`, `content`, `weight`, `active`, `title`, `subtitle`, `fixed`, `image_name`, `image_original_name`, `image_mime_type`, `image_size`, `image_dimensions`, `deleted`) VALUES
(1, 1, 'Contact', NULL, '\r\n			<p>Jeux de rôles : <a class=\"lien-contact\" href=\"mailto:lephenixcadurcien@live.fr\">lephenixcadurcien@live.fr</a></p>\r\n			<p>Concours scénario : <a class=\"lien-contact\" href=\"mailto:scenario.envol.du.phenix@gmail.com\">scenario.envol.du.phenix@gmail.com</a></p>\r\n			<p>Autres : <a class=\"lien-contact\" href=\"mailto:lephenixcadurcien@live.fr\">lephenixcadurcien@live.fr</a></p>\r\n', 0, 1, 'Contact', 'Une question ? Une suggestion ? Écrivez-nous !', 0, NULL, NULL, NULL, NULL, NULL, 0),
(2, 1, 'Infos Pratiques', NULL, '<!-- Texte -->\r\n	<div class=\"row justify-content-center\">\r\n		<div class=\"col-sm-6 sup-padd\">\r\n			<h3 class=\"titre-page\">L\'Envol du Phénix</h3>\r\n			<hr class=\"hr-titre\">\r\n			<h5 id=\"ss-titre-infos\">11, 12 et 13 Mai 2018<br>\r\n				Espace Valentré, Allées des Soupirs, 46000 Cahors </h5>\r\n			<br>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2848.515460415642!2d1.4318160154748891!3d44.44310057910216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12ac89661e8648eb%3A0xbc33f21a7042c3c5!2sEspace+Valentr%C3%A9!5e0!3m2!1sfr!2sfr!4v1493930846057\" width=\"100%\" height=\"400\" frameborder=\"0\" style=\"border:0\" allowfullscreen=\"\"></iframe>\r\n	</div> <!-- row -->\r\n	<div class=\"row justify-content-center\">\r\n		<div class=\"col-sm-6 form-ic\" id=\"vtl-line-gold\">\r\n			<p><strong>Infos diverses</strong><br>\r\n				Restauration sur place<br>\r\n				Les mineurs souhaitant rester sur place après 19h doivent être accompagnés d\'un adulte ou munis d\'une autorisation parentale signée.<br>\r\n			</p>\r\n <div class=\"alert alert-warning\" style=\"font-size: small\" role=\"alert\">\r\n            <p>Cette année, faute de place, <strong>nous ne pouvons plus faire dormir les participants sur la scene</strong>. Pour palier à ce problème le phénix a mis en place un partenariat avec le lycée Clément Marot. Pour la modique somme de 5€ par nuit vous pourrez bénéficier d\'une place dans une chambre de 4 avec sanitaires qui se situe à une dizaine de minutes à pied. Vous devez amener votre linge / sac de couchage. Si vous souhaitez réserver une chambre indiquez le dans <a href=\"{{ path(\'profile.edit\') }}\">votre compte</a> et envoyez nous un chêque du montant adéquat :</p>\r\n            <p>Ordre : MJC Cahors</p>\r\n            <p>Adresse : 201 rue Clémenceau <br> 46000 CAHORS</p>\r\n        </div>\r\n		</div> <!-- col -->\r\n		<br>\r\n	</div> <!-- row -->', 1, 1, '', '', 0, NULL, NULL, NULL, NULL, NULL, 0),
(3, 2, 'Présentation', NULL, '<p>Le jeu de r&ocirc;les est un loisir qui consiste &agrave; s&rsquo;installer <strong>avec d&rsquo;autres personnes</strong> autour d&rsquo;une table pour d&eacute;crire, de fa&ccedil;on <strong>collaborative</strong>, les aventures de personnages fictifs &eacute;voluant dans un monde imaginaire.</p>\r\n\r\n<p>Un des joueurs, le meneur de jeu, met en sc&egrave;ne l&rsquo;aventure dans ce cadre imaginaire, en s&rsquo;aidant g&eacute;n&eacute;ralement d&rsquo;un sc&eacute;nario. <strong>Les autres joueurs</strong>, interpr&eacute;tant les <strong>personnages principaux</strong>, vont alors entrer dans un dialogue permanent avec le meneur de jeu, et d&eacute;crire les actions de leurs personnages.</p>\r\n\r\n<p>Le meneur intervient pour sa part en donnant les effets de ces actions, en interpr&eacute;tant les personnages secondaires, et en apportant un cadre &agrave; la partie, bas&eacute; sur des r&egrave;gles. Le hasard intervient fr&eacute;quemment lors d&rsquo;une s&eacute;ance de jeu de r&ocirc;les, notamment lorsque les actions que tentent d&rsquo;entreprendre les personnages ont une issue incertaine.</p>\r\n\r\n<p>Pour simuler cette incertitude, la plupart des jeux proposent d&rsquo;utiliser des d&eacute;s (pas n&eacute;cessairement &agrave; six faces) pour figurer la composante al&eacute;atoire, bien qu&rsquo;il soit &eacute;galement possible de proc&eacute;der autrement (des cartes, voire la simple appr&eacute;ciation du meneur de jeu). Au final, <strong>l&rsquo;imagination est la seule limite</strong> &agrave; ce que peuvent faire les joueurs durant une partie de jeu de r&ocirc;les.</p>\r\n\r\n<p>Il n&rsquo;y a jamais <strong>ni gagnant ni perdant</strong> dans un jeu de r&ocirc;les, le seul v&eacute;ritable but du jeu &eacute;tant le simple plaisir que l&rsquo;on trouve &agrave; y jouer. La partie s&rsquo;arr&ecirc;te alors en fonction du temps disponible ou encore lorsque l&rsquo;on arrive &agrave; un point du r&eacute;cit pr&eacute;sentant un certain caract&egrave;re d&rsquo;ach&egrave;vement (typiquement, lorsque l&rsquo;objectif du sc&eacute;nario semble avoir &eacute;t&eacute; atteint). On peut ainsi continuer &agrave; faire &eacute;voluer ind&eacute;finiment les m&ecirc;mes personnages, chaque s&eacute;ance de jeu constituant un chapitre de la vie de ces derniers, un peu &agrave; la mani&egrave;re des &eacute;pisodes d&rsquo;une s&eacute;rie.</p>\r\n\r\n<p>Il existe une v&eacute;ritable litt&eacute;rature concernant le jeu de r&ocirc;les, apportant aux joueurs des supports riches et pr&eacute;cis, aussi bien en termes d&rsquo;univers que de r&egrave;gles. En France, on trouve bien s&ucirc;r de nombreuses traductions d&rsquo;ouvrages anglo-saxons (entre autres), mais &eacute;galement une production nationale extr&ecirc;mement florissante et vari&eacute;e, soutenue par plusieurs maisons d&rsquo;&eacute;dition.</p>', 0, 1, 'Présentationn', 'Qu\'est-ce que le Jeu de Rôles ?', 0, '3.png', 'table-jdr.png', 'image/png', 532074, '900,339', 0),
(4, 2, 'Liste des tables', 'roleplay', NULL, 1, 1, '', '', 1, NULL, NULL, NULL, NULL, NULL, 0),
(5, 2, 'Murder Party', NULL, '\r\n			<p>Une ville sans histoire ou presque. Un bar que certains disent miteux, d’autres sympathique. Des clients qui se détendent en buvant une bière ou sirotant un cocktail….</p>\r\n			<p>Mais, non loin, il y a un pont. Un pont avec un secret et une légende.<br> Le secret est bien gardé et la légende ne raconte pas toute la vérité.</p>\r\n			<p><i>\"On raconte que l\'architecte ne pouvant venir à bout de la construction du pont dans les temps, eut recours au Diable et fit un pacte avec lui.<br>\r\n				Le Diable s\'engageait à l\'aider par tous les moyens et à lui obéir ponctuellement, quelque ordre qu\'il put recevoir.<br>\r\n				Le travail fini, l\'âme de l\'architecte devait en être le prix.<br> Mais si le démon, pour une cause quelconque, refusait de continuer son assistance jusqu\'au bout, il perdrait tous ses droits sur le prix en question.<br>\r\n				La besogne marcha vite avec un tel manoeuvre.<br>\r\n				Pour sauver son âme, car il ne tenait pas à finir ses jours en enfer, l\'architecte demanda au diable d\'aller chercher de l\'eau à la source des Chartreux, pour ses ouvriers, avec un crible.<br>\r\n				Satan revint naturellement bredouille, l\'exercice étant impossible, et perdit son marché.<br>\r\n				Décidé à se venger, le Diable envoya chaque nuit un diablotin pour desceller la dernière pierre de la tour centrale, dite Tour du Diable, remise en place la veille par les maçons.\"</i></p>\r\n			<p>La murder sera jouée deux fois, le samedi et le dimanche. Même si il est impossible de participer aux deux sessions, vous avez la possiblité de vous préinscrire aux deux séssions, nous donnant plus de souplesse pour l\'organisation.</p>\r\n{{ button.print(\'MU-D\')|raw }}\r\n{{ button.print(\'MU-S\')|raw }}\r\n', 2, 1, 'Murder Party', '', 0, NULL, NULL, NULL, NULL, NULL, 0),
(6, 2, 'Concours de scénario', NULL, '<ul id=\"list-rglmt\">\r\n				<li>Le thème du concours de scénario s\'inscrit dans la lignée de celui de la convention&nbsp;: <b>légendes</b>.</li>\r\n				<li>Chaque auteur ou groupe de coauteurs ne peut présenter qu\'un seul scénario.</li>\r\n				<li>Les participants devront proposer une œuvre originale jamais encore proposée ou éditée. Si un scénario proposé se révèle être un plagiat, il sera exclu du concours.</li>\r\n				<li>Les participants devront proposer un scénario qui doit impérativement représenter entre 4 et 10 pages de texte (entre 10 000 et 25 000 signes espaces compris), accompagné de six feuilles de personnages pré-tirés et d\'annexes. Sauf univers particuliers, des équipes mixtes sont grandement souhaitées. Les historiques doivent faire entre une demi-page et une page entière, et chaque feuille de personnage ne peut faire plus de deux pages. Des fiches manuscrites scannées sont acceptées, mais doivent être lisibles par le jury. Les annexes ne doivent pas totaliser plus de 10 000 signes espaces compris, et comprendre un maximum de deux plans et une annexe d\'ambiance ou de description (situation politique, village, etc.).</li>\r\n				<li>Le scénario doit pouvoir être joué en 4 à 6 heures.</li>\r\n				<li>Un effort au sujet de l\'orthographe et de la grammaire sera grandement apprécié par le jury.</li>\r\n				<li>Le scénario, les annexes, et les feuilles des personnages pré-tirés doivent être rendus au format PDF, <strong>au plus tard le 1er mai 2018 à 23h59</strong>, par courrier électronique uniquement, à l\'adresse <a class=\"lien-contact\" href=\"mailto:scenario.envol.du.phenix@gmail.com\">scenario.envol.du.phenix@gmail.com</a>.</li>\r\n				<li>Les auteurs conservent tous les droits sur leur œuvre.</li>\r\n				<li>Le jury du concours de scénario est composé d\'un membre du club du Phénix de Cahors.</li>\r\n				<li>Les participants sont invités à être présents lors de la convention ou de l\'annonce des résultats, qui seront déclarés à l\'issue de la convention, le dimanche 13 mai 2018 en fin d\'après-midi.</li>\r\n			</ul>\r\n		\r\n	<p>Pour toutes questions, vous pouvez nous écrire à <a class=\"lien-contact\" href=\"mailto:scenario.envol.du.phenix@gmail.com\">scenario.envol.du.phenix@gmail.com</a>.</p>', 3, 1, 'Concours de scénario', 'Règlement', 0, NULL, NULL, NULL, NULL, NULL, 1),
(7, 3, 'Présentation', NULL, '\r\n			<p>Il s’agit, pour résumer, de <strong>deux joueurs s’affrontant par le biais de figurines</strong>, en incarnant des factions différentes.</p>\r\n			<p>Les atouts principaux du wargame résident dans son <strong>aspect visuel</strong> et la personnalisation de l’armée jouée. Il est possible de donner une touche personnelle à ses figurines en personnalisant certaines pièces ou l’armée entière. Un très bon niveau de réalisme est parfois atteint, exigeant plusieurs heures de travail.</p>\r\n			<p>Les parties se déroulent sur des <strong>tables figurant le champ de bataille</strong>. Ces tables de jeu sont la plupart du temps peintes et décorées de façon à renforcer l’ambiance du jeu et présentent les différents décors de l’univers évoqué.</p>\r\n		', 0, 1, 'Présentation', 'Qu\'est-ce que le Wargame ?', 0, NULL, NULL, NULL, NULL, NULL, 0),
(8, 3, 'Blood Bowl', NULL, '\r\n			<p><em>Ceci est un communiqué de Carjac, coach des Hellcatrash et éleveur de champions*:</em></p>\r\n			<p>BONJOUR À TOUS ET À TOUTES, AMIS SPORTIFS, ET BIENVENUS SUR LA PAGE DÉDIÉE AU BLOOD&nbsp;BOWWWL!!!!<br>\r\n				COMMENT ÇA, TU NE CONNAIS PAS LE BLOOD BOWL?!<br>\r\n				BON. ASSIEDS-TOI LÀ GAMIN. JE VAIS T\'EXPLIQUER:</p>\r\n			<div class=\"justi-txt\"><p><strong>BLOOD BOWL</strong> est un jeu de <strong>football américain fantastique</strong> (En gros, il faut se taper dessus et, parfois, aller mettre un ballon dans l\'extrémité du camp adverse). À la fois jeu de figurines et jeu de société, l\'action se situe dans un monde médiéval fantastique imaginé par la compagnie <strong>Games Workshop</strong>.</p>\r\n				<p>Deux joueurs endossent le rôle de coach, en choisissant leur équipe parmi de nombreuses factions (Orque, elfe, chaos; humain et bien d\'autres) chacune avec un style de jeu différent. Une combinaison de stratégie et de tactique, une pointe de chance, c\'est Blood Bowl, le classique du jeu de football fantastique.</p>\r\n				<p>VIOLENCE, COUP BAS, TRICHERIE, rien n\'est trop sale au BLOOD BOWL, ON EST LÀ POUR GAGNER!!! Mais toujours dans une bonne ambiance avec son adversaire! Parce qu\'après tout, c\'est ça le sport: se foutre sur la gueule pendant deux longues mi-temps, puis se réconcilier <del>dans</del> avec une bonne bière pendant la 3ème mi-temps...</p></div>\r\n			<p>AU PROGRAMME:<br>\r\n				-UN TOURNOIS NAF!!! <a class=\"lien-contact\" href=\"http://teamfrancebb.positifforum.com/t5556-quercybowl-cahors-12-et-13-mai-2018\" target=\"_blank\">Inscriptions ICI</a><br>\r\n				-UNE INITIATION. OUVERTE A TOUUUUUUUUUUUUS!!!!! </p>\r\n		\r\n			<p><small><em>*L\'enthousiasme de Carjac étant ce qu\'il est, le Phénix Cadurcien décline toute responsabilité quant à l\'emploi abusif de majuscules et / ou de points d\'exclamation. </em></small></p>\r\n		', 1, 1, 'Blood Bowl', 'Tournoi et Initiation', 0, NULL, NULL, NULL, NULL, NULL, 0),
(9, 3, 'Alkemy', NULL, '<p>Alkemy est un jeu d’escarmouche dans un univers médiéval fantastique qui utilise entre 6 à 10 figurines (28 mm) en moyenne. Le but d’une partie n’est pas de tuer l’adversaire, mais de réaliser les objectifs d’un scénario. Les règles sont très faciles à assimiler, une partie se joue en 45 mn environ.</p>\r\n			<p><a class=\"lien-contact\" href=\"http://alkemy-the-game.com/fr/\" target=\"_blank\">Le site officiel</a></p>\r\n			<p><a class=\"lien-contact\" href=\"https://www.tabletoptournaments.net/fr/t3_tournament.php?tid=21538\" target=\"_blank\">Inscription au tournoi sur T3</a></p>', 3, 1, 'Alkemy', 'Tournoi et Initiation', 0, NULL, NULL, NULL, NULL, NULL, 0),
(10, 3, 'Warhammer 40000', NULL, '<p>&quot;Dans le futur cauchemardesque du quarante-et-uni&egrave;me mill&eacute;naire, l&#39;humanit&eacute; lutte contre sa propre extinction. Les fronti&egrave;res de son Imperium galactique grouillent d&#39;extraterrestres hostiles, tandis que cr&eacute;atures mal&eacute;fiques et rebelles h&eacute;r&eacute;tiques constituent un terrible ennemi int&eacute;rieur. Seule la puissance de l&#39;Immortel Empereur de Terra pr&eacute;vient l&#39;extermination du genre humain. Les innombrables guerriers, agents et serviteurs de l&#39;Imperium sont d&eacute;vou&eacute;s &agrave; Son service. A leur t&ecirc;te se tiennent les Space Marines, mentalement et physiquement con&ccedil;us pour &ecirc;tre les guerriers supr&ecirc;mes, ultimes d&eacute;fenseurs de l&#39;humanit&eacute;.&quot;<br />\r\nIl n&#39;y a pas de paix.<br />\r\nPas de r&eacute;pit.<br />\r\nPas de r&eacute;mission.<br />\r\nIl n&#39;y a que la GUERRE</p>\r\n\r\n<p>Warhammer 40 000, parfois abr&eacute;g&eacute; en Warhammer 40K, WH40K ou simplement 40k, est un univers de science-fiction gothique et violent cr&eacute;&eacute; par Games Workshop en 1987. D&eacute;velopp&eacute; initialement pour le jeu de figurines &eacute;ponyme, l&#39;univers d&eacute;passe aujourd&#39;hui le seul cadre du jeu, et s&#39;&eacute;tend &agrave; de nombreux autres supports.</p>\r\n\r\n<p>Une partie correspond en l&#39;affrontement de 2 arm&eacute;es. Chaque joueur doit &eacute;liminer l&#39;arm&eacute;e de l&#39;autre, pour cela il utilisera tout son sens tactique, un peu de chance et une force militaire puissante pour mettre &agrave; mal son adversaire.&quot;</p>', 2, 1, 'Warhammer 40 000', 'Initiation', 0, '10.png', 'wg40k.png', 'image/png', 1269468, '1594,500', 0),
(11, 3, 'Fury : Outburst Control', NULL, '<p><strong>Fury : Outburst Control</strong> est un jeu d’escarmouche créé et sculpté par Forge Studio. Nous accueillerons Jerôme \"Whispe\" Labadie, son concepteur, pour des parties d\'initiation / de découverte.</p>\r\n			<br>\r\n			<br>\r\n			<p><strong>Fury : Outburst Control*</strong> est un jeu d’escarmouche à activation alternée qui vous offre la possibilité de combattre dans cet univers d’exception.</p>\r\n				<p>Manipulant les énergies de la colère, prenez la tête de patrouilles de 3 à 10 figurines pour des parties ultra-rapides en 125 points ou de groupes bien plus nombreux dans des formats allant jusqu’à 300 points de Patrouille. En utilisant à bon escient le potentiel de vos officiers, accumulez des points de Furie afin de leur faire relâcher des techniques de combat dévastatrices. Apprenez à gérer les différentes postures de combat adaptées à chaque situation afin d’atteindre au mieux vos objectifs.</p>\r\n			<br>\r\n			<img src=\"{{ asset(\'images/wg/fury2.jpg\')}}\" class=\"center-block rounded img-fluid\">\r\n			<br>\r\n			<p><em>*Source article et photos: <a href=\"www.forge-studio.com/fury\" target=\"_blank\">www.forge-studio.com/fury</a></em></p>', 4, 1, 'Fury : Outburst Control', 'Initiation', 0, NULL, NULL, NULL, NULL, NULL, 0),
(12, 4, 'Présentation', NULL, '\r\n			<p>Bang! ... Bang! ... Bang!...</p>\r\n			<p>Les portes s’ouvrent sur l\'espace Valentré. La pleine lune illumine le ciel pour le bonheur des petits et des grands.  Les sorcières préparent leurs potions et les magiciens leurs formules. Des pactes sont conclus…</p>\r\n			<p>À chaque coup sur l\'espace jeux de société du festival l\'Envol du Phénix, vous êtes l\'acteur de scènes épiques.\r\n			</p>\r\n			<p>Les thématiques des jeux de société ont bien évolués ces dernières années. Et les animateurs du Phénix vont vous proposer de :<br>\r\n				Piloter vos figurines de vaisseau spatial avec <strong>X-wing</strong>,<br>\r\n				Chasser du zombie en groupe avec <strong>Zombicide</strong>,<br>\r\n				Vengez un fantôme avec vos talents de médium avec <strong>Mystérium</strong>,<br>\r\n				Retrouvez un coupable parmi six suspects avec les indices de votre <strong>Profiler</strong>,<br>\r\n				... Affrontez les ténèbres et forgez votre propre légende !<br>\r\n			</p>\r\n			<p>Les hostilités débuteront le&nbsp; <strong>Samedi 12 mai de 10h - 20h</strong> gratis et tout public!<br>\r\n				Prolongations le <strong>Dimanche 13 mai de 10h - 18h</strong> gratis et tout public!</p>\r\n			', 0, 1, 'Présentation', 'Gratuit / Tout public', 0, NULL, NULL, NULL, NULL, NULL, 0),
(13, 4, 'Soirée Loups-Garous de Thiercelieux', NULL, '<!-- Texte -->\r\n	<div class=\"row justify-content-center\">\r\n		<div class=\"col-sm-6\">\r\n			<h3 class=\"titre-page\">Soirée des Loups-Garous de Thiercelieux</h3>\r\n			<hr class=\"hr-titre\">\r\n			<h5 class=\"sous-titre\">VENDREDI</h5>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div>\r\n		<img class=\"img-fluid\" src=\"{{ asset(\'images/jds/bobmical.jpg\')}}\">\r\n		</div>\r\n	</div> <!-- row -->\r\n	<div class=\"row justify-content-center\">\r\n		<div class=\"col-md-6\">\r\n			<p>Au village de Thiercelieux, les villageois vivent paisiblement le jour durant.<br>\r\n				Mais lorsque la nuit tombe, certain se transforme en loup garou et attaque discrètement.<br>\r\n				Et au levé du jour, la peur, la méfiance et le silence règnent. Tout ceci doit stopper! Les survivants vont s\'illustrer dans l\'art oratoire pour bannir les loups garous de village!</p>\r\n			<p>Grand conseil le <strong>Vendredi 11 mai à partir de 21h, tout public, pour 2€</strong>!</p>\r\n			<br>\r\n{{ button.print(\'LGT\')|raw }}\r\n			<img class=\"img-fluid rounded\" src=\"{{ asset(\'images/jds/lg2.JPG\')}}\">\r\n			<br>\r\n		</div> <!-- col -->\r\n\r\n	</div> <!-- row -->', 1, 1, '', '', 0, NULL, NULL, NULL, NULL, NULL, 0),
(14, 4, 'Liste des parties', 'boardgame', NULL, 2, 1, '', '', 1, NULL, NULL, NULL, NULL, NULL, 0),
(15, 5, 'Description', NULL, '<!-- Texte -->\r\n<div class=\"row justify-content-center\">\r\n    <div class=\"col-sm-6\">\r\n        <h3 class=\"titre-page\">Joutes médiévales</h3>\r\n        <hr class=\"hr-titre\">\r\n        <h5 class=\"sous-titre\">INITIATION</h5>\r\n    </div> <!-- col -->\r\n</div> <!-- row -->\r\n\r\n<div class=\"row justify-content-center\">\r\n    <div class=\"col-sm-8 justi-txt\">\r\n        <p><br>\r\n            <h3>\"Venez tester vos compétences de chevaliers !</h3>\r\n\r\n            Grâce à cette activité, le maniement des armes typiques du Moyen Age et de la renaissance vous sera plus familier tout comme leur histoire.<br>\r\n\r\n            Démonstrations, essais, discussions vous serez plongé dans les légendes les plus épiques.<br>\r\n\r\n            Les moments forts seront les démonstrations techniques, suivi d’un combat libre.<br>\r\n        </p>\r\n\r\n        <strong>Samedi</strong>\r\n        <ul>\r\n            <li>à 11h : Ma première arme dans ma vie de chevalier, mon épée. Comment on l’utilise ?</li>\r\n\r\n            <li>à 14h : Après expérience, je me penche sur l’épée longue.</li>\r\n\r\n            <li>à 17h : Et la lance ??</li>\r\n        </ul>\r\n        <strong>Dimanche</strong>\r\n        <ul>\r\n            <li>à 11h30 : Il faut que je sache me battre ! Des techniques ?</li>\r\n\r\n            <li>à 14h : Un sujet précédent selon souhait du public.</li>\r\n        </ul>\r\n        <p><br>\r\n            <h3>Petite surprise !</h3>\r\n\r\n            <strong>Le Samedi à 15h30 : Tournois enfants</strong>\r\n\r\n            Avec épées en mousse, masques, gants afin d’assurer une pratique sécurisée, les enfants pourront également se mesurer à leurs adversaires.<br>\r\n\r\n            Amusement mais aussi challenge seront de mises !<br>\r\n\r\n            <i>Inscriptions sur place.</i>\r\n        </p>\r\n\r\n       <p> Votre maître d’armes vous attend pour votre entrainement ! </p>\r\n        \r\n    </div> <!-- col -->\r\n</div> <!-- row -->', 0, 1, '', '', 0, NULL, NULL, NULL, NULL, NULL, 0),
(16, 2, 'Test', NULL, '<p>Page de test</p>', 4, 0, 'Page de Test', 'Juste un test', 0, '.png', 'PersosJDR (3).png', 'image/png', 11066, '179,179', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `FK_3BAE0AA713B3DB11` FOREIGN KEY (`master_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_3BAE0AA7A6005CA0` FOREIGN KEY (`round_id`) REFERENCES `round` (`id`),
  ADD CONSTRAINT `FK_AC74095AC51EFA73` FOREIGN KEY (`activity_type_id`) REFERENCES `activity_type` (`id`);

--
-- Contraintes pour la table `activity_user`
--
ALTER TABLE `activity_user`
  ADD CONSTRAINT `FK_8E570DDB81C06096` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8E570DDBA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `event_user`
--
ALTER TABLE `event_user`
  ADD CONSTRAINT `FK_92589AE271F7E88B` FOREIGN KEY (`event_id`) REFERENCES `activity` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_92589AE2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `round`
--
ALTER TABLE `round`
  ADD CONSTRAINT `FK_C5EEEA34C51EFA73` FOREIGN KEY (`activity_type_id`) REFERENCES `activity_type` (`id`);

--
-- Contraintes pour la table `user_event`
--
ALTER TABLE `user_event`
  ADD CONSTRAINT `FK_D96CF1FF71F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D96CF1FFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_menu`
--
ALTER TABLE `user_menu`
  ADD CONSTRAINT `FK_784765AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_784765ACCD7E912` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `view`
--
ALTER TABLE `view`
  ADD CONSTRAINT `FK_FEFDAB8ECCD7E912` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
