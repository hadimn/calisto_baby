-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 25, 2025 at 03:20 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `calisto_baby`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `first_name`, `last_name`) VALUES
(2, 'admin5119@calisto.com', '$2y$10$zrXw6XWDvIlXMc4nG3cjlewjEdTDzwYukJAd2ZHgETeddaQQRrQQi', 'Admin', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `billing_addresses`
--

DROP TABLE IF EXISTS `billing_addresses`;
CREATE TABLE IF NOT EXISTS `billing_addresses` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `country` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `additional_info` text,
  PRIMARY KEY (`address_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `billing_addresses`
--

INSERT INTO `billing_addresses` (`address_id`, `customer_id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `country`, `city`, `additional_info`) VALUES
(2, 3, 'hadi', 'monzer', 'hadimonzer1999@gmail.com', '71337068', 'doha', 'Lebanon', 'mreijeh', 'mreijeh bank al mawared');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `added_at` timestamp NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `customers_accounts`
--

DROP TABLE IF EXISTS `customers_accounts`;
CREATE TABLE IF NOT EXISTS `customers_accounts` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`(191))
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `customers_accounts`
--

INSERT INTO `customers_accounts` (`customer_id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `password`) VALUES
(3, 'hadi', 'monzer', 'hadimonzer1999@gmail.com', '71337068', 'doha', '$2y$10$M3mIremUDzwt5PNocvQn6OVxjwHNvi7ysQX4OPtbswfEc8WqYqhzi'),
(6, 'hadi', 'hadi', 'hadimn121@gmail.com', '76872332', 'doha,qatar', '$2y$10$23dVJ4xebFbLk3ClZhuEMO8aTmwNyYjxL.iX2IWOXxHCozBaBFzwa');

-- --------------------------------------------------------

--
-- Table structure for table `customer_messages`
--

DROP TABLE IF EXISTS `customer_messages`;
CREATE TABLE IF NOT EXISTS `customer_messages` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `sender_name` varchar(255) NOT NULL,
  `message_content` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `customer_promo_usage`
--

DROP TABLE IF EXISTS `customer_promo_usage`;
CREATE TABLE IF NOT EXISTS `customer_promo_usage` (
  `usage_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `promo_id` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `used_at` datetime NOT NULL,
  PRIMARY KEY (`usage_id`),
  KEY `customer_id` (`customer_id`),
  KEY `promo_id` (`promo_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
CREATE TABLE IF NOT EXISTS `discounts` (
  `discount_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `discount_type` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `discount_percentage` decimal(10,2) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`discount_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`discount_id`, `customer_id`, `discount_type`, `discount_percentage`, `status`) VALUES
(1, 6, 'first_order', 10.00, 'active'),
(2, 3, 'first_order', 10.00, 'used');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `currency` enum('USD','LBP') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `total_amount`, `currency`, `status`, `created_at`) VALUES
(8, 3, 17.20, 'USD', 'pending', '2025-03-25 14:37:20');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price_at_purchase`) VALUES
(16, 8, 32, 4, 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `payment_method` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `exchange_rate` decimal(5,2) DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `price` decimal(10,2) NOT NULL,
  `new_price` decimal(10,2) DEFAULT '0.00',
  `currency` enum('USD','LBP') NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `popular` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `best_deal` int NOT NULL DEFAULT '0',
  `on_sale` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `admin_id`, `name`, `description`, `price`, `new_price`, `currency`, `image`, `popular`, `created_at`, `updated_at`, `best_deal`, `on_sale`) VALUES
(31, 2, 'back bag', 'enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia res eos qui ratione voluptatem sequi Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora inform', 14.22, 11.33, 'USD', 'uploads/calisto_1.jpg', 1, '2025-03-07 16:21:15', '2025-03-23 06:41:40', 0, 1),
(30, 2, 'pant shorts', 'enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia res eos qui ratione voluptatem sequi Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora inform', 800.00, 700.00, 'USD', 'uploads/calisto_1.jpg', 1, '2025-03-09 16:20:03', '2025-03-24 12:34:12', 1, 1),
(27, 2, 'shorts', 'enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia res eos qui ratione voluptatem sequi Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora inform', 12.00, 0.00, 'USD', 'uploads/calisto_1.jpg', 1, '2025-03-08 14:00:08', '2025-03-11 13:55:30', 0, 0),
(26, 2, 'pants', 'enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia res eos qui ratione voluptatem sequi Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora inform', 13.00, 11.00, 'USD', 'uploads/calisto_1.jpg', 1, '2025-03-10 13:51:22', '2025-03-12 17:00:30', 1, 1),
(32, 2, 'test', 'enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia res eos qui ratione voluptatem sequi Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora inform', 13.00, 2.00, 'USD', 'uploads/calisto_1.jpg', 1, '2025-03-10 16:21:50', '2025-03-12 17:10:36', 1, 1),
(33, 2, 'test 2', 'enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia res eos qui ratione voluptatem sequi Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora inform', 12.40, 0.00, 'USD', 'uploads/calisto_1.jpg', 1, '2025-03-11 15:00:36', '2025-03-23 07:24:53', 0, 0),
(34, 2, 'test new price', 'test new price', 12.00, 0.00, 'USD', 'uploads/calisto_1.jpg', 0, '2025-03-12 16:31:15', '2025-03-21 07:18:06', 0, 0),
(35, 2, 'new shirt', 'NEW shirt', 12.00, 0.00, 'USD', 'uploads/calisto_1.jpg', 0, '2025-03-13 16:33:18', NULL, 0, 0),
(36, 2, 'test image', 'test image', 123.00, 0.00, 'USD', 'uploads/calisto_1.jpg', 0, '2025-03-15 01:35:17', '2025-03-16 09:30:22', 0, 0),
(37, 2, 'error test', 'error test', 1323.00, 0.00, 'USD', 'uploads/calisto_1.jpg', 0, '2025-03-15 01:39:09', NULL, 0, 0),
(38, 2, 'test test', 'test test', 43.00, 0.00, 'USD', 'uploads/calisto_1.jpg', 0, '2025-03-15 01:40:15', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

DROP TABLE IF EXISTS `product_sizes`;
CREATE TABLE IF NOT EXISTS `product_sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `size` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stock` int NOT NULL,
  `color_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=183 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `color`, `stock`, `color_image`) VALUES
(182, 30, 'X', 'black', 3, NULL),
(83, 27, 'S', 'blue', 4, NULL),
(98, 26, 'S', 'brown', 4, NULL),
(102, 32, 'S', 'yellow', 4, NULL),
(151, 36, 'X', 'red', 4, 'uploads/calisto_1.jpg'),
(181, 33, 'S', 'yellow', 3, 'uploads/calisto_1.jpg'),
(171, 34, 'S', 'purple', 3, NULL),
(103, 35, 'XL', 'blue', 3, 'uploads/calisto_1.jpg'),
(104, 35, 'L', 'brown', 4, 'uploads/calisto_1.jpg'),
(179, 31, 'S', 'brown', 3, 'uploads/calisto_1.jpg'),
(178, 31, 'S', 'blue', 4, 'uploads/calisto_1.jpg'),
(130, 37, 'S', 'blue', 3, 'uploads/calisto_1.jpg'),
(131, 38, 'S', 'blue', 34, 'uploads/calisto_1.jpg'),
(177, 31, 'X', 'purple', 5, 'uploads/calisto_1.jpg'),
(176, 31, 'X', 'blue', 5, 'uploads/fffff(1).png');

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

DROP TABLE IF EXISTS `product_tags`;
CREATE TABLE IF NOT EXISTS `product_tags` (
  `product_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`product_id`,`tag_id`),
  KEY `fk_product_tags_tag_id` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `product_tags`
--

INSERT INTO `product_tags` (`product_id`, `tag_id`) VALUES
(26, 14),
(26, 15),
(27, 14),
(27, 15),
(28, 14),
(29, 14),
(29, 15),
(30, 14),
(30, 15),
(31, 14),
(31, 15),
(32, 14),
(32, 15),
(33, 29),
(34, 14),
(34, 15),
(34, 16),
(35, 14),
(35, 15),
(35, 16),
(36, 14),
(36, 15),
(36, 16),
(37, 14),
(38, 15);

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

DROP TABLE IF EXISTS `promo_codes`;
CREATE TABLE IF NOT EXISTS `promo_codes` (
  `promo_id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `discount_type` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_value` decimal(10,2) NOT NULL,
  `max_uses` int NOT NULL,
  `expires_at` datetime NOT NULL,
  `status` enum('Active','Expired','Disabled') NOT NULL,
  PRIMARY KEY (`promo_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

DROP TABLE IF EXISTS `shipping`;
CREATE TABLE IF NOT EXISTS `shipping` (
  `shipping_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `carrier` varchar(255) NOT NULL,
  `tracking_number` varchar(100) NOT NULL,
  `estimated_delivery` date NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`shipping_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_fees`
--

DROP TABLE IF EXISTS `shipping_fees`;
CREATE TABLE IF NOT EXISTS `shipping_fees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fee` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shipping_fees`
--

INSERT INTO `shipping_fees` (`id`, `fee`) VALUES
(1, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

DROP TABLE IF EXISTS `social_media`;
CREATE TABLE IF NOT EXISTS `social_media` (
  `social_id` int NOT NULL AUTO_INCREMENT,
  `platform` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon_class` varchar(50) NOT NULL,
  `bg_color` varchar(255) NOT NULL DEFAULT 'btn-info',
  `enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`social_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `social_media`
--

INSERT INTO `social_media` (`social_id`, `platform`, `link`, `icon_class`, `bg_color`, `enabled`) VALUES
(1, 'Facebook', 'https://www.facebook.com/profile.php?id=100077276937756', 'fa fa-facebook', 'background-color: #0d6efd; border-color: #0d6efd;', 1),
(2, 'Twitter', 'https://twitter.com', 'fa fa-twitter', 'background-color: #0dcaf0; border-color: #0dcaf0;', 1),
(3, 'Instagram', 'https://instagram.com', 'fa fa-instagram', 'background-color: #dc3545; border-color: #dc3545;', 1),
(4, 'LinkedIn', 'https://linkedin.com', 'fa fa-linkedin', 'background-color: #0077b5; border-color: #0077b5;', 0),
(5, 'YouTube', 'https://youtube.com', 'fa fa-youtube', 'background-color: #ff0000; border-color: #ff0000;', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `name`, `description`, `image`, `created_at`) VALUES
(14, 'new born', 'new born clothes', 'uploads/tags/calisto_1.jpg', '2025-03-10 11:51:54'),
(15, 'underwear', 'underwear', 'uploads/tags/calisto_1.jpg', '2025-03-10 11:53:04'),
(21, 'footwear', 'footwear', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:32:28'),
(17, 'girl clothing', 'girl clothing', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:28:57'),
(18, 'boy clothing', 'boy clothing', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:29:19'),
(19, 'Must have basics', 'Must have basics', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:29:36'),
(20, 'Blankets', 'Blankets', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:30:20'),
(22, 'Bags', 'Bags', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:32:42'),
(23, 'Meal Time', 'Meal Time', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:32:57'),
(24, 'Bath and Care', 'Bath and Care', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:33:24'),
(25, 'Accessories and More', 'Accessories and More', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:33:47'),
(26, 'Baby Items', 'Baby Items', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:34:03'),
(27, 'new born books', 'new born books', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:35:49'),
(28, 'Toys and playtime', 'Toys and playtime', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:36:14'),
(29, 'baby room', 'baby room', 'uploads/tags/calisto_1.jpg', '2025-03-21 05:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `whishlist_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`whishlist_id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`whishlist_id`, `customer_id`, `product_id`, `created_at`) VALUES
(12, 3, 30, '2025-03-25 14:28:51'),
(2, 3, 32, '2025-03-25 11:46:27'),
(3, 3, 31, '2025-03-25 11:46:32'),
(4, 3, 27, '2025-03-25 11:46:34'),
(5, 3, 26, '2025-03-25 11:46:39');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
