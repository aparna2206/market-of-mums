-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: nutrilicious
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

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
-- Table structure for table `bill_details`
--

DROP TABLE IF EXISTS `bill_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_details` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `paid_date` datetime DEFAULT NULL,
  `transaction_id` varchar(24) DEFAULT NULL,
  `status` enum('Pending','Paid','Cancel') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_details`
--

LOCK TABLES `bill_details` WRITE;
/*!40000 ALTER TABLE `bill_details` DISABLE KEYS */;
INSERT INTO `bill_details` VALUES (1,3,'2015-04-29 13:53:51',NULL,'Pending'),(2,4,'2015-04-29 13:54:35',NULL,'Pending'),(3,5,'2015-05-08 12:51:37',NULL,'Pending'),(4,6,'2015-05-10 17:02:16',NULL,'Paid'),(5,1,'2015-04-28 00:09:18',NULL,'Pending'),(6,2,'2015-04-28 00:09:18',NULL,'Pending'),(7,49,'2015-06-23 17:15:57',NULL,'Pending'),(8,50,'2015-06-24 17:15:41',NULL,'Pending'),(9,51,'2015-06-24 17:24:54',NULL,'Pending'),(10,52,'2015-06-24 17:26:41',NULL,'Pending'),(11,55,'2015-06-26 12:40:23',NULL,'Pending');
/*!40000 ALTER TABLE `bill_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) DEFAULT NULL,
  `description` text,
  `status` tinyint(4) DEFAULT '1',
  `is_visible` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Egg','Egg preparations',1,0),(2,'Milk','Milk preparations',1,1),(3,'Chicken','Chicken dishes ',1,1),(4,'Fish','Fish preparations',1,1),(5,'Sweet','The taste is biiter',1,1),(6,'Sweet','The taste is biiter',1,1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaint_types`
--

DROP TABLE IF EXISTS `complaint_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaint_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaint_types`
--

LOCK TABLES `complaint_types` WRITE;
/*!40000 ALTER TABLE `complaint_types` DISABLE KEYS */;
INSERT INTO `complaint_types` VALUES (2,'Bad quality of food',2),(3,'Bad service by delivery driver',3),(4,'Wrong food delivered',4),(5,'Wrong food delivered',5),(6,'Other',6);
/*!40000 ALTER TABLE `complaint_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `param` varchar(100) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uniq` (`param`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (15,'per_page','10'),(16,'pincodes','SN1,SN2,SN3,SN4,SN5,SN6,SN25,SN26,411051'),(17,'avail_days','1,4');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons_discount`
--

DROP TABLE IF EXISTS `coupons_discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons_discount` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `discount_amount` double DEFAULT NULL,
  `discount_per` double DEFAULT '0',
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons_discount`
--

LOCK TABLES `coupons_discount` WRITE;
/*!40000 ALTER TABLE `coupons_discount` DISABLE KEYS */;
INSERT INTO `coupons_discount` VALUES (1,'SNUTDISC20',13,2,'2015-06-23','2015-06-30'),(2,'SNUTDISC30',0,30,'0001-06-05','2015-06-30');
/*!40000 ALTER TABLE `coupons_discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_status`
--

DROP TABLE IF EXISTS `delivery_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_status`
--

LOCK TABLES `delivery_status` WRITE;
/*!40000 ALTER TABLE `delivery_status` DISABLE KEYS */;
INSERT INTO `delivery_status` VALUES (1,'pending'),(2,'dispatched'),(3,'delivered'),(4,'canceled');
/*!40000 ALTER TABLE `delivery_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dietary_requirements`
--

DROP TABLE IF EXISTS `dietary_requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dietary_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(512) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dietary_requirements`
--

LOCK TABLES `dietary_requirements` WRITE;
/*!40000 ALTER TABLE `dietary_requirements` DISABLE KEYS */;
INSERT INTO `dietary_requirements` VALUES (1,'gluten frees','gluten free'),(2,'nutfree','nutfree'),(3,'lactose free','lactose free');
/*!40000 ALTER TABLE `dietary_requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lunch_box`
--

DROP TABLE IF EXISTS `lunch_box`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lunch_box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `recipe` varchar(50) DEFAULT NULL,
  `cost` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lunch_box`
--

LOCK TABLES `lunch_box` WRITE;
/*!40000 ALTER TABLE `lunch_box` DISABLE KEYS */;
INSERT INTO `lunch_box` VALUES (1,'28-04-2015 LB Menu',NULL,'2015-05-08','5,10,15,16',5),(5,'29-04-2015 LB MENU',NULL,'2015-05-09','6,12,19,16',4),(6,'30-04-2015 LB MENU',NULL,'2015-05-10','6,12,13,18,4',1),(7,'01-05-2015 LB MENU',NULL,'2015-05-11','5,13,14',1),(8,'02-05-2015 LB Menu',NULL,'2015-05-12','5,3,14',1),(9,'03-05-2015 LB Menu',NULL,'2015-05-13','6,15,17',12),(10,'04-05-2015 LB Menu',NULL,'2015-05-14','6,15,4',12);
/*!40000 ALTER TABLE `lunch_box` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lunch_slots`
--

DROP TABLE IF EXISTS `lunch_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lunch_slots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lunch_slots`
--

LOCK TABLES `lunch_slots` WRITE;
/*!40000 ALTER TABLE `lunch_slots` DISABLE KEYS */;
INSERT INTO `lunch_slots` VALUES (1,'12:00-1:30'),(2,'2:00-2:30');
/*!40000 ALTER TABLE `lunch_slots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meal_packs`
--

DROP TABLE IF EXISTS `meal_packs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meal_packs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `recipe` varchar(50) DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meal_packs`
--

LOCK TABLES `meal_packs` WRITE;
/*!40000 ALTER TABLE `meal_packs` DISABLE KEYS */;
INSERT INTO `meal_packs` VALUES (1,'Weakly Meal','2015-05-08','5,10,15,19,16,17',18,NULL),(11,'fdsf','2015-05-09','5,6',18,NULL),(16,'Best of day','2015-05-10','5,15,14',18,NULL),(19,'Again the best','2015-05-11','5,6,16',30,NULL),(20,'01-05-2015 MB MENU','2015-05-12','6,11,13,18,19',18,NULL),(22,'02-05-2015 MB MENU','2015-05-13','6,15,18,16',20,NULL),(23,'03-05-2015 MB MENU','2015-05-14','10,18,3,14,17',18,NULL);
/*!40000 ALTER TABLE `meal_packs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `recipe_ids` varchar(250) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `is_visible` tinyint(2) DEFAULT '1',
  `booking_available_till` datetime DEFAULT NULL,
  `menu_type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (8,'First','2015-05-08','3,5,4',1,1,'2015-04-06 20:20:00',1),(9,'Second','2015-05-09','10',1,1,'2015-04-10 20:00:00',1),(11,'2015-04-28 todays Menu','2015-05-30','5,6,12,14,16,4',1,1,'2015-04-28 00:00:00',1),(12,'2015-04-29 Todays Menu','2015-06-01','6,12,15,19,3,16,4',1,1,'2015-04-29 00:00:00',1),(14,'2015-04-30 Todays Menu','2015-06-03','5,6,11,19,16,4',1,1,'2015-04-30 00:00:00',1),(17,'This is an test','2015-06-02','5,6,19,14,16',1,1,'2015-05-11 00:00:00',1),(18,'Special','2015-06-04','5,6,10,3,14,16',1,1,'2015-05-13 00:00:00',1),(19,'Special','2015-06-05','5,6,10,3,14,16',1,1,'2015-05-13 00:00:00',1),(20,'2015-05-01 Todays Menu','2015-06-06','6,10,13,19',1,1,'2015-05-01 00:00:00',1),(21,'2015-05-02 Todays Menu','2015-06-07','5,10,12,19,16',1,1,'2015-05-02 00:00:00',1),(22,'2015-05-03 Todays menu','2015-06-08','5,10,19,16',1,1,'2015-05-03 00:00:00',1),(23,'2015-05-04 Todays menu','2015-05-27','5,6,10,3,4',1,1,'2015-05-04 00:00:00',1),(24,'2015-05-05 Todays Menu','2015-06-21','12,13,15,3,14',1,1,'2015-05-05 00:00:00',1),(25,'2015-05-06 Todays Menu','2015-06-22','13,15,14,17',1,1,'2015-05-06 00:00:00',2),(26,'2015-05-07 Todays Menu','2015-06-29','18,19,3,10,13,16,4',1,1,'2015-05-07 00:00:00',1);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_types`
--

DROP TABLE IF EXISTS `menu_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_types` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_types`
--

LOCK TABLES `menu_types` WRITE;
/*!40000 ALTER TABLE `menu_types` DISABLE KEYS */;
INSERT INTO `menu_types` VALUES (1,'Lunch Box'),(2,'Munch Box');
/*!40000 ALTER TABLE `menu_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `munch_box`
--

DROP TABLE IF EXISTS `munch_box`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `munch_box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `recipe` varchar(50) DEFAULT NULL,
  `cost` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `munch_box`
--

LOCK TABLES `munch_box` WRITE;
/*!40000 ALTER TABLE `munch_box` DISABLE KEYS */;
INSERT INTO `munch_box` VALUES (1,'28-04-2015 MuB Menu',NULL,'2015-05-08','6,14',8),(3,'01-05-2015 MuB MENU',NULL,'2015-05-09','16,17',8),(4,'02-05-2015 MuB MENU',NULL,'2015-05-10','11,16,4',8),(5,'03-05-2015 MuB MENU',NULL,'2015-05-11','3,17',9),(6,'30-04-2015 MuB Menu',NULL,'2015-05-12','5,14',9),(8,'Title',1,'2015-05-13','3,17',5),(9,'Title',1,'2015-05-14','3,17',7),(10,'Title',1,'2015-05-15','3,17',6.5),(11,'Title',1,'2015-05-16','6,17',6.5),(12,'Title',1,'2015-05-17','6,17',6.5),(13,'Title',1,'2015-05-18','6,17',6),(14,'Title',1,'2015-05-19','6,17',8);
/*!40000 ALTER TABLE `munch_box` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_details` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `recipe_ids` varchar(150) NOT NULL,
  `total_amount` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `final_amount` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `delivery_status` tinyint(4) DEFAULT '1',
  `meal_qnt` int(11) DEFAULT NULL,
  `lunch_box_qnt` int(11) DEFAULT NULL,
  `munch_box_qnt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` VALUES (1,1,'2015-04-28 00:00:00','',NULL,NULL,NULL,1,1,1,1,NULL),(2,2,'2015-04-30 00:00:00','11,11',NULL,NULL,NULL,1,1,1,NULL,NULL),(3,3,'2015-04-30 00:00:00','5,4,11,6',NULL,NULL,NULL,1,1,1,NULL,NULL),(4,4,'2015-04-30 00:00:00','5',NULL,NULL,NULL,1,1,1,NULL,NULL),(5,5,'2015-05-11 00:00:00','4',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(6,6,'2015-05-09 00:00:00','',NULL,NULL,NULL,1,1,NULL,1,NULL),(7,6,'2015-05-14 00:00:00','4,6',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(8,7,'2015-05-26 00:00:00','16',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(9,8,'2015-05-26 00:00:00','',NULL,NULL,NULL,1,1,NULL,NULL,1),(10,10,'2015-05-26 00:00:00','',NULL,NULL,NULL,1,1,NULL,1,NULL),(11,12,'2015-05-26 00:00:00','10',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(12,13,'2015-05-26 00:00:00','16',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(13,14,'2015-05-26 00:00:00','5',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(14,16,'2015-05-26 00:00:00','16',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(15,17,'2015-05-26 00:00:00','10',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(16,18,'2015-05-27 00:00:00','10',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(17,20,'2015-05-27 00:00:00','3',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(18,21,'2015-05-27 00:00:00','3',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(19,25,'2015-05-27 00:00:00','6',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(20,26,'2015-05-27 00:00:00','3',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(21,41,'2015-05-27 00:00:00','6',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(22,44,'2015-05-27 00:00:00','6',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(23,47,'2015-05-27 00:00:00','10',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(24,48,'2015-05-27 00:00:00','10',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(25,49,'2015-06-24 00:00:00','3,3,3,3,3,3,3,3,3,3',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(26,50,'2015-06-25 00:00:00','3',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(27,51,'2015-06-25 00:00:00','3,4',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(28,52,'2015-06-25 00:00:00','18,3',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(29,53,'2015-06-26 00:00:00','10',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(30,54,'2015-06-26 00:00:00','18',NULL,NULL,NULL,1,1,NULL,NULL,NULL),(31,55,'2015-06-27 00:00:00','10',NULL,NULL,NULL,1,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `customer_email` varchar(50) DEFAULT NULL,
  `customer_contact` varchar(50) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `delivery_address` text,
  `delivery_city` varchar(150) DEFAULT NULL,
  `delivery_state` varchar(150) DEFAULT NULL,
  `delivery_pin_code` varchar(150) DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `final_amount` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `special_notes` varchar(250) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `coupons_discount` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,2,'jagdish patil','jagdish@gmail.com','9890165484','2015-04-28 00:09:18','deleivery address','d_pune','d_maharashtra','411051',210,30,180,0,'keep delivery at receiption','COD',0),(2,2,'jagdish patil','jagdish@gmail.com','9890165484','2015-04-28 13:16:43','deleivery address','d_pune','d_maharashtra','411051',110,1.6,108.4,0,'','COD',0),(3,9,'Vikram kerkar','vikram@gmail.com','8987878987','2015-04-29 13:53:51','test','test','test','411051',230,4.45,225.55,0,'','COD',0),(4,9,'Vikram kerkar','vikram@gmail.com','8987878987','2015-04-29 13:54:35','test','test','test','411051',55,0.5,54.5,0,'test','COD',0),(5,NULL,' rohit galage','rohit@gmail.com','9890165484','2015-05-08 12:51:37','flat A2, dangat patil nagar, vadgaon','pune','maharashtra','411051',15,0.75,14.25,0,'test','COD',0),(6,2,'jagdish patil','jagdish@gmail.com','9890165484','2015-05-08 13:17:01','deleivery address','d_pune','d_maharashtra','411051',19,0.75,18.25,0,'','COD',0),(7,NULL,' t','t@gmail.com','9890989898','2015-05-25 13:09:06','test','pune','maharashtra','411051',85,1.7,83.3,0,'test','CC',0),(8,NULL,' k','k@gmail.com','8787878787','2015-05-25 13:09:57','k','k','k','411051',0,0,0,0,'k','CC',0),(9,NULL,' k','k@gmail.com','8787878787','2015-05-25 13:11:36','k','k','k','411051',0,0,0,0,'k','CC',0),(10,NULL,' l','l@gmail.com','9898989898','2015-05-25 13:12:19','l','l','l','411051',0,0,0,0,'l','CC',0),(11,NULL,' l','l@gmail.com','9898989898','2015-05-25 13:12:43','l','l','l','411051',0,0,0,0,'l','CC',0),(12,NULL,' j','j@gmail.com','8787878787','2015-05-25 13:15:22','j','j','j','411051',60,1.5,58.5,0,'j','CC',0),(13,NULL,' s','s@gmail.com','8787878787','2015-05-25 13:21:22','s','s','s','411051',85,1.7,83.3,0,'s','CC',0),(14,NULL,' h','h@gmail.com','9898989898','2015-05-25 13:23:08','h','h','h','411051',25,0.5,24.5,0,'h','CC',0),(15,NULL,' h','h@gmail.com','9898989898','2015-05-25 13:23:41','h','h','h','411051',25,0.5,24.5,0,'h','CC',0),(16,NULL,' kh','kh@gmail.com','9898989898','2015-05-25 13:28:36','kh','kh','kh','411051',85,1.7,83.3,0,'kh','CC',0),(17,NULL,' mn','mn@gmail.com','mn','2015-05-25 13:29:54','mn','mn','mn','411051',60,1.5,58.5,0,'mn','CC',0),(18,NULL,' amar','amar@gmail.com','9898989898','2015-05-26 10:46:21','test','test','test','411051',60,1.5,58.5,0,'test','CC',0),(19,NULL,' amar','amar@gmail.com','9898989898','2015-05-26 10:47:38','test','test','test','411051',60,1.5,58.5,0,'test','CC',0),(20,NULL,' l','l@gmail.com','8787878787','2015-05-26 10:48:24','l','l','l','411051',300,60,240,0,'l','CC',0),(21,NULL,' min','min@gmail.com','7878787878','2015-05-26 11:05:42','jhjh','jhjh','jhjh','411051',300,60,240,0,'jhjh','CC',0),(22,NULL,' min','min@gmail.com','7878787878','2015-05-26 11:07:27','jhjh','jhjh','jhjh','411051',300,60,240,0,'jhjh','CC',0),(23,NULL,' min','min@gmail.com','7878787878','2015-05-26 11:07:54','jhjh','jhjh','jhjh','411051',300,60,240,0,'jhjh','CC',0),(24,NULL,' min','min@gmail.com','7878787878','2015-05-26 11:08:16','jhjh','jhjh','jhjh','411051',300,60,240,0,'jhjh','CC',0),(25,NULL,' nk','nk@gmail.com','8787878787','2015-05-26 11:19:45','nk','nk','nk','411051',120,2.4,117.6,0,'nk','CC',0),(26,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:24:38','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(27,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:25:25','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(28,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:26:08','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(29,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:27:00','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(30,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:27:35','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(31,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:27:40','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(32,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:31:44','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(33,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:31:48','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(34,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:33:02','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(35,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:33:07','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(36,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:37:50','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(37,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:37:55','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(38,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:41:54','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(39,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:42:23','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(40,NULL,' kj','kj@gmail.com','878787878','2015-05-26 13:43:55','kj','kj','kj','411051',300,60,240,0,'kj','CC',0),(41,NULL,' m','m@gmail.com','8787878787','2015-05-26 15:18:18','m','m','m','411051',120,2.4,117.6,0,'m','CC',0),(42,NULL,' m','m@gmail.com','8787878787','2015-05-26 15:20:34','m','m','m','411051',120,2.4,117.6,0,'m','CC',0),(43,NULL,' m','m@gmail.com','8787878787','2015-05-26 15:20:40','m','m','m','411051',120,2.4,117.6,0,'m','CC',0),(44,NULL,' i','i@g.com','h','2015-05-26 15:31:22','g','h','h','411051',120,2.4,117.6,0,'h','CC',0),(45,NULL,' i','i@g.com','h','2015-05-26 15:35:09','g','h','h','411051',120,2.4,117.6,0,'h','CC',0),(46,NULL,' i','i@g.com','h','2015-05-26 15:42:51','g','h','h','411051',120,2.4,117.6,0,'h','CC',0),(47,NULL,' k','k@g.com','8787878787','2015-05-26 15:45:05','k','k','k','411051',60,1.5,58.5,0,'k','CC',0),(48,NULL,' j','j@gmail.com','7878787878','2015-05-26 15:46:51','j','j','j','411051',60,1.5,58.5,0,'j','CC',0),(49,NULL,' Manish bhopale','manish@gmail.com','9898989898','2015-06-23 17:15:57','pune','pune','maharashtra','411051',3000,600,2400,0,'test','COD',0),(50,2,'jagdish patil','jagdish@gmail.com','9890165484','2015-06-24 17:15:41','deleivery address','d_pune','d_maharashtra','411051',30,0.6,29.4,0,'','COD',0),(51,2,'jagdish patil','jagdish@gmail.com','9890165484','2015-06-24 17:24:54','deleivery address','d_pune','d_maharashtra','411051',45,1.35,43.65,0,'','COD',0),(52,2,'jagdish patil','jagdish@gmail.com','9890165484','2015-06-24 17:26:41','deleivery address','d_pune','d_maharashtra','411051',170,7.6,162.4,0,'','COD',0),(53,NULL,' amar','amarpol1305@gmail.com','9890165484','2015-06-25 17:30:18','test','pune','maharashtra','SN1 2323',60,1.5,58.5,0,'','CC',0),(54,NULL,' amar','amarpol1305@gmail.com','9890165484','2015-06-25 17:39:59','test','pune','maharashtra','SN1 34',140,7,133,0,'test','CC',0),(55,2,'jagdish patil','jagdish@gmail.com','9890165484','2015-06-26 12:40:23','deleivery address','d_pune','d_maharashtra','SN1 2343',60,1.5,45.5,0,'test','COD',0);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'credit card','CC'),(2,'cash on delivery','COD');
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `description` text,
  `notes` text,
  `category_id` bigint(20) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `is_visible` tinyint(2) DEFAULT '1',
  `photo` varchar(250) DEFAULT NULL,
  `ingrediants` text,
  `nutritional_info` text,
  `allergens` text,
  `recipe_level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe`
--

LOCK TABLES `recipe` WRITE;
/*!40000 ALTER TABLE `recipe` DISABLE KEYS */;
INSERT INTO `recipe` VALUES (3,'Boild Egg','fds','fds',1,NULL,1,'3_food_bg2.jpg','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',1),(4,'Butter Milk','Butter Milk','Butter Milk',2,NULL,0,'4_food_bg5.jpg','fdsf','fsdf','fdsf',1),(5,'Creame & Egg','Creame & Egg','Creame & Egg',1,NULL,1,'5_food_bg5.jpg','sdaf','fsdf','fsdaf',1),(6,'Egg Mugalai','Egg Mugalai','Egg Mugalai',1,NULL,1,'6_lunch_box.jpg','Boiled Egg, Cucumber, Tomato, Coriender','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',1),(10,'Bread Salad','Bread, Cucumber, Tomato, onion','Bread, Cucumber, Tomato, onion',1,NULL,1,'10_food_bg1.jpg','Bread, Cucumber, Tomato, onion','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',1),(11,'Lava Cake','Butter, baking Power, coke powder, ','Butter, baking Power, coke powder',1,NULL,1,'11_food_bg7.jpg','1','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n',1),(12,'Roti & Salad','Wheat floor, onion, tomato, spinach, Red Chilli','Wheat floor, onion, tomato, spinach, Red Chilli',1,NULL,1,'12_munch_box.jpg','Wheat floor, onion, tomato, spinach, Red Chilli','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g',1),(13,'Lava Cake','Butter, baking Power, coke powder, ','Butter, baking Power, coke powder',1,0,NULL,'13_food_bg7.jpg','1','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n',1),(14,'Jam & butter','testt','test',2,0,NULL,'14_food_bg6.jpg','1','testt','test',1),(15,'Pudding','Rice, Spinach, Red chilli','Rice, Spinach, Red chilli',1,NULL,1,'15_meal_box.jpg','Rice, Spinach, Red chilli1','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n','Rice, Spinach, Red chilli',1),(16,'Cerenel','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since ','the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, ',2,NULL,0,'16_food_bg6.jpg','Moog Dal, Spinach, Coconut Date Balls, Almond','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n',1),(17,'Coconut Date Balls','Coconut, Date, Gum , Jaggary ,Almond Powder, White Peeper','Coconut, Date, Gum , Jaggary ,Almond Powder, White Peeper',2,NULL,0,'17_food_bg.jpg','Coconut, Date, Gum , Jaggary ,Almond Powder, White Peeper','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n',1),(18,'Red Chillli Pudding','Red Chilli, Rice','Red Chilli, Rice',1,0,NULL,'18_food_bg4.jpg','1','Red Chilli, Rice','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n',1),(19,'Red Chillli Pudding','Red Chilli, Rice','Red Chilli, Rice',1,NULL,1,'19_food_bg4.jpg','1','Red Chilli, Rice','Protein:9.6g;Carbohydrate:67.6g(of which sugars 6.6g);Fat:9.8g(of which sugars 3.4g);Fibre: 8.1g;Salt:0.25g;Sodium:0.0g\r\n',2);
/*!40000 ALTER TABLE `recipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_cost`
--

DROP TABLE IF EXISTS `recipe_cost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe_cost` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `recipe_id` bigint(20) NOT NULL,
  `base_price` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `total_qnt` int(11) DEFAULT NULL,
  `available_qnt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_cost`
--

LOCK TABLES `recipe_cost` WRITE;
/*!40000 ALTER TABLE `recipe_cost` DISABLE KEYS */;
INSERT INTO `recipe_cost` VALUES (2,4,15,0.75,'2015-02-01 00:00:00','2015-02-01 00:00:00',NULL,5),(3,5,25,0.5,'2015-02-01 00:00:00','2015-06-01 00:00:00',NULL,5),(4,6,120,2.4,'2015-02-01 00:00:00','2015-02-01 00:00:00',NULL,5),(5,3,30,0.6,'2015-07-01 00:00:00','2015-09-01 00:00:00',NULL,5),(6,3,56,2.8,'2015-04-28 00:00:00','2015-07-30 00:00:00',NULL,4),(7,4,20,0.4,'2015-04-28 00:00:00','2015-07-30 00:00:00',NULL,3),(10,5,85,4.25,'2015-04-28 00:00:00','2015-07-30 00:00:00',NULL,5),(12,6,120,6,'2015-04-28 00:00:00','2015-06-30 00:00:00',NULL,5),(14,10,60,1.5,'2015-04-28 00:00:00','2015-07-03 00:00:00',NULL,3),(15,11,40,0.8,'2015-04-28 00:00:00','2015-04-30 00:00:00',NULL,5),(16,12,130,6.5,'2015-04-28 00:00:00','2015-07-30 00:00:00',NULL,5),(17,14,78,1.56,'2015-04-28 00:00:00','2015-07-30 00:00:00',NULL,5),(18,15,160,8,'2015-04-28 00:00:00','2015-07-30 00:00:00',NULL,5),(19,16,85,1.7,'2015-04-28 00:00:00','2015-07-30 00:00:00',NULL,5),(20,17,68,1.36,'2015-04-28 00:00:00','2015-07-30 00:00:00',NULL,5),(21,18,140,7,'2015-04-28 00:00:00','2015-07-30 00:00:00',NULL,3),(22,18,1,0.2,'2015-06-23 00:00:00','2015-06-30 00:00:00',12,3);
/*!40000 ALTER TABLE `recipe_cost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_level`
--

DROP TABLE IF EXISTS `recipe_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_level`
--

LOCK TABLES `recipe_level` WRITE;
/*!40000 ALTER TABLE `recipe_level` DISABLE KEYS */;
INSERT INTO `recipe_level` VALUES (1,'Our home-made specials'),(2,'Our good food collection'),(3,'Our body & mind range');
/*!40000 ALTER TABLE `recipe_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_ratings`
--

DROP TABLE IF EXISTS `recipe_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `ratings` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_ratings`
--

LOCK TABLES `recipe_ratings` WRITE;
/*!40000 ALTER TABLE `recipe_ratings` DISABLE KEYS */;
INSERT INTO `recipe_ratings` VALUES (1,6,NULL,6),(5,6,2,6),(6,10,NULL,14),(7,16,NULL,9),(8,12,NULL,14),(9,3,NULL,10),(10,14,NULL,14);
/*!40000 ALTER TABLE `recipe_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `special_diet`
--

DROP TABLE IF EXISTS `special_diet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `special_diet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(512) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `special_diet`
--

LOCK TABLES `special_diet` WRITE;
/*!40000 ALTER TABLE `special_diet` DISABLE KEYS */;
INSERT INTO `special_diet` VALUES (1,'low carb diet','low carb diet'),(2,'alkaline diet','alkaline diet');
/*!40000 ALTER TABLE `special_diet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_master`
--

DROP TABLE IF EXISTS `status_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_master`
--

LOCK TABLES `status_master` WRITE;
/*!40000 ALTER TABLE `status_master` DISABLE KEYS */;
INSERT INTO `status_master` VALUES (1,'Active'),(2,'Disabled'),(3,'Deleted');
/*!40000 ALTER TABLE `status_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_complaint`
--

DROP TABLE IF EXISTS `user_complaint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_complaint` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `ordered_date` date NOT NULL,
  `compliant_for` int(11) DEFAULT NULL,
  `description` text,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_complaint`
--

LOCK TABLES `user_complaint` WRITE;
/*!40000 ALTER TABLE `user_complaint` DISABLE KEYS */;
INSERT INTO `user_complaint` VALUES (1,2,'2015-04-20',5,NULL,2);
/*!40000 ALTER TABLE `user_complaint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_feedback`
--

DROP TABLE IF EXISTS `user_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_feedback` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `recipe` bigint(20) NOT NULL,
  `date` date DEFAULT NULL,
  `food_quality` varchar(50) DEFAULT NULL,
  `delivery_quality` varchar(50) DEFAULT NULL,
  `food_improve_tips` varchar(512) DEFAULT NULL,
  `service_improve_tips` varchar(512) DEFAULT NULL,
  `repeat_on_menu` tinyint(4) DEFAULT NULL,
  `oth_comment` varchar(512) DEFAULT NULL,
  `recomend_friend` varchar(50) DEFAULT NULL,
  `food_test` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_feedback`
--

LOCK TABLES `user_feedback` WRITE;
/*!40000 ALTER TABLE `user_feedback` DISABLE KEYS */;
INSERT INTO `user_feedback` VALUES (1,2,3,'2015-04-20','excellent','excellent','trest','qdsfsd',1,'gfdsf',NULL,NULL,2),(2,2,4,'2015-04-20','good','good','test',NULL,NULL,NULL,'may be','excellent',NULL);
/*!40000 ALTER TABLE `user_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
INSERT INTO `user_types` VALUES (1,'Normal'),(2,'Admin');
/*!40000 ALTER TABLE `user_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `correspondence_address` text,
  `city` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `pin_code` varchar(16) DEFAULT NULL,
  `delivery_address` text,
  `delivery_city` varchar(150) DEFAULT NULL,
  `delivery_state` varchar(150) DEFAULT NULL,
  `delivery_pin_code` varchar(16) NOT NULL,
  `user_type` int(11) NOT NULL,
  `balance` double DEFAULT '0',
  `other_contact_no` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_date` datetime DEFAULT NULL,
  `created_by` bigint(11) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `prefered_payment_method` int(11) DEFAULT NULL,
  `special_dietary_requirements` varchar(256) DEFAULT NULL,
  `special_diet` varchar(256) DEFAULT NULL,
  `lunch_slot` int(11) DEFAULT NULL,
  `office_name` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Amar','Pol','amarpol1305@gmail.com','d01b8c6ea1a64ba2510df7cee1e4d604','9890165484',NULL,NULL,NULL,NULL,'lkl','d_pune','d_maharashtra','878787',2,0,NULL,2,'2015-04-01 16:56:07',NULL,'2013-05-19',1,'1,2',NULL,1,NULL),(2,'jagdish','patil','jagdish@gmail.com','3bd26b3ffb700a7c00f75c8752d9c492','9890165484','test','pune','maharashtra','411051','deleivery address','d_pune','d_maharashtra','878787',2,0,'8149123320',1,'2015-04-02 17:22:38',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'testing','testing','t@gmail.com','e358efa489f58062f10dd7316b65649e','9898','t','t','t','989','t','t','t','9898',1,0,'9898',1,'2015-04-11 11:30:09',NULL,'0000-00-00',1,'2','1',1,'ticona'),(4,'illa','meges','a@tewt.com','865c0c0b4ab0e063e5caa3387c1a8741','989','tes','test','test','test','tes','sdf','fdsf','sdsa',1,0,'90',1,'2015-04-11 16:49:00',NULL,'2012-09-09',1,'1,2','1,2',1,'test'),(9,'Vikram','kerkar','vikram@gmail.com','4f03a3d7d3dffa764d27606ff3773311','8987878987','test','test','test','34334','test','test','test','212121',1,0,'',1,'2015-04-15 17:57:44',NULL,'0000-00-00',1,'1',NULL,1,'Aimsoft'),(10,'ROHIT','GALAGE','ROHITGALAGE@GMAIL.COM','2d235ace000a3ad85f590e321c89bb99','9766560476','A WING VENUKUNJ,DANGAT PATIL NAGAR, NEAR VADGAON BRIDGE,','PUNE','MAHARASHTRA','411041','A WING VENUKUNJ,DANGAT PATIL NAGAR, NEAR VADGAON BRIDGE,','PUNE','MAHARASHTRA','411041',2,0,'9096194657',1,'2015-04-28 12:01:51',NULL,'0000-00-00',1,'3',NULL,1,'FOURBYTE EMBEDDED SOLUTION');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-26 12:42:21
