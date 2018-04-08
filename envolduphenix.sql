-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 08 avr. 2018 à 13:09
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
-- Structure de la table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `game` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3BAE0AA713B3DB11` (`master_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `event`
--

INSERT INTO `event` (`id`, `master_id`, `name`, `start`, `end`, `description`, `game`, `style`) VALUES
(2, 10, 'Table Jdr', '2018-05-11 21:00:00', '2018-05-12 04:00:00', 'Table de jeu de rôle', 'Warhammer', 'Blablabla');

-- --------------------------------------------------------

--
-- Structure de la table `event_type`
--

DROP TABLE IF EXISTS `event_type`;
CREATE TABLE IF NOT EXISTS `event_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `event_type`
--

INSERT INTO `event_type` (`id`, `name`) VALUES
(1, 'roleplay'),
(2, 'wargame'),
(3, 'boardgame');

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

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`id`, `name`, `weight`, `active`, `color`, `pic`) VALUES
(1, 'L\'événement', 0, 1, 'bd-bleu', 'blk'),
(2, 'Jeu de rôle', 1, 1, 'bd-orange', 'jdr'),
(3, 'Wargame', 2, 1, 'bd-orange', 'wg'),
(4, 'Jeu de société', 3, 1, 'bd-bleu', 'jds');

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
('20180408122307');

-- --------------------------------------------------------

--
-- Structure de la table `round`
--

DROP TABLE IF EXISTS `round`;
CREATE TABLE IF NOT EXISTS `round` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `roles` json NOT NULL COMMENT '(DC2Type:json_array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D64935C246D5` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `password`, `hash`, `valid`, `created`, `updated`, `username`, `firstname`, `lastname`, `email`, `is_active`, `roles`) VALUES
(10, '$2y$13$QqHg8oe/cSrqy8AUy3NXIOb0hlbLgt1063x/Fs/KbuhlEXGtO2y7O', '$2y$13$hoLLPJUHCpmJnnI1OOvFo.RHudwQVnlsfxiGxY4a8Rwx0MHtISUim', 1, '2018-04-02 22:37:50', '2018-04-02 22:37:50', 'Basch', 'Cedric', 'Molines', 'ced_46000@hotmail.com', 0, '[\"ROLE_ADMIN\"]');

-- --------------------------------------------------------

--
-- Structure de la table `view`
--

DROP TABLE IF EXISTS `view`;
CREATE TABLE IF NOT EXISTS `view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `weight` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FEFDAB8ECCD7E912` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `view`
--

INSERT INTO `view` (`id`, `name`, `menu_id`, `link`, `content`, `weight`, `active`) VALUES
(1, 'Contact', 1, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3 sup-padd\">\r\n			<h5 class=\"sous-titre\">Une question ? Une suggestion ? Écrivez-nous !</h5>\r\n			<hr class=\"hr-titre\">\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'/images/cahier.jpg\') }}\">\r\n			<br>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-offset-3 col-sm-6 form-ic\" id=\"vtl-line-gold\">\r\n			<p>Jeux de rôles : <a class=\"lien-contact\" href=\"mailto:lephenixcadurcien@live.fr\">lephenixcadurcien@live.fr</a></p>\r\n			<p>Concours scénario : <a class=\"lien-contact\" href=\"mailto:scenario.envol.du.phenix@gmail.com\">scenario.envol.du.phenix@gmail.com</a></p>\r\n			<p>Autres : <a class=\"lien-contact\" href=\"mailto:lephenixcadurcien@live.fr\">lephenixcadurcien@live.fr</a><br>\r\n			</p>\r\n		</div> <!-- col -->\r\n		<br>\r\n	</div> <!-- row -->', 0, 1),
(2, 'Infos Pratiques', 1, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3 sup-padd\">\r\n			<h3 class=\"titre-page\">L\'Envol du Phénix</h3>\r\n			<hr class=\"hr-titre\">\r\n			<h5 id=\"ss-titre-infos\">11, 12 et 13 Mai 2018<br>\r\n				Espace Valentré, Allées des Soupirs, 46000 Cahors </h5>\r\n			<br>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2848.515460415642!2d1.4318160154748891!3d44.44310057910216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12ac89661e8648eb%3A0xbc33f21a7042c3c5!2sEspace+Valentr%C3%A9!5e0!3m2!1sfr!2sfr!4v1493930846057\" width=\"100%\" height=\"200\" frameborder=\"0\" style=\"border:0\" allowfullscreen=\"\"></iframe>\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-offset-3 col-sm-6 form-ic\" id=\"vtl-line-gold\">\r\n			<p><strong>Infos diverses</strong><br>\r\n				Restauration sur place<br>\r\n				Les mineurs souhaitant rester sur place après 19h doivent être accompagnés d\'un adulte ou munis d\'une autorisation parentale signée.<br>\r\n			</p>\r\n		</div> <!-- col -->\r\n		<br>\r\n	</div> <!-- row -->', 1, 1),
(3, 'Présentation', 2, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3\">\r\n			<h3 class=\"titre-page\">Qu\'est-ce que le Jeu de Rôles ?</h3>\r\n			<hr class=\"hr-titre\">\r\n			<p>Le jeu de rôles est un loisir qui consiste à s’installer <b>avec d’autres personnes</b> autour d’une table pour décrire, de façon <b>collaborative</b>, les aventures de personnages fictifs évoluant dans un monde imaginaire.</p>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-2 col-sm-push-1 pj\">\r\n			<img class=\"img-rounded pj1\" src=\"{{ asset(\'images/jdr/pirate.png\') }}\">\r\n			<img class=\"img-rounded pj1\" src=\"{{ asset(\'images/jdr/vampire.png\') }}\">\r\n			<img class=\"img-rounded pj1\" src=\"{{ asset(\'images/jdr/viking.png\') }}\">\r\n			<img class=\"img-rounded pj2\" src=\"{{ asset(\'images/jdr/sorciere.png\') }}\">\r\n			<img class=\"img-rounded pj2\" src=\"{{ asset(\'images/jdr/obiwan.png\') }}\">\r\n			<img class=\"img-rounded pj2\" src=\"{{ asset(\'images/jdr/asiat.png\') }}\">\r\n		</div> <!-- col -->\r\n		<div class=\"col-sm-7 col-sm-push-2 txt-jdr\">\r\n			<p>Un des joueurs, le meneur de jeu, met en scène l’aventure dans ce cadre imaginaire, en s’aidant généralement d’un scénario. <b>Les autres joueurs</b>, interprétant les <b>personnages principaux</b>, vont alors entrer dans un dialogue permanent avec le meneur de jeu, et décrire les actions de leurs personnages.</p>\r\n			<p>Le meneur intervient pour sa part en donnant les effets de ces actions, en interprétant les personnages secondaires, et en apportant un cadre à la partie, basé sur des règles. Le hasard intervient fréquemment lors d’une séance de jeu de rôles, notamment lorsque les actions que tentent d’entreprendre les personnages ont une issue incertaine.\r\n			</p>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/jdr/table-jdr.png\') }}\">\r\n			<p>Pour simuler cette incertitude, la plupart des jeux proposent d’utiliser des dés (pas nécessairement à six faces) pour figurer la composante aléatoire, bien qu’il soit également possible de procéder autrement (des cartes, voire la simple appréciation du meneur de jeu). Au final, <b>l’imagination est la seule limite</b> à ce que peuvent faire les joueurs durant une partie de jeu de rôles.</p>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/jdr/dice-carre.png\') }}\">\r\n			<p>Il n’y a jamais <b>ni gagnant ni perdant</b> dans un jeu de rôles, le seul véritable but du jeu étant le simple plaisir que l’on trouve à y jouer. La partie s’arrête alors en fonction du temps disponible ou encore lorsque l’on arrive à un point du récit présentant un certain caractère d’achèvement (typiquement, lorsque l’objectif du scénario semble avoir été atteint). On peut ainsi continuer à faire évoluer indéfiniment les mêmes personnages, chaque séance de jeu constituant un chapitre de la vie de ces derniers, un peu à la manière des épisodes d’une série.</p>\r\n			<p>Il existe une véritable littérature concernant le jeu de rôles, apportant aux joueurs des supports riches et précis, aussi bien en termes d’univers que de règles. En France, on trouve bien sûr de nombreuses traductions d’ouvrages anglo-saxons (entre autres), mais également une production nationale extrêmement florissante et variée, soutenue par plusieurs maisons d’édition.</p>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-xs-12\">\r\n			<img class=\"img-rounded pj3\" src=\"{{ asset(\'/images/jdr/sorciere.png\') }}\">\r\n			<img class=\"img-rounded pj3\" src=\"{{ asset(\'/images/jdr/obiwan.png\') }}\">\r\n			<img class=\"img-rounded pj3\" src=\"{{ asset(\'/images/jdr/asiat.png\') }}\">\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->', 0, 1),
(4, 'Liste des tables', 2, 'roleplay', NULL, 1, 1),
(5, 'Murder Party', 2, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3\">\r\n			<h3 class=\"titre-page\">La Murder Party</h3>\r\n			<hr class=\"hr-titre\">\r\n			<h5 class=\"sous-titre\">SAMEDI et DIMANCHE après midi</h5>\r\n			<p>Une ville sans histoire ou presque. Un bar que certains disent miteux, d’autres sympathique. Des clients qui se détendent en buvant une bière ou sirotant un cocktail….</p>\r\n			<p>Mais, non loin, il y a un pont. Un pont avec un secret et une légende.<br> Le secret est bien gardé et la légende ne raconte pas toute la vérité.</p>\r\n			<p><i>\"On raconte que l\'architecte ne pouvant venir à bout de la construction du pont dans les temps, eut recours au Diable et fit un pacte avec lui.<br>\r\n				Le Diable s\'engageait à l\'aider par tous les moyens et à lui obéir ponctuellement, quelque ordre qu\'il put recevoir.<br>\r\n				Le travail fini, l\'âme de l\'architecte devait en être le prix.<br> Mais si le démon, pour une cause quelconque, refusait de continuer son assistance jusqu\'au bout, il perdrait tous ses droits sur le prix en question.<br>\r\n				La besogne marcha vite avec un tel manoeuvre.<br>\r\n				Pour sauver son âme, car il ne tenait pas à finir ses jours en enfer, l\'architecte demanda au diable d\'aller chercher de l\'eau à la source des Chartreux, pour ses ouvriers, avec un crible.<br>\r\n				Satan revint naturellement bredouille, l\'exercice étant impossible, et perdit son marché.<br>\r\n				Décidé à se venger, le Diable envoya chaque nuit un diablotin pour desceller la dernière pierre de la tour centrale, dite Tour du Diable, remise en place la veille par les maçons.\"</i></p>\r\n			<p>La murder sera jouée deux fois, le samedi et le dimanche. Même si il est impossible de participer aux deux sessions, vous avez la possiblité de vous préinscrire aux deux séssions, nous donnant plus de souplesse pour l\'organisation.</p>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->', 2, 1),
(6, 'Concours de scénario', 2, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-8 col-sm-push-2 sup-padd\">\r\n			<h3 class=\"titre-page\">Règlement du concours de scénario</h3>\r\n			<hr class=\"hr-titre\">\r\n			<br>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/jdr/concours.jpg\')}}\">\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row conc-scenar\">\r\n		<div class=\"col-sm-8 col-sm-push-2\" id=\"vertical-line\">\r\n			<ul id=\"list-rglmt\">\r\n				<li>Le thème du concours de scénario s\'inscrit dans la lignée de celui de la convention&nbsp;: <b>légendes</b>.</li>\r\n				<li>Chaque auteur ou groupe de coauteurs ne peut présenter qu\'un seul scénario.</li>\r\n				<li>Les participants devront proposer une œuvre originale jamais encore proposée ou éditée. Si un scénario proposé se révèle être un plagiat, il sera exclu du concours.</li>\r\n				<li>Les participants devront proposer un scénario qui doit impérativement représenter entre 4 et 10 pages de texte (entre 10 000 et 25 000 signes espaces compris), accompagné de six feuilles de personnages pré-tirés et d\'annexes. Sauf univers particuliers, des équipes mixtes sont grandement souhaitées. Les historiques doivent faire entre une demi-page et une page entière, et chaque feuille de personnage ne peut faire plus de deux pages. Des fiches manuscrites scannées sont acceptées, mais doivent être lisibles par le jury. Les annexes ne doivent pas totaliser plus de 10 000 signes espaces compris, et comprendre un maximum de deux plans et une annexe d\'ambiance ou de description (situation politique, village, etc.).</li>\r\n				<li>Le scénario doit pouvoir être joué en 4 à 6 heures.</li>\r\n				<li>Un effort au sujet de l\'orthographe et de la grammaire sera grandement apprécié par le jury.</li>\r\n				<li>Le scénario, les annexes, et les feuilles des personnages pré-tirés doivent être rendus au format PDF, <strong>au plus tard le 1er mai 2018 à 23h59</strong>, par courrier électronique uniquement, à l\'adresse <a class=\"lien-contact\" href=\"mailto:scenario.envol.du.phenix@gmail.com\">scenario.envol.du.phenix@gmail.com</a>.</li>\r\n				<li>Les auteurs conservent tous les droits sur leur œuvre.</li>\r\n				<li>Le jury du concours de scénario est composé de plusieurs membres du club du Phénix de Cahors.</li>\r\n				<li>Les participants sont invités à être présents lors de la convention ou de l\'annonce des résultats, qui seront déclarés à l\'issue de la convention, le dimanche 13 mai 2018 en fin d\'après-midi.</li>\r\n			</ul>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<br>\r\n	<p>Pour toutes questions, vous pouvez nous écrire à <a class=\"lien-contact\" href=\"mailto:scenario.envol.du.phenix@gmail.com\">scenario.envol.du.phenix@gmail.com</a>.</p>', 3, 1),
(7, 'Présentation', 3, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3 col-md\">\r\n			<h3 class=\"titre-page\">Qu\'est-ce que le Wargame ?</h3>\r\n			<hr class=\"hr-titre\">\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-xs-6 col-sm-4 col-xs-push-3 col-sm-push-0\">\r\n			<img class=\"img-responsive img-rounded\" id=\"wgb1\" src=\"{{ asset(\'images/wg/wgb1.jpg\') }}\">\r\n		</div> <!-- col -->\r\n		<div class=\"col-xs-10 col-xs-push-1 col-sm-push-0 col-sm-6 col-lg-4\" id=\"pres-wg\">\r\n			<p>Il s’agit, pour résumer, de <strong>deux joueurs s’affrontant par le biais de figurines</strong>, en incarnant des factions différentes.</p>\r\n			<p>Les atouts principaux du wargame résident dans son <strong>aspect visuel</strong> et la personnalisation de l’armée jouée. Il est possible de donner une touche personnelle à ses figurines en personnalisant certaines pièces ou l’armée entière. Un très bon niveau de réalisme est parfois atteint, exigeant plusieurs heures de travail.</p>\r\n			<p>Les parties se déroulent sur des <strong>tables figurant le champ de bataille</strong>. Ces tables de jeu sont la plupart du temps peintes et décorées de façon à renforcer l’ambiance du jeu et présentent les différents décors de l’univers évoqué.</p>\r\n		</div> <!-- col -->\r\n		<div class=\"col-sm-4\">\r\n			<img class=\"img-responsive img-rounded\" id=\"wgb2\" src=\"{{ asset(\'images/wg/wgb2.jpg\')}}\">\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->', 0, 1),
(8, 'Blood Bowl', 3, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3 col-md\">\r\n			<h3 class=\"titre-page\">Blood Bowl</h3>\r\n			<hr class=\"hr-titre\">\r\n			<h5 class=\"sous-titre\">TOURNOI ET INITIATION</h5>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-8 col-sm-push-2\">\r\n			<br>\r\n			<img src=\"{{ asset(\'images/wg/bloodbowl2.png\') }}\" class=\"center-block img-responsive\">\r\n			<br>\r\n			<p><em>Ceci est un communiqué de Carjac, coach des Hellcatrash et éleveur de champions*:</em></p>\r\n			<p>BONJOUR À TOUS ET À TOUTES, AMIS SPORTIFS, ET BIENVENUS SUR LA PAGE DÉDIÉE AU BLOOD&nbsp;BOWWWL!!!!<br>\r\n				COMMENT ÇA, TU NE CONNAIS PAS LE BLOOD BOWL?!<br>\r\n				BON. ASSIEDS-TOI LÀ GAMIN. JE VAIS T\'EXPLIQUER:</p>\r\n			<div class=\"justi-txt\"><p><strong>BLOOD BOWL</strong> est un jeu de <strong>football américain fantastique</strong> (En gros, il faut se taper dessus et, parfois, aller mettre un ballon dans l\'extrémité du camp adverse). À la fois jeu de figurines et jeu de société, l\'action se situe dans un monde médiéval fantastique imaginé par la compagnie <strong>Games Workshop</strong>.</p>\r\n				<p>Deux joueurs endossent le rôle de coach, en choisissant leur équipe parmi de nombreuses factions (Orque, elfe, chaos; humain et bien d\'autres) chacune avec un style de jeu différent. Une combinaison de stratégie et de tactique, une pointe de chance, c\'est Blood Bowl, le classique du jeu de football fantastique.</p>\r\n				<p>VIOLENCE, COUP BAS, TRICHERIE, rien n\'est trop sale au BLOOD BOWL, ON EST LÀ POUR GAGNER!!! Mais toujours dans une bonne ambiance avec son adversaire! Parce qu\'après tout, c\'est ça le sport: se foutre sur la gueule pendant deux longues mi-temps, puis se réconcilier <del>dans</del> avec une bonne bière pendant la 3ème mi-temps...</p></div>\r\n			<p>AU PROGRAMME:<br>\r\n				-UN TOURNOIS NAF!!! <a class=\"lien-contact\" href=\"http://teamfrancebb.positifforum.com/t5556-quercybowl-cahors-12-et-13-mai-2018\" target=\"_blank\">Inscriptions ICI</a><br>\r\n				-UNE INITIATION. OUVERTE A TOUUUUUUUUUUUUS!!!!! </p>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-10 col-sm-push-1\">\r\n			<br>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/wg/bloodbowl.jpg\') }}\">\r\n			<br>\r\n			<p><small><em>*L\'enthousiasme de Carjac étant ce qu\'il est, le Phénix Cadurcien décline toute responsabilité quant à l\'emploi abusif de majuscules et / ou de points d\'exclamation. </em></small></p>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->', 1, 1),
(9, 'Alkemy', 3, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3 col-md\">\r\n			<h3 class=\"titre-page\">Alkemy</h3>\r\n			<hr class=\"hr-titre\">\r\n			<h5 class=\"sous-titre\">TOURNOI ET INITIATION</h5>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-8 col-sm-push-2\">\r\n			<br>\r\n			<img src=\"{{ asset(\'images/wg/AlkemyBlitz.jpg\')}}\" class=\"center-block img-responsive img-rounded\">\r\n			<br>\r\n			<p>Alkemy est un jeu d’escarmouche dans un univers médiéval fantastique qui utilise entre 6 à 10 figurines (28 mm) en moyenne. Le but d’une partie n’est pas de tuer l’adversaire, mais de réaliser les objectifs d’un scénario. Les règles sont très faciles à assimiler, une partie se joue en 45 mn environ.</p>\r\n			<p><a class=\"lien-contact\" href=\"http://alkemy-the-game.com/fr/\" target=\"_blank\">Le site officiel</a></p>\r\n			<p><a class=\"lien-contact\" href=\"https://www.tabletoptournaments.net/fr/t3_tournament.php?tid=21538\" target=\"_blank\">Inscription au tournoi sur T3</a></p>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-10 col-sm-push-1\">\r\n			<br>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/wg/aurlok.jpg\')}}\">\r\n			<br>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/wg/khaliman.jpg\')}}\">\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->', 2, 1),
(10, 'Warhammer 40000', 3, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3 col-md\">\r\n			<h3 class=\"titre-page\">Warhammer 40 000</h3>\r\n			<hr class=\"hr-titre\">\r\n			<h5 class=\"sous-titre\">INITIATION</h5>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<br>\r\n		<img src=\"{{ asset(\'images/wg/wg40k.png\')}}\" class=\" img-responsive\">\r\n		<br>\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-8 col-sm-push-2 justi-txt\">\r\n			<p>\"Dans le futur cauchemardesque du quarante-et-unième millénaire, l\'humanité lutte contre sa propre extinction. Les frontières de son Imperium galactique grouillent d\'extraterrestres hostiles, tandis que créatures maléfiques et rebelles hérétiques constituent un terrible ennemi intérieur. Seule la puissance de l\'Immortel Empereur de Terra prévient l\'extermination du genre humain. Les innombrables guerriers, agents et serviteurs de l\'Imperium sont dévoués à Son service. A leur tête se tiennent les Space Marines, mentalement et physiquement conçus pour être les guerriers suprêmes, ultimes défenseurs de l\'humanité.\"<br>\r\n				Il n\'y a pas de paix.<br>\r\n				Pas de répit.<br>\r\n				Pas de rémission.<br>\r\n				Il n\'y a que la GUERRE</p>\r\n			<p>Warhammer 40 000, parfois abrégé en Warhammer 40K, WH40K ou simplement 40k, est un univers de science-fiction gothique et violent créé par Games Workshop en 1987. Développé initialement pour le jeu de figurines éponyme, l\'univers dépasse aujourd\'hui le seul cadre du jeu, et s\'étend à de nombreux autres supports.</p>\r\n			<p>Une partie correspond en l\'affrontement de 2 armées. Chaque joueur doit éliminer l\'armée de l\'autre, pour cela il utilisera tout son sens tactique, un peu de chance et une force militaire puissante pour mettre à mal son adversaire.\"</p>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->', 3, 1),
(11, 'Fury : Outburst Control', 3, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3 col-md\">\r\n			<h3 class=\"titre-page\">Fury : Outburst Control</h3>\r\n			<hr class=\"hr-titre\">\r\n			<h5 class=\"sous-titre\">INITIATION</h5>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-md-offset-2 col-md-8\">\r\n			<br>\r\n			<p><strong>Fury : Outburst Control</strong> est un jeu d’escarmouche créé et sculpté par Forge Studio. Nous accueillerons Jerôme \"Whispe\" Labadie, son concepteur, pour des parties d\'initiation / de découverte.</p>\r\n			<br>\r\n			<img src=\"{{ asset(\'images/wg/furybanniere1.png\')}}\" class=\"img-responsive img-fury\">\r\n			<br>\r\n			<div class=\"justi-txt\"><p><strong>Fury : Outburst Control*</strong> est un jeu d’escarmouche à activation alternée qui vous offre la possibilité de combattre dans cet univers d’exception.</p>\r\n				<p>Manipulant les énergies de la colère, prenez la tête de patrouilles de 3 à 10 figurines pour des parties ultra-rapides en 125 points ou de groupes bien plus nombreux dans des formats allant jusqu’à 300 points de Patrouille. En utilisant à bon escient le potentiel de vos officiers, accumulez des points de Furie afin de leur faire relâcher des techniques de combat dévastatrices. Apprenez à gérer les différentes postures de combat adaptées à chaque situation afin d’atteindre au mieux vos objectifs.</p></div>\r\n			<br>\r\n			<img src=\"{{ asset(\'images/wg/fury2.jpg\')}}\" class=\"center-block img-rounded img-responsive\">\r\n			<br>\r\n			<p><em>*Source article et photos: <a href=\"www.forge-studio.com/fury\" target=\"_blank\">www.forge-studio.com/fury</a></em></p>\r\n		</div>\r\n	</div>', 4, 1),
(12, 'Présentation', 4, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3\">\r\n			<h3 class=\"titre-page\">Présentation</h3>\r\n			<hr class=\"hr-titre\">\r\n			<h5 class=\"sous-titre\">GRATUIT / TOUT PUBLIC</h5>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-10 col-sm-push-1 col-md-8 col-md-push-2\">\r\n			<br>\r\n			<p>Bang! ... Bang! ... Bang!...</p>\r\n			<div class=\"justi-txt\"><p>Les portes s’ouvrent sur l\'espace Valentré. La pleine lune illumine le ciel pour le bonheur des petits et des grands.  Les sorcières préparent leurs potions et les magiciens leurs formules. Des pactes sont conclus…\r\n			</p>\r\n				<p>À chaque coup sur l\'espace jeux de société du festival l\'Envol du Phénix, vous êtes l\'acteur de scènes épiques.\r\n				</p>\r\n				<p>Les thématiques des jeux de société ont bien évolués ces dernières années. Et les animateurs du Phénix vont vous proposer de :<br>\r\n					Piloter vos figurines de vaisseau spatial avec <strong>X-wing</strong>,<br>\r\n					Chasser du zombie en groupe avec <strong>Zombicide</strong>,<br>\r\n					Vengez un fantôme avec vos talents de médium avec <strong>Mystérium</strong>,<br>\r\n					Retrouvez un coupable parmi six suspects avec les indices de votre <strong>Profiler</strong>,<br>\r\n					... Affrontez les ténèbres et forgez votre propre légende !<br>\r\n				</p>\r\n				<p>Les hostilités débuteront le&nbsp; <strong>Samedi 12 mai de 10h - 20h</strong> gratis et tout public!<br>\r\n					Prolongations le <strong>Dimanche 13 mai de 10h - 18h</strong> gratis et tout public!</p>\r\n			</div>\r\n		</div> <!-- col -->\r\n		<div class=\"col-xs-6 col-sm-4 col-sm-offset-2 col-md-2 col-md-offset-0 col-md-pull-8\">\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/jds/take.jpg\')}}\">\r\n			<br>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/jds/abyss.jpg\')}}\">\r\n			<br>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/jds/potion.jpg\')}}\">\r\n		</div>\r\n		<div class=\"col-xs-6 col-sm-4 col-md-2\">\r\n\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/jds/tablejds.jpg\')}}\">\r\n			<br>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/jds/myst.jpg\')}}\">\r\n			<br>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/jds/magic.jpg\')}}\">\r\n		</div>\r\n	</div> <!-- row -->', 0, 1),
(13, 'Soirée Loups-Garous de Thiercelieux', 4, NULL, '<!-- Texte -->\r\n	<div class=\"row\">\r\n		<div class=\"col-sm-6 col-sm-push-3\">\r\n			<h3 class=\"titre-page\">Soirée des Loups-Garous de Thiercelieux</h3>\r\n			<hr class=\"hr-titre\">\r\n			<h5 class=\"sous-titre\">VENDREDI</h5>\r\n		</div> <!-- col -->\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<br>\r\n		<img class=\"img-responsive\" src=\"{{ asset(\'images/jds/bobmical.jpg\')}}\">\r\n		<br>\r\n	</div> <!-- row -->\r\n	<div class=\"row\">\r\n		<div class=\"col-md-offset-3 col-md-6\">\r\n			<p>Au village de Thiercelieux, les villageois vivent paisiblement le jour durant.<br>\r\n				Mais lorsque la nuit tombe, certain se transforme en loup garou et attaque discrètement.<br>\r\n				Et au levé du jour, la peur, la méfiance et le silence règnent. Tout ceci doit stopper! Les survivants vont s\'illustrer dans l\'art oratoire pour bannir les loups garous de village!</p>\r\n			<p>Grand conseil le <strong>Vendredi 11 mai à partir de 21h, tout public, pour 2€</strong>!</p>\r\n			<br>\r\n			<img class=\"img-responsive img-rounded\" src=\"{{ asset(\'images/jds/lg2.JPG\')}}\">\r\n			<br>\r\n		</div> <!-- col -->\r\n\r\n	</div> <!-- row -->', 1, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_3BAE0AA713B3DB11` FOREIGN KEY (`master_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `event_user`
--
ALTER TABLE `event_user`
  ADD CONSTRAINT `FK_92589AE271F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_92589AE2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `view`
--
ALTER TABLE `view`
  ADD CONSTRAINT `FK_FEFDAB8ECCD7E912` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
