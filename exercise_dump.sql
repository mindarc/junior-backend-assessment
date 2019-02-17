-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 17, 2019 at 08:53 PM
-- Server version: 10.1.29-MariaDB-6ubuntu2
-- PHP Version: 7.2.15-0ubuntu0.18.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mindarc_assessment`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrated_data`
--

CREATE TABLE `migrated_data` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(50) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
   PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migrated_data`
--

INSERT INTO `migrated_data` (`product_id`, `sku`, `name`, `image_url`) VALUES
(1, 'men_red_shirt', 'Mens Red Shirt', NULL),
(2, 'women_red_blouse', 'Womens Red Blouse', NULL),
(3, 'men_blue_shorts', 'Mens Blue Shorts', NULL),
(4, 'women_blue_skirt', 'Womens Blue Skirt', NULL),
(5, 'women_rainbow_singlet', 'Singlet in Rainbow Colours', NULL),
(6, 'women_sun_one', 'Aviator Sunglasses', NULL),
(7, 'women_gold_neck', 'Gold Necklace Chain', './media/1550397599_download.jpeg'),
(8, 'women_iph_case', 'Iphone Case pink', NULL),
(9, 'men_sam_case', 'Samsung Case Skulls', NULL),
(10, 'men_black_shirt', 'AC/DC Shirt', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `original_data`
--

CREATE TABLE `original_data` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `product_label` varchar(255) CHARACTER SET utf8 NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
   PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `original_data`
--

INSERT INTO `original_data` (`product_id`, `product_code`, `product_label`, `gender`) VALUES
(1, 'red_shirt', 'Mens Red Shirt', 'm\r'),
(2, 'red_blouse', 'Womens Red Blouse', 'f\r'),
(3, 'blue_shorts', 'Mens Blue Shorts', 'm\r'),
(4, 'blue_skirt', 'Womens Blue Skirt', 'f\r'),
(5, 'rainbow_singlet', 'Singlet in Rainbow Colours', 'v\r'),
(6, 'sun_one', 'Aviator Sunglasses', 'f'),
(7, 'gold_neck', 'Gold Necklace Chain', '\r'),
(8, 'iph_case', 'Iphone Case pink', ' F\r'),
(9, 'sam_case', 'Samsung Case Skulls', 'M\r'),
(10, 'black_shirt', 'AC/DC Shirt', 'm\r');

--
-- Indexes for dumped tables
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;