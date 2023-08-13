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
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz` (
  `quiz_id` int NOT NULL AUTO_INCREMENT,
  `quiz_title` varchar(40) NOT NULL,
  `quiz_category` varchar(50) NOT NULL,
  `quiz_cover` longtext NOT NULL,
  `quiz_timer` int NOT NULL,
  `quiz_point` int NOT NULL,
  `quiz_description` varchar(255) NOT NULL,
  `quiz_create_date` date NOT NULL,
  `teac_id` int NOT NULL,
  `course_id` int NOT NULL,
  PRIMARY KEY (`quiz_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz`
--

LOCK TABLES `quiz` WRITE;
/*!40000 ALTER TABLE `quiz` DISABLE KEYS */;
INSERT INTO `quiz` VALUES (1,'SDP QUIZ','Language and Literacy','Business Analysis Fundamentals.jpg',40,20,'123','2021-03-01',4,1),(2,'Entrepreneurial Quiz','Language and Literacy','Enterprising & Entrepreneurial.jpeg',1,5,'This quiz is to test students on their basic entrepreneurial knowledge.','2021-03-01',4,2),(3,'Communication Quiz','Language and Literacy','Communication Skills.png',20,10,'This quiz is to test students on their communication skills.','2021-03-01',4,3),(4,'Fundamentals Graphic Design Practice','Mathematics and Logic','fundamental_design.jpg',15,10,'This quiz is to test students on their creativity design.','2021-03-01',4,4),(5,'HTML and CSS Quiz','Science and Discovery','html_css.jpg',20,10,'This quiz is to test students on their web development expertise.','2021-03-01',4,5),(6,'Adobe Photoshop Test','Mathematics and Logic','photoshop_course.jpg',20,10,'This quiz is to test students on their photoshop skills.','2021-03-01',4,6),(7,'JavaScript Quiz','Science and Discovery','javascript.jpg',10,10,'This quiz is to test students on their knowledge towards scripting language.','2021-03-01',4,7),(8,'PHP Tutorials Quiz','Science and Discovery','php.jpg',30,20,'This quiz is to test students on their knowledge towards PHP language.','2022-05-03',4,8),(9,'Adobe Design Test','Mathematics and Logic','photoshop_course.jpg',10,10,'This quiz is to test students on their knowledge towards adobe skills.','2022-05-02',4,9);
/*!40000 ALTER TABLE `quiz` ENABLE KEYS */;
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

-- Dump completed on 2023-08-10 17:12:08
