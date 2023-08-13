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
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teacher` (
  `teac_id` int NOT NULL AUTO_INCREMENT,
  `teac_username` varchar(30) NOT NULL,
  `teac_password` varchar(255) NOT NULL,
  `teac_email` varchar(40) NOT NULL,
  `teac_first_name` varchar(30) NOT NULL,
  `teac_last_name` varchar(30) NOT NULL,
  `teac_join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `teac_profile_picture` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'teac_default_profile.png',
  `teac_edu_proof` varchar(255) NOT NULL,
  `teac_status` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`teac_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher`
--

LOCK TABLES `teacher` WRITE;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` VALUES (1,'jordan_1908','$2y$10$24qXX0nBZwAbAiF7.Dvs2uKtdR0u6u3Kh07gMnOY5IbA5XpQFldKe','jordansahabudin@gmail.com','Jordan','Sahabudin','2022-04-19 17:42:08','p1.png','SAT ans.pdf','Verified'),(2,'jadson','$2y$10$0p4kBk1kgGPpiyyruIgQ5OxceHBLa.RB.JeYcJtguKgC5iFWM9HPa','jadson@justsimple.com','jadson','chong','2022-05-18 15:38:14','teac_default_profile.png','ERD.pdf','Verified'),(3,'jadsonchong','$2y$10$jS8ozMyIYGWagLR9wQq4GOJuhhB2eTZhhOZhs0eOMl7iB6KQaUryq','jadson@gmail.com','jadson','chong','2022-05-27 14:49:22','teac_default_profile.png','CC2 Group&Individual Assignment.docx','Verified'),(4,'TeacherTesting','$2y$10$R1lBJiN9fR7KeC3udJJK.uf/57DADVwNjR.tIKmWbk.BZmKe4QkCq','teachertesting@gmail.com','Teacher','Testing','2023-06-11 01:17:59','teac_default_profile.png','suzume-no-tojimari-67asgs.pdf','Verified');
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;
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

-- Dump completed on 2023-08-10 17:11:26
