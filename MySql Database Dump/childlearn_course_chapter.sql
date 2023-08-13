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
-- Table structure for table `course_chapter`
--

DROP TABLE IF EXISTS `course_chapter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_chapter` (
  `chapter_id` int NOT NULL AUTO_INCREMENT,
  `chapter_title` varchar(40) NOT NULL,
  `chapter_order` int NOT NULL,
  `content_text` longtext NOT NULL,
  `content_image` longtext NOT NULL,
  `content_video` longtext,
  `course_id` int NOT NULL,
  PRIMARY KEY (`chapter_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_chapter`
--

LOCK TABLES `course_chapter` WRITE;
/*!40000 ALTER TABLE `course_chapter` DISABLE KEYS */;
INSERT INTO `course_chapter` VALUES (1,'Letter Magic',1,'Welcome to the exciting world of Letter Magic! Get ready to embark on a thrilling journey through the alphabet, from A to Z. Each letter holds a special power and opens up a whole new world of words and wonders. Let\'s explore the magic of each letter and learn more about them:\n\nA - A is for Apple: A juicy and delicious fruit that starts with the letter A. Can you think of any other words that start with the letter A?\n\nB - B is for Ball: A round object that we can play with. What other words can you think of that begin with the letter B?\n\nC - C is for Cat: A furry and playful animal that starts with the letter C. Can you name any other animals that begin with the letter C?\n\nD - D is for Dog: A loyal and friendly animal that starts with the letter D. Can you think of any other words that start with the letter D?\n\nE - E is for Elephant: A magnificent and gentle giant that begins with the letter E. What other words can you think of that start with the letter E?\n\nF - F is for Flower: Beautiful and colorful plants that begin with the letter F. Can you name any other words that start with the letter F?\n\nG - G is for Giraffe: A tall and graceful animal that starts with the letter G. What other words can you think of that begin with the letter G?\n\nH - H is for Hat: An accessory that we wear on our heads. Can you think of any other words that start with the letter H?\n\nI - I is for Ice Cream: A sweet and cold treat that starts with the letter I. Can you name any other words that begin with the letter I?\n\nJ - J is for Jellyfish: An interesting sea creature that starts with the letter J. What other words can you think of that start with the letter J?\n\nK - K is for Key: An object we use to unlock doors. Can you think of any other words that start with the letter K?\n\nL - L is for Lion: A majestic and powerful animal that starts with the letter L. Can you name any other words that begin with the letter L?\n\nM - M is for Monkey: A playful and curious creature that starts with the letter M. What other words can you think of that start with the letter M?\n\nN - N is for Nest: A cozy home built by birds. Can you think of any other words that start with the letter N?\n\nO - O is for Octopus: A fascinating sea creature with many tentacles. Can you name any other words that begin with the letter O?\n\nP - P is for Penguin: A cute and waddling bird that starts with the letter P. What other words can you think of that start with the letter P?\n\nQ - Q is for Queen: A royal title for a female ruler. Can you think of any other words that start with the letter Q?\n\nR - R is for Rainbow: A beautiful arc of colors that appears after the rain. Can you name any other words that begin with the letter R?\n\nS - S is for Sun: The bright and shining star that gives us light and warmth. What other words can you think of that start with the letter S?\n\nT - T is for Tree: A tall and sturdy plant with branches and leaves. Can you think of any other words that start with the letter T?\n\nU - U is for Unicorn: A mythical and magical creature with a horn on its head. Can you name any other words that begin with the letter U?\n\nV - V is for Vegetable: Healthy and nutritious plants that we eat. What other words can you think of that start with the letter V?\n\nW - W is for Whale: A massive and gentle creature that lives in the ocean. Can you think of any other words that start with the letter W?\n\nX - X is for Xylophone: A musical instrument with wooden keys. Can you name any other words that begin with the letter X?\n\nY - Y is for Yellow: A bright and cheerful color that starts with the letter Y. What other words can you think of that start with the letter Y?\n\nZ - Z is for Zebra: A striped and unique animal that begins with the letter Z. Can you think of any other words that start with the letter Z?\n\nLet\'s continue our journey through the alphabet and explore the magic of each letter. Together, we\'ll learn to recognize, write, and use the letters to create words. Get ready to unlock the power of the ABCs and embark on an extraordinary learning adventure with Letter Magic!','lettermagic_chapter_contentimage.jpg','lettermagic_chapter_contentvideo.mp4',1),(2,'Sound Detectives',2,'Chapter 2 teaching content paragraph 1...','Sound Detectives.jpeg','Sound Detectives.mp4',1),(3,'Reading Adventures',3,'Chapter 3 teaching content paragraph 1...','Reading Adventures.jpeg','Reading Adventures.mp4',1),(4,'Creating Characters',1,'Chapter 1 teaching content paragraph 1...','Creating Characters.jpeg','Creating Characters.mp4',2),(5,'Building Plotlines',2,'Chapter 2 teaching content paragraph 1...','Building Plotlines.jpeg','Building Plotlines.mp4',2),(6,'Expressive Storytelling',3,'Chapter 3 teaching content paragraph 1...','Expressive Storytelling.jpeg','Expressive Storytelling.mp4',2),(7,'Vocabulary Voyage',1,'Chapter 1 teaching content paragraph 1...','Vocabulary Voyage.jpeg','Vocabulary Voyage.mp4',3),(8,'Word Puzzles Galore',2,'Chapter 2 teaching content paragraph 1...','Word Puzzles Galore.jpeg','Word Puzzles Galore.mp4',3),(9,'Creative Word Play',3,'Chapter 3 teaching content paragraph 1...','Creative Word Play.jpeg','Creative Word Play.mp4',3),(10,'Counting Conquerors',1,'Chapter 1 teaching content paragraph 1...','Counting Conquerors.jpeg','Counting Conquerors.mp4',4),(11,'Addition Adventures',2,'Chapter 2 teaching content paragraph 1...','Addition Adventures.jpeg','Addition Adventures.mp4',4),(12,'Subtraction Superstars',3,'Chapter 3 teaching content paragraph 1...','Subtraction Superstars.jpeg','Subtraction Superstars.mp4',4),(13,'Exploring 2D Shapes',1,'Chapter 1 teaching content paragraph 1...','Exploring 2D Shapes.jpeg','Exploring 2D Shapes.mp4',5),(14,'Discovering 3D Shapes',2,'Chapter 2 teaching content paragraph 1...','Discovering 3D Shapes.jpeg','Discovering 3D Shapes.mp4',5),(15,'Pattern Puzzlers',3,'Chapter 3 teaching content paragraph 1...','Pattern Puzzlers.jpeg','Pattern Puzzlers.mp4',5),(16,'Logic Labyrinth',1,'Chapter 1 teaching content paragraph 1...','Logic Labyrinth.jpeg','Logic Labyrinth.mp4',6),(17,'Critical Thinking Challenges',2,'Chapter 2 teaching content paragraph 1...','Critical Thinking Challenges.jpeg','Critical Thinking Challenges.mp4',6),(18,'Puzzle Solvers Society',3,'Chapter 3 teaching content paragraph 1...','Puzzle Solvers Society.jpeg','Puzzle Solvers Society.mp4',6),(19,'Plants and Their World',1,'Chapter 1 teaching content paragraph 1...','Plants and Their World.jpeg','Plants and Their World.mp4',7),(20,'Animal Kingdom Explorations',2,'Chapter 2 teaching content paragraph 1...','Animal Kingdom Explorations.jpeg','Animal Kingdom Explorations.mp4',7),(21,'Ecosystem Expeditions',3,'Chapter 3 teaching content paragraph 1...','Ecosystem Expeditions.jpeg','Ecosystem Expeditions.mp4',7),(22,'States of Matter Exploration',1,'Chapter 1 teaching content paragraph 1...','States of Matter Exploration.jpeg','States of Matter Exploration.mp4',8),(23,'Electricity and Circuitry Adventures',2,'Chapter 2 teaching content paragraph 1...','Electricity and Circuitry Adventures.jpeg','Electricity and Circuitry Adventures.mp4',8),(24,'Chemical Reactions Unveiled',3,'Chapter 3 teaching content paragraph 1...','Chemical Reactions Unveiled.jpeg','Chemical Reactions Unveiled.mp4',8),(25,'Introduction to Robotics',1,'Chapter 1 teaching content paragraph 1...','Introduction to Robotics.jpeg','Introduction to Robotics.mp4',9),(26,'Building Simple Machines',2,'Chapter 2 teaching content paragraph 1...','Building Simple Machines.jpeg','Building Simple Machines.mp4',9),(27,'Coding Adventures',3,'Chapter 3 teaching content paragraph 1...','Coding Adventures.jpeg','Coding Adventures.mp4',9);
/*!40000 ALTER TABLE `course_chapter` ENABLE KEYS */;
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

-- Dump completed on 2023-08-10 17:11:47
