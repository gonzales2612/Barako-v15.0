-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 10:06 PM
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
-- Database: `barako`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Hot Coffee'),
(2, 'Cold Coffee'),
(3, 'Blended Beverages'),
(4, 'Iced Tea & Lemonade'),
(5, 'Milk, Juice & More'),
(8, 'Top Rated');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine ', '2024-12-04 09:13:19'),
(2, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine ', '2024-12-04 09:13:22'),
(3, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine ', '2024-12-04 09:14:14'),
(4, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine ', '2024-12-04 09:16:06'),
(5, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine ', '2024-12-04 09:17:01'),
(6, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine ', '2024-12-04 09:17:52'),
(7, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:38:11'),
(8, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:38:31'),
(9, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:38:33'),
(10, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:39:07'),
(11, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:39:38'),
(12, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:40:12'),
(13, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:40:44'),
(14, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:41:52'),
(15, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:42:12'),
(16, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:42:42'),
(17, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 4', '2024-12-04 15:44:16'),
(18, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 4', '2024-12-04 15:47:06'),
(19, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 4', '2024-12-04 15:47:39'),
(20, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 4', '2024-12-04 15:48:01'),
(21, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:49:31'),
(22, 'Carlo Gonzales', 'gonzales.christiancarlo@auf.edu.ph', 'mahal ko si jasmine 2', '2024-12-04 15:49:33');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`) VALUES
(1, 'What are the store hours?', 'Our store is open from 8:00 AM to 8:00 PM, Monday to Sunday.'),
(2, 'Do you offer home delivery?', 'Yes, we offer home delivery within a 5-mile radius. Delivery charges may apply.');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`Id`, `Name`, `Type`, `Price`, `Image`, `category_id`) VALUES
(1, 'Best Seller Drink 1', '', 5.99, 'best_seller_drink1.jpg', 1),
(2, 'Hot Coffee 1', '', 3.99, 'hot_coffee1.jpg', 1),
(3, 'Cold Coffee 1', '', 4.49, 'cold_coffee1.jpg', 2),
(4, 'Refresher 1', '', 3.29, 'refresher1.jpg', 3),
(5, 'Frappuccino 1', '', 4.99, 'frappuccino1.jpg', 3),
(6, 'Iced Tea 1', '', 2.99, 'iced_tea1.jpg', 4),
(7, 'Hot Tea 1', '', 2.49, 'hot_tea1.jpg', 4),
(8, 'Milk Juice 1', '', 3.49, 'milk_juice1.jpg', 5),
(9, 'Hot Breakfast 1', '', 6.99, 'hot_breakfast1.jpg', 5),
(10, 'Oatmeal 1', '', 2.99, 'oatmeal1.jpg', 5),
(11, 'Pastry 1', '', 1.99, 'pastry1.jpg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Id` int(11) NOT NULL,
  `CustomerName` varchar(255) NOT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `TotalAmount` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Id`, `CustomerName`, `OrderDate`, `TotalAmount`, `status`) VALUES
(64, 'Gonzales, Christian Carlo D.', '2023-12-31 16:00:00', 23.95, 'Pending'),
(65, 'Gonzales, Christian Carlo D.', '2023-12-31 16:00:00', 23.95, 'Pending'),
(66, 'Gonzales, Christian Carlo D.', '2023-12-31 16:00:00', 23.95, 'Pending'),
(67, 'Gonzales, Christian Carlo D.', '2024-01-31 16:00:00', 23.95, 'Pending'),
(68, 'Gonzales, Christian Carlo D.', '2024-01-31 16:00:00', 23.95, 'Pending'),
(69, 'Gonzales, Christian Carlo D.', '2024-02-29 16:00:00', 23.95, 'Pending'),
(70, 'Gonzales, Christian Carlo D.', '2024-02-29 16:00:00', 23.95, 'Pending'),
(71, 'Gonzales, Christian Carlo D.', '2024-02-29 16:00:00', 23.95, 'Pending'),
(72, 'Gonzales, Christian Carlo D.', '2024-02-29 16:00:00', 23.95, 'Pending'),
(73, 'Gonzales, Christian Carlo D.', '2024-03-31 16:00:00', 23.95, 'Pending'),
(74, 'Gonzales, Christian Carlo D.', '2024-04-30 16:00:00', 23.95, 'Pending'),
(75, 'Gonzales, Christian Carlo D.', '2024-04-30 16:00:00', 23.95, 'Pending'),
(76, 'Gonzales, Christian Carlo D.', '2024-04-30 16:00:00', 23.95, 'Pending'),
(77, 'Gonzales, Christian Carlo D.', '2024-05-31 16:00:00', 23.95, 'Pending'),
(78, 'Gonzales, Christian Carlo D.', '2024-05-31 16:00:00', 23.95, 'Pending'),
(79, 'Gonzales, Christian Carlo D.', '2024-06-30 16:00:00', 23.95, 'Pending'),
(80, 'Gonzales, Christian Carlo D.', '2024-06-30 16:00:00', 23.95, 'Pending'),
(81, 'Gonzales, Christian Carlo D.', '2024-06-30 16:00:00', 23.95, 'Pending'),
(82, 'Gonzales, Christian Carlo D.', '2024-06-30 16:00:00', 23.95, 'Pending'),
(83, 'Gonzales, Christian Carlo D.', '2024-06-30 16:00:00', 23.95, 'Pending'),
(84, 'Gonzales, Christian Carlo D.', '2024-06-30 16:00:00', 23.95, 'Pending'),
(85, 'Gonzales, Christian Carlo D.', '2024-06-30 16:00:00', 23.95, 'Pending'),
(86, 'Gonzales, Christian Carlo D.', '2024-06-30 16:00:00', 23.95, 'Pending'),
(87, 'Gonzales, Christian Carlo D.', '2024-07-31 16:00:00', 23.95, 'Pending'),
(88, 'Gonzales, Christian Carlo D.', '2024-07-31 16:00:00', 23.95, 'Pending'),
(89, 'Gonzales, Christian Carlo D.', '2024-07-31 16:00:00', 23.95, 'Pending'),
(90, 'Gonzales, Christian Carlo D.', '2024-07-31 16:00:00', 23.95, 'Pending'),
(91, 'Gonzales, Christian Carlo D.', '2024-07-31 16:00:00', 23.95, 'Pending'),
(92, 'Gonzales, Christian Carlo D.', '2024-08-31 16:00:00', 23.95, 'Pending'),
(93, 'Gonzales, Christian Carlo D.', '2024-08-31 16:00:00', 23.95, 'Pending'),
(94, 'Gonzales, Christian Carlo D.', '2024-08-31 16:00:00', 23.95, 'Pending'),
(95, 'Gonzales, Christian Carlo D.', '2024-09-30 16:00:00', 15.47, 'Pending'),
(96, 'Gonzales, Christian Carlo D.', '2024-09-30 16:00:00', 15.47, 'Pending'),
(97, 'Gonzales, Christian Carlo D.', '2024-10-31 16:00:00', 20.45, 'Pending'),
(98, 'Gonzales, Christian Carlo D.', '2024-10-31 16:00:00', 20.45, 'Pending'),
(99, 'Gonzales, Christian Carlo D.', '2024-10-31 16:00:00', 20.45, 'Pending'),
(100, 'Gonzales, Christian Carlo D.', '2024-10-31 16:00:00', 20.45, 'Pending'),
(101, 'Gonzales, Christian Carlo D.', '2024-12-03 16:00:00', 20.45, 'Pending'),
(102, 'Gonzales, Christian Carlo D.', '2024-12-03 16:00:00', 20.45, 'Pending'),
(103, 'Gonzales, Christian Carlo D.', '2024-12-05 16:00:00', 39.92, 'Pending'),
(104, 'Christian Carlo Gonzales', '2024-12-05 16:00:00', 5.99, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `OrderId` int(11) NOT NULL,
  `MenuItemId` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`OrderId`, `MenuItemId`, `Quantity`, `Subtotal`) VALUES
(64, 1, 2, 7.98),
(64, 2, 3, 11.97),
(65, 1, 2, 7.98),
(65, 2, 3, 11.97),
(66, 1, 2, 7.98),
(66, 2, 3, 11.97),
(67, 1, 2, 7.98),
(67, 2, 3, 11.97),
(68, 1, 2, 7.98),
(68, 2, 3, 11.97),
(69, 1, 2, 7.98),
(69, 2, 3, 11.97),
(70, 1, 2, 7.98),
(70, 2, 3, 11.97),
(71, 1, 2, 7.98),
(71, 2, 3, 11.97),
(72, 1, 2, 7.98),
(72, 2, 3, 11.97),
(73, 1, 2, 7.98),
(73, 2, 3, 11.97),
(74, 1, 2, 7.98),
(74, 2, 3, 11.97),
(75, 1, 2, 7.98),
(75, 2, 3, 11.97),
(76, 1, 2, 7.98),
(76, 2, 3, 11.97),
(77, 1, 2, 7.98),
(77, 2, 3, 11.97),
(78, 1, 2, 7.98),
(78, 2, 3, 11.97),
(79, 1, 2, 7.98),
(79, 2, 3, 11.97),
(80, 1, 2, 7.98),
(80, 2, 3, 11.97),
(81, 1, 2, 7.98),
(81, 2, 3, 11.97),
(82, 1, 2, 7.98),
(82, 2, 3, 11.97),
(83, 1, 2, 7.98),
(83, 2, 3, 11.97),
(84, 1, 2, 7.98),
(84, 2, 3, 11.97),
(85, 1, 2, 7.98),
(85, 2, 3, 11.97),
(86, 1, 2, 7.98),
(86, 2, 3, 11.97),
(87, 1, 2, 7.98),
(87, 2, 3, 11.97),
(88, 1, 2, 7.98),
(88, 2, 3, 11.97),
(89, 1, 2, 7.98),
(89, 2, 3, 11.97),
(90, 1, 2, 7.98),
(90, 2, 3, 11.97),
(91, 1, 2, 7.98),
(91, 2, 3, 11.97),
(92, 1, 2, 7.98),
(92, 2, 3, 11.97),
(93, 1, 2, 7.98),
(93, 2, 3, 11.97),
(94, 1, 2, 7.98),
(94, 2, 3, 11.97),
(95, 1, 2, 6.98),
(95, 8, 1, 3.49),
(96, 1, 2, 6.98),
(96, 8, 1, 3.49),
(97, 1, 2, 3.98),
(97, 8, 1, 1.99),
(97, 10, 1, 1.99),
(97, 11, 1, 1.99),
(98, 1, 2, 3.98),
(98, 8, 1, 1.99),
(98, 10, 1, 1.99),
(98, 11, 1, 1.99),
(99, 1, 2, 3.98),
(99, 8, 1, 1.99),
(99, 10, 1, 1.99),
(99, 11, 1, 1.99),
(100, 1, 2, 3.98),
(100, 8, 1, 1.99),
(100, 10, 1, 1.99),
(100, 11, 1, 1.99),
(101, 1, 2, 3.98),
(101, 8, 1, 1.99),
(101, 10, 1, 1.99),
(101, 11, 1, 1.99),
(102, 1, 2, 3.98),
(102, 8, 1, 1.99),
(102, 10, 1, 1.99),
(102, 11, 1, 1.99),
(103, 1, 4, 15.96),
(103, 2, 4, 15.96),
(104, 1, 1, 5.99);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `menu_item_id`, `user_id`, `rating`) VALUES
(6, 10, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`) VALUES
(1, 'gonzales.christiancarlo@auf.edu.ph', '$2y$10$MiwyjI43Y8PPwtGd3u355OJcfy/oulGYvf6RpUw99T1zaLCs6bsXa', 'carlo', 'gonzales');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`OrderId`,`MenuItemId`),
  ADD KEY `order_items_ibfk_2` (`MenuItemId`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_item_id` (`menu_item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`MenuItemId`) REFERENCES `menu` (`Id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`menu_item_id`) REFERENCES `menu` (`Id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
