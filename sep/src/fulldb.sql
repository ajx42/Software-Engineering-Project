-- MySQL dump 10.13  Distrib 5.5.50, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: LMS
-- ------------------------------------------------------
-- Server version	5.5.50-0ubuntu0.14.04.1

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
-- Table structure for table `Joining_Reports`
--

DROP TABLE IF EXISTS `Joining_Reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Joining_Reports` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(80) NOT NULL,
  `Nature` varchar(20) NOT NULL,
  `Period_From` date NOT NULL,
  `Period_To` date NOT NULL,
  `Report_From` varchar(20) NOT NULL,
  `Date` date NOT NULL,
  `application_id` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Joining_Reports`
--

LOCK TABLES `Joining_Reports` WRITE;
/*!40000 ALTER TABLE `Joining_Reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `Joining_Reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `username` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(500) NOT NULL,
  `type` int(11) NOT NULL,
  `department` varchar(200) NOT NULL,
  `notifications` int(2) NOT NULL DEFAULT '1',
  `approving_authority` varchar(50) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES ('admin@lps.iiti.ac.in','admin','admin',4,'Administration',0,'admin@iiti.ac.in'),('approver@lps.iiti.ac.in','approver','approver',3,'Mechanical Eng.',1,'approver@iiti.ac.in'),('recommender@lps.iiti.ac.in','recommender','recommender',2,'Computer Science & E',1,'approver@iiti.ac.in'),('user@lps.iiti.ac.in','testuser','testuser',1,'CSE',1,'approver@iiti.ac.in');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `add_news`
--

DROP TABLE IF EXISTS `add_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `add_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` varchar(500) NOT NULL,
  `news` varchar(500) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `add_news`
--

LOCK TABLES `add_news` WRITE;
/*!40000 ALTER TABLE `add_news` DISABLE KEYS */;
INSERT INTO `add_news` VALUES (9,'YO','hey dhruv','2017-04-30');
/*!40000 ALTER TABLE `add_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application` (
  `application_id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `nature` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `period_from` varchar(50) DEFAULT NULL,
  `period_to` varchar(50) DEFAULT NULL,
  `prefix_holidays` int(11) DEFAULT NULL,
  `sufix_holidays` int(11) DEFAULT NULL,
  `LTC` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `recommending_auth` varchar(50) NOT NULL,
  `approving_auth` varchar(50) NOT NULL,
  `cur_date` varchar(50) NOT NULL,
  `recommender_comments` text,
  `approver_comments` text,
  `joining_report` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

LOCK TABLES `application` WRITE;
/*!40000 ALTER TABLE `application` DISABLE KEYS */;
/*!40000 ALTER TABLE `application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `department` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES ('Computer Science & Eng,'),('Mechanical Eng.'),('Alpha Engineering'),('Beta Engineering');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forward_approving_auth`
--

DROP TABLE IF EXISTS `forward_approving_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forward_approving_auth` (
  `username` varchar(50) NOT NULL,
  `forwarded_to` varchar(50) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forward_approving_auth`
--

LOCK TABLES `forward_approving_auth` WRITE;
/*!40000 ALTER TABLE `forward_approving_auth` DISABLE KEYS */;
INSERT INTO `forward_approving_auth` VALUES ('approver@iiti.ac.in','approver@iiti.ac.in');
/*!40000 ALTER TABLE `forward_approving_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_balance`
--

DROP TABLE IF EXISTS `leave_balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_balance` (
  `username` varchar(50) NOT NULL,
  `CL` int(10) NOT NULL,
  `HPL` int(10) NOT NULL,
  `Vacation` int(10) NOT NULL,
  `EL` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_balance`
--

LOCK TABLES `leave_balance` WRITE;
/*!40000 ALTER TABLE `leave_balance` DISABLE KEYS */;
INSERT INTO `leave_balance` VALUES ('aditya1304jain@gmail.com',4,4,4,4),('adityajain.aj10@gmail.com',10,10,0,0),('approver@iiti.ac.in',0,0,0,0),('user@iiti.ac.in',-2,0,0,0);
/*!40000 ALTER TABLE `leave_balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userinfo`
--

DROP TABLE IF EXISTS `userinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userinfo` (
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userinfo`
--

LOCK TABLES `userinfo` WRITE;
/*!40000 ALTER TABLE `userinfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `userinfo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-30  3:56:20
