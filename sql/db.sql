-- MariaDB dump 10.17  Distrib 10.4.13-MariaDB, for osx10.15 (x86_64)
--
-- Host: localhost    Database: frameworkOCauth
-- ------------------------------------------------------
-- Server version	10.4.12-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idNews` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date` datetime NOT NULL,
  `validated` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_FK_1` (`idNews`),
  KEY `comments_FK` (`idUser`),
  CONSTRAINT `comments_FK` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`),
  CONSTRAINT `comments_FK_1` FOREIGN KEY (`idNews`) REFERENCES `news` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (12,6,7,'Super article!','2020-05-06 17:36:42',1),(13,5,8,'Cet article est un peu vieux...','2020-05-06 19:01:23',1),(16,11,8,'Super article','2020-05-21 17:41:15',1);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `chapo` text NOT NULL,
  `contenu` text NOT NULL,
  `dateAjout` datetime NOT NULL,
  `dateModif` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_FK` (`idUser`),
  CONSTRAINT `news_FK` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (5,8,'Un article sur le html5!','Le html c\'est super!','HTML5 (HyperText Markup Language 5) est la dernière révision majeure du HTML (format de données conçu pour représenter les pages web). Cette version a été finalisée le 28 octobre 2014. HTML5 spécifie deux syntaxes d\'un modèle abstrait défini en termes de DOM : HTML5 et XHTML5. Le langage comprend également une couche application avec de nombreuses API, ainsi qu\'un algorithme afin de pouvoir traiter les documents à la syntaxe non conforme. Le travail a été repris par le W3C en mars 2007 après avoir été lancé par le WHATWG. Les deux organisations travaillent en parallèle sur le même document afin de maintenir une version unique de la technologie. Le W3C clôt les ajouts de fonctionnalités le 22 mai 2011, annonçant une finalisation de la spécification en 20141, et encourage les développeurs Web à utiliser HTML 5 dès ce moment. Fin 2016, la version 5.1 est officiellement publiée et présente plusieurs nouveautés qui doivent faciliter le travail des développeurs d\'applications Web2.','2020-05-06 16:48:22','2020-05-06 16:48:22'),(6,8,'Le javascript','Un article intéressant sur le JS!','JavaScript (qui est souvent abrégé en « JS ») est un langage de script léger, orienté objet, principalement connu comme le langage de script des pages web. Mais il est aussi utilisé dans de nombreux environnements extérieurs aux navigateurs web tels que Node.js, Apache CouchDB voire Adobe Acrobat. Le code JavaScript est interprété ou compilé à la volée (JIT). C\'est un langage à objets utilisant le concept de prototype, disposant d\'un typage faible et dynamique qui permet de programmer suivant plusieurs paradigmes de programmation : fonctionnelle, impérative et orientée objet. Apprenez-en plus sur JavaScript.','2020-05-06 17:26:57','2020-05-06 17:26:57'),(7,8,'Le php','Un petit tour d\'horizon sur le php... Top!','PHP: Hypertext Preprocessor5, plus connu sous son sigle PHP (sigle auto-référentiel), est un langage de programmation libre6, principalement utilisé pour produire des pages Web dynamiques via un serveur HTTP5, mais pouvant également fonctionner comme n\'importe quel langage interprété de façon locale. PHP est un langage impératif orienté objet.\r\n\r\nPHP a permis de créer un grand nombre de sites web célèbres, comme Facebook et Wikipédia7 Il est considéré comme une des bases de la création de sites web dits dynamiques mais également des applications web.','2020-05-07 15:32:06','2020-05-20 19:56:55'),(8,8,'Le language Go','Un article sur go','Go est un langage de programmation compilé et concurrent inspiré de C et Pascal. Ce langage a été développé par Google5 à partir d\'un concept initial de Robert Griesemer, Rob Pike et Ken Thompson. Go possède deux implémentations, la première utilise gc, le compilateur Go et la seconde utilise gccgo, « frontend » GCC écrit en C++. Go est écrit en C en utilisant yacc et GNU Bison pour l\'analyse syntaxique6 jusqu\'à la version 1.4, et en Go lui-même pour les versions suivantes (1.5).\r\n\r\nLogo de Google Go\r\nMascotte de Google Go.\r\nUn objectif de Go est donné par Rob Pike, l\'un de ses trois créateurs, qui dit à propos des développeurs inexpérimentés7 :\r\n\r\n« Ils ne sont pas capables de comprendre un langage brillant, mais nous voulons les amener à réaliser de bons programmes. Ainsi, le langage que nous leur donnons doit être facile à comprendre et facile à adopter »\r\n\r\nGo veut faciliter et accélérer la programmation à grande échelle : en raison de sa simplicité il est donc concevable de l\'utiliser aussi bien pour écrire des applications, des scripts ou de grands systèmes. Cette simplicité est nécessaire aussi pour assurer la maintenance et l\'évolution des programmes sur plusieurs générations de développeurs.\r\n\r\nS\'il vise aussi la rapidité d\'exécution, indispensable à la programmation système, il considère le multithreading comme le moyen le plus robuste d\'assurer sur les processeurs actuels cette rapidité8 tout en rendant la maintenance facile par séparation de tâches simples exécutées indépendamment afin d\'éviter de créer des « usines à gaz ». Cette conception permet également le fonctionnement sans réécriture sur des architectures multi-cœurs en exploitant immédiatement l\'augmentation de puissance correspondante','2020-05-07 15:32:35','2020-05-07 15:32:35'),(9,8,'Le language ruby','Court article sur Ruby et son ancienne hype','Ruby est un langage de programmation libre. Il est interpr&eacute;t&eacute;, orient&eacute; objet et multi-paradigme. Le langage a &eacute;t&eacute; standardis&eacute; au Japon en 2011 (JIS X 3017:2011)3, et en 2012 par l&#039;Organisation internationale de normalisation (ISO 30170:2012)4.','2020-05-07 15:33:16','2020-05-20 20:13:59'),(10,8,'Le python','Le language python','Python (/ˈpaɪ.θɑn/5) est un langage de programmation interprété, multi-paradigme et multiplateformes. Il favorise la programmation impérative structurée, fonctionnelle et orientée objet. Il est doté d\'un typage dynamique fort, d\'une gestion automatique de la mémoire par ramasse-miettes et d\'un système de gestion d\'exceptions ; il est ainsi similaire à Perl, Ruby, Scheme, Smalltalk et Tcl.\r\n\r\nLe langage Python est placé sous une licence libre proche de la licence BSD6 et fonctionne sur la plupart des plates-formes informatiques, des smartphones aux ordinateurs centraux7, de Windows à Unix avec notamment GNU/Linux en passant par macOS, ou encore Android, iOS, et peut aussi être traduit en Java ou .NET. Il est conçu pour optimiser la productivité des programmeurs en offrant des outils de haut niveau et une syntaxe simple à utiliser.\r\n\r\nIl est également apprécié par certains pédagogues qui y trouvent un langage où la syntaxe, clairement séparée des mécanismes de bas niveau, permet une initiation aisée aux concepts de base de la programmation8.','2020-05-07 15:34:34','2020-05-07 15:34:34'),(11,8,'Qu\'est-ce que git','Un petit article sur git...','Git est un logiciel de gestion de versions décentralisé. C\'est un logiciel libre créé par Linus Torvalds, auteur du noyau Linux, et distribué selon les termes de la licence publique générale GNU version 2. En 2016, il s’agit du logiciel de gestion de versions le plus populaire qui est utilisé par plus de douze millions de personnes.','2020-05-07 15:35:05','2020-05-21 17:40:45');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` smallint(6) NOT NULL,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(100) NOT NULL,
  `validationToken` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (7,'toto','toto@toto.to',2,1,'$2y$10$HkmgwsHTKsBVxLHLL9VF2OGpSTWrBXgWhwtdQmMoyNmcRLdBg9XCG','void'),(8,'tata','tata@tata.ta',1,1,'$2y$10$SktyaMK5d9TV9nQTliz3aObab9jHqil0Tm3cyiU7TETSlD43EiKdy','void');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-22 16:00:23
