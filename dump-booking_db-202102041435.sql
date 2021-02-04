-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: booking_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.38-MariaDB

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
-- Table structure for table `amenities`
--

DROP TABLE IF EXISTS `amenities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amenities` (
  `amenity_id` int(11) NOT NULL AUTO_INCREMENT,
  `amenity_desc` varchar(45) DEFAULT NULL,
  `amenity_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`amenity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `amenities`
--

LOCK TABLES `amenities` WRITE;
/*!40000 ALTER TABLE `amenities` DISABLE KEYS */;
INSERT INTO `amenities` VALUES (1,'โทรทัศน์',NULL),(2,'ตู้เย็น',NULL),(3,'ตู้เสื้อผ้า',NULL),(4,'ห้องน้ำ',NULL),(5,'แอร์',NULL),(6,'เตียงไฟฟ้า',NULL),(7,'เครื่องทำน้ำอุ่น',NULL),(8,'เตียง/โซฟา สำหรับญาติ',NULL),(9,'โต๊ะอาหาร',NULL),(10,'เก้าอี้',NULL),(11,'ถ้วย',NULL),(12,'จาน',NULL),(13,'ช้อน',NULL),(14,'ส้อม',NULL),(15,'ผ้าขนหนู',NULL),(16,'ผ้าห่ม',NULL),(17,'หมอน',NULL),(18,'เตาไมโครเวฟ',NULL),(19,'โทรศัพท์',NULL);
/*!40000 ALTER TABLE `amenities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking_rooms`
--

DROP TABLE IF EXISTS `booking_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_rooms` (
  `book_id` int(11) NOT NULL,
  `room_id` varchar(45) NOT NULL,
  `checkin_date` date DEFAULT NULL,
  `checkout_date` date DEFAULT NULL,
  `checkin_time` time DEFAULT NULL,
  `checkout_time` time DEFAULT NULL,
  PRIMARY KEY (`book_id`,`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_rooms`
--

LOCK TABLES `booking_rooms` WRITE;
/*!40000 ALTER TABLE `booking_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_date` date DEFAULT NULL,
  `an` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `remark` text,
  `ward_id` varchar(45) DEFAULT NULL,
  `user_id` varchar(45) DEFAULT NULL,
  `queue` int(11) DEFAULT NULL,
  `book_status` int(11) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buildings` (
  `building_id` int(11) NOT NULL AUTO_INCREMENT,
  `building_no` varchar(45) DEFAULT NULL,
  `building_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buildings`
--

LOCK TABLES `buildings` WRITE;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` VALUES (1,'1','อาคารผู้ป่วยนอก 5 ชั้น'),(2,'2','อาคารอำนวยการ'),(3,'3','อาคารผู้ป่วยใน 10 ชั้น'),(4,'4','อาคารอุบัติเหตุและฉุกเฉิน 6 ชั้น');
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_amenities`
--

DROP TABLE IF EXISTS `room_amenities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_amenities` (
  `room_id` int(11) NOT NULL,
  `amenity_id` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`room_id`,`amenity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_amenities`
--

LOCK TABLES `room_amenities` WRITE;
/*!40000 ALTER TABLE `room_amenities` DISABLE KEYS */;
/*!40000 ALTER TABLE `room_amenities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_groups`
--

DROP TABLE IF EXISTS `room_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_groups` (
  `room_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_group_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`room_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_groups`
--

LOCK TABLES `room_groups` WRITE;
/*!40000 ALTER TABLE `room_groups` DISABLE KEYS */;
INSERT INTO `room_groups` VALUES (1,'ห้องพิเศษ ชั้น 1'),(2,'ห้องพิเศษ ชั้น 2'),(3,'ห้องพิเศษ ชั้น 3');
/*!40000 ALTER TABLE `room_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_types`
--

DROP TABLE IF EXISTS `room_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_types` (
  `room_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_type_name` varchar(45) NOT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`room_type_id`,`room_type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_types`
--

LOCK TABLES `room_types` WRITE;
/*!40000 ALTER TABLE `room_types` DISABLE KEYS */;
INSERT INTO `room_types` VALUES (1,'Standard',1000),(2,'VIP',1600),(3,'Super VIP',2500);
/*!40000 ALTER TABLE `room_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(45) DEFAULT NULL,
  `room_type` int(11) DEFAULT NULL,
  `room_group` int(11) NOT NULL,
  `building_id` int(11) DEFAULT NULL,
  `floor` varchar(45) DEFAULT NULL,
  `room_img_url` varchar(45) DEFAULT NULL,
  `room_status` int(11) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'ห้องพิเศษ 101',1,1,3,'1',NULL,0,NULL,'2021-02-04 14:18:00',NULL,'2021-02-04 14:18:00'),(2,'ห้องพิเศษ 102',1,1,3,'1',NULL,0,NULL,'2021-02-04 14:18:00',NULL,'2021-02-04 14:18:00');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'booking_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-04 14:35:05
