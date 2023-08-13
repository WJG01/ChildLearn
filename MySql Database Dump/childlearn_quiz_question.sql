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
-- Table structure for table `quiz_question`
--

DROP TABLE IF EXISTS `quiz_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz_question` (
  `quques_id` int NOT NULL AUTO_INCREMENT,
  `quques_number` int NOT NULL,
  `quques_question` text NOT NULL,
  `quques_correct_answer` char(2) NOT NULL,
  `quques_choices_A` varchar(40) NOT NULL,
  `quques_choices_B` varchar(40) NOT NULL,
  `quques_choices_C` varchar(40) DEFAULT NULL,
  `quques_choices_D` varchar(40) DEFAULT NULL,
  `quiz_id` int NOT NULL,
  PRIMARY KEY (`quques_id`),
  KEY `quiz_id` (`quiz_id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_question`
--

LOCK TABLES `quiz_question` WRITE;
/*!40000 ALTER TABLE `quiz_question` DISABLE KEYS */;
INSERT INTO `quiz_question` VALUES (1,1,'CWC stands for?','3','Central Water Commission','Central Warehousing Commission','Central Warehousing Corporation','Central Water Corporation',1),(2,2,'Which of the following is not a function of insurance?','2','Risk sharing','Assist in capital formation','Lending of funds','None of the above',1),(3,3,'The validity period of a demand draft is?','3','One month','Two Months','Three months','Six Months',1),(4,4,'DTH services are provided by?','3',' Transport Company','Banks','Cellular Company','None of these',1),(5,5,'Which of the following is an allied postal service?','3','Greeting post','Media post','Speed post','Passport Application',1),(6,1,'____ carried out indirectly through existing resources?','2','Market research','Secondary research','Demographics','Primary research',2),(7,2,'Which distinguishes goods or services through a design, symbol, name, term, or other features?','4','Positioning','Marketing','Demographics','Brand',2),(8,3,'____ conducted directly on a subject or subjects?','4','Secondary research','Marketing','Market research','Primary research',2),(9,4,'The development and use of strategies for getting a product or service to customers.','1','Marketing','Market Segment','Brand','Positioning',2),(10,5,'Stages that a product or service in the market - introduction, growth, maturity, and decline?','2','Positioning','Product life cycle (PLC)','Market research','Primary research',2),(11,1,'Of the following which is not a nonverbal communication?','3','Eye contact','Arms Crossed','Verbally talking','Nail biting',3),(32,2,'Which option below allows users to saturate pixels?','3','Dodge Tool','Burn Tool','Sponge Tool','Mixer Brush Tool',7),(12,2,'Communication is always a ____ way process.','2','One','Two','Three','Four',3),(13,3,'____ is the sharing of information in which a receiver understands the meaning of a message.','3','Netiquette','Distraction','Communication','Non verbal',3),(14,4,'When a receiver relays information, they expect ____.','3','Communication','Symbols','Feedback','Reaction',3),(15,5,'This type of communication is speaking to teachers and students.','3','Written','Non verbal','Oral','Body language',3),(16,1,'What is the first and most basic element of design?','1','Line','Shape','Color','Size',4),(17,2,'What is the most obvious elements of design?','1','Color','Shape','Line','Texture',4),(18,3,'How a fabric feels or looks.','2','Rough','Texture','Slick','Shiny',4),(19,4,'Content and Copy are two types of?','1','Printing','Shedding','Designs','Communication',4),(20,5,'George Eastman created the _____ ?','1','Eastman Kodak Company','AT&T','T-Mobile','Chinese Printing Press',4),(31,1,'What keyboard shortcut would you use to undo the last edit?','1','Cmd+Z/Ctrl+Z','Cmd+U/Ctrl+U','Option+Z/Alt+Z','Option+U/Ctrl+U',7),(21,1,'Who is making the Web standards?','2','Google','The World Wide Web Consurtium','Mozilla','Microsoft',5),(22,2,'Which of the following is a font property?','4','Face','Color','Size','All of these are font properties',5),(23,3,'Which character is used to indicate an end tag?','1','/','*','^','<',5),(24,4,'What is the purpose of HTML','2','To make a formatted document','To make a webpage','To edit photos','To make a creative slide',5),(25,5,'Google Chrome is an example of a what?','3','URL','IP address','Web browser','Incorrect metal',5),(26,1,'Businesses that sell primarily to other businesses are in the _________ market.','4','Manufacturing','B2C','Target','B2B',6),(27,2,'Process of communicating with potential customers in an effort to influence their buying behavior.','2','Marketing strategy','Promotion','Personal influence','Situational influence',6),(28,3,'Focuses on building long-term relationships with customers.','3','Extensive buying decision','Promotion','Relationship selling','Personal influence',6),(29,4,'Marketing to a larger group of people who might buy a product.','2','Promotion','Mass marketing','Personal influence','Social influence',6),(30,5,'\"Being green.\"','4','Production','Sales','Market','Societal',6),(33,3,'The _____ bar changes depending on which tool is currently selected.','1','Options','Tools','Menu','Document',7),(34,4,'In the View menu, you can click ______ to set a guide at an exact point.','4','Lock Guide','Set Guide','Edit Guide','New Guide',7),(35,5,'A color _____ defines the range of colors within a color model.','1','Profile','Menu','Gallery','Setting',7),(36,1,'Line segments between anchor points are referred to as _____________.','2','Segments','Paths','Lines','Graphics',8),(37,2,'How do you change the color of a shape?','2','By changing the stroke line.','By selecting it and changing the fill.','By selecting it.','By changing it to none.',8),(38,3,'The graphics created in Adobe Illustrator are...?','1','Vector graphics','Bitmap images','Lines','Paths',8),(39,4,'How do you get a reference image or photo into Illustrator?','3','Drag and drop it in.','File>Save>Desktop.','File>Place','Embed it.',8),(40,5,'How do you get a photo reference image to stay in your Illustrator project?','2','File>Save','Embed it','Edit>Arrange','Object>Live Trace',8),(59,4,'What is floor plans?','2','A map of your house.','Diagram showing main structure elements.','A brochure of ideas.','A road map.',12),(58,3,'What is tactile texture?','4','It is how to look at something.','It is how we taste something.','It is how we hear something.','It is how it feels to the touch.',12),(60,5,'What is aesthetics?\r\n','4','Plants.','Foods.','Maps.','Refers to beauty of a product.',12),(57,2,'How do you become an interior designer?','2','Earn a degree in software engineering.','Build a presentable design portfolio.','Achieve straight As in your courses.','Be good at architectures.',12),(56,1,'What is interior design?','1','It is about how we experience spaces.','It is the physical architecture.','It is how home decoration.','It gives life to your home.',12),(41,1,'Witch intruction from this create an Loop?','2','If','While','Var','Else',9),(42,2,'This date 29 is data type?','3','Boolean','String','Integer','Float',9),(43,3,'What is the correct syntax for declaring a function?','3','var myFunction()','myFunction function()','function myFunction()','function my Function()',9),(44,4,'Which is the correct syntax for displaying data in the console?','1','console.log();','log.console();','console.log[];','console.log;',9),(45,5,'How can you get the total number of arguments passed to a function?','2','Using args.length property','Using arguments.length property','Both of the above.','None of the above.',9),(46,1,'Which of the following type of variables are named and indexed collections of other values?','2','Strings','Arrays','Objects','Recources',10),(47,2,'Which of the following is used to get information sent via get method in PHP?','1','$_GET','$GET','$GETREQUEST','None of the above.',10),(48,3,'Which of the following function is used to read the content of a file?','2','fopen()','fread()','filesize()','file_exist()',10),(49,4,'Which of the following method returns a formatted string representing a date?','3','time()','getdate()','date()','None of the above',10),(50,5,'Which of the following gives a string containing PHP script file name in which it is called?','1','$_PHP_SELF','$_PHP_SELF','$_COOKIE','$_SESSION',10),(51,1,'Which of the following is not the keyword in C++?','3','Volatile','Friend','Extends','This',11),(52,2,'Choose the invalid identifier from the below','2','Int','Bool','Double','_0_',11),(53,3,'Which of the following is the correct identifier?','2','$var_name','VAR_123','varname@','None of the above',11),(54,4,'Which of the following is the address operator?','3','@','#','&','%',11),(55,5,'The programming language that has the ability to create new data types is called___.','4','Overloaded','Encapsulated','Reprehensible','Extensible',11),(62,1,'1+2 =?','1','3','4','5','7',13);
/*!40000 ALTER TABLE `quiz_question` ENABLE KEYS */;
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

-- Dump completed on 2023-08-10 17:11:54
