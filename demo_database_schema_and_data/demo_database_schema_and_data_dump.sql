-- MySQL dump 10.16  Distrib 10.2.31-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: rowland1_strategy_insights_demo_dev
-- ------------------------------------------------------
-- Server version	10.2.31-MariaDB-cll-lve

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
-- Table structure for table `ci_stakeholder_comments`
--

DROP TABLE IF EXISTS `ci_stakeholder_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_stakeholder_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stakeholder_id` int(11) NOT NULL,
  `date_of_comment` date NOT NULL,
  `comment_citation_type` varchar(200) NOT NULL,
  `comment_citation` varchar(300) NOT NULL,
  `comment_citation_url` varchar(300) NOT NULL,
  `raw_comment` text NOT NULL,
  `generic_comment` varchar(300) NOT NULL,
  `category` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_stakeholder_comments`
--

LOCK TABLES `ci_stakeholder_comments` WRITE;
/*!40000 ALTER TABLE `ci_stakeholder_comments` DISABLE KEYS */;
INSERT INTO `ci_stakeholder_comments` VALUES (1,1,'0000-00-00','Publication','Polymerase II in transcription','google.com','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non arcu ac mauris consequat bibendum et vel ante. Donec quis congue sapien. Vestibulum fermentum lorem quis venenatis imperdiet. Praesent ullamcorper porttitor laoreet. Vivamus venenatis metus eget purus blandit vulputate. Suspendisse commodo leo eget lorem euismod feugiat vitae a nisl. Maecenas non maximus quam.','There is a need for bigger compute','Infrastructure'),(2,1,'0000-00-00','Publication','Polymerase II in transcription','https://tinker.edu.au/call-for-a-national-digital-hass-research-framework/','Nam eu magna at sem varius lacinia. Cras eu diam ante. Proin at venenatis est. Vestibulum nibh mauris, auctor sit amet auctor nec, vulputate vitae ex. Duis eleifend purus eget eros vulputate, sed tempus tellus aliquet. Maecenas ut nisl sed tellus blandit congue ac faucibus nisi. Donec euismod sem nulla, quis maximus enim feugiat mollis.','Data that is accurate, up to date and clean is important','Data as Infrastructure'),(3,2,'0000-00-00','Correspondence','sadfasdfasdf','https://tinker.edu.au/call-for-a-national-digital-hass-research-framework/','Vivamus vel lorem pulvinar, ultricies tortor sed, finibus mi. Nulla aliquam nisl quis sem scelerisque, non porta nisl volutpat. Donec congue faucibus mi vel dictum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce quis consectetur nunc, sed vulputate lorem. Aliquam non lacinia arcu.','Women in IT is important','Workforce'),(4,3,'0000-00-00','Correspondence','Email','','\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nam finibus tempor condimentum. Mauris lobortis mi id congue lobortis. Nam aliquam purus metus, eu sodales ante blandit vel. Nunc tempor condimentum metus, id dignissim nunc lacinia vitae. In hac habitasse platea dictumst. Cras fringilla viverra sodales. Donec ac dolor dapibus, fringilla ante a, tristique nisl. Suspendisse eu urna quis ipsum finibus lobortis quis sed est. Vivamus ac mi id ante accumsan iaculis sed at ipsum. Duis dolor erat, pharetra ac ullamcorper ac, dapibus a eros. In quis quam non urna dapibus vestibulum. Duis ut efficitur sem. Etiam odio felis, convallis ac leo nec, feugiat fringilla justo.\r\n\r\nNunc sollicitudin consectetur aliquet. In mi purus, cursus at auctor quis, feugiat ut dolor. Duis maximus laoreet urna, vel egestas purus finibus a. Mauris non venenatis dui. Nunc eu imperdiet nisi. Morbi erat nunc, iaculis et volutpat et, posuere ac mauris. Nullam pulvinar ex lorem, et pulvinar est sagittis quis. Fusce ac nibh quis erat mattis hendrerit at et velit. Duis interdum cursus nunc, at placerat massa pulvinar non. Vestibulum eget ante sed nunc vulputate tincidunt.','Research Software Engineers are needed to exploit the infrastructure for the researchers','Workforce');
/*!40000 ALTER TABLE `ci_stakeholder_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_stakeholders`
--

DROP TABLE IF EXISTS `ci_stakeholders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_stakeholders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `honorific` varchar(50) NOT NULL,
  `first_name` varchar(300) NOT NULL,
  `second_name` varchar(300) NOT NULL,
  `organisation` varchar(300) NOT NULL,
  `role` varchar(300) NOT NULL,
  `country` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `experience_summary` text NOT NULL,
  `personal_url` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_stakeholders`
--

LOCK TABLES `ci_stakeholders` WRITE;
/*!40000 ALTER TABLE `ci_stakeholders` DISABLE KEYS */;
INSERT INTO `ci_stakeholders` VALUES (1,'Mr','Arnold','Rimmer','JMC Red Dwarf','First Technician','Australia','','',''),(2,'Professor','Marion','Mamet','Diva Droid International','','Indonesia','','',''),(3,'A/Prof','Michael','D\'Angelo','','','Malaysia','','','');
/*!40000 ALTER TABLE `ci_stakeholders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-04 13:47:20
