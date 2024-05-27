-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: sadsad
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dance_categories`
--

DROP TABLE IF EXISTS `dance_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dance_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y = Yes\nN = No\nD = Deleted',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dance_categories`
--

LOCK TABLES `dance_categories` WRITE;
/*!40000 ALTER TABLE `dance_categories` DISABLE KEYS */;
INSERT INTO `dance_categories` VALUES (1,'Curacha','Y',1,'2024-04-17 16:13:03',1,'2024-04-17 08:13:03'),(2,'Special Dance','Y',1,'2024-04-17 16:13:03',1,'2024-04-17 08:13:03');
/*!40000 ALTER TABLE `dance_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrance_details`
--

DROP TABLE IF EXISTS `entrance_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entrance_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entrance_id` int DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y = Yes,\nV = Void',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrance_details`
--

LOCK TABLES `entrance_details` WRITE;
/*!40000 ALTER TABLE `entrance_details` DISABLE KEYS */;
INSERT INTO `entrance_details` VALUES (1,1,'male',1,50,'Y',1,'2024-04-16 21:42:45',1,'2024-04-16 13:42:45'),(2,1,'female',2,30,'Y',1,'2024-04-16 21:42:47',1,'2024-04-16 13:42:47'),(3,1,'kids',0,15,'Y',1,'2024-04-16 21:42:47',1,'2024-04-16 13:42:47'),(4,1,'table-charge',1,50,'Y',1,'2024-04-16 21:42:47',1,'2024-04-16 13:42:47'),(5,2,'male',4,50,'Y',1,'2024-04-16 21:48:08',1,'2024-04-16 13:48:08'),(6,2,'female',2,30,'Y',1,'2024-04-16 21:48:08',1,'2024-04-16 13:48:08'),(7,2,'kids',0,15,'Y',1,'2024-04-16 21:48:08',1,'2024-04-16 13:48:08'),(8,2,'table-charge',1,50,'Y',1,'2024-04-16 21:48:08',1,'2024-04-16 13:48:08'),(9,3,'male',2,50,'Y',1,'2024-04-16 21:49:40',1,'2024-04-16 13:49:40'),(10,3,'female',2,30,'Y',1,'2024-04-16 21:49:40',1,'2024-04-16 13:49:40'),(11,3,'kids',1,15,'Y',1,'2024-04-16 21:49:40',1,'2024-04-16 13:49:40'),(12,3,'table-charge',1,50,'Y',1,'2024-04-16 21:49:40',1,'2024-04-16 13:49:40'),(13,4,'male',2,50,'Y',1,'2024-04-17 20:14:52',1,'2024-04-17 12:14:52'),(14,4,'female',1,30,'Y',1,'2024-04-17 20:14:52',1,'2024-04-17 12:14:52'),(15,4,'kids',1,15,'Y',1,'2024-04-17 20:14:52',1,'2024-04-17 12:14:52'),(16,4,'table-charge',1,50,'Y',1,'2024-04-17 20:14:52',1,'2024-04-17 12:14:52'),(17,5,'male',2,50,'Y',1,'2024-04-17 20:19:58',1,'2024-04-17 12:19:58'),(18,5,'female',1,30,'Y',1,'2024-04-17 20:19:58',1,'2024-04-17 12:19:58'),(19,5,'kids',0,15,'Y',1,'2024-04-17 20:19:58',1,'2024-04-17 12:19:58'),(20,5,'table-charge',1,50,'Y',1,'2024-04-17 20:19:58',1,'2024-04-17 12:19:58'),(21,6,'male',4,50,'Y',1,'2024-04-26 16:54:31',1,'2024-04-26 08:54:31'),(22,6,'female',2,30,'Y',1,'2024-04-26 16:54:32',1,'2024-04-26 08:54:32'),(23,6,'kids',1,15,'Y',1,'2024-04-26 16:54:32',1,'2024-04-26 08:54:32'),(24,6,'table-charge',1,150,'Y',1,'2024-04-26 16:54:32',1,'2024-04-26 08:54:32');
/*!40000 ALTER TABLE `entrance_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrance_prices`
--

DROP TABLE IF EXISTS `entrance_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entrance_prices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int DEFAULT NULL,
  `male` double(8,2) NOT NULL DEFAULT '0.00',
  `female` double(8,2) NOT NULL DEFAULT '0.00',
  `kids` double(8,2) NOT NULL DEFAULT '0.00',
  `table_charge` double(8,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'Y',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrance_prices`
--

LOCK TABLES `entrance_prices` WRITE;
/*!40000 ALTER TABLE `entrance_prices` DISABLE KEYS */;
INSERT INTO `entrance_prices` VALUES (1,2,50.00,30.00,15.00,150.00,'Y',1,'2024-04-16 16:55:27',1,'2024-04-16 09:03:54');
/*!40000 ALTER TABLE `entrance_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrances`
--

DROP TABLE IF EXISTS `entrances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entrances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int DEFAULT NULL,
  `transaction_no` varchar(15) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `status` char(1) DEFAULT 'Y' COMMENT 'Y = Yes\\\\nN = No\\\\nD = Deleted',
  `total` double(8,2) NOT NULL DEFAULT '0.00',
  `cash` double(8,2) NOT NULL DEFAULT '0.00',
  `amount_change` double(8,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `entrance_no_idx` (`transaction_no`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrances`
--

LOCK TABLES `entrances` WRITE;
/*!40000 ALTER TABLE `entrances` DISABLE KEYS */;
INSERT INTO `entrances` VALUES (1,2,'24-E-00001','Customer','Y',160.00,200.00,40.00,NULL,1,'2024-04-16 21:42:45',1,'2024-04-16 13:42:45'),(2,2,'24-E-00002','Customer','Y',310.00,500.00,190.00,NULL,1,'2024-04-16 21:48:08',1,'2024-04-16 13:48:08'),(3,2,'24-E-00003','Tanod Group','Y',225.00,500.00,275.00,NULL,1,'2024-04-16 21:49:40',1,'2024-04-16 13:49:40'),(4,2,'24-E-00004','Customer','Y',195.00,200.00,5.00,NULL,1,'2024-04-17 20:14:51',1,'2024-04-17 12:14:51'),(5,2,'24-E-00005','Customer','Y',180.00,200.00,20.00,NULL,1,'2024-04-17 20:19:57',1,'2024-04-18 04:11:27'),(6,2,'24-E-00006','Juan','Y',425.00,1000.00,575.00,NULL,1,'2024-04-26 16:54:31',1,'2024-04-26 08:54:31');
/*!40000 ALTER TABLE `entrances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `status` char(1) DEFAULT 'Y' COMMENT 'Y = Yes\\\\nN = No\\\\nD = Deleted',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Tanod Pa DISCO','2024-04-06 19:00:00','2024-04-07 03:00:00','N',1,'2024-04-06 08:47:33',1,'2024-04-16 03:34:59'),(2,'Barangay Day','2024-04-16 17:00:00','2024-05-28 17:00:00','Y',1,'2024-04-16 11:03:03',1,'2024-05-27 06:26:14');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events1`
--

DROP TABLE IF EXISTS `events1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events1` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `date` date NOT NULL,
  `status` char(1) DEFAULT 'Y' COMMENT 'Y = Yes\\\\nN = No\\\\nD = Deleted',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events1`
--

LOCK TABLES `events1` WRITE;
/*!40000 ALTER TABLE `events1` DISABLE KEYS */;
/*!40000 ALTER TABLE `events1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(45) DEFAULT NULL,
  `sort` int NOT NULL DEFAULT '0',
  `active_keyword` varchar(45) DEFAULT NULL,
  `is_active` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y = Yes\nN = No',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Home','/','bi bi-grid',1,'home','Y',1,'2023-12-01 12:15:47',1,'2024-04-05 04:01:38'),(2,'Settings','#','bi bi-menu-button-wide with-sub-menu',10,'settings','Y',1,'2023-12-01 12:15:47',1,'2024-04-18 08:22:15'),(3,'POS','/views/pos.php','bi bi-credit-card',2,'post','Y',1,'2024-04-06 11:25:53',1,'2024-04-06 03:28:52'),(4,'Gate Entrance','/views/entrance.php','bi bi-door-open',3,'entrance','Y',1,'2024-04-06 11:25:53',1,'2024-04-18 08:24:08'),(5,'Requested Dance/Curacha','/views/requested-dance.php','ri ri-body-scan-line',4,'Requested Dance','Y',1,'2024-04-06 11:25:53',1,'2024-04-17 08:23:00'),(6,'Reports','#','bi bi-card-heading',5,'reports','Y',1,'2024-04-18 16:39:10',1,'2024-04-18 08:39:10');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prices`
--

DROP TABLE IF EXISTS `prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `product_id` int NOT NULL,
  `unit_id` int NOT NULL,
  `original_price` double(8,2) NOT NULL DEFAULT '0.00',
  `selling_price` double(8,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'Y',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `price_uq` (`event_id`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prices`
--

LOCK TABLES `prices` WRITE;
/*!40000 ALTER TABLE `prices` DISABLE KEYS */;
INSERT INTO `prices` VALUES (1,1,1,1,38.00,50.00,'Y',1,'2024-04-06 19:16:25',1,'2024-04-06 11:16:25'),(2,1,2,1,104.00,150.00,'Y',1,'2024-04-06 19:16:50',1,'2024-04-06 11:16:50'),(3,1,3,1,104.00,150.00,'Y',1,'2024-04-06 19:17:10',1,'2024-04-06 11:17:10'),(4,1,4,1,38.00,50.00,'Y',1,'2024-04-06 19:17:37',1,'2024-04-06 11:17:37'),(5,1,5,1,121.00,160.00,'Y',1,'2024-04-06 19:18:01',1,'2024-04-06 11:18:01'),(6,1,6,1,19.00,25.00,'Y',1,'2024-04-06 19:18:26',1,'2024-04-06 11:18:26'),(7,1,7,2,1.68,2.00,'Y',1,'2024-04-06 19:19:22',1,'2024-04-06 11:19:22'),(8,1,8,2,9.00,15.00,'Y',1,'2024-04-06 19:19:46',1,'2024-04-06 11:19:46'),(9,1,9,2,1.90,2.50,'Y',1,'2024-04-06 19:20:23',1,'2024-04-06 11:20:23'),(10,1,10,2,1.90,2.50,'Y',1,'2024-04-06 19:21:00',1,'2024-04-06 11:21:00'),(11,1,11,2,1.11,2.00,'Y',1,'2024-04-06 19:21:20',1,'2024-04-06 11:21:20'),(12,1,12,2,6.00,8.00,'Y',1,'2024-04-06 19:21:46',1,'2024-04-06 11:21:46'),(13,1,13,2,6.00,8.00,'Y',1,'2024-04-06 19:22:09',1,'2024-04-06 11:22:09'),(14,1,14,2,28.00,35.00,'Y',1,'2024-04-06 19:22:37',1,'2024-04-06 11:22:37'),(15,1,15,2,28.00,35.00,'Y',1,'2024-04-06 19:22:59',1,'2024-04-06 11:22:59'),(16,1,16,2,16.00,20.00,'Y',1,'2024-04-06 19:23:18',1,'2024-04-06 11:23:18'),(17,1,17,3,120.00,140.00,'Y',1,'2024-04-06 19:24:39',1,'2024-04-06 11:24:39'),(18,1,18,3,120.00,140.00,'Y',1,'2024-04-06 19:24:59',1,'2024-04-06 11:24:59'),(19,2,2,1,115.00,150.00,'Y',1,'2024-04-16 19:47:34',1,'2024-04-16 11:47:34'),(20,2,1,1,38.00,50.00,'Y',1,'2024-04-17 10:30:35',1,'2024-04-17 02:30:35');
/*!40000 ALTER TABLE `prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'Y',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Pilsen (Gagmay)','','Y',1,'2024-04-06 06:57:30',1,'2024-04-06 11:01:18'),(2,'Redhorse Litro','','Y',1,'2024-04-06 07:38:46',1,'2024-04-06 11:01:33'),(3,'Grande (Beer)','','Y',1,'2024-04-06 07:39:06',1,'2024-04-06 11:01:55'),(4,'San Mig Apple','','Y',1,'2024-04-06 07:39:20',1,'2024-04-06 11:02:07'),(5,'Tanduay Light','','Y',1,'2024-04-06 10:28:13',1,'2024-04-06 11:02:23'),(6,'Mismo','','Y',1,'2024-04-06 10:29:16',1,'2024-04-06 11:02:42'),(7,'Maxx (Candy)','','Y',1,'2024-04-06 19:02:55',1,'2024-04-06 11:02:55'),(8,'Assorted Oishi','','Y',1,'2024-04-06 19:03:08',1,'2024-04-06 11:03:08'),(9,'Happy Peanut','','Y',1,'2024-04-06 19:03:20',1,'2024-04-06 11:03:20'),(10,'Dragon Sid','','Y',1,'2024-04-06 19:03:33',1,'2024-04-06 11:03:33'),(11,'Dispossable Glass','','Y',1,'2024-04-06 19:03:43',1,'2024-04-06 11:03:43'),(12,'Chesterfield (White) Sigarilyo','','Y',1,'2024-04-06 19:04:03',1,'2024-04-06 11:04:03'),(13,'Chesterfield (Red) Sigarilyo','','Y',1,'2024-04-06 19:04:21',1,'2024-04-06 11:04:21'),(14,'Dingdong (Big)','','Y',1,'2024-04-06 19:04:33',1,'2024-04-06 11:04:33'),(15,'Boy Bawang','','Y',1,'2024-04-06 19:04:45',1,'2024-04-06 11:04:45'),(16,'Mineral Water (330 ml)','','Y',1,'2024-04-06 19:04:59',1,'2024-04-06 11:04:59'),(17,'Chesterfield (Red) Sigarilyo Caha','','Y',1,'2024-04-06 19:12:49',1,'2024-04-06 11:12:49'),(18,'Chesterfield (White) Sigarilyo Caha','','Y',1,'2024-04-06 19:13:03',1,'2024-04-06 11:13:03');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requested_dances`
--

DROP TABLE IF EXISTS `requested_dances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requested_dances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `dance_category_id` int NOT NULL,
  `event_id` int NOT NULL,
  `amount` double(8,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'Y',
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requested_dances`
--

LOCK TABLES `requested_dances` WRITE;
/*!40000 ALTER TABLE `requested_dances` DISABLE KEYS */;
INSERT INTO `requested_dances` VALUES (1,'Hon. Dennis V. Montallana x Divine Quinto',1,2,1500.00,'Y',1,'2024-04-17 19:45:43',1,'2024-04-17 11:45:43',NULL),(2,'Basketball Players',2,2,200.00,'Y',1,'2024-04-17 19:52:55',1,'2024-04-17 13:40:45',NULL);
/*!40000 ALTER TABLE `requested_dances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stocks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `product_id` int NOT NULL,
  `unit_id` int NOT NULL,
  `quantity` double(8,1) NOT NULL DEFAULT '0.0',
  `purchase` double(8,1) NOT NULL DEFAULT '0.0',
  `status` char(1) NOT NULL DEFAULT 'Y',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stocks` (`event_id`,`supplier_id`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (1,1,1,1,1,48.0,48.0,'Y',1,'2024-04-06 19:06:12',1,'2024-04-06 14:57:54'),(2,1,1,2,1,84.0,61.0,'Y',1,'2024-04-06 19:06:42',1,'2024-04-06 18:54:19'),(3,1,1,3,1,60.0,46.0,'Y',1,'2024-04-06 19:06:58',1,'2024-04-06 18:23:32'),(4,1,1,4,1,48.0,21.0,'Y',1,'2024-04-06 19:07:14',1,'2024-04-06 14:30:58'),(5,1,1,5,1,12.0,10.0,'Y',1,'2024-04-06 19:07:34',1,'2024-04-06 19:04:15'),(6,1,1,6,1,60.0,33.0,'Y',1,'2024-04-06 19:07:59',1,'2024-04-06 17:50:19'),(7,1,1,7,2,100.0,39.0,'Y',1,'2024-04-06 19:08:30',1,'2024-04-06 17:48:03'),(8,1,1,8,2,50.0,34.0,'Y',1,'2024-04-06 19:08:55',1,'2024-04-06 18:21:39'),(9,1,1,9,2,24.0,46.0,'Y',1,'2024-04-06 19:10:17',1,'2024-04-06 14:18:04'),(10,1,1,10,2,60.0,34.0,'Y',1,'2024-04-06 19:11:22',1,'2024-04-06 17:31:43'),(11,1,1,11,2,100.0,30.0,'Y',1,'2024-04-06 19:11:49',1,'2024-04-06 16:03:44'),(12,1,1,13,2,200.0,35.0,'Y',1,'2024-04-06 19:13:55',1,'2024-04-06 19:02:52'),(13,1,1,12,2,200.0,39.0,'Y',1,'2024-04-06 19:14:14',1,'2024-04-06 19:04:57'),(14,1,1,14,2,5.0,3.0,'Y',1,'2024-04-06 19:14:46',1,'2024-04-06 16:15:22'),(15,1,1,15,2,6.0,7.0,'Y',1,'2024-04-06 19:15:03',1,'2024-04-06 12:53:36'),(16,1,1,16,1,24.0,4.0,'Y',1,'2024-04-06 19:15:43',1,'2024-04-06 14:59:18'),(17,1,1,17,3,10.0,0.0,'Y',1,'2024-04-06 19:24:00',1,'2024-04-06 11:24:00'),(18,1,1,18,3,10.0,0.0,'Y',1,'2024-04-06 19:24:17',1,'2024-04-06 11:24:17'),(19,2,1,2,1,60.0,11.0,'Y',1,'2024-04-16 19:47:01',1,'2024-04-26 08:30:34'),(20,2,1,1,1,48.0,18.0,'Y',1,'2024-04-17 10:28:09',1,'2024-04-19 04:02:10');
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_menu`
--

DROP TABLE IF EXISTS `sub_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(45) DEFAULT NULL,
  `sort` int NOT NULL DEFAULT '0',
  `active_keyword` varchar(45) DEFAULT NULL,
  `is_active` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y = Yes\nN = No',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_menu`
--

LOCK TABLES `sub_menu` WRITE;
/*!40000 ALTER TABLE `sub_menu` DISABLE KEYS */;
INSERT INTO `sub_menu` VALUES (1,2,'Users','/views/settings/users/index.php','bi bi-circle',4,'users','Y',1,'2023-12-01 12:25:21',1,'2024-04-06 00:53:13'),(2,2,'User Roles','/views/settings/user-roles/index.php','bi bi-circle',3,'user-roles','Y',1,'2023-12-01 12:25:21',1,'2024-04-16 06:56:49'),(3,2,'Products','/views/settings/products/index.php','bi bi-circle',1,'products','Y',1,'2024-04-05 12:07:40',1,'2024-04-05 04:08:25'),(4,2,'Product Prices','/views/settings/product-prices/index.php','bi bi-circle',2,'product-prices','Y',1,'2024-04-06 08:51:49',1,'2024-04-06 00:53:13'),(5,2,'Stocks','/views/settings/stocks/index.php','bi bi-circle',2,'stocks','Y',1,'2024-04-06 10:39:33',1,'2024-04-06 02:39:33'),(6,2,'Suppliers','/views/settings/suppliers/index.php','bi bi-circle',2,'suppliers','Y',1,'2024-04-06 10:39:33',1,'2024-04-09 06:37:19'),(7,2,'Events','/views/settings/events/index.php','bi bi-circle',2,'events','Y',1,'2024-04-06 10:39:33',1,'2024-04-10 04:22:25'),(8,2,'Entrance Prices','/views/settings/entrance-prices/index.php','bi bi-circle',2,'entrance-prices','Y',1,'2024-04-16 16:06:01',1,'2024-04-18 08:23:39'),(9,6,'Sales','/views/reports/sales/index.php','bi bi-circle',2,'sales','Y',1,'2024-04-16 16:06:01',1,'2024-04-18 09:19:47'),(10,6,'Transactions','/views/reports/transactions/index.php','bi bi-circle',2,'transactions','Y',1,'2024-04-16 16:06:01',1,'2024-05-02 04:26:00');
/*!40000 ALTER TABLE `sub_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `status` char(1) DEFAULT 'Y' COMMENT 'Y = Yes\\\\nN = No\\\\nD = Deleted',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Badiagon Supplier','Y',1,'2024-04-06 10:35:41',1,'2024-04-06 11:05:40'),(2,'Adan Enterprises','Y',1,'2024-04-09 15:02:08',1,'2024-04-09 07:03:04');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_details`
--

DROP TABLE IF EXISTS `transaction_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaction_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `unit_id` int DEFAULT NULL,
  `qty` double(8,1) NOT NULL DEFAULT '0.0',
  `price` double(8,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y = Yes\nV = Void',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_details`
--

LOCK TABLES `transaction_details` WRITE;
/*!40000 ALTER TABLE `transaction_details` DISABLE KEYS */;
INSERT INTO `transaction_details` VALUES (1,1,2,1,6.0,150.00,'Y',1,'2024-04-06 19:57:18',1,'2024-04-06 11:57:18'),(2,1,11,2,1.0,2.00,'Y',1,'2024-04-06 19:57:18',1,'2024-04-06 11:57:18'),(4,3,5,1,1.0,160.00,'Y',1,'2024-04-06 20:06:10',1,'2024-04-06 12:06:10'),(5,3,11,2,2.0,2.00,'Y',1,'2024-04-06 20:06:10',1,'2024-04-06 12:06:10'),(6,4,15,2,1.0,35.00,'Y',1,'2024-04-06 20:14:06',1,'2024-04-06 12:14:06'),(7,5,6,1,2.0,25.00,'Y',1,'2024-04-06 20:22:41',1,'2024-04-06 12:22:41'),(8,6,7,2,2.0,2.00,'Y',1,'2024-04-06 20:23:48',1,'2024-04-06 12:23:48'),(9,7,2,1,1.0,150.00,'Y',1,'2024-04-06 20:25:18',1,'2024-04-06 12:25:18'),(10,7,11,2,2.0,2.00,'Y',1,'2024-04-06 20:25:18',1,'2024-04-06 12:25:18'),(11,8,2,1,2.0,150.00,'Y',1,'2024-04-06 20:26:22',1,'2024-04-06 12:26:22'),(12,9,8,2,1.0,15.00,'Y',1,'2024-04-06 20:35:54',1,'2024-04-06 12:35:54'),(13,10,6,1,3.0,25.00,'Y',1,'2024-04-06 20:40:44',1,'2024-04-06 12:40:44'),(14,10,15,2,2.0,35.00,'Y',1,'2024-04-06 20:40:44',1,'2024-04-06 12:40:44'),(15,11,2,1,6.0,150.00,'Y',1,'2024-04-06 20:41:52',1,'2024-04-06 12:41:52'),(16,11,4,1,12.0,50.00,'Y',1,'2024-04-06 20:41:52',1,'2024-04-06 12:41:52'),(17,12,3,1,1.0,150.00,'Y',1,'2024-04-06 20:43:14',1,'2024-04-06 12:43:14'),(18,13,2,1,3.0,150.00,'Y',1,'2024-04-06 20:43:54',1,'2024-04-06 12:43:54'),(19,14,11,2,1.0,2.00,'Y',1,'2024-04-06 20:44:35',1,'2024-04-06 12:44:35'),(20,15,16,2,1.0,20.00,'Y',1,'2024-04-06 20:46:26',1,'2024-04-06 12:46:26'),(21,16,11,2,1.0,2.00,'Y',1,'2024-04-06 20:47:04',1,'2024-04-06 12:47:04'),(22,17,15,2,1.0,35.00,'Y',1,'2024-04-06 20:49:46',1,'2024-04-06 12:49:46'),(23,18,4,1,2.0,50.00,'Y',1,'2024-04-06 20:50:52',1,'2024-04-06 12:50:52'),(24,19,5,1,1.0,160.00,'Y',1,'2024-04-06 20:52:23',1,'2024-04-06 12:52:23'),(25,19,11,2,2.0,2.00,'Y',1,'2024-04-06 20:52:23',1,'2024-04-06 12:52:23'),(26,20,15,2,3.0,35.00,'Y',1,'2024-04-06 20:53:36',1,'2024-04-06 12:53:36'),(27,20,10,2,12.0,2.50,'Y',1,'2024-04-06 20:53:36',1,'2024-04-06 12:53:36'),(28,21,2,1,6.0,150.00,'Y',1,'2024-04-06 20:54:17',1,'2024-04-06 12:54:17'),(29,22,11,2,1.0,2.00,'Y',1,'2024-04-06 20:55:00',1,'2024-04-06 12:55:00'),(30,23,2,1,2.0,150.00,'Y',1,'2024-04-06 20:59:04',1,'2024-04-06 12:59:04'),(31,23,8,2,2.0,15.00,'Y',1,'2024-04-06 20:59:04',1,'2024-04-06 12:59:04'),(32,23,11,2,1.0,2.00,'Y',1,'2024-04-06 20:59:05',1,'2024-04-06 12:59:05'),(33,24,7,2,4.0,2.00,'Y',1,'2024-04-06 20:59:47',1,'2024-04-06 12:59:47'),(34,25,14,2,1.0,35.00,'Y',1,'2024-04-06 21:03:02',1,'2024-04-06 13:03:02'),(35,26,9,2,8.0,2.50,'Y',1,'2024-04-06 21:05:45',1,'2024-04-06 13:05:45'),(36,27,8,2,1.0,15.00,'Y',1,'2024-04-06 21:08:51',1,'2024-04-06 13:08:51'),(37,28,16,2,1.0,20.00,'Y',1,'2024-04-06 21:11:14',1,'2024-04-06 13:11:14'),(38,29,7,2,5.0,2.00,'Y',1,'2024-04-06 21:11:57',1,'2024-04-06 13:11:57'),(39,30,6,1,1.0,25.00,'Y',1,'2024-04-06 21:12:30',1,'2024-04-06 13:12:30'),(40,31,6,1,1.0,25.00,'Y',1,'2024-04-06 21:14:55',1,'2024-04-06 13:14:55'),(41,31,9,2,18.0,2.50,'Y',1,'2024-04-06 21:14:55',1,'2024-04-06 13:14:55'),(42,32,8,2,1.0,15.00,'Y',1,'2024-04-06 21:18:52',1,'2024-04-06 13:18:52'),(43,33,7,2,4.0,2.00,'Y',1,'2024-04-06 21:20:41',1,'2024-04-06 13:20:41'),(44,34,2,1,1.0,150.00,'Y',1,'2024-04-06 21:21:51',1,'2024-04-06 13:21:51'),(45,35,16,2,1.0,20.00,'Y',1,'2024-04-06 21:32:29',1,'2024-04-06 13:32:29'),(46,36,5,1,1.0,160.00,'Y',1,'2024-04-06 21:36:51',1,'2024-04-06 13:36:51'),(47,36,11,2,2.0,2.00,'Y',1,'2024-04-06 21:36:51',1,'2024-04-06 13:36:51'),(48,37,6,1,2.0,25.00,'Y',1,'2024-04-06 21:38:07',1,'2024-04-06 13:38:07'),(49,38,2,1,3.0,150.00,'Y',1,'2024-04-06 21:39:38',1,'2024-04-06 13:39:38'),(50,39,3,1,4.0,150.00,'Y',1,'2024-04-06 21:40:19',1,'2024-04-06 13:40:19'),(51,40,6,1,2.0,25.00,'Y',1,'2024-04-06 21:40:57',1,'2024-04-06 13:40:57'),(52,41,11,2,2.0,2.00,'Y',1,'2024-04-06 21:41:42',1,'2024-04-06 13:41:42'),(53,41,7,2,1.0,2.00,'Y',1,'2024-04-06 21:41:43',1,'2024-04-06 13:41:43'),(54,42,11,2,3.0,2.00,'Y',1,'2024-04-06 21:42:54',1,'2024-04-06 13:42:54'),(55,43,2,1,1.0,150.00,'Y',1,'2024-04-06 21:44:49',1,'2024-04-06 13:44:49'),(56,43,6,1,1.0,25.00,'Y',1,'2024-04-06 21:44:50',1,'2024-04-06 13:44:50'),(57,44,12,2,7.0,8.00,'Y',1,'2024-04-06 21:46:17',1,'2024-04-06 13:46:17'),(58,45,11,2,1.0,2.00,'Y',1,'2024-04-06 21:48:56',1,'2024-04-06 13:48:56'),(59,46,2,1,1.0,150.00,'Y',1,'2024-04-06 21:51:49',1,'2024-04-06 13:51:49'),(60,46,11,2,1.0,2.00,'Y',1,'2024-04-06 21:51:49',1,'2024-04-06 13:51:49'),(61,47,4,1,1.0,50.00,'Y',1,'2024-04-06 22:00:42',1,'2024-04-06 14:00:42'),(62,48,6,1,2.0,25.00,'Y',1,'2024-04-06 22:01:37',1,'2024-04-06 14:01:37'),(63,49,4,1,1.0,50.00,'Y',1,'2024-04-06 22:02:07',1,'2024-04-06 14:02:07'),(64,50,2,1,2.0,150.00,'Y',1,'2024-04-06 22:03:04',1,'2024-04-06 14:03:04'),(65,51,1,1,24.0,50.00,'Y',1,'2024-04-06 22:05:31',1,'2024-04-06 14:05:31'),(66,52,5,1,1.0,160.00,'Y',1,'2024-04-06 22:06:32',1,'2024-04-06 14:06:32'),(67,53,8,2,2.0,15.00,'Y',1,'2024-04-06 22:07:53',1,'2024-04-06 14:07:53'),(68,53,7,2,2.0,2.00,'Y',1,'2024-04-06 22:07:53',1,'2024-04-06 14:07:53'),(69,54,2,1,1.0,150.00,'Y',1,'2024-04-06 22:11:51',1,'2024-04-06 14:11:51'),(70,55,3,1,1.0,150.00,'Y',1,'2024-04-06 22:15:11',1,'2024-04-06 14:15:11'),(71,55,11,2,1.0,2.00,'Y',1,'2024-04-06 22:15:11',1,'2024-04-06 14:15:11'),(72,56,9,2,20.0,2.50,'Y',1,'2024-04-06 22:18:04',1,'2024-04-06 14:18:04'),(73,57,3,1,1.0,150.00,'Y',1,'2024-04-06 22:18:56',1,'2024-04-06 14:18:56'),(74,58,4,1,1.0,50.00,'Y',1,'2024-04-06 22:19:51',1,'2024-04-06 14:19:51'),(75,58,11,2,1.0,2.00,'Y',1,'2024-04-06 22:19:51',1,'2024-04-06 14:19:51'),(76,59,8,2,2.0,15.00,'Y',1,'2024-04-06 22:22:00',1,'2024-04-06 14:22:00'),(77,60,4,1,3.0,50.00,'Y',1,'2024-04-06 22:23:04',1,'2024-04-06 14:23:04'),(78,61,5,1,1.0,160.00,'Y',1,'2024-04-06 22:24:44',1,'2024-04-06 14:24:44'),(79,62,6,1,1.0,25.00,'Y',1,'2024-04-06 22:26:02',1,'2024-04-06 14:26:02'),(80,63,3,1,6.0,150.00,'Y',1,'2024-04-06 22:28:26',1,'2024-04-06 14:28:26'),(81,64,7,2,10.0,2.00,'Y',1,'2024-04-06 22:29:02',1,'2024-04-06 14:29:02'),(82,65,11,2,5.0,2.00,'Y',1,'2024-04-06 22:30:08',1,'2024-04-06 14:30:08'),(83,66,4,1,1.0,50.00,'Y',1,'2024-04-06 22:30:58',1,'2024-04-06 14:30:58'),(84,67,8,2,1.0,15.00,'Y',1,'2024-04-06 22:32:34',1,'2024-04-06 14:32:34'),(85,68,7,2,5.0,2.00,'Y',1,'2024-04-06 22:36:57',1,'2024-04-06 14:36:57'),(86,69,3,1,1.0,150.00,'Y',1,'2024-04-06 22:50:41',1,'2024-04-06 14:50:41'),(87,70,1,1,24.0,50.00,'Y',1,'2024-04-06 22:57:54',1,'2024-04-06 14:57:54'),(88,70,8,2,2.0,15.00,'Y',1,'2024-04-06 22:57:54',1,'2024-04-06 14:57:54'),(89,71,2,1,6.0,150.00,'Y',1,'2024-04-06 22:58:23',1,'2024-04-06 14:58:23'),(90,72,16,2,1.0,20.00,'Y',1,'2024-04-06 22:59:18',1,'2024-04-06 14:59:18'),(91,73,2,1,1.0,150.00,'Y',1,'2024-04-06 23:02:36',1,'2024-04-06 15:02:36'),(92,73,11,2,1.0,2.00,'Y',1,'2024-04-06 23:02:36',1,'2024-04-06 15:02:36'),(93,74,8,2,3.0,15.00,'Y',1,'2024-04-06 23:03:41',1,'2024-04-06 15:03:41'),(94,75,13,2,6.0,8.00,'Y',1,'2024-04-06 23:05:25',1,'2024-04-06 15:05:25'),(95,75,7,2,1.0,2.00,'Y',1,'2024-04-06 23:05:25',1,'2024-04-06 15:05:25'),(96,76,12,2,1.0,8.00,'Y',1,'2024-04-06 23:10:51',1,'2024-04-06 15:10:51'),(97,77,12,2,5.0,8.00,'Y',1,'2024-04-06 23:21:35',1,'2024-04-06 15:21:35'),(98,78,2,1,6.0,150.00,'Y',1,'2024-04-06 23:39:11',1,'2024-04-06 15:39:11'),(99,79,8,2,2.0,15.00,'Y',1,'2024-04-06 23:40:38',1,'2024-04-06 15:40:38'),(100,80,3,1,2.0,150.00,'Y',1,'2024-04-06 23:45:29',1,'2024-04-06 15:45:29'),(101,81,3,1,2.0,150.00,'Y',1,'2024-04-06 23:57:08',1,'2024-04-06 15:57:08'),(102,82,5,1,1.0,160.00,'Y',1,'2024-04-06 23:58:01',1,'2024-04-06 15:58:01'),(103,83,5,1,1.0,160.00,'Y',1,'2024-04-07 00:03:44',1,'2024-04-06 16:03:44'),(104,83,11,2,2.0,2.00,'Y',1,'2024-04-07 00:03:44',1,'2024-04-06 16:03:44'),(105,83,6,1,4.0,25.00,'Y',1,'2024-04-07 00:03:44',1,'2024-04-06 16:03:44'),(106,83,3,1,1.0,150.00,'Y',1,'2024-04-07 00:03:44',1,'2024-04-06 16:03:44'),(107,84,3,1,1.0,150.00,'Y',1,'2024-04-07 00:04:28',1,'2024-04-06 16:04:28'),(108,85,3,1,1.0,150.00,'Y',1,'2024-04-07 00:05:00',1,'2024-04-06 16:05:00'),(109,86,6,1,3.0,25.00,'Y',1,'2024-04-07 00:15:22',1,'2024-04-06 16:15:22'),(110,86,14,2,2.0,35.00,'Y',1,'2024-04-07 00:15:22',1,'2024-04-06 16:15:22'),(111,87,6,1,1.0,25.00,'Y',1,'2024-04-07 00:17:37',1,'2024-04-06 16:17:37'),(112,87,8,2,1.0,15.00,'Y',1,'2024-04-07 00:17:37',1,'2024-04-06 16:17:37'),(113,88,2,1,1.0,150.00,'Y',1,'2024-04-07 00:19:05',1,'2024-04-06 16:19:05'),(114,88,8,2,1.0,15.00,'Y',1,'2024-04-07 00:19:05',1,'2024-04-06 16:19:05'),(115,89,6,1,1.0,25.00,'Y',1,'2024-04-07 00:19:54',1,'2024-04-06 16:19:54'),(116,90,3,1,1.0,150.00,'Y',1,'2024-04-07 00:20:40',1,'2024-04-06 16:20:40'),(117,91,12,2,6.0,8.00,'Y',1,'2024-04-07 00:22:51',1,'2024-04-06 16:22:51'),(118,92,3,1,6.0,150.00,'Y',1,'2024-04-07 00:34:01',1,'2024-04-06 16:34:01'),(119,93,3,1,1.0,150.00,'Y',1,'2024-04-07 00:35:23',1,'2024-04-06 16:35:23'),(120,93,8,2,1.0,15.00,'Y',1,'2024-04-07 00:35:23',1,'2024-04-06 16:35:23'),(121,94,3,1,6.0,150.00,'Y',1,'2024-04-07 00:35:54',1,'2024-04-06 16:35:54'),(122,95,2,1,2.0,150.00,'Y',1,'2024-04-07 00:36:30',1,'2024-04-06 16:36:30'),(123,96,13,2,6.0,8.00,'Y',1,'2024-04-07 00:40:44',1,'2024-04-06 16:40:44'),(124,97,6,1,1.0,25.00,'Y',1,'2024-04-07 00:42:26',1,'2024-04-06 16:42:26'),(125,98,2,1,6.0,150.00,'Y',1,'2024-04-07 00:45:54',1,'2024-04-06 16:45:54'),(126,99,5,1,1.0,160.00,'Y',1,'2024-04-07 00:47:28',1,'2024-04-06 16:47:28'),(127,100,8,2,4.0,15.00,'Y',1,'2024-04-07 00:52:22',1,'2024-04-06 16:52:22'),(128,101,2,1,1.0,150.00,'Y',1,'2024-04-07 01:00:41',1,'2024-04-06 17:00:41'),(129,101,13,2,4.0,8.00,'Y',1,'2024-04-07 01:00:41',1,'2024-04-06 17:00:41'),(130,101,10,2,6.0,2.50,'Y',1,'2024-04-07 01:00:41',1,'2024-04-06 17:00:41'),(131,102,3,1,6.0,150.00,'Y',1,'2024-04-07 01:01:35',1,'2024-04-06 17:01:35'),(132,103,10,2,8.0,2.50,'Y',1,'2024-04-07 01:08:30',1,'2024-04-06 17:08:30'),(133,104,8,2,2.0,15.00,'Y',1,'2024-04-07 01:11:02',1,'2024-04-06 17:11:02'),(134,104,12,2,5.0,8.00,'Y',1,'2024-04-07 01:11:02',1,'2024-04-06 17:11:02'),(135,105,2,1,1.0,150.00,'Y',1,'2024-04-07 01:19:24',1,'2024-04-06 17:19:24'),(136,106,8,2,2.0,15.00,'Y',1,'2024-04-07 01:31:43',1,'2024-04-06 17:31:43'),(137,106,10,2,8.0,2.50,'Y',1,'2024-04-07 01:31:43',1,'2024-04-06 17:31:43'),(138,107,3,1,3.0,150.00,'Y',1,'2024-04-07 01:36:06',1,'2024-04-06 17:36:06'),(139,108,12,2,2.0,8.00,'Y',1,'2024-04-07 01:38:32',1,'2024-04-06 17:38:32'),(140,109,6,1,1.0,25.00,'Y',1,'2024-04-07 01:40:18',1,'2024-04-06 17:40:18'),(141,110,12,2,2.0,8.00,'Y',1,'2024-04-07 01:41:57',1,'2024-04-06 17:41:57'),(142,110,13,2,1.0,8.00,'Y',1,'2024-04-07 01:41:57',1,'2024-04-06 17:41:57'),(143,111,7,2,2.0,2.00,'Y',1,'2024-04-07 01:47:01',1,'2024-04-06 17:47:01'),(144,111,8,2,5.0,15.00,'Y',1,'2024-04-07 01:47:01',1,'2024-04-06 17:47:01'),(145,111,6,1,3.0,25.00,'Y',1,'2024-04-07 01:47:01',1,'2024-04-06 17:47:01'),(146,112,7,2,3.0,2.00,'Y',1,'2024-04-07 01:48:03',1,'2024-04-06 17:48:03'),(147,113,12,2,5.0,8.00,'Y',1,'2024-04-07 01:50:19',1,'2024-04-06 17:50:19'),(148,113,5,1,1.0,160.00,'Y',1,'2024-04-07 01:50:19',1,'2024-04-06 17:50:19'),(149,113,3,1,1.0,150.00,'Y',1,'2024-04-07 01:50:19',1,'2024-04-06 17:50:19'),(150,113,6,1,4.0,25.00,'Y',1,'2024-04-07 01:50:19',1,'2024-04-06 17:50:19'),(151,114,13,2,6.0,8.00,'Y',1,'2024-04-07 01:54:25',1,'2024-04-06 17:54:25'),(152,115,12,2,2.0,8.00,'Y',1,'2024-04-07 01:55:18',1,'2024-04-06 17:55:18'),(153,116,12,2,2.0,8.00,'Y',1,'2024-04-07 01:57:18',1,'2024-04-06 17:57:18'),(154,117,12,2,1.0,8.00,'Y',1,'2024-04-07 02:21:39',1,'2024-04-06 18:21:39'),(155,117,8,2,1.0,15.00,'Y',1,'2024-04-07 02:21:39',1,'2024-04-06 18:21:39'),(156,118,13,2,6.0,8.00,'Y',1,'2024-04-07 02:23:32',1,'2024-04-06 18:23:32'),(157,118,3,1,1.0,150.00,'Y',1,'2024-04-07 02:23:32',1,'2024-04-06 18:23:32'),(158,119,2,1,1.0,150.00,'Y',1,'2024-04-07 02:29:50',1,'2024-04-06 18:29:50'),(159,120,2,1,1.0,150.00,'Y',1,'2024-04-07 02:54:19',1,'2024-04-06 18:54:19'),(160,121,13,2,6.0,8.00,'Y',1,'2024-04-07 03:02:52',1,'2024-04-06 19:02:52'),(161,122,5,1,1.0,160.00,'Y',1,'2024-04-07 03:04:15',1,'2024-04-06 19:04:15'),(162,123,12,2,1.0,8.00,'Y',1,'2024-04-07 03:04:57',1,'2024-04-06 19:04:57'),(166,127,2,1,2.0,150.00,'Y',1,'2024-04-17 10:18:58',1,'2024-04-17 02:18:58'),(167,128,1,1,10.0,50.00,'Y',1,'2024-04-17 10:31:17',1,'2024-04-17 02:31:17'),(168,129,2,1,2.0,150.00,'Y',1,'2024-04-17 20:16:18',1,'2024-04-17 12:16:18'),(169,130,1,1,2.0,50.00,'Y',1,'2024-04-18 14:08:39',1,'2024-04-18 06:08:39'),(170,131,1,1,6.0,50.00,'Y',1,'2024-04-19 12:02:10',1,'2024-04-19 04:02:10'),(171,131,2,1,1.0,150.00,'Y',1,'2024-04-19 12:02:11',1,'2024-04-19 04:02:11'),(172,132,2,1,6.0,150.00,'Y',1,'2024-04-26 16:30:34',1,'2024-04-26 08:30:34');
/*!40000 ALTER TABLE `transaction_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_history`
--

DROP TABLE IF EXISTS `transaction_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaction_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `good_for` char(1) NOT NULL DEFAULT 'N',
  `total_amount` double(8,2) NOT NULL DEFAULT '0.00',
  `amount_paid` double(8,2) NOT NULL DEFAULT '0.00',
  `amount_change` double(8,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y = Yes\nV = Void',
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_history`
--

LOCK TABLES `transaction_history` WRITE;
/*!40000 ALTER TABLE `transaction_history` DISABLE KEYS */;
INSERT INTO `transaction_history` VALUES (1,2,'Customer','N',900.00,850.00,-50.00,'Y','',1,'2024-05-27 16:57:36',1,'2024-05-27 08:57:36'),(2,2,'Customer','N',900.00,100.00,50.00,'P','',1,'2024-05-27 16:57:36',1,'2024-05-27 08:57:36'),(3,2,'Customer','Y',300.00,0.00,0.00,'Y','',1,'2024-05-27 17:00:02',1,'2024-05-27 09:00:02'),(4,2,'Customer','Y',300.00,500.00,200.00,'P','',1,'2024-05-27 17:00:02',1,'2024-05-27 09:00:02');
/*!40000 ALTER TABLE `transaction_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_no` varchar(15) NOT NULL,
  `event_id` int NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `good_for` char(1) NOT NULL DEFAULT 'N',
  `total_amount` double(8,2) NOT NULL DEFAULT '0.00',
  `amount_paid` double(8,2) NOT NULL DEFAULT '0.00',
  `amount_change` double(8,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y = Yes\\nV = Void, P = Paid',
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_no_UNIQUE` (`transaction_no`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,'24-00001',1,'Customer-Jomel','N',902.00,1002.00,100.00,'Y',NULL,1,'2024-04-06 19:57:18',1,'2024-04-06 11:57:18'),(3,'24-00002',1,'Customer-Sadam','N',164.00,200.00,36.00,'Y',NULL,1,'2024-04-06 20:06:10',1,'2024-04-06 12:06:10'),(4,'24-00003',1,'Customer-Sadam-Dina','N',35.00,36.00,1.00,'Y',NULL,1,'2024-04-06 20:14:06',1,'2024-04-06 12:14:06'),(5,'24-00004',1,'Customer-Nano','N',50.00,100.00,50.00,'Y',NULL,1,'2024-04-06 20:22:41',1,'2024-04-06 12:22:41'),(6,'24-00005',1,'Customer-Normelyn','N',4.00,4.00,0.00,'Y',NULL,1,'2024-04-06 20:23:48',1,'2024-04-06 12:23:48'),(7,'24-00006',1,'Customer-Lio','N',154.00,504.00,350.00,'Y',NULL,1,'2024-04-06 20:25:18',1,'2024-04-06 12:25:18'),(8,'24-00007',1,'Customer-Bot','N',300.00,300.00,0.00,'Y',NULL,1,'2024-04-06 20:26:22',1,'2024-04-06 12:26:22'),(9,'24-00008',1,'Customer-Nano','N',15.00,15.00,0.00,'Y',NULL,1,'2024-04-06 20:35:54',1,'2024-04-06 12:35:54'),(10,'24-00009',1,'Customer-Renan','N',145.00,150.00,5.00,'Y',NULL,1,'2024-04-06 20:40:44',1,'2024-04-06 12:40:44'),(11,'24-00010',1,'Customer-Mai','N',1500.00,2000.00,500.00,'Y',NULL,1,'2024-04-06 20:41:52',1,'2024-04-06 12:41:52'),(12,'24-00011',1,'Customer-Buko','N',150.00,150.00,0.00,'Y',NULL,1,'2024-04-06 20:43:14',1,'2024-04-06 12:43:14'),(13,'24-00012',1,'Customer-Renan','N',450.00,450.00,0.00,'Y',NULL,1,'2024-04-06 20:43:54',1,'2024-04-06 12:43:54'),(14,'24-00013',1,'Customer-Sadam','N',2.00,2.00,0.00,'Y',NULL,1,'2024-04-06 20:44:35',1,'2024-04-06 12:44:35'),(15,'24-00014',1,'Customer-Norma','N',20.00,50.00,30.00,'Y',NULL,1,'2024-04-06 20:46:26',1,'2024-04-06 12:46:26'),(16,'24-00015',1,'Customer-Renan','N',2.00,2.00,0.00,'Y',NULL,1,'2024-04-06 20:47:03',1,'2024-04-06 12:47:03'),(17,'24-00016',1,'Customer-Mai','N',35.00,40.00,5.00,'Y',NULL,1,'2024-04-06 20:49:45',1,'2024-04-06 12:49:45'),(18,'24-00017',1,'Customer-Bolantoy','N',100.00,100.00,0.00,'Y',NULL,1,'2024-04-06 20:50:52',1,'2024-04-06 12:50:52'),(19,'24-00018',1,'Customer-Nicole','N',164.00,170.00,6.00,'Y',NULL,1,'2024-04-06 20:52:23',1,'2024-04-06 12:52:23'),(20,'24-00019',1,'Customer-Mai','N',135.00,500.00,365.00,'Y',NULL,1,'2024-04-06 20:53:36',1,'2024-04-06 12:53:36'),(21,'24-00020',1,'Customer-Jomel','N',900.00,900.00,0.00,'Y',NULL,1,'2024-04-06 20:54:17',1,'2024-04-06 12:54:17'),(22,'24-00021',1,'Customer-Jumil','N',2.00,2.00,0.00,'Y',NULL,1,'2024-04-06 20:55:00',1,'2024-04-06 12:55:00'),(23,'24-00022',1,'Customer-Liezel','N',332.00,1000.00,668.00,'Y',NULL,1,'2024-04-06 20:59:04',1,'2024-04-06 12:59:04'),(24,'24-00023',1,'Customer-Liezel','N',8.00,8.00,0.00,'Y',NULL,1,'2024-04-06 20:59:47',1,'2024-04-06 12:59:47'),(25,'24-00024',1,'Customer-Normelyn','N',35.00,35.00,0.00,'Y',NULL,1,'2024-04-06 21:03:02',1,'2024-04-06 13:03:02'),(26,'24-00025',1,'Customer-Ethan','N',20.00,100.00,80.00,'Y',NULL,1,'2024-04-06 21:05:45',1,'2024-04-06 13:05:45'),(27,'24-00026',1,'Customer-Dolly','N',15.00,20.00,5.00,'Y',NULL,1,'2024-04-06 21:08:51',1,'2024-04-06 13:08:51'),(28,'24-00027',1,'Customer-Buko','N',20.00,50.00,30.00,'Y',NULL,1,'2024-04-06 21:11:14',1,'2024-04-06 13:11:14'),(29,'24-00028',1,'Customer-Jan2x','N',10.00,10.00,0.00,'Y',NULL,1,'2024-04-06 21:11:57',1,'2024-04-06 13:11:57'),(30,'24-00029',1,'Customer-Mike','N',25.00,500.00,475.00,'Y',NULL,1,'2024-04-06 21:12:30',1,'2024-04-06 13:12:30'),(31,'24-00030',1,'Customer-Ethan','N',70.00,70.00,0.00,'Y',NULL,1,'2024-04-06 21:14:55',1,'2024-04-06 13:14:55'),(32,'24-00031',1,'Customer-Emma','N',15.00,20.00,5.00,'Y',NULL,1,'2024-04-06 21:18:52',1,'2024-04-06 13:18:52'),(33,'24-00032',1,'Customer-Danny','N',8.00,8.00,0.00,'Y',NULL,1,'2024-04-06 21:20:40',1,'2024-04-06 13:20:40'),(34,'24-00033',1,'Customer-Nato','N',150.00,200.00,50.00,'Y',NULL,1,'2024-04-06 21:21:51',1,'2024-04-06 13:21:51'),(35,'24-00034',1,'Customer-Vergie','N',20.00,50.00,30.00,'Y',NULL,1,'2024-04-06 21:32:29',1,'2024-04-06 13:32:29'),(36,'24-00035',1,'Customer-Justin','N',164.00,200.00,36.00,'Y',NULL,1,'2024-04-06 21:36:50',1,'2024-04-06 13:36:50'),(37,'24-00036',1,'Customer','N',50.00,1036.00,986.00,'Y',NULL,1,'2024-04-06 21:38:07',1,'2024-04-06 13:38:07'),(38,'24-00037',1,'Customer-Buko','N',450.00,500.00,50.00,'Y',NULL,1,'2024-04-06 21:39:38',1,'2024-04-06 13:39:38'),(39,'24-00038',1,'Customer-Andro','N',600.00,600.00,0.00,'Y',NULL,1,'2024-04-06 21:40:19',1,'2024-04-06 13:40:19'),(40,'24-00039',1,'Customer-Daniela','N',50.00,50.00,0.00,'Y',NULL,1,'2024-04-06 21:40:57',1,'2024-04-06 13:40:57'),(41,'24-00040',1,'Customer-Andro','N',6.00,6.00,0.00,'Y',NULL,1,'2024-04-06 21:41:42',1,'2024-04-06 13:41:42'),(42,'24-00041',1,'Customer-Renan','N',6.00,6.00,0.00,'Y',NULL,1,'2024-04-06 21:42:54',1,'2024-04-06 13:42:54'),(43,'24-00042',1,'Customer-Soyen','N',175.00,200.00,25.00,'Y',NULL,1,'2024-04-06 21:44:49',1,'2024-04-06 13:44:49'),(44,'24-00043',1,'Customer-Dina','N',56.00,100.00,44.00,'Y',NULL,1,'2024-04-06 21:46:17',1,'2024-04-06 13:46:17'),(45,'24-00044',1,'Customer-Soyen','N',2.00,2.00,0.00,'Y',NULL,1,'2024-04-06 21:48:56',1,'2024-04-06 13:48:56'),(46,'24-00045',1,'Customer-Ronel','N',152.00,200.00,48.00,'Y',NULL,1,'2024-04-06 21:51:49',1,'2024-04-06 13:51:49'),(47,'24-00046',1,'Customer-Rolwen(Kuya Dodo)','N',50.00,100.00,50.00,'Y',NULL,1,'2024-04-06 22:00:42',1,'2024-04-06 14:00:42'),(48,'24-00047',1,'Customer-Lennyben','N',50.00,100.00,50.00,'Y',NULL,1,'2024-04-06 22:01:37',1,'2024-04-06 14:01:37'),(49,'24-00048',1,'Customer-Simoy','N',50.00,50.00,0.00,'Y',NULL,1,'2024-04-06 22:02:07',1,'2024-04-06 14:02:07'),(50,'24-00049',1,'Customer-Andro','N',300.00,300.00,0.00,'Y',NULL,1,'2024-04-06 22:03:04',1,'2024-04-06 14:03:04'),(51,'24-00050',1,'Customer-Ronel','N',1200.00,1100.00,-100.00,'Y',NULL,1,'2024-04-06 22:05:31',1,'2024-04-06 14:05:31'),(52,'24-00051',1,'Customer-Soyen','N',160.00,200.00,40.00,'Y',NULL,1,'2024-04-06 22:06:32',1,'2024-04-06 14:06:32'),(53,'24-00052',1,'Customer-Ronel','N',34.00,50.00,20.00,'Y',NULL,1,'2024-04-06 22:07:53',1,'2024-04-06 14:07:53'),(54,'24-00053',1,'Customer-Renato','N',150.00,150.00,0.00,'Y',NULL,1,'2024-04-06 22:11:51',1,'2024-04-06 14:11:51'),(55,'24-00054',1,'Customer-Lyca','N',152.00,200.00,48.00,'Y',NULL,1,'2024-04-06 22:15:11',1,'2024-04-06 14:15:11'),(56,'24-00055',1,'Customer-Badot','N',50.00,50.00,0.00,'Y',NULL,1,'2024-04-06 22:18:04',1,'2024-04-06 14:18:04'),(57,'24-00056',1,'Customer-Danny','N',150.00,150.00,0.00,'Y',NULL,1,'2024-04-06 22:18:56',1,'2024-04-06 14:18:56'),(58,'24-00057',1,'Customer-Simoy','N',52.00,100.00,48.00,'Y',NULL,1,'2024-04-06 22:19:51',1,'2024-04-06 14:19:51'),(59,'24-00058',1,'Customer-Lennyben','N',30.00,50.00,20.00,'Y',NULL,1,'2024-04-06 22:22:00',1,'2024-04-06 14:22:00'),(60,'24-00059',1,'Customer-Renan','N',150.00,150.00,0.00,'Y',NULL,1,'2024-04-06 22:23:04',1,'2024-04-06 14:23:04'),(61,'24-00060',1,'Customer-Justin','N',160.00,186.00,26.00,'Y',NULL,1,'2024-04-06 22:24:44',1,'2024-04-06 14:24:44'),(62,'24-00061',1,'Customer-Zaldie','N',25.00,50.00,25.00,'Y',NULL,1,'2024-04-06 22:26:02',1,'2024-04-06 14:26:02'),(63,'24-00062',1,'Customer-Jimboy','N',900.00,800.00,-100.00,'Y',NULL,1,'2024-04-06 22:28:26',1,'2024-04-06 14:28:26'),(64,'24-00063',1,'Customer-Jimboy','N',20.00,20.00,0.00,'Y',NULL,1,'2024-04-06 22:29:02',1,'2024-04-06 14:29:02'),(65,'24-00064',1,'Customer-Jimboy','N',10.00,10.00,0.00,'Y',NULL,1,'2024-04-06 22:30:08',1,'2024-04-06 14:30:08'),(66,'24-00065',1,'Customer-Simoy','N',50.00,50.00,0.00,'Y',NULL,1,'2024-04-06 22:30:58',1,'2024-04-06 14:30:58'),(67,'24-00066',1,'Customer-Alex','N',15.00,20.00,5.00,'Y',NULL,1,'2024-04-06 22:32:33',1,'2024-04-06 14:32:33'),(68,'24-00067',1,'Customer-Esot','N',10.00,100.00,90.00,'Y',NULL,1,'2024-04-06 22:36:57',1,'2024-04-06 14:36:57'),(69,'24-00068',1,'Customer-Te Bebe','N',150.00,200.00,50.00,'Y',NULL,1,'2024-04-06 22:50:41',1,'2024-04-06 14:50:41'),(70,'24-00069',1,'Customer-Ronel','N',1230.00,1500.00,270.00,'Y',NULL,1,'2024-04-06 22:57:54',1,'2024-04-06 14:57:54'),(71,'24-00070',1,'Customer-Buko','N',900.00,1000.00,100.00,'Y',NULL,1,'2024-04-06 22:58:23',1,'2024-04-06 14:58:23'),(72,'24-00071',1,'Customer-Joyce','N',20.00,50.00,30.00,'Y',NULL,1,'2024-04-06 22:59:18',1,'2024-04-06 14:59:18'),(73,'24-00072',1,'Customer-Wilfredo','N',152.00,160.00,8.00,'Y',NULL,1,'2024-04-06 23:02:35',1,'2024-04-06 15:02:35'),(74,'24-00073',1,'Customer-Lennyben','N',45.00,45.00,0.00,'Y',NULL,1,'2024-04-06 23:03:40',1,'2024-04-06 15:03:40'),(75,'24-00074',1,'Customer-Badot','N',50.00,50.00,0.00,'Y',NULL,1,'2024-04-06 23:05:25',1,'2024-04-06 15:05:25'),(76,'24-00075',1,'Customer-Danny','N',8.00,10.00,2.00,'Y',NULL,1,'2024-04-06 23:10:51',1,'2024-04-06 15:10:51'),(77,'24-00076',1,'Customer-Dina','N',40.00,44.00,4.00,'Y',NULL,1,'2024-04-06 23:21:35',1,'2024-04-06 15:21:35'),(78,'24-00077',1,'Customer-Jumil-Utang','Y',900.00,0.00,0.00,'Y',NULL,1,'2024-04-06 23:39:11',1,'2024-04-06 15:39:11'),(79,'24-00078',1,'Customer-Lennyben','N',30.00,30.00,0.00,'Y',NULL,1,'2024-04-06 23:40:38',1,'2024-04-06 15:40:38'),(80,'24-00079',1,'Customer-Elly','N',300.00,300.00,0.00,'Y',NULL,1,'2024-04-06 23:45:29',1,'2024-04-06 15:45:29'),(81,'24-00080',1,'Customer-Jimboy','Y',300.00,0.00,0.00,'Y',NULL,1,'2024-04-06 23:57:08',1,'2024-04-06 15:57:08'),(82,'24-00081',1,'Customer-Justin','N',160.00,200.00,40.00,'Y',NULL,1,'2024-04-06 23:58:01',1,'2024-04-06 15:58:01'),(83,'24-00082',1,'Customer-Ron2x','N',414.00,500.00,86.00,'Y',NULL,1,'2024-04-07 00:03:44',1,'2024-04-06 16:03:44'),(84,'24-00083',1,'Customer-Te Bebe','N',150.00,150.00,0.00,'Y',NULL,1,'2024-04-07 00:04:28',1,'2024-04-06 16:04:28'),(85,'24-00084',1,'Customer-Danny','Y',150.00,0.00,0.00,'Y',NULL,1,'2024-04-07 00:05:00',1,'2024-04-06 16:05:00'),(86,'24-00085',1,'Customer-Rolena','N',145.00,200.00,55.00,'Y',NULL,1,'2024-04-07 00:15:22',1,'2024-04-06 16:15:22'),(87,'24-00086',1,'Customer-Kuya Dodo','N',40.00,50.00,10.00,'Y',NULL,1,'2024-04-07 00:17:37',1,'2024-04-06 16:17:37'),(88,'24-00087',1,'Customer-Andro','N',165.00,250.00,85.00,'Y',NULL,1,'2024-04-07 00:19:05',1,'2024-04-06 16:19:05'),(89,'24-00088',1,'Customer-Rolwen(Kuya Dodo)','N',25.00,25.00,0.00,'Y',NULL,1,'2024-04-07 00:19:54',1,'2024-04-06 16:19:54'),(90,'24-00089',1,'Customer-Ron2x','N',150.00,150.00,0.00,'Y',NULL,1,'2024-04-07 00:20:40',1,'2024-04-06 16:20:40'),(91,'24-00090',1,'Customer1','N',48.00,50.00,2.00,'Y',NULL,1,'2024-04-07 00:22:51',1,'2024-04-06 16:22:51'),(92,'24-00091',1,'Customer-Badot','N',900.00,1000.00,100.00,'Y',NULL,1,'2024-04-07 00:34:01',1,'2024-04-06 16:34:01'),(93,'24-00092',1,'Customer-Bot','N',165.00,200.00,35.00,'Y',NULL,1,'2024-04-07 00:35:23',1,'2024-04-06 16:35:23'),(94,'24-00093',1,'Customer-Randy','N',900.00,1000.00,100.00,'Y',NULL,1,'2024-04-07 00:35:54',1,'2024-04-06 16:35:54'),(95,'24-00094',1,'Customer-Ambacon','N',300.00,300.00,0.00,'Y',NULL,1,'2024-04-07 00:36:30',1,'2024-04-06 16:36:30'),(96,'24-00095',1,'Customer-Randy','N',48.00,50.00,2.00,'Y',NULL,1,'2024-04-07 00:40:44',1,'2024-04-06 16:40:44'),(97,'24-00096',1,'Customer-niejay','N',25.00,100.00,75.00,'Y',NULL,1,'2024-04-07 00:42:26',1,'2024-04-06 16:42:26'),(98,'24-00097',1,'Customer-tanod-utang','Y',900.00,0.00,0.00,'Y',NULL,1,'2024-04-07 00:45:54',1,'2024-04-06 16:45:54'),(99,'24-00098',1,'Customer-Justin','N',160.00,200.00,40.00,'Y',NULL,1,'2024-04-07 00:47:28',1,'2024-04-06 16:47:28'),(100,'24-00099',1,'Customer-Mike','N',60.00,500.00,440.00,'Y',NULL,1,'2024-04-07 00:52:22',1,'2024-04-06 16:52:22'),(101,'24-00100',1,'Customer2','N',197.00,200.00,18.00,'Y',NULL,1,'2024-04-07 01:00:41',1,'2024-04-06 17:00:41'),(102,'24-00101',1,'Customer-Randy','N',900.00,1000.00,100.00,'Y',NULL,1,'2024-04-07 01:01:35',1,'2024-04-06 17:01:35'),(103,'24-00102',1,'Customer-Soyen','N',20.00,100.00,80.00,'Y',NULL,1,'2024-04-07 01:08:30',1,'2024-04-06 17:08:30'),(104,'24-00103',1,'Customer-Soyen','N',70.00,70.00,0.00,'Y',NULL,1,'2024-04-07 01:11:02',1,'2024-04-06 17:11:02'),(105,'24-00104',1,'Customer-Andro','N',150.00,150.00,0.00,'Y',NULL,1,'2024-04-07 01:19:24',1,'2024-04-06 17:19:24'),(106,'24-00105',1,'Customer-Ondoy Boro','N',50.00,50.00,0.00,'Y',NULL,1,'2024-04-07 01:31:43',1,'2024-04-06 17:31:43'),(107,'24-00106',1,'Customer-Danny(Utang Pepe)','Y',450.00,0.00,0.00,'Y',NULL,1,'2024-04-07 01:36:06',1,'2024-04-06 17:36:06'),(108,'24-00107',1,'Customer-Mike','N',16.00,16.00,0.00,'Y',NULL,1,'2024-04-07 01:38:32',1,'2024-04-06 17:38:32'),(109,'24-00108',1,'Customer3','N',25.00,25.00,0.00,'Y',NULL,1,'2024-04-07 01:40:18',1,'2024-04-06 17:40:18'),(110,'24-00109',1,'Customer-Butod','N',24.00,26.00,2.00,'Y',NULL,1,'2024-04-07 01:41:56',1,'2024-04-06 17:41:56'),(111,'24-00110',1,'Customer-Crislyn','N',154.00,500.00,346.00,'Y',NULL,1,'2024-04-07 01:47:01',1,'2024-04-06 17:47:01'),(112,'24-00111',1,'Customer-Crislyn','N',6.00,6.00,0.00,'Y',NULL,1,'2024-04-07 01:48:03',1,'2024-04-06 17:48:03'),(113,'24-00112',1,'Customer-Barudo','N',450.00,500.00,50.00,'Y',NULL,1,'2024-04-07 01:50:19',1,'2024-04-06 17:50:19'),(114,'24-00113',1,'Customer-Unknown','N',48.00,50.00,2.00,'Y',NULL,1,'2024-04-07 01:54:25',1,'2024-04-06 17:54:25'),(115,'24-00114',1,'Customer-Barudo','N',16.00,20.00,4.00,'Y',NULL,1,'2024-04-07 01:55:18',1,'2024-04-06 17:55:18'),(116,'24-00115',1,'Customer-Opong','N',16.00,50.00,34.00,'Y',NULL,1,'2024-04-07 01:57:18',1,'2024-04-06 17:57:18'),(117,'24-00116',1,'Customer','N',23.00,23.00,0.00,'Y',NULL,1,'2024-04-07 02:21:39',1,'2024-04-06 18:21:39'),(118,'24-00117',1,'Customer-Barudo','N',198.00,200.00,2.00,'Y',NULL,1,'2024-04-07 02:23:32',1,'2024-04-06 18:23:32'),(119,'24-00118',1,'Customer-Bulantoy','N',150.00,150.00,0.00,'Y',NULL,1,'2024-04-07 02:29:50',1,'2024-04-06 18:29:50'),(120,'24-00119',1,'Customer-Domel','N',150.00,200.00,50.00,'Y',NULL,1,'2024-04-07 02:54:19',1,'2024-04-06 18:54:19'),(121,'24-00120',1,'Customer-Barudo','N',48.00,50.00,2.00,'Y',NULL,1,'2024-04-07 03:02:52',1,'2024-04-06 19:02:52'),(122,'24-00121',1,'Customer-Crislyn-Budoy Aproach','Y',160.00,0.00,0.00,'Y',NULL,1,'2024-04-07 03:04:14',1,'2024-04-06 19:04:14'),(123,'24-00122',1,'Customer-Mike','N',8.00,10.00,2.00,'Y',NULL,1,'2024-04-07 03:04:57',1,'2024-04-06 19:04:57'),(127,'24-00123',2,'Customer','Y',300.00,500.00,200.00,'P',NULL,1,'2024-04-17 10:18:57',1,'2024-05-27 09:00:02'),(128,'24-00124',2,'Customer-Mike','N',500.00,500.00,0.00,'Y',NULL,1,'2024-04-17 10:31:17',1,'2024-04-17 02:31:17'),(129,'24-00125',2,'Customer','N',300.00,500.00,200.00,'Y',NULL,1,'2024-04-17 20:16:18',1,'2024-04-17 12:16:18'),(130,'24-00126',2,'Customer','N',100.00,100.00,0.00,'D','Error pag encode.',1,'2024-04-18 14:08:39',1,'2024-04-18 06:35:21'),(131,'24-00127',2,'Norman','N',450.00,500.00,50.00,'Y',NULL,1,'2024-04-19 12:02:10',1,'2024-04-19 04:02:10'),(132,'24-00128',2,'Customer','N',900.00,950.00,50.00,'P',NULL,1,'2024-04-26 16:30:34',1,'2024-05-27 08:57:36');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `status` char(1) DEFAULT 'Y' COMMENT 'Y = Yes\\\\nN = No\\\\nD = Deleted',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'Bottles','Y',1,'2024-04-05 10:22:42',1,'2024-04-05 02:22:42'),(2,'Pieces','Y',1,'2024-04-05 10:22:42',1,'2024-04-05 02:22:42'),(3,'Packs','Y',1,'2024-04-05 10:22:42',1,'2024-04-05 02:22:59');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y = Yes\nN = No\nD = Deleted',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,'Administrator','Y',1,'2024-04-16 12:49:52',1,'2024-04-16 04:49:52'),(2,'Treasurer','Y',1,'2024-04-16 15:00:31',1,'2024-04-16 07:00:31');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `user_role_id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y = Yes\\\\nN = No\\\\nD = Deleted',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `u_uname` (`username`) /*!80000 INVISIBLE */
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','Admin',1,'admin','b83f6110ff0612b651587aeeb4269e6fa097282780604fd3f2b5f5f7410e0c5ce4f265ee4e6a2a85d66488c5626e24722aafb774d15c1afa554ef92b0782caec','Y',1,'2021-10-20 19:03:57',1,'2024-04-05 00:44:20'),(2,'Normelyn','Claridad',2,'treasurer','5c368d36eb441d1e9de9133137fe20f6f0711c4d0aae179c1f331fd97965ac51e82d2d02f610450b19392cc963037f9ec95fedc514fba34ea3ad66b00ae91c8e','Y',1,'2024-04-16 14:31:11',1,'2024-04-16 07:05:11');
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

-- Dump completed on 2024-05-27 17:18:59
