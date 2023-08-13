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
-- Table structure for table `chatbot`
--

DROP TABLE IF EXISTS `chatbot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chatbot` (
  `id` int NOT NULL AUTO_INCREMENT,
  `queries` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `replies` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatbot`
--

LOCK TABLES `chatbot` WRITE;
/*!40000 ALTER TABLE `chatbot` DISABLE KEYS */;
INSERT INTO `chatbot` VALUES (1,'hi | hello | heyyy | who are you | whats your name? | what is your name?','Hello there! I am SkillBot, here to assist you in your doubts.'),(2,'How many quiz do you have? | What quiz do you have? | How many type of quiz do you have?','We currently focus on 3 types of quiz which are Business, Design, and IT quiz.'),(3,'Does your quiz have time limit? | What is the time limit of your quiz | Is there time limit on your quizzes? | time limit | How long is the time limit for each quiz?','Yes, different time limits are being set for different quiz.'),(4,'How many questions are there in a quiz? | questions in quiz','The number of questions differs for each quiz. Number of questions for each quiz would typically range from 5 to 10 questions.'),(5,'Do you offer any online courses? | Are there any courses available on your website? | Do you sell courses? | What courses do you have on your website?','We currently do not provide any courses within our website, only quizzes. However, always stay tune for new updates!'),(6,'How many attempts can i try in a quiz? | How many attempts are there for each quiz? | What are the attempts for each quiz? | What are the number of attempts for each quiz?','You can attempt as many tries as you like. There are no limits on how many times a user may attempt the quiz.'),(7,'How to contact you regarding other enquiry? | Whats your email address? | How to send you an email? | Do you have a phone number? | Whats your contact address?','You can always send us an email at skillsofteducation@gmail.com. We will get back to you as soon as possible.'),(8,'Do you offer membership? | Do you have membership feature?','We do not offer any membership feature as of now due to the website still being in the initial release stage. '),(9,'Is it possible to order attempt quiz without signing in? Can i attempt quiz without signing in? | Can i attempt quiz without logging in? | Is it compulsory to log in? | log in | login | signin | sign in','Yes, all users are required to sign in and verify their account through the registered email before being able to utilize the major website features.'),(10,'Can i post a forum? How to post a forum question? | forum | Can i post unrelated forum question?','You can always post a question in the forum by clicking the forum button on the top navigational panel when you are logged into your account.'),(11,'What is this website about? | What is the main objective of Skillsoft? | What does Skillsoft hope to achieve?','This is a website that focuses on providing exciting quizzes that enhances students learning knowledge.');
/*!40000 ALTER TABLE `chatbot` ENABLE KEYS */;
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

-- Dump completed on 2023-08-10 17:12:01
