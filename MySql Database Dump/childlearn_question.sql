-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: awseb-e-ecfp7dp5pn-stack-awsebrdsdatabase-3kt0ellbqgdt.c1cevqakx6ry.us-east-1.rds.amazonaws.com    Database: childlearn
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '';

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question` (
  `ques_id` int NOT NULL AUTO_INCREMENT,
  `ques_title` varchar(100) NOT NULL,
  `ques_content` text NOT NULL,
  `ques_post_date` date DEFAULT NULL,
  `stud_id` int NOT NULL,
  PRIMARY KEY (`ques_id`),
  KEY `stud_id` (`stud_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'Ajax Delete Request','I have a problem talking with an API. I need to make a DELETE request containing a token and an id to delete some data in the database.','2022-05-25',2),(2,'How to edit jquery?','My question is, where should I enter the jQuery code I want to use?','2022-05-25',2),(3,'How to insert data using SQL?','I kept receiving an error when inserting query to phpMyAdmin. Can someone help me out?','2022-05-25',2),(4,'SQL Select','May I know what is SQL Select statement used for?','2022-05-25',2),(5,'Material Design Topic','How to be extremely good at designing materials?','2022-05-25',2),(6,'Business Development Expertise','May I know how to boost my business development strategy?','2022-05-25',2),(7,'PHP Extract Method','What does the extract method used for in PHP?','2022-05-25',2),(8,'PHP Framework','May I know which is the most popular framework for PHP in the current market?\r\n','2022-05-25',2),(9,'Regression Testing','Does anyone here have experience with regression testing? I need some help on my project.','2022-05-25',2),(10,'WordPress Plugins','I want to integrate WooCommerce into my WordPress website, but have no experience in this field. Can someone lend me a hand?','2022-05-25',2),(11,'AJAX vs jQuery','What exactly are the differences between AJAX and jQuery? It feels like both are the same technology.','2022-05-25',2),(13,'I wanted to ask a question','my question is about the question','2023-06-10',3),(14,'Mathematics Question','How does linear equation work?','2023-07-29',13);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-10 17:12:23
