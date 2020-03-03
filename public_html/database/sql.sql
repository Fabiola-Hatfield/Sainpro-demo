-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 29, 2020 at 08:07 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sainpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(50) NOT NULL,
  `client_phone` varchar(20) NOT NULL,
  `client_address` varchar(70) DEFAULT NULL,
  `client_email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `client_name`, `client_phone`, `client_address`, `client_email`) VALUES
(1, 'Amihan Benson', '(592) 301-9393', '8076 W. South St.  Gibsonia, PA 15044', 'amiha@gmail.com'),
(2, 'Lyubochka Skaidrte', '(272) 654-2278', '7834 Mountainview Ave.  Allison Park, PA 15101', 'Lyuska@gmail.com'),
(3, 'Elias Albinuss', '(564) 574-0677', '7983 Canal St.  Greensboro, NC 27405', 'elias@abc.edu');

--
-- Triggers `client`
--
DROP TRIGGER IF EXISTS `update_client`;
DELIMITER $$
CREATE TRIGGER `update_client` AFTER UPDATE ON `client` FOR EACH ROW UPDATE invoice SET invoice.client_name = NEW.client_name WHERE invoice.client_name = OLD.client_name
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_no` int(4) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(50) NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `sub_total` double NOT NULL,
  `taxes` double NOT NULL,
  `discount` double NOT NULL,
  `net_total` double NOT NULL,
  `paid` double NOT NULL,
  `due` double NOT NULL,
  `payment_type` text NOT NULL,
  PRIMARY KEY (`invoice_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
CREATE TABLE IF NOT EXISTS `invoice_details` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `invoice_no` int(4) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `qty` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_no` (`invoice_no`),
  KEY `nose` (`product_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `entry_price` double NOT NULL,
  `sell_price` double DEFAULT NULL,
  `quantity` double NOT NULL,
  `unit` enum('Pounds','Inches','Feet','Pieces','Liters','Other') NOT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_product_name_uindex` (`product_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `entry_date`, `description`, `entry_price`, `sell_price`, `quantity`, `unit`, `status`) VALUES
(1, 'Microware Spoolarc 0.045\"', '2020-01-21', 'Selling by kilos', 2.41, 3, 2, 'Other', 1),
(2, 'Steelmark', '2020-01-21', '', 0.75, 2.5, 33, 'Pieces', 1),
(3, 'Welding lens shade 11', '2020-01-21', '                                ', 10.2, 112.5, 19, 'Pieces', 1),
(4, 'ER1100 Aluminium 1/16 x 36', '2020-01-21', '                                ', 7.99, 10, 374, 'Pounds', 1);

--
-- Triggers `product`
--
DROP TRIGGER IF EXISTS `update`;
DELIMITER $$
CREATE TRIGGER `update` AFTER UPDATE ON `product` FOR EACH ROW UPDATE invoice_details SET invoice_details.product_name = NEW.product_name WHERE invoice_details.product_name = OLD.product_name
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT NULL,
  `user_email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `register_date` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `user_type` enum('Admin','User') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `user_email`, `password`, `register_date`, `last_login`, `user_type`) VALUES
(1, 'Admin Example', 'admin@gmail.com', '$2y$10$KBAhQ27Y5fwgqHKyFsuDR.xIIxy/tR9zJJ25uId4rjIGHqFmlfsLC', '2020-01-20 23:57:54', NULL, 'Admin'),
(2, 'User Example', 'user@gmail.com', '$2y$10$JmqVI1aR7RHkNnlEGucoWO3yQ1VZlDmIVdmnUx90PozVzN9OTqsju', '2020-01-20 23:58:22', NULL, 'User');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `invoice_invoice_details` FOREIGN KEY (`invoice_no`) REFERENCES `invoice` (`invoice_no`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
