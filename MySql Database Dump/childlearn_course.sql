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
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course` (
  `course_id` int NOT NULL AUTO_INCREMENT,
  `course_title` varchar(40) NOT NULL,
  `course_category` varchar(50) NOT NULL,
  `course_cover` longtext NOT NULL,
  `course_description` varchar(255) NOT NULL,
  `course_create_date` date NOT NULL,
  `teac_id` int NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'Phonics Fun','Language and Literacy','phonicfun_course_coverpage.jpeg','This course introduces children to phonics through interactive games, songs, and activities.','2023-06-30',4),(2,'Storytelling Adventures','Language and Literacy','storytelling_course_coverpage.jpeg','In this course, children embark on exciting storytelling adventures. They learn how to create characters, build narratives, and express their ideas through storytelling techniques, encouraging creativity and language development.','2023-06-30',4),(3,'Word Wizards','Language and Literacy','wordwizard_course_coverpage.jpeg','Word Wizards is a vocabulary-building course that helps children expand their word bank, improve word usage, and enhance their language skills through engaging word games, puzzles, and word association activities.','2023-06-30',4),(4,'Number Ninjas','Mathematics and Logic','numberninjas_course_coverpage.jpeg','Number Ninjas is a course designed to develop children\'s number sense and counting skills. Through interactive exercises, games, and counting adventures, children learn to recognize numbers, count objects, and understand basic mathematical concepts.','2023-06-30',4),(5,'Shape Explorers','Mathematics and Logic','shapeexplorer_course_coverpage.jpeg','Shape Explorers takes children on a journey to discover different shapes and patterns. Through hands-on activities, shape recognition games, and pattern-building challenges, children develop spatial awareness and logical thinking skills.','2023-06-30',4),(6,'Problem Solvers Club','Mathematics and Logic','problemsolverclub_course_coverpage.jpeg','In the Problem Solvers Club, children are introduced to critical thinking and problem-solving skills. Through puzzles, riddles, and interactive challenges, they learn to analyze situations, make decisions, and find solutions using their mathematical abili','2023-06-30',4),(7,'Nature Detectives','Science and Discovery','naturedetectives_course_coverpage.jpeg','Nature Detectives is an exploration course that helps children discover the wonders of nature. Through interactive lessons, virtual field trips, and nature-themed activities, children learn about plants, animals, ecosystems, and develop an appreciation fo','2023-06-30',4),(8,'Science Lab Explorers','Science and Discovery','sciencelabexplorer_course_coverpage.jpeg','Science Lab Explorers takes children on a virtual journey to the science lab. Through hands-on experiments, demonstrations, and scientific investigations, children explore basic scientific concepts, such as states of matter, electricity, or simple chemica','2023-06-30',4),(9,'STEM Builders','Science and Discovery','stembuilder_course_coverpage.jpeg','STEM Builders is a course that introduces children to the exciting world of STEM. Through engaging projects, experiments, and interactive challenges, children develop critical thinking, problem-solving, and engineering skills while exploring topics like r','2023-06-30',4),(40,'testing x-ray------','testingS3','courseCover_testing x-ray------_apspace-black.jpg','testing x-ray------','2023-08-08',1),(48,'testing x-ray-test','testingS3','apspace-black.jpg','testing x-ray-test','2023-08-10',4);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
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

-- Dump completed on 2023-08-10 17:11:40
