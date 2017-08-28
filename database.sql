-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: useless
-- ------------------------------------------------------
-- Server version	5.6.26-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currencies` (
  `id`            INT(10) UNSIGNED       NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(20)            NOT NULL,
  `sign`          CHAR(1)                NOT NULL,
  `exchange_rate` DECIMAL(4, 2) UNSIGNED NOT NULL
  COMMENT 'Exchange rate to default Bitcoin currency (USD)',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies`
  DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1, 'USD', '$', 1.00), (2, 'EUR', '€', 0.84), (3, 'RUB', '₽', 58.58);
/*!40000 ALTER TABLE `currencies`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offers` (
  `id`                INT(10) UNSIGNED       NOT NULL AUTO_INCREMENT,
  `player_id`         INT(10) UNSIGNED       NOT NULL,
  `type`              ENUM ('0', '1')        NOT NULL,
  `payment_method_id` INT(10) UNSIGNED       NOT NULL,
  `currency_id`       INT(10) UNSIGNED       NOT NULL,
  `amount_min`        DECIMAL(7, 2) UNSIGNED NOT NULL,
  `amount_max`        DECIMAL(7, 2) UNSIGNED NOT NULL,
  `margin`            FLOAT UNSIGNED         NOT NULL,
  `disabled`          TINYINT(1)             NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk-offers_pm_id-pm_idx` (`payment_method_id`),
  KEY `fk_currency_id-currencies_idx` (`currency_id`),
  KEY `fk-player_id-players_idx` (`player_id`),
  CONSTRAINT `fk-currency_id-currencies` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk-offers_pm_id-pm` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk-player_id-players` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 10
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offers`
--

LOCK TABLES `offers` WRITE;
/*!40000 ALTER TABLE `offers`
  DISABLE KEYS */;
INSERT INTO `offers` VALUES (8, 3, '1', 36, 2, 100.00, 500.00, 10.1, 0), (9, 3, '0', 48, 1, 1.00, 100.00, 9, 0);
/*!40000 ALTER TABLE `offers`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_method_groups`
--

DROP TABLE IF EXISTS `payment_method_groups`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_method_groups` (
  `id`   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100)     NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 5
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_method_groups`
--

LOCK TABLES `payment_method_groups` WRITE;
/*!40000 ALTER TABLE `payment_method_groups`
  DISABLE KEYS */;
INSERT INTO `payment_method_groups` VALUES (1, 'Group 1'), (2, 'Group 2'), (3, 'Group 3'), (4, 'Group4');
/*!40000 ALTER TABLE `payment_method_groups`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id`       INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`     VARCHAR(55)      NOT NULL,
  `group_id` INT(11) UNSIGNED          DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-pm_method_group-pm_method_groups_id_idx` (`group_id`),
  CONSTRAINT `fk-pm_method_group-pm_method_groups_id` FOREIGN KEY (`group_id`) REFERENCES `payment_method_groups` (`id`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 54
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods`
  DISABLE KEYS */;
INSERT INTO `payment_methods`
VALUES (1, 'nnbrikeq', 3), (2, 'fdcbxnse', 3), (3, 'uarkvcuv', 3), (4, 'fsbayrpa', 2), (5, 'alfplkpw', 3),
  (6, 'ljlfswht', 4), (7, 'jbbesdmb', 3), (8, 'rdomsfvo', 2), (9, 'pgiywlqw', 2), (10, 'rxrnruwa', 2),
  (11, 'fruznsxl', 3), (12, 'ixswhrpz', 1), (13, 'qucyoyco', 3), (14, 'hrlftepk', 2), (15, 'thdvrzxo', 1),
  (16, 'mjinqpdw', 4), (17, 'xvkoqkfr', 4), (18, 'mrwmqudd', 2), (19, 'impljors', 3), (20, 'sxljmieu', 3),
  (21, 'flqvidpq', 2), (22, 'hevrzvhx', 3), (23, 'cavddemz', 2), (24, 'fuhbinrv', 1), (25, 'xlikauaq', 2),
  (26, 'fjdqsslb', 4), (27, 'egsvcxjb', 1), (28, 'kpwrqghq', 2), (29, 'ftguhzdo', 3), (30, 'vsdlwboq', 3),
  (31, 'cptxjber', 4), (32, 'mtgbmhwr', 3), (33, 'kynukqbh', 2), (34, 'lneieuol', 2), (35, 'ddfsxoyc', 2),
  (36, 'hvltikbb', 1), (37, 'cijwhufp', 2), (38, 'ijspvjhk', 1), (39, 'fsdiiovn', 2), (40, 'hwocvxbm', 2),
  (41, 'uhywrqfd', 1), (42, 'uyivcymo', 2), (43, 'bfukqbik', 1), (44, 'wjgctlyl', 2), (45, 'qywocsjq', 1),
  (46, 'nicmdcdj', 2), (47, 'vbqewyfb', 3), (48, 'geapyyxr', 3), (49, 'jspwocsj', 3), (50, 'fyhmnfnx', 1),
  (51, 'wxybjqfa', 3), (52, 'ltkrggki', 2), (53, 'difecbxk', 2);
/*!40000 ALTER TABLE `payment_methods`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `players` (
  `id`              INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email`           VARCHAR(200)     NOT NULL,
  `full_name`       VARCHAR(60)      NOT NULL,
  `password`        VARCHAR(60)      NOT NULL,
  `current_balance` DECIMAL(12, 8)   NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 5
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `players`
--

LOCK TABLES `players` WRITE;
/*!40000 ALTER TABLE `players`
  DISABLE KEYS */;
INSERT INTO `players`
VALUES (3, 'gta4kv@gmail.com', 'Danny1', '$2y$10$2VQf9SENI1zs6DUb6bRYw.XfOzZd0NvZk2WkAXED/Zltt/Lb6vxcG', 5.00000000),
  (4, 't@t.ru', 'asd', '$2y$10$swPe.bWJpKFxmT52qRt/E.H9FXAk5na0yTnUM5AOp9i90Kc4kpvk2', 5.00000000);
/*!40000 ALTER TABLE `players`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trades`
--

DROP TABLE IF EXISTS `trades`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trades` (
  `id`             INT(10) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `offer_id`       INT(10) UNSIGNED        NOT NULL,
  `player_id`      INT(10) UNSIGNED        NOT NULL,
  `partner_id`     INT(10) UNSIGNED        NOT NULL,
  `amount_fiat`    DECIMAL(7, 2) UNSIGNED  NOT NULL,
  `amount_bitcoin` DECIMAL(12, 8) UNSIGNED NOT NULL,
  `created_at`     DATETIME                         DEFAULT CURRENT_TIMESTAMP,
  `status`         VARCHAR(20)                      DEFAULT 'created',
  PRIMARY KEY (`id`),
  KEY `fk-trades_players-id_idx` (`player_id`),
  KEY `fk-trades_offers-id_idx` (`offer_id`),
  KEY `fk-trades-players-partner-id_idx` (`partner_id`),
  CONSTRAINT `fk-trades-players-partner-id` FOREIGN KEY (`partner_id`) REFERENCES `players` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk-trades_offers-id` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk-trades_players-id` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trades`
--

LOCK TABLES `trades` WRITE;
/*!40000 ALTER TABLE `trades`
  DISABLE KEYS */;
INSERT INTO `trades` VALUES (1, 8, 4, 3, 298.00, 100.00000000, '2017-08-28 03:00:39', 'created');
/*!40000 ALTER TABLE `trades`
  ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2017-08-28 14:37:12
