-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 12:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalproject126`
--

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `cartItemID` int(11) NOT NULL,
  `customerID` int(11) DEFAULT NULL,
  `productID` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `createdAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`cartItemID`, `customerID`, `productID`, `quantity`, `price`, `createdAt`) VALUES
(15, 5, 3, 1, NULL, '2025-05-24 13:09:15'),
(16, 5, 4, 1, NULL, '2025-05-24 13:09:16'),
(17, 5, 8, 1, NULL, '2025-05-24 13:09:27'),
(25, 6, 4, 1, NULL, '2025-05-24 13:58:02'),
(26, 7, 1, 1, NULL, '2025-05-24 14:01:48'),
(27, 7, 2, 1, NULL, '2025-05-24 14:01:48'),
(28, 7, 3, 1, NULL, '2025-05-24 14:01:50'),
(29, 7, 7, 1, NULL, '2025-05-24 14:02:00'),
(30, 8, 3, 1, NULL, '2025-05-24 14:38:10'),
(31, 6, 8, 1, NULL, '2025-05-24 16:04:05'),
(61, 4, 17, 1, NULL, '2025-05-24 19:49:55'),
(62, 4, 16, 1, NULL, '2025-05-24 19:49:57'),
(63, 4, 14, 1, NULL, '2025-05-24 19:49:59'),
(64, 4, 13, 1, NULL, '2025-05-24 19:50:00'),
(65, 4, 3, 1, NULL, '2025-05-24 19:50:02'),
(66, 9, 30, 1, NULL, '2025-05-29 18:30:02'),
(67, 9, 24, 1, NULL, '2025-05-29 18:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'Drinks', 'A variety of refreshing beverages, including cold and hot drinks.'),
(2, 'Appetizer', 'Small dishes served before a main course'),
(3, 'Main Course', 'The central, most substantial part of a meal');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `fname`, `email`, `password`, `lname`, `address`) VALUES
(1, 'Dale', 'dalealmonia121@gmail.com', '$2y$10$PZI3t8F7lsriJtyUzdHf8eet0TpocyuVCfwwIy6/IShOo7FZnkmOq', 'Almonia', NULL),
(2, 'Dale Louize', 'almonia@gmail.com', 'f7d00d544523a41f0027407b784ae391', 'Almonia', NULL),
(3, 'Stefan', 'monster@gmail.com', '4d7936e5d9e9c3f9270d49d1e40eb6d0', 'Monster', NULL),
(4, 'Krishia', 'Hofilena@gmail.com', 'f7d00d544523a41f0027407b784ae391', 'Hofilena', 'Mat-y, Miagao, Iloilo, Western Visayas, 5023, Philippines'),
(5, 'Cedric ', 'ctoyco@gmail.com', 'f7d00d544523a41f0027407b784ae391', 'Oyco', NULL),
(6, 'Jed ', 'tirol@gmail.com', 'f7d00d544523a41f0027407b784ae391', 'Tirol', 'University of the Philippines Visayas, Hollywood Street, Mat-y, Miagao, Iloilo, Western Visayas, 5023, Philippines'),
(7, 'Luis', 'Borb@gmail.com', 'f7d00d544523a41f0027407b784ae391', 'Borbolla', NULL),
(8, 'Vyenge', 'gayosa@gmail.com', 'f7d00d544523a41f0027407b784ae391', 'Gayosa', NULL),
(9, 'Dale Louize ', 'dalealmonia0121@gmail.com', 'f7d00d544523a41f0027407b784ae391', 'Almonia', 'Road 1, Bolho, Sapa, Miagao, Iloilo, Western Visayas, 5023, Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `orderItemID` int(11) NOT NULL,
  `orderID` int(11) DEFAULT NULL,
  `productID` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `priceAtOrder` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`orderItemID`, `orderID`, `productID`, `quantity`, `priceAtOrder`) VALUES
(1, 1, 10, 1, 90.00),
(2, 1, 9, 1, 90.00),
(3, 1, 1, 1, 79.00),
(4, 1, 2, 1, 89.00),
(5, 2, 3, 1, 85.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `customerID` int(11) DEFAULT NULL,
  `orderDate` datetime NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `customerID`, `orderDate`, `totalAmount`) VALUES
(1, 4, '2025-05-24 07:23:45', 388.00),
(2, 4, '2025-05-24 07:36:52', 125.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `shopID` int(11) DEFAULT NULL,
  `itemName` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `shopID`, `itemName`, `description`, `price`, `image_url`, `category_id`) VALUES
(1, 1, 'Ala King', 'Delicious Ala King dish', 79.00, 'Img/1.png', 3),
(2, 1, 'Fish Fillet', 'Fresh Fish Fillet', 89.00, 'Img/2.png', 3),
(3, 1, 'Chicken Tenders', 'Crispy Chicken Tenders', 85.00, 'Img/3.png', 3),
(4, 1, 'Chicken w/ Cream', 'Chicken with Cream Sauce', 75.00, 'Img/4.png', 3),
(5, 1, 'Tenderloin w/ Cream', 'Tenderloin with Cream Sauce', 99.00, 'Img/5.png', 3),
(6, 1, 'Sweet Chili Chicken', 'Chicken with Sweet Chili Glaze', 69.00, 'Img/6.png', 3),
(7, 2, 'Buttered Chicken Combo', 'Combo meal with buttered chicken, free side-dish, free soup, and free drink', 90.00, 'Img/K1.png', 3),
(8, 2, 'Fried Pork Combo', 'Combo meal with fried pork, free side-dish, free soup, and free drink', 90.00, 'Img/K2.png', 3),
(9, 2, 'Fried Fish Combo', 'Combo meal with fried fish, free side-dish, free soup, and free drink', 90.00, 'Img/K3.png', 3),
(10, 2, 'Beef and Mushroom Combo', 'Combo meal with beef and mushroom, free side-dish, free soup, and free drink', 90.00, 'Img/K4.png', 3),
(11, 1, 'Potato Wedges', 'Crispy golden potato wedges served with dip', 170.00, 'Img/7.png', 2),
(12, 1, 'Onion Rings', 'Crispy fried onion rings served with dip', 150.00, 'Img/8.png', 2),
(13, 1, 'Chicken Tenders Snackbox', 'Crispy chicken tenders with pasta and potato wedges', 185.00, 'Img/9.png', 2),
(14, 1, 'Chicken Snackbox', 'Fried chicken with pasta and potato wedges', 185.00, 'Img/10.png', 2),
(15, 1, 'Royal Tru-Orange', 'Refreshing orange soda', 35.00, 'Img/14.png', 1),
(16, 1, 'Mountain Dew Zero', 'Sugar-free Mountain Dew', 40.00, 'Img/13.png', 1),
(17, 1, 'Sprite', 'Refreshing lemon-lime soda', 35.00, 'Img/12.png', 1),
(18, 1, 'Coca-Cola', 'Classic Coca-Cola soda', 40.00, 'Img/11.png', 1),
(19, 2, 'Royal Tru-Orange', 'Refreshing orange soda', 35.00, 'Img/14.png', 1),
(20, 2, 'Mountain Dew Zero', 'Sugar-free Mountain Dew', 40.00, 'Img/13.png', 1),
(21, 2, 'Sprite', 'Refreshing lemon-lime soda', 35.00, 'Img/12.png', 1),
(22, 2, 'Coca-Cola', 'Classic Coca-Cola soda', 40.00, 'Img/11.png', 1),
(23, 2, 'Bihon Guisado', 'Stir-fried bihon with mixed vegetables and meat', 80.00, 'Img/K5.png', 2),
(24, 2, 'Pancit Malabon', 'Traditional Filipino noodle dish with shrimp and egg', 95.00, 'Img/K6.png', 2),
(25, 2, 'Cookies and Cream Float', 'Delicious cookies and cream flavored float', 60.00, 'Img/K7.png', 1),
(26, 2, 'Ube Float', 'Ube flavored  float', 60.00, 'Img/K8.png', 1),
(27, 2, 'Choco Fudge Float', 'Choco Fudge flavored float', 60.00, 'Img/K9.png', 1),
(28, 2, 'Sweet & Sour Chicken', 'Sweet and sour dish with meat and vegetables', 90.00, 'Img/K10.png', 3),
(29, 2, 'Orange Chicken Combo Meal', 'Crispy orange chicken with rice and sides', 90.00, 'Img/K11.png', 3),
(30, 2, 'Chicken Inasal Combo Meal', 'Grilled chicken marinated in special spices with rice', 90.00, 'Img/K12.png', 3),
(31, 2, 'Pork Sisig Combo Meal', 'Sizzling pork sisig with rice and egg', 90.00, 'Img/K13.png', 3),
(32, 2, 'Sweet & Sour Porok', 'Classic sweet and sour dish', 90.00, 'Img/K14.png', 3),
(33, 2, 'Tuna Bicol Express Combo Meal', 'Tuna dish with rice and sides', 90.00, 'Img/K15.png', 3),
(34, 2, 'Sweet & Sour Fish', 'Variation of sweet and sour dish', 90.00, 'Img/K16.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `shopID` int(11) NOT NULL,
  `shopName` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`shopID`, `shopName`, `location`) VALUES
(1, 'Vineyard', 'Corner Mueda St. and Nonato St. Brgy. Baybay Sur 5023 Miagao, Philippines'),
(2, 'KUBO', 'Balay Cawayan Boarding House, Hollywood Street, Mat-y, Miagao');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`cartItemID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`orderItemID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `shopID` (`shopID`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`shopID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `cartItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `orderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `shopID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`),
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`shopID`) REFERENCES `shops` (`shopID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
