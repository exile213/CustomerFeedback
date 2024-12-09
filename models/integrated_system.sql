-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for integrated_system
CREATE DATABASE IF NOT EXISTS `integrated_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `integrated_system`;

-- Dumping structure for table integrated_system.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.categories: ~5 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
	(1, 'Short / Pants', NULL),
	(2, 'Sandals', NULL),
	(3, 'Shirts', NULL),
	(4, 'Accessories', NULL),
	(5, 'Perfumes / Cosmetics', NULL);

-- Dumping structure for table integrated_system.change_log
CREATE TABLE IF NOT EXISTS `change_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `details` text,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `change_log_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.change_log: ~5 rows (approximately)
INSERT INTO `change_log` (`id`, `product_id`, `action`, `details`, `timestamp`) VALUES
	(1, NULL, 'Added', 'New product added: Gshock', '2024-11-19 01:00:53'),
	(2, NULL, 'Added', 'New product added: Womens', '2024-11-19 14:41:15'),
	(3, NULL, 'Deleted', 'Product deleted with ID: 2', '2024-11-19 14:42:55'),
	(4, NULL, 'Added', 'New product added: Womens', '2024-11-19 15:55:24'),
	(5, NULL, 'Added', 'New product added: Mens', '2024-11-19 15:58:04');

-- Dumping structure for table integrated_system.communication
CREATE TABLE IF NOT EXISTS `communication` (
  `ReportID` int NOT NULL AUTO_INCREMENT,
  `CustomerID` int DEFAULT NULL,
  `message_type` varchar(50) DEFAULT NULL,
  `message_content` text,
  `sent_date` datetime DEFAULT NULL,
  `is_sent` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ReportID`),
  KEY `communication_customer_key` (`CustomerID`),
  CONSTRAINT `communication_customer_key` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.communication: ~5 rows (approximately)
INSERT INTO `communication` (`ReportID`, `CustomerID`, `message_type`, `message_content`, `sent_date`, `is_sent`) VALUES
	(1, 1, 'Email', 'Thank you for your recent purchase!', '2023-06-02 09:00:00', 1),
	(2, 2, 'SMS', 'Your order has been shipped.', '2023-06-16 10:30:00', 1),
	(3, 3, 'Email', 'We appreciate your feedback!', '2023-07-02 11:45:00', 1),
	(4, 4, 'Email', 'We\'re sorry to hear about your experience. How can we make it right?', '2023-07-16 14:00:00', 1),
	(5, 5, 'SMS', 'Your loyalty discount is now active!', '2023-08-02 15:30:00', 1);

-- Dumping structure for table integrated_system.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `CustomerID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.customer: ~5 rows (approximately)
INSERT INTO `customer` (`CustomerID`, `Name`, `Email`, `Phone`, `Date`) VALUES
	(1, 'John Doe', 'john.doe@email.com', '123-456-7890', '2023-01-15'),
	(2, 'Jane Smith', 'jane.smith@email.com', '234-567-8901', '2023-02-20'),
	(3, 'Bob Johnson', 'bob.johnson@email.com', '345-678-9012', '2023-03-25'),
	(4, 'Alice Brown', 'alice.brown@email.com', '456-789-0123', '2023-04-30'),
	(5, 'Charlie Davis', 'charlie.davis@email.com', '567-890-1234', '2023-05-05');

-- Dumping structure for table integrated_system.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `EmployeeID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Status` varchar(50) NOT NULL,
  PRIMARY KEY (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.employee: ~2 rows (approximately)
INSERT INTO `employee` (`EmployeeID`, `name`, `email`, `password`, `role`, `Status`) VALUES
	(1, 'admin', 'admin@gmail.com', '03025785845a4e4c063a1b82726bab99be17f34ce8604a7e4eaf2d112fd6d39b', 'admin', 'active'),
	(2, 'staff', 'staff@gmail.com', '864ba45d6811c8fdc395dbd5ab4e3004659a6fa1a818591776542df16c09c3cc', 'staff', 'active');

-- Dumping structure for table integrated_system.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `FeedbackID` int NOT NULL AUTO_INCREMENT,
  `CustomerID` int DEFAULT NULL,
  `feedback_date` date DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`FeedbackID`),
  KEY `Feedback_customer_key` (`CustomerID`),
  CONSTRAINT `Feedback_customer_key` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.feedback: ~5 rows (approximately)
INSERT INTO `feedback` (`FeedbackID`, `CustomerID`, `feedback_date`, `comments`) VALUES
	(1, 1, '2023-06-01', 'Great service and products!'),
	(2, 3, '2023-07-01', 'Excellent customer support.'),
	(3, 5, '2023-08-01', 'Very satisfied with my purchase.'),
	(4, 2, '2023-06-15', 'Good experience overall, but could improve on delivery time.'),
	(5, 4, '2023-07-15', 'Product quality was not as expected.');

-- Dumping structure for table integrated_system.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `category_id` int DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.products: ~30 rows (approximately)
INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `stock`) VALUES
	(1, 'Short - Girls', NULL, 150.00, 1, 0),
	(2, 'Spandex Trousers', NULL, 150.00, 1, 0),
	(3, 'Barcrepe Face prints', NULL, 220.00, 1, 0),
	(4, 'Belt Pants', NULL, 300.00, 1, 0),
	(5, 'Sandal – A', NULL, 120.00, 2, 0),
	(6, 'Double Lining', NULL, 99.00, 3, 0),
	(7, 'Face prints Blouses', NULL, 150.00, 3, 0),
	(8, 'Cotton Dress', NULL, 220.00, 3, 0),
	(9, 'Dress', NULL, 280.00, 3, 0),
	(10, 'Plain Blouse', NULL, 135.00, 3, 0),
	(11, 'Eyelet Blouse', NULL, 180.00, 3, 0),
	(12, 'Men stripe', NULL, 280.00, 3, 0),
	(13, 'Chelsy Blouse', NULL, 150.00, 3, 0),
	(14, 'Barbara Tops', NULL, 180.00, 3, 0),
	(15, 'Sando', NULL, 180.00, 3, 0),
	(16, 'G-Shock Watch', NULL, 265.00, 4, 0),
	(17, 'Premium Earrings', NULL, 180.00, 4, 0),
	(18, 'Bangkok Earrings', NULL, 150.00, 4, 0),
	(19, 'Premium Necklace', NULL, 250.00, 4, 0),
	(20, 'Stainless Watch', NULL, 250.00, 4, 0),
	(21, 'Water Resist Watch', NULL, 265.00, 4, 0),
	(22, 'Bangles', NULL, 99.00, 4, 0),
	(23, 'Vanilla Lace', NULL, 199.00, 5, 0),
	(24, 'Bottle Perfume', NULL, 90.00, 5, 0),
	(25, 'Roll Lip tint', NULL, 50.00, 5, 0),
	(26, 'PS Sunblock', NULL, 100.00, 5, 0),
	(27, 'Matte Tint', NULL, 80.00, 5, 0),
	(28, 'Lipstick', NULL, 80.00, 5, 0),
	(29, 'PS Sunblock (Big)', NULL, 180.00, 5, 0),
	(30, 'Kojic Papaya Soap', NULL, 45.00, 5, 0);

-- Dumping structure for table integrated_system.ratingcategory
CREATE TABLE IF NOT EXISTS `ratingcategory` (
  `categoryID` int NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) DEFAULT NULL,
  `Description` text,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.ratingcategory: ~5 rows (approximately)
INSERT INTO `ratingcategory` (`categoryID`, `categoryName`, `Description`) VALUES
	(1, 'Overall Satisfaction', 'Overall customer satisfaction rating'),
	(2, 'Product Quality', 'Rating for product quality'),
	(3, 'Service Quality', 'Rating for service quality'),
	(4, 'Purchase Experience', 'Rating for ease of purchase'),
	(5, 'Recommendation Likelihood', 'Likelihood to recommend to others');

-- Dumping structure for table integrated_system.ratings
CREATE TABLE IF NOT EXISTS `ratings` (
  `RatingID` int NOT NULL AUTO_INCREMENT,
  `FeedbackID` int DEFAULT NULL,
  `categoryID` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`RatingID`),
  KEY `rating_feedback_key` (`FeedbackID`),
  KEY `rating_category_key` (`categoryID`),
  CONSTRAINT `rating_category_key` FOREIGN KEY (`categoryID`) REFERENCES `ratingcategory` (`categoryID`),
  CONSTRAINT `rating_feedback_key` FOREIGN KEY (`FeedbackID`) REFERENCES `feedback` (`FeedbackID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.ratings: ~25 rows (approximately)
INSERT INTO `ratings` (`RatingID`, `FeedbackID`, `categoryID`, `score`, `created_at`) VALUES
	(1, 1, 1, 5, '2023-06-01 10:00:00'),
	(2, 1, 2, 5, '2023-06-01 10:00:00'),
	(3, 1, 3, 5, '2023-06-01 10:00:00'),
	(4, 1, 4, 4, '2023-06-01 10:00:00'),
	(5, 1, 5, 5, '2023-06-01 10:00:00'),
	(6, 2, 1, 4, '2023-06-15 14:30:00'),
	(7, 2, 2, 4, '2023-06-15 14:30:00'),
	(8, 2, 3, 4, '2023-06-15 14:30:00'),
	(9, 2, 4, 3, '2023-06-15 14:30:00'),
	(10, 2, 5, 4, '2023-06-15 14:30:00'),
	(11, 3, 1, 5, '2023-07-01 11:15:00'),
	(12, 3, 2, 4, '2023-07-01 11:15:00'),
	(13, 3, 3, 5, '2023-07-01 11:15:00'),
	(14, 3, 4, 5, '2023-07-01 11:15:00'),
	(15, 3, 5, 5, '2023-07-01 11:15:00'),
	(16, 4, 1, 3, '2023-07-15 16:45:00'),
	(17, 4, 2, 2, '2023-07-15 16:45:00'),
	(18, 4, 3, 4, '2023-07-15 16:45:00'),
	(19, 4, 4, 3, '2023-07-15 16:45:00'),
	(20, 4, 5, 3, '2023-07-15 16:45:00'),
	(21, 5, 1, 5, '2023-08-01 09:30:00'),
	(22, 5, 2, 5, '2023-08-01 09:30:00'),
	(23, 5, 3, 4, '2023-08-01 09:30:00'),
	(24, 5, 4, 5, '2023-08-01 09:30:00'),
	(25, 5, 5, 5, '2023-08-01 09:30:00');

-- Dumping structure for table integrated_system.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total_amount` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL,
  `cash_received` decimal(10,2) NOT NULL,
  `change_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.transactions: ~2 rows (approximately)
INSERT INTO `transactions` (`id`, `total_amount`, `tax_amount`, `cash_received`, `change_amount`, `created_at`) VALUES
	(1, 767.20, 82.20, 768.00, 0.80, '2024-12-03 17:04:01'),
	(2, 403.20, 43.20, 1000.00, 596.80, '2024-12-03 17:09:53');

-- Dumping structure for table integrated_system.transaction_items
CREATE TABLE IF NOT EXISTS `transaction_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`),
  CONSTRAINT `transaction_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table integrated_system.transaction_items: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
