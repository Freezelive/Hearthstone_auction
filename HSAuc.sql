-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: HSAuc
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auction_log`
--

DROP TABLE IF EXISTS `auction_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auction_log` (
  `round` tinyint(4) DEFAULT NULL,
  `player` int(11) DEFAULT NULL,
  `bid` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `player` (`player`),
  KEY `round` (`round`),
  CONSTRAINT `auction_log_ibfk_1` FOREIGN KEY (`player`) REFERENCES `auction_players` (`id`),
  CONSTRAINT `auction_log_ibfk_2` FOREIGN KEY (`round`) REFERENCES `auction_round` (`round`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auction_log`
--

LOCK TABLES `auction_log` WRITE;
/*!40000 ALTER TABLE `auction_log` DISABLE KEYS */;
INSERT INTO `auction_log` VALUES (1,4,10,153),(2,3,9,154),(3,3,19,155),(4,3,5,156),(5,3,7,157),(6,4,5,158),(7,4,15,159),(8,5,0,160),(9,4,10,161),(10,3,28,162),(11,4,3,163),(12,5,0,164),(13,3,9,165),(14,4,21,166),(15,4,4,167),(16,5,0,168),(17,4,8,169),(18,4,24,170),(19,6,0,172);
/*!40000 ALTER TABLE `auction_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auction_players`
--

DROP TABLE IF EXISTS `auction_players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auction_players` (
  `player` varchar(50) NOT NULL,
  `dust` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auction_players`
--

LOCK TABLES `auction_players` WRITE;
/*!40000 ALTER TABLE `auction_players` DISABLE KEYS */;
INSERT INTO `auction_players` VALUES ('Malcom',23,3),('Ghost101',0,4),('Gotero',100,5),('Anonimus',100,6);
/*!40000 ALTER TABLE `auction_players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auction_round`
--

DROP TABLE IF EXISTS `auction_round`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auction_round` (
  `round` tinyint(4) NOT NULL,
  `common` tinyint(4) DEFAULT NULL,
  `rare` tinyint(4) DEFAULT NULL,
  `epic` tinyint(4) DEFAULT NULL,
  `legendary` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`round`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auction_round`
--

LOCK TABLES `auction_round` WRITE;
/*!40000 ALTER TABLE `auction_round` DISABLE KEYS */;
INSERT INTO `auction_round` VALUES (1,0,5,1,0),(2,2,3,1,0),(3,3,2,0,1),(4,5,1,0,0),(5,0,6,0,0),(6,1,5,0,0),(7,1,4,0,1),(8,3,3,0,0),(9,1,2,3,0),(10,0,0,5,1),(11,0,NULL,NULL,NULL),(12,NULL,0,NULL,NULL),(13,NULL,NULL,0,NULL),(14,NULL,NULL,NULL,0),(15,0,NULL,NULL,NULL),(16,NULL,0,NULL,NULL),(17,NULL,NULL,0,NULL),(18,NULL,NULL,NULL,0),(19,7,6,5,1);
/*!40000 ALTER TABLE `auction_round` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-12 22:46:11
