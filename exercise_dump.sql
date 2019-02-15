# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17)
# Database: mindarc_assessment
# Generation Time: 2019-02-15 14:20:50 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table migrated_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrated_data`;

CREATE TABLE `migrated_data` (
  `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `image_url` varchar(255) DEFAULT '',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `migrated_data` WRITE;
/*!40000 ALTER TABLE `migrated_data` DISABLE KEYS */;

INSERT INTO `migrated_data` (`product_id`, `sku`, `name`, `image_url`)
VALUES
	(1,'men_red_shirt','Mens Red Shirt',''),
	(2,'women_red_blouse','Womens Red Blouse','1550240237_4.jpeg'),
	(3,'men_blue_shorts','Mens Blue Shorts',''),
	(4,'women_blue_skirt','Womens Blue Skirt',''),
	(5,'women_rainbow_singlet','Singlet in Rainbow Colours',''),
	(6,'women_sun_one','Aviator Sunglasses',''),
	(7,'women_gold_neck','Gold Necklace Chain',''),
	(8,'women_iph_case','Iphone Case pink',''),
	(9,'men_sam_case','Samsung Case Skulls',''),
	(10,'men_black_shirt','AC/DC Shirt','');

/*!40000 ALTER TABLE `migrated_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table original_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `original_data`;

CREATE TABLE `original_data` (
  `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_code` varchar(50) NOT NULL DEFAULT '',
  `product_label` varchar(255) NOT NULL DEFAULT '',
  `gender` varchar(255) DEFAULT '',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `original_data` WRITE;
/*!40000 ALTER TABLE `original_data` DISABLE KEYS */;

INSERT INTO `original_data` (`product_id`, `product_code`, `product_label`, `gender`)
VALUES
	(1,'red_shirt','Mens Red Shirt','m'),
	(2,'red_blouse','Womens Red Blouse','f'),
	(3,'blue_shorts','Mens Blue Shorts','m'),
	(4,'blue_skirt','Womens Blue Skirt','f'),
	(5,'rainbow_singlet','Singlet in Rainbow Colours','v'),
	(6,'sun_one','Aviator Sunglasses','f'),
	(7,'gold_neck','Gold Necklace Chain',''),
	(8,'iph_case','Iphone Case pink',' F'),
	(9,'sam_case','Samsung Case Skulls','M'),
	(10,'black_shirt','AC/DC Shirt','m');

/*!40000 ALTER TABLE `original_data` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
