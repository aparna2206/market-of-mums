-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: uk2me
-- ------------------------------------------------------
-- Server version	5.5.43-0ubuntu0.14.04.1

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `desc` varchar(500) DEFAULT NULL,
  `short_desc` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category` (`category`,`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Men',0,1,NULL,NULL,'Men','Men'),(2,'Women',0,2,NULL,NULL,'Women','Women'),(4,'Shoes',1,0,'4_shoe.jpg',NULL,'Shoes','Shoes'),(5,'Jewellery',2,0,'5_jwell.jpg',NULL,'Jewellery','Jewellery'),(6,NULL,NULL,0,'',NULL,'sweyw5ry',NULL),(7,NULL,NULL,0,'',NULL,'sew',NULL),(8,NULL,NULL,0,'',NULL,'srtyrsty',NULL),(9,'Lingerie',2,0,'9_ling.jpg',NULL,'Lingerie','Lingerie');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'document_root','/var/www/electricsourcing/public_html');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons_discount`
--

LOCK TABLES `coupons_discount` WRITE;
/*!40000 ALTER TABLE `coupons_discount` DISABLE KEYS */;
INSERT INTO `coupons_discount` VALUES (1,'DISC20SSS',0,20,'2015-08-05','2015-08-28');
/*!40000 ALTER TABLE `coupons_discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `website_name` varchar(150) DEFAULT NULL,
  `product_name` varchar(150) DEFAULT NULL,
  `product_code` varchar(150) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `size` double DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `status` enum('Pending','Processed') DEFAULT NULL,
  `payment_status` enum('Pending','Paid','Refunded') DEFAULT NULL,
  `delivery_status` enum('Pending','in_process','delivered','returned') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
INSERT INTO `shops` VALUES (1,'aregesy','srtydrtyh','1_famous_quotes_wallpapers_2.jpg','srtyrsty'),(2,'adidas','https://shop.adidas.co.in/?cm_mmc=adwords-_-brand-_-adidas-_-_et-adidas&gclid=Cj0KEQjwx_WuBRDJ7tSK2-W0pJkBEiQAEWgR8HXZVi5byxDhxTA462EYwaBl14sMaauUkR1q',' favicon.png','products like shoes clothes'),(5,'srtyrety','srtyrty','','srtyrty'),(6,'fsdf','fdsfs',' favicon.png','fdsf'),(7,'fdsf','fdsaf','famous_quotes_wallpapers_2.jpg','fdsfa'),(8,'fdsfa','fdsfa',NULL,'fdsfa'),(9,'fdsfa','fdsfa',NULL,'fdsfa'),(10,'fdsfa','fdsfa',NULL,'fdsfa'),(11,'fdsfa','fdsfa',NULL,'fdsfa'),(12,'fsdfa','fdsa',NULL,'fdsaf'),(13,'fdsfa','fdsaf',NULL,'fdsaf'),(14,'fdsfs','fsdfdsf','14_Significon-Tag-20.png','fdsf');
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
INSERT INTO `user_types` VALUES (1,'Admin');
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
  `name_title` varchar(8) DEFAULT NULL,
  `first_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `address_1` text,
  `city` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `pin_code` varchar(16) DEFAULT NULL,
  `delivery_address` text,
  `delivery_city` varchar(150) DEFAULT NULL,
  `delivery_state` varchar(150) DEFAULT NULL,
  `delivery_country` varchar(150) DEFAULT NULL,
  `delivery_pin_code` varchar(16) NOT NULL,
  `user_type` int(11) NOT NULL,
  `delivery_contact` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mr.','Amar ','Pol ','amarpol1305@gmail.com','36341cbb9c5a51ba81e855523de49dfd','+91902112245755','test','pune','maharashtra','india','411051','test','pune','maharashtra','india','411051',1,'+919021122457',1,'2015-08-19 17:58:27'),(2,'Mr.','arge','saret','klrhewig@KJAER.COM','','514564646464','efsrtetert','awert','aert','aert',NULL,NULL,NULL,NULL,NULL,'',0,NULL,1,'2015-08-31 14:47:24'),(3,'Mr.','arge','saret','sert@gmail.com','','5656464646446','zdrtsretysrty','awert','aert','aert',NULL,NULL,NULL,NULL,NULL,'',0,NULL,1,'2015-08-31 14:57:07'),(24,'Mrs.','sheena','bora','sheenabora@gmail.com','e10adc3949ba59abbe56e057f20f883e','1234567895','aertyete','srtest','sertsret','restesrt',NULL,NULL,NULL,NULL,NULL,'',0,NULL,1,'2015-08-31 16:25:31'),(27,'Mr.','sourah','kale','kalesourabh01@gmail.com','e10adc3949ba59abbe56e057f20f883e','9405859350','gedfh','tasgaon','maharashtra','Nigeria',NULL,'gedfh','tasgaon','maharashtra','Nigeria','',0,'9405859350',1,'2015-08-31 19:49:23');
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

-- Dump completed on 2015-08-31 21:23:21
