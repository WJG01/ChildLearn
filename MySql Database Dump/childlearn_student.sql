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
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `stud_id` int NOT NULL AUTO_INCREMENT,
  `stud_first_name` varchar(30) NOT NULL,
  `stud_last_name` varchar(30) NOT NULL,
  `stud_username` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `stud_email` varchar(40) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `stud_profile_picture` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'default_profile_picture.png',
  `verified` int NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`stud_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'jadson','winyip','jadson','dexter_winyip01@hotmail.com','$2y$10$L7LxRqQDMdSpxgYAyk0ZM.KvdHZFaTZJu7sWvq4AesNrir.1j1tMi','CRI Poster (Chong Win Yip - TP056517).png',1,'b04555f9ab69fd130d61c72fdcc75f06ca36d5d24fd25c31a42e2f5b416322819fce7050f6249807939348883f941e4c83ad'),(13,'Jordan','Sahabudin','jordan_1908','jordansahabudin@gmail.com','$2y$10$pQf88BrgRjzomzfmVDpnb.Ff3RpEtFR6BJvZI/OgN5in4uZsFxr2u','tom.png',1,'21a7165f2aff3916a83a1c0a772e911aba795a6b8527f745d19af9e989ac7164f905a50e5935292fd4da28df1170572df2ae'),(3,'Testing','Student','TestingStudent','anonymousname1904@gmail.com','$2y$10$5a3Ln0hFnVf4pLAVqOch9.udKGXKrQMWnQuZQIVp/jXsRVxIqZ9n2','securityGuard-SID1.jpg',1,'3bdac7a2858138e5ed63916bb6e0aa7df6713ea5321427b9938989ef7e34e5916d10ec34e104a6f1409c76b3e1ccadc53edd'),(5,'aa','aaa','aa','jason@gmail.com','$2y$10$8LkWLJILc1K.3H3llM/eqOpzJWJKZBBvy9VrpBq9z40T59heKXEJS','default_profile_picture.png',0,'6067fd21ca09d29c214f3f3f27e5df0b332146631a7204015ab8d0f5862278d6724dfe81b5025ab4c15e2a4d79ac522b4e1f'),(6,'jasonlee','jason','jasonlee12031','shengoishen@gmail.com','$2y$10$grHFTt97rwA4reydioo1JOVfRcl7hE.dqXWssLNHIdRz3PZSAKIpC','default_profile_picture.png',0,'d63b85fe99745a3013abb24bd2c7f8d9f176e4c03afd910d4306d6301fe9fdc99e1c10988e2b06a1bc2146eddbc541355e4d'),(20,'Jordan','Sahabudin','jordansahabudin','jordansahabudin01@yahoo.com','$2y$10$6h7vNIdkaGcre81uduqxhOro/7pU95/u6RMMwN5MAq1B3UeH78bTW','default_profile_picture.png',1,'e2cd3a98773cdd54fde66ec73d4b930716f63a8b8baf1859cb3274f9a6e28adae8842aebe1acae80e87c6e068d5cf8957720'),(19,'hackathon','techify','hackathon','hackathon.techify@gmail.com','$2y$10$UukCx42gmW2PTTSGZH847eAZUmn1Ag0ge484.l3HAL1TebJ1h3sgS','default_profile_picture.png',1,'934bf2038fde3505da2a9a6e5d44379bb4fc9ad18be6a7b2e9f1e02687176f1c9437213a94d785a3a47c0fd6bf0ba0bc61a0'),(10,'aaa','aaa','aaaaaaa','aa@aa.com','$2y$10$popHbd.YCX0e6duMe.eJTuQm1l068GFqOYOvAb78RrygfjHnfn9QG','default_profile_picture.png',0,'5485cfec91061a2a280bc01eb4084cc17566fefcb80e546a92c21093302f060271001e1b574a4069b70752f2659ca714ac39'),(11,'Goi','Yi Shen','goiyishen','goiyishen@gmail.com','$2y$10$p8LpDs9aGBeZ2s66VtGIDe1Vfijz3XqE3sQep2EOgTWD.HS6D31Um','default_profile_picture.png',1,'1306be83e416c32214e359a3426c03aa26395f7f8ebc6aebc408fc3dacdf427048bf896bfc1340be8e37625f4b8d97c8dea9'),(14,'childlearn','learn','childlearn','childlearndaycare@gmail.com','$2y$10$F6FQLsoBOLMxnT9LT/fGmO3flmx3yMXT3A1Ym2rZOi3EVowVO2nb6','default_profile_picture.png',1,'507bb7d0ff061e040363bec0b85dac00f71f165ed03ce0d24f182444085b6c74e1b6e8c5a0bc4e17dcf086454acb13170098'),(21,'Gan','Jun','gwjuser','weijungan0123@gmail.com','$2y$10$4r2hUhCpYcszsDxcpt1Gm.imnK6suEzr5wO/TBMjGLfzOGNlX3CA2','default_profile_picture.png',1,'d261cce220c907b47faa983cbe0dd3500bdffa2174e26a68ff61d816f1d86d92fe858b7788b190788c28b2e4462f0ae560fe');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
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

-- Dump completed on 2023-08-10 17:12:31
