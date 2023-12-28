-- MySQL dump 10.13  Distrib 8.1.0, for macos13.3 (x86_64)
--
-- Host: localhost    Database: bvet
-- ------------------------------------------------------
-- Server version	8.1.0

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
-- Table structure for table `agenda`
--

DROP TABLE IF EXISTS `agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agenda` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` text,
  `kegiatan` text,
  `lokasi` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda`
--

LOCK TABLES `agenda` WRITE;
/*!40000 ALTER TABLE `agenda` DISABLE KEYS */;
/*!40000 ALTER TABLE `agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alurpelayanan`
--

DROP TABLE IF EXISTS `alurpelayanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alurpelayanan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alurpelayanan`
--

LOCK TABLES `alurpelayanan` WRITE;
/*!40000 ALTER TABLE `alurpelayanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `alurpelayanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alurpersyaratan`
--

DROP TABLE IF EXISTS `alurpersyaratan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alurpersyaratan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `excerpt` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alurpersyaratan`
--

LOCK TABLES `alurpersyaratan` WRITE;
/*!40000 ALTER TABLE `alurpersyaratan` DISABLE KEYS */;
/*!40000 ALTER TABLE `alurpersyaratan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anggaran`
--

DROP TABLE IF EXISTS `anggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anggaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `category` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggaran`
--

LOCK TABLES `anggaran` WRITE;
/*!40000 ALTER TABLE `anggaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `anggaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aplikasi`
--

DROP TABLE IF EXISTS `aplikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aplikasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `layanan` text,
  `link` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aplikasi`
--

LOCK TABLES `aplikasi` WRITE;
/*!40000 ALTER TABLE `aplikasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `aplikasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_groups_users`
--

DROP TABLE IF EXISTS `auth_groups_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_groups_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `group` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_groups_users_user_id_foreign` (`user_id`),
  CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_groups_users`
--

LOCK TABLES `auth_groups_users` WRITE;
/*!40000 ALTER TABLE `auth_groups_users` DISABLE KEYS */;
INSERT INTO `auth_groups_users` VALUES (1,1,'superadmin','2023-12-15 04:36:16');
/*!40000 ALTER TABLE `auth_groups_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_identities`
--

DROP TABLE IF EXISTS `auth_identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_identities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `secret` varchar(255) NOT NULL,
  `secret2` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text,
  `force_reset` tinyint(1) NOT NULL DEFAULT '0',
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_secret` (`type`,`secret`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_identities`
--

LOCK TABLES `auth_identities` WRITE;
/*!40000 ALTER TABLE `auth_identities` DISABLE KEYS */;
INSERT INTO `auth_identities` VALUES (1,1,'email_password',NULL,'kalmndo@gmail.com','$2y$10$hiY8GIYxJr5v3Czs7Ul3s.bITFrWs.Be7jmhoKGvC4fjU8uE2nTBy',NULL,NULL,0,'2023-12-15 05:38:57','2023-12-15 04:36:16','2023-12-15 05:38:57');
/*!40000 ALTER TABLE `auth_identities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_logins`
--

DROP TABLE IF EXISTS `auth_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_logins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type_identifier` (`id_type`,`identifier`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_logins`
--

LOCK TABLES `auth_logins` WRITE;
/*!40000 ALTER TABLE `auth_logins` DISABLE KEYS */;
INSERT INTO `auth_logins` VALUES (1,'::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36','email_password','kalmndo@gmail.com',1,'2023-12-15 05:26:42',1),(2,'::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36','email_password','kalmndo@gmail.com',1,'2023-12-15 05:27:22',1),(3,'::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36','email_password','kalmndo@gmail.com',1,'2023-12-15 05:38:57',1);
/*!40000 ALTER TABLE `auth_logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_permissions_users`
--

DROP TABLE IF EXISTS `auth_permissions_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_permissions_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_permissions_users_user_id_foreign` (`user_id`),
  CONSTRAINT `auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_permissions_users`
--

LOCK TABLES `auth_permissions_users` WRITE;
/*!40000 ALTER TABLE `auth_permissions_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_permissions_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_remember_tokens`
--

DROP TABLE IF EXISTS `auth_remember_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_remember_tokens` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int unsigned NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `auth_remember_tokens_user_id_foreign` (`user_id`),
  CONSTRAINT `auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_remember_tokens`
--

LOCK TABLES `auth_remember_tokens` WRITE;
/*!40000 ALTER TABLE `auth_remember_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_remember_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_token_logins`
--

DROP TABLE IF EXISTS `auth_token_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_token_logins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type_identifier` (`id_type`,`identifier`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_token_logins`
--

LOCK TABLES `auth_token_logins` WRITE;
/*!40000 ALTER TABLE `auth_token_logins` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_token_logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bakteriologi`
--

DROP TABLE IF EXISTS `bakteriologi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bakteriologi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bakteriologi`
--

LOCK TABLES `bakteriologi` WRITE;
/*!40000 ALTER TABLE `bakteriologi` DISABLE KEYS */;
/*!40000 ALTER TABLE `bakteriologi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `berita`
--

DROP TABLE IF EXISTS `berita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `berita` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `excerpt` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `berita`
--

LOCK TABLES `berita` WRITE;
/*!40000 ALTER TABLE `berita` DISABLE KEYS */;
/*!40000 ALTER TABLE `berita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bioteknologi`
--

DROP TABLE IF EXISTS `bioteknologi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bioteknologi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bioteknologi`
--

LOCK TABLES `bioteknologi` WRITE;
/*!40000 ALTER TABLE `bioteknologi` DISABLE KEYS */;
/*!40000 ALTER TABLE `bioteknologi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `excerpt` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datapegawai`
--

DROP TABLE IF EXISTS `datapegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datapegawai` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datapegawai`
--

LOCK TABLES `datapegawai` WRITE;
/*!40000 ALTER TABLE `datapegawai` DISABLE KEYS */;
/*!40000 ALTER TABLE `datapegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `downloads`
--

DROP TABLE IF EXISTS `downloads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `downloads` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `category` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `downloads`
--

LOCK TABLES `downloads` WRITE;
/*!40000 ALTER TABLE `downloads` DISABLE KEYS */;
/*!40000 ALTER TABLE `downloads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epidimiologi`
--

DROP TABLE IF EXISTS `epidimiologi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `epidimiologi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epidimiologi`
--

LOCK TABLES `epidimiologi` WRITE;
/*!40000 ALTER TABLE `epidimiologi` DISABLE KEYS */;
/*!40000 ALTER TABLE `epidimiologi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `externallink`
--

DROP TABLE IF EXISTS `externallink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `externallink` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `instansi` text,
  `alamat` text,
  `link` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `externallink`
--

LOCK TABLES `externallink` WRITE;
/*!40000 ALTER TABLE `externallink` DISABLE KEYS */;
/*!40000 ALTER TABLE `externallink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formikm`
--

DROP TABLE IF EXISTS `formikm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formikm` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formikm`
--

LOCK TABLES `formikm` WRITE;
/*!40000 ALTER TABLE `formikm` DISABLE KEYS */;
/*!40000 ALTER TABLE `formikm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `file` text,
  `type` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `file` text,
  `type` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informasiberkala`
--

DROP TABLE IF EXISTS `informasiberkala`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `informasiberkala` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `category` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informasiberkala`
--

LOCK TABLES `informasiberkala` WRITE;
/*!40000 ALTER TABLE `informasiberkala` DISABLE KEYS */;
/*!40000 ALTER TABLE `informasiberkala` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informasiserta`
--

DROP TABLE IF EXISTS `informasiserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `informasiserta` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `category` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informasiserta`
--

LOCK TABLES `informasiserta` WRITE;
/*!40000 ALTER TABLE `informasiserta` DISABLE KEYS */;
/*!40000 ALTER TABLE `informasiserta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informasisetiap`
--

DROP TABLE IF EXISTS `informasisetiap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `informasisetiap` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `category` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informasisetiap`
--

LOCK TABLES `informasisetiap` WRITE;
/*!40000 ALTER TABLE `informasisetiap` DISABLE KEYS */;
/*!40000 ALTER TABLE `informasisetiap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instalasi`
--

DROP TABLE IF EXISTS `instalasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instalasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instalasi`
--

LOCK TABLES `instalasi` WRITE;
/*!40000 ALTER TABLE `instalasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `instalasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `internallink`
--

DROP TABLE IF EXISTS `internallink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `internallink` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `instansi` text,
  `alamat` text,
  `link` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `internallink`
--

LOCK TABLES `internallink` WRITE;
/*!40000 ALTER TABLE `internallink` DISABLE KEYS */;
/*!40000 ALTER TABLE `internallink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kebijakanmutu`
--

DROP TABLE IF EXISTS `kebijakanmutu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kebijakanmutu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kebijakanmutu`
--

LOCK TABLES `kebijakanmutu` WRITE;
/*!40000 ALTER TABLE `kebijakanmutu` DISABLE KEYS */;
/*!40000 ALTER TABLE `kebijakanmutu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kemavet`
--

DROP TABLE IF EXISTS `kemavet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kemavet` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kemavet`
--

LOCK TABLES `kemavet` WRITE;
/*!40000 ALTER TABLE `kemavet` DISABLE KEYS */;
/*!40000 ALTER TABLE `kemavet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kinerja`
--

DROP TABLE IF EXISTS `kinerja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kinerja` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `category` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kinerja`
--

LOCK TABLES `kinerja` WRITE;
/*!40000 ALTER TABLE `kinerja` DISABLE KEYS */;
/*!40000 ALTER TABLE `kinerja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `komitmenbersama`
--

DROP TABLE IF EXISTS `komitmenbersama`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `komitmenbersama` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `komitmenbersama`
--

LOCK TABLES `komitmenbersama` WRITE;
/*!40000 ALTER TABLE `komitmenbersama` DISABLE KEYS */;
/*!40000 ALTER TABLE `komitmenbersama` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `komitmenketerbukaan`
--

DROP TABLE IF EXISTS `komitmenketerbukaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `komitmenketerbukaan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `komitmenketerbukaan`
--

LOCK TABLES `komitmenketerbukaan` WRITE;
/*!40000 ALTER TABLE `komitmenketerbukaan` DISABLE KEYS */;
/*!40000 ALTER TABLE `komitmenketerbukaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporanikm`
--

DROP TABLE IF EXISTS `laporanikm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporanikm` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporanikm`
--

LOCK TABLES `laporanikm` WRITE;
/*!40000 ALTER TABLE `laporanikm` DISABLE KEYS */;
/*!40000 ALTER TABLE `laporanikm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layananppid`
--

DROP TABLE IF EXISTS `layananppid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `layananppid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `layanan` text,
  `link` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layananppid`
--

LOCK TABLES `layananppid` WRITE;
/*!40000 ALTER TABLE `layananppid` DISABLE KEYS */;
/*!40000 ALTER TABLE `layananppid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maklumatpelayanan`
--

DROP TABLE IF EXISTS `maklumatpelayanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maklumatpelayanan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maklumatpelayanan`
--

LOCK TABLES `maklumatpelayanan` WRITE;
/*!40000 ALTER TABLE `maklumatpelayanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `maklumatpelayanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mekanismepengaduan`
--

DROP TABLE IF EXISTS `mekanismepengaduan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mekanismepengaduan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `excerpt` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mekanismepengaduan`
--

LOCK TABLES `mekanismepengaduan` WRITE;
/*!40000 ALTER TABLE `mekanismepengaduan` DISABLE KEYS */;
/*!40000 ALTER TABLE `mekanismepengaduan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meta_info`
--

DROP TABLE IF EXISTS `meta_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meta_info` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `resource_id` int unsigned NOT NULL,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meta_info`
--

LOCK TABLES `meta_info` WRITE;
/*!40000 ALTER TABLE `meta_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `meta_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2020-12-28-223112','CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables','default','CodeIgniter\\Shield',1702614936,1),(2,'2021-07-04-041948','CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable','default','CodeIgniter\\Settings',1702614936,1),(3,'2021-09-04-044800','App\\Database\\Migrations\\AdditionalUserFields','default','Bonfire\\{Users}',1702614936,1),(4,'2021-10-05-040656','App\\Database\\Migrations\\CreateMetaTable','default','Bonfire\\{Users}',1702614936,1),(5,'2021-11-14-143905','CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn','default','CodeIgniter\\Settings',1702614936,1),(6,'2023-04-30-101748','App\\Modules\\Blogs\\Database\\Migrations\\CreateBlogsTable','default','App\\Modules\\{Blogs}',1702614936,1),(7,'2023-04-30-101748','App\\Modules\\Downloads\\Database\\Migrations\\CreateDownloadsTable','default','App\\Modules\\{Downloads}',1702614936,1),(8,'2023-04-30-101748','App\\Modules\\Galleries\\Database\\Migrations\\CreateGalleriesTable','default','App\\Modules\\{Galleries}',1702614936,1),(9,'2023-04-30-101748','App\\Modules\\Informasi\\Aplikasi\\Database\\Migrations\\CreateAplikasiTable','default','App\\Modules\\Informasi\\{Aplikasi}',1702614936,1),(10,'2023-04-30-101748','App\\Modules\\Informasi\\LayananPpid\\Database\\Migrations\\CreateLayananPpidTable','default','App\\Modules\\Informasi\\{LayananPpid}',1702614936,1),(11,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\Agenda\\Database\\Migrations\\CreateAgendaTable','default','App\\Modules\\Informasi\\Umum\\{Agenda}',1702614936,1),(12,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\Berita\\Database\\Migrations\\CreateBeritaTable','default','App\\Modules\\Informasi\\Umum\\{Berita}',1702614936,1),(13,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\ExternalLink\\Database\\Migrations\\CreateExternalLinkTable','default','App\\Modules\\Informasi\\Umum\\{ExternalLink}',1702614936,1),(14,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\Gallery\\Database\\Migrations\\CreateGalleryTable','default','App\\Modules\\Informasi\\Umum\\{Gallery}',1702614936,1),(15,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\InternalLink\\Database\\Migrations\\CreateInternalLinkTable','default','App\\Modules\\Informasi\\Umum\\{InternalLink}',1702614936,1),(16,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\Pelayanan\\Database\\Migrations\\CreatePelayananTable','default','App\\Modules\\Informasi\\Umum\\{Pelayanan}',1702614936,1),(17,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\Pengumuman\\Database\\Migrations\\CreatePengumumanTable','default','App\\Modules\\Informasi\\Umum\\{Pengumuman}',1702614936,1),(18,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\Publikasi\\Database\\Migrations\\CreatePublikasiTable','default','App\\Modules\\Informasi\\Umum\\{Publikasi}',1702614936,1),(19,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\Sop\\Database\\Migrations\\CreateSopTable','default','App\\Modules\\Informasi\\Umum\\{Sop}',1702614936,1),(20,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\StandarMutu\\Database\\Migrations\\CreateStandarMutuTable','default','App\\Modules\\Profile\\Instansi\\{StandarMutu}',1702614936,1),(21,'2023-04-30-101748','App\\Modules\\Informasi\\Umum\\StandarPelayanan\\Database\\Migrations\\CreateStandarPelayananTable','default','App\\Modules\\Informasi\\Umum\\{StandarPelayanan}',1702614936,1),(22,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\AlurPersyaratan\\Database\\Migrations\\CreateAlurPersyaratanTable','default','App\\Modules\\Informasi\\Veteriner\\{AlurPersyaratan}',1702614936,1),(23,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\FormIkm\\Database\\Migrations\\CreateFormIkmTable','default','App\\Modules\\Informasi\\Veteriner\\{FormIkm}',1702614936,1),(24,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\InformasiBerkala\\Database\\Migrations\\CreateInformasiBerkalaTable','default','App\\Modules\\Informasi\\Veteriner\\{InformasiBerkala}',1702614936,1),(25,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\InformasiSerta\\Database\\Migrations\\CreateInformasiSertaTable','default','App\\Modules\\Informasi\\Veteriner\\{InformasiSerta}',1702614936,1),(26,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\InformasiSetiap\\Database\\Migrations\\CreateInformasiSetiapTable','default','App\\Modules\\Informasi\\Veteriner\\{InformasiSetiap}',1702614936,1),(27,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\LaporanIkm\\Database\\Migrations\\CreateLaporanIkmTable','default','App\\Modules\\Informasi\\Veteriner\\{LaporanIkm}',1702614936,1),(28,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\MekanismePengaduan\\Database\\Migrations\\CreateMekanismePengaduanTable','default','App\\Modules\\Informasi\\Veteriner\\{MekanismePengaduan}',1702614936,1),(29,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\PantauPenyakit\\Database\\Migrations\\CreatePantauPenyakitTable','default','App\\Modules\\Informasi\\Veteriner\\{PantauPenyakit}',1702614936,1),(30,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\PengaduanMasyarakat\\Database\\Migrations\\CreatePengaduanMasyarakatTable','default','App\\Modules\\Informasi\\Veteriner\\{PengaduanMasyarakat}',1702614936,1),(31,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\PustakaOnline\\Database\\Migrations\\CreatePustakaOnlineTable','default','App\\Modules\\Informasi\\Veteriner\\{PustakaOnline}',1702614936,1),(32,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\SertifikatHasil\\Database\\Migrations\\CreateSertifikatHasilTable','default','App\\Modules\\Informasi\\Veteriner\\{SertifikatHasil}',1702614936,1),(33,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\TarifPengujian\\Database\\Migrations\\CreateTarifPengujianTable','default','App\\Modules\\Informasi\\Veteriner\\{TarifPengujian}',1702614936,1),(34,'2023-04-30-101748','App\\Modules\\Informasi\\Veteriner\\TataCara\\Database\\Migrations\\CreateTataCaraTable','default','App\\Modules\\Informasi\\Veteriner\\{TataCara}',1702614936,1),(35,'2023-04-30-101748','App\\Modules\\Kinerja\\Database\\Migrations\\CreateKinerjaTable','default','App\\Modules\\{Kinerja}',1702614936,1),(36,'2023-04-30-101748','App\\Modules\\Pages\\Database\\Migrations\\CreatePagesTable','default','App\\Modules\\{Pages}',1702614936,1),(37,'2023-04-30-101748','App\\Modules\\Profile\\Instansi\\AlurPelayanan\\Database\\Migrations\\CreateAlurPelayananTable','default','App\\Modules\\Profile\\Instansi\\{AlurPelayanan}',1702614936,1),(38,'2023-04-30-101748','App\\Modules\\Profile\\Instansi\\KebijakanMutu\\Database\\Migrations\\CreateKebijakanMutuTable','default','App\\Modules\\Profile\\Instansi\\{KebijakanMutu}',1702614936,1),(39,'2023-04-30-101748','App\\Modules\\Profile\\Instansi\\KomitmenBersama\\Database\\Migrations\\CreateKomitmenBersamaTable','default','App\\Modules\\Profile\\Instansi\\{KomitmenBersama}',1702614936,1),(40,'2023-04-30-101748','App\\Modules\\Profile\\Instansi\\KomitmenKeterbukaan\\Database\\Migrations\\CreateKomitmenKeterbukaanTable','default','App\\Modules\\Profile\\Instansi\\{KomitmenKeterbukaan}',1702614936,1),(41,'2023-04-30-101748','App\\Modules\\Profile\\Instansi\\MaklumatPelayanan\\Database\\Migrations\\CreateMaklumatPelayananTable','default','App\\Modules\\Profile\\Instansi\\{MaklumatPelayanan}',1702614936,1),(42,'2023-04-30-101748','App\\Modules\\Profile\\Instansi\\Motto\\Database\\Migrations\\CreateMottoTable','default','App\\Modules\\Profile\\Instansi\\{Motto}',1702614936,1),(43,'2023-04-30-101748','App\\Modules\\Profile\\Instansi\\Prestasi\\Database\\Migrations\\CreatePrestasiTable','default','App\\Modules\\Profile\\Instansi\\{Prestasi}',1702614936,1),(44,'2023-04-30-101748','App\\Modules\\Profile\\Instansi\\Sejarah\\Database\\Migrations\\CreateSejarahTable','default','App\\Modules\\Profile\\Instansi\\{Sejarah}',1702614936,1),(45,'2023-04-30-101748','App\\Modules\\Profile\\Instansi\\Tupoksi\\Database\\Migrations\\CreateTupoksiTable','default','App\\Modules\\Profile\\Instansi\\{Tupoksi}',1702614936,1),(46,'2023-04-30-101748','App\\Modules\\Profile\\Instansi\\VisiMisi\\Database\\Migrations\\CreateVisiMisiTable','default','App\\Modules\\Profile\\Instansi\\{VisiMisi}',1702614936,1),(47,'2023-04-30-101748','App\\Modules\\Profile\\Laboratorium\\Bakteriologi\\Database\\Migrations\\CreateBakteriologiTable','default','App\\Modules\\Profile\\Laboratorium\\{Bakteriologi}',1702614936,1),(48,'2023-04-30-101748','App\\Modules\\Profile\\Laboratorium\\Bioteknologi\\Database\\Migrations\\CreateBioteknologiTable','default','App\\Modules\\Profile\\Laboratorium\\{Bioteknologi}',1702614936,1),(49,'2023-04-30-101748','App\\Modules\\Profile\\Laboratorium\\Epidimiologi\\Database\\Migrations\\CreateEpidimiologiTable','default','App\\Modules\\Profile\\Laboratorium\\{Epidimiologi}',1702614936,1),(50,'2023-04-30-101748','App\\Modules\\Profile\\Laboratorium\\Instalasi\\Database\\Migrations\\CreateInstalasiTable','default','App\\Modules\\Profile\\Laboratorium\\{Instalasi}',1702614936,1),(51,'2023-04-30-101748','App\\Modules\\Profile\\Laboratorium\\Kemavet\\Database\\Migrations\\CreateKemavetTable','default','App\\Modules\\Profile\\Laboratorium\\{Kemavet}',1702614937,1),(52,'2023-04-30-101748','App\\Modules\\Profile\\Laboratorium\\Parasitologi\\Database\\Migrations\\CreateParasitologiTable','default','App\\Modules\\Profile\\Laboratorium\\{Parasitologi}',1702614937,1),(53,'2023-04-30-101748','App\\Modules\\Profile\\Laboratorium\\Patologi\\Database\\Migrations\\CreatePatologiTable','default','App\\Modules\\Profile\\Laboratorium\\{Patologi}',1702614937,1),(54,'2023-04-30-101748','App\\Modules\\Profile\\Laboratorium\\Virologi\\Database\\Migrations\\CreateVirologiTable','default','App\\Modules\\Profile\\Laboratorium\\{Virologi}',1702614937,1),(55,'2023-04-30-101748','App\\Modules\\Profile\\SDM\\DataPegawai\\Database\\Migrations\\CreateDataPegawaiTable','default','App\\Modules\\Profile\\SDM\\{DataPegawai}',1702614937,1),(56,'2023-04-30-101748','App\\Modules\\Profile\\SDM\\PejabatStruktural\\Database\\Migrations\\CreatePejabatStrukturalTable','default','App\\Modules\\Profile\\SDM\\{PejabatStruktural}',1702614937,1),(57,'2023-04-30-101748','App\\Modules\\Profile\\SDM\\StrukturOrganisasi\\Database\\Migrations\\CreateStrukturOrganisasiTable','default','App\\Modules\\Profile\\SDM\\{StrukturOrganisasi}',1702614937,1),(58,'2023-04-30-101748','App\\Modules\\Program\\Anggaran\\Database\\Migrations\\CreateAnggaranTable','default','App\\Modules\\Program\\{Anggaran}',1702614937,1),(59,'2023-04-30-101748','App\\Modules\\Program\\RencanaKerja\\Database\\Migrations\\CreateRencanaKerjaTable','default','App\\Modules\\Program\\{RencanaKerja}',1702614937,1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motto`
--

DROP TABLE IF EXISTS `motto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `motto` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motto`
--

LOCK TABLES `motto` WRITE;
/*!40000 ALTER TABLE `motto` DISABLE KEYS */;
/*!40000 ALTER TABLE `motto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pantaupenyakit`
--

DROP TABLE IF EXISTS `pantaupenyakit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pantaupenyakit` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pantaupenyakit`
--

LOCK TABLES `pantaupenyakit` WRITE;
/*!40000 ALTER TABLE `pantaupenyakit` DISABLE KEYS */;
/*!40000 ALTER TABLE `pantaupenyakit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parasitologi`
--

DROP TABLE IF EXISTS `parasitologi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parasitologi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parasitologi`
--

LOCK TABLES `parasitologi` WRITE;
/*!40000 ALTER TABLE `parasitologi` DISABLE KEYS */;
/*!40000 ALTER TABLE `parasitologi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patologi`
--

DROP TABLE IF EXISTS `patologi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patologi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patologi`
--

LOCK TABLES `patologi` WRITE;
/*!40000 ALTER TABLE `patologi` DISABLE KEYS */;
/*!40000 ALTER TABLE `patologi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pejabatstruktural`
--

DROP TABLE IF EXISTS `pejabatstruktural`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pejabatstruktural` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pejabatstruktural`
--

LOCK TABLES `pejabatstruktural` WRITE;
/*!40000 ALTER TABLE `pejabatstruktural` DISABLE KEYS */;
/*!40000 ALTER TABLE `pejabatstruktural` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pelayanan`
--

DROP TABLE IF EXISTS `pelayanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pelayanan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `excerpt` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelayanan`
--

LOCK TABLES `pelayanan` WRITE;
/*!40000 ALTER TABLE `pelayanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pelayanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaduanmasyarakat`
--

DROP TABLE IF EXISTS `pengaduanmasyarakat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaduanmasyarakat` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaduanmasyarakat`
--

LOCK TABLES `pengaduanmasyarakat` WRITE;
/*!40000 ALTER TABLE `pengaduanmasyarakat` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengaduanmasyarakat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengumuman`
--

DROP TABLE IF EXISTS `pengumuman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengumuman` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `excerpt` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengumuman`
--

LOCK TABLES `pengumuman` WRITE;
/*!40000 ALTER TABLE `pengumuman` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengumuman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestasi`
--

DROP TABLE IF EXISTS `prestasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestasi`
--

LOCK TABLES `prestasi` WRITE;
/*!40000 ALTER TABLE `prestasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publikasi`
--

DROP TABLE IF EXISTS `publikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publikasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `category` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publikasi`
--

LOCK TABLES `publikasi` WRITE;
/*!40000 ALTER TABLE `publikasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `publikasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pustakaonline`
--

DROP TABLE IF EXISTS `pustakaonline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pustakaonline` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pustakaonline`
--

LOCK TABLES `pustakaonline` WRITE;
/*!40000 ALTER TABLE `pustakaonline` DISABLE KEYS */;
/*!40000 ALTER TABLE `pustakaonline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rencanakerja`
--

DROP TABLE IF EXISTS `rencanakerja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rencanakerja` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `category` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rencanakerja`
--

LOCK TABLES `rencanakerja` WRITE;
/*!40000 ALTER TABLE `rencanakerja` DISABLE KEYS */;
/*!40000 ALTER TABLE `rencanakerja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejarah`
--

DROP TABLE IF EXISTS `sejarah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sejarah` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sejarah`
--

LOCK TABLES `sejarah` WRITE;
/*!40000 ALTER TABLE `sejarah` DISABLE KEYS */;
INSERT INTO `sejarah` VALUES (1,'Sejarah','<p>anjing</p>','2023-12-15 06:52:38','2023-12-15 06:52:38');
/*!40000 ALTER TABLE `sejarah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sertifikathasil`
--

DROP TABLE IF EXISTS `sertifikathasil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sertifikathasil` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sertifikathasil`
--

LOCK TABLES `sertifikathasil` WRITE;
/*!40000 ALTER TABLE `sertifikathasil` DISABLE KEYS */;
/*!40000 ALTER TABLE `sertifikathasil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'Config\\Auth','allowRegistration','0','boolean',NULL,'2023-12-15 05:27:07','2023-12-15 05:27:07'),(2,'Config\\Auth','minimumPasswordLength','8','integer',NULL,'2023-12-15 05:27:07','2023-12-15 05:27:07'),(3,'Config\\Auth','passwordValidators','a:3:{i:0;s:64:\"CodeIgniter\\Shield\\Authentication\\Passwords\\CompositionValidator\";i:1;s:68:\"CodeIgniter\\Shield\\Authentication\\Passwords\\NothingPersonalValidator\";i:2;s:63:\"CodeIgniter\\Shield\\Authentication\\Passwords\\DictionaryValidator\";}','array',NULL,'2023-12-15 05:27:07','2023-12-15 05:27:07'),(4,'Config\\AuthGroups','defaultGroup','user','string',NULL,'2023-12-15 05:27:07','2023-12-15 05:27:07'),(5,'Config\\Auth','actions','a:2:{s:8:\"register\";N;s:5:\"login\";N;}','array',NULL,'2023-12-15 05:27:07','2023-12-15 05:27:07'),(6,'Config\\Auth','sessionConfig','a:4:{s:5:\"field\";s:9:\"logged_in\";s:16:\"allowRemembering\";s:1:\"1\";s:18:\"rememberCookieName\";s:8:\"remember\";s:14:\"rememberLength\";s:1:\"0\";}','array',NULL,'2023-12-15 05:27:07','2023-12-15 05:27:07'),(7,'Config\\Users','useGravatar','0','boolean',NULL,'2023-12-15 05:27:07','2023-12-15 05:27:07'),(8,'Config\\Users','gravatarDefault','blank','string',NULL,'2023-12-15 05:27:07','2023-12-15 05:27:07'),(9,'Config\\Users','avatarNameBasis','name','string',NULL,'2023-12-15 05:27:07','2023-12-15 05:27:07'),(10,'Config\\Users','avatarResize','0','boolean',NULL,'2023-12-15 05:27:07','2023-12-15 05:27:07');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sop`
--

DROP TABLE IF EXISTS `sop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sop` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sop`
--

LOCK TABLES `sop` WRITE;
/*!40000 ALTER TABLE `sop` DISABLE KEYS */;
/*!40000 ALTER TABLE `sop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `standarmutu`
--

DROP TABLE IF EXISTS `standarmutu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `standarmutu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `file` text,
  `type` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `standarmutu`
--

LOCK TABLES `standarmutu` WRITE;
/*!40000 ALTER TABLE `standarmutu` DISABLE KEYS */;
INSERT INTO `standarmutu` VALUES (1,'asdfasdfasd','uploads/1702615200_3461b3ee18352c7cd919.jpeg','IMAGE','2023-12-15 04:40:00','2023-12-15 04:40:00',NULL);
/*!40000 ALTER TABLE `standarmutu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `standarpelayanan`
--

DROP TABLE IF EXISTS `standarpelayanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `standarpelayanan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text,
  `file` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `standarpelayanan`
--

LOCK TABLES `standarpelayanan` WRITE;
/*!40000 ALTER TABLE `standarpelayanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `standarpelayanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `strukturorganisasi`
--

DROP TABLE IF EXISTS `strukturorganisasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `strukturorganisasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `strukturorganisasi`
--

LOCK TABLES `strukturorganisasi` WRITE;
/*!40000 ALTER TABLE `strukturorganisasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `strukturorganisasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarifpengujian`
--

DROP TABLE IF EXISTS `tarifpengujian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tarifpengujian` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `excerpt` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarifpengujian`
--

LOCK TABLES `tarifpengujian` WRITE;
/*!40000 ALTER TABLE `tarifpengujian` DISABLE KEYS */;
/*!40000 ALTER TABLE `tarifpengujian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tatacara`
--

DROP TABLE IF EXISTS `tatacara`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tatacara` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `excerpt` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tatacara`
--

LOCK TABLES `tatacara` WRITE;
/*!40000 ALTER TABLE `tatacara` DISABLE KEYS */;
/*!40000 ALTER TABLE `tatacara` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tupoksi`
--

DROP TABLE IF EXISTS `tupoksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tupoksi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tupoksi`
--

LOCK TABLES `tupoksi` WRITE;
/*!40000 ALTER TABLE `tupoksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `tupoksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'kalmndo@gmail.com','adm','kalamondo',NULL,NULL,NULL,1,'2023-12-15 06:52:38','2023-12-15 04:36:16','2023-12-15 04:36:16',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `virologi`
--

DROP TABLE IF EXISTS `virologi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `virologi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `virologi`
--

LOCK TABLES `virologi` WRITE;
/*!40000 ALTER TABLE `virologi` DISABLE KEYS */;
/*!40000 ALTER TABLE `virologi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visimisi`
--

DROP TABLE IF EXISTS `visimisi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visimisi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visimisi`
--

LOCK TABLES `visimisi` WRITE;
/*!40000 ALTER TABLE `visimisi` DISABLE KEYS */;
/*!40000 ALTER TABLE `visimisi` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-15 19:31:10
