-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2026 at 05:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `velvet_vogue`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(30, 4, 18, 1),
(31, 4, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Men'),
(2, 'Women'),
(3, 'Formal'),
(4, 'Casual'),
(5, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `payment_method`, `status`, `created_at`) VALUES
(1, 4, 57000.00, 'cod', 'Confirmed', '2026-01-01 10:03:37'),
(2, 4, 56500.00, 'COD', 'Confirmed', '2026-01-01 14:02:47'),
(3, 7, 57300.00, 'Credit Card', 'Confirmed', '2026-01-01 16:44:14'),
(4, 4, 62000.00, 'Credit Card', 'Confirmed', '2026-01-02 12:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 6, 2, 8500.00),
(2, 1, 7, 1, 22000.00),
(3, 1, 8, 4, 4500.00),
(4, 2, 6, 2, 8500.00),
(5, 2, 15, 2, 12000.00),
(6, 2, 5, 1, 15500.00),
(7, 3, 13, 1, 7500.00),
(8, 3, 16, 1, 5800.00),
(9, 3, 7, 2, 22000.00),
(10, 4, 16, 2, 5800.00),
(11, 4, 7, 2, 22000.00),
(12, 4, 14, 1, 6400.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `colour` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `description`, `price`, `size`, `colour`, `image`) VALUES
(5, 'Midnight Velvet Blazer', 3, 'A premium deep-blue velvet blazer with silk lapels.', 15500.00, 'L', 'Blue', 'blazer.jpg'),
(6, 'Gold Silk Evening Shirt', 3, 'Luxurious silk shirt with intricate gold detailing.', 8500.00, 'M', 'Gold', 'shirt.jpg'),
(7, 'Crimson Velvet Gown', 2, 'Elegant floor-length velvet gown for gala events.', 22000.00, 'S', 'Red', 'crimson.jpg'),
(8, 'Urban Black Chinos', 4, 'Comfortable slim-fit chinos for everyday style.', 4500.00, 'M', 'Black', 'chinos.jpg'),
(9, 'Midnight Silk Saree', 2, 'Authentic hand-woven silk saree with gold thread detailing.', 24500.00, 'Free Size', 'Black', 'saree_1.jpg'),
(10, 'Heritage Linen Shirt', 1, 'Premium breathable linen, perfect for the tropical climate.', 4800.00, 'S, M, L, X', 'White', 'shirt_1.jpg'),
(11, 'Royal Blue Evening Gown', 2, 'Floor-length velvet gown with a cinched waist.', 18900.00, 'M, L', 'Blue', 'gown_1.jpg'),
(12, 'Casual Island Chinos', 2, 'Lightweight stretch cotton chinos for everyday elegance.', 5200.00, '30, 32, 34', 'Beige', 'chinos_1.jpg'),
(13, 'Golden Lotus Clutch', 3, 'Handcrafted clutch with traditional Sri Lankan embroidery.', 7500.00, 'One Size', 'Gold', 'clutch_1.jpg'),
(14, 'Crimson Wrap Dress', 2, 'Vibrant wrap dress made from eco-friendly viscose.', 6400.00, 'S, M, L', 'Red', 'dress_1.jpg'),
(15, 'Minimalist Silver Cuff', 3, 'Sterling silver cuff with a matte finish.', 12000.00, 'One Size', 'Silver', 'cuff_1.jpg'),
(16, 'Shadow Stripe Trousers', 4, 'Tailored fit trousers with subtle vertical pinstripes.', 5800.00, '30, 32, 34', 'Grey', 'trousers_1.jpg'),
(18, 'Teardrop Slingback Pumps', 2, 'Satin Teardrop Crystal Stiletto Heel Slingback Pumps', 27600.00, '6,7,8,9', 'Teal', 'pumps_1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'admin',
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `card_number` varchar(16) DEFAULT NULL,
  `card_expiry` varchar(5) DEFAULT NULL,
  `card_cvv` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `address`, `city`, `phone`, `card_number`, `card_expiry`, `card_cvv`) VALUES
(2, 'P.A.Devindu Malshan', 'devindu.nwcv@gmail.com', '$2y$10$M4UTbvLKnFT6ofQV6JI7jOfzGVIbwjezhD.GznwWKP61AZgex8fda', 'customer', '162/c pragathi mawatha nagoda kalutara south', NULL, '0782350462', NULL, NULL, NULL),
(4, 'Sarangi Vishwakumaram', 'devindu.n@gmail.com', '$2y$10$Ay5VBxDXNFzzuVIyNuxofeJjm5.Zq32mjzgYWiaJ1Kf.81TdIVzra', 'customer', '123 Fashion Street', NULL, '0782350462', NULL, NULL, NULL),
(5, 'John Finlo', 'john.finlo@vogue.com', '$2y$10$wRsA42qRbkd8v1sTCPUV9./5CnxfijW/YjsIQl8yWhtC/BbuXbgTG', 'admin', '456 Chinos Plaza Colombo 07', NULL, '0770530832', NULL, NULL, NULL),
(7, 'Sandali Fernando ', 'sandali@vogue.com', '$2y$10$0pu0gzEDYXt6LjD3iLRaXO8LmbDb5iJmDIeTyDub/gH0kFwMVlPT.', 'customer', '125/B Fashion City Mumbai', NULL, '0771234567', NULL, NULL, NULL),
(8, 'Devindu Malshan', 'devindu.m@outlook.com', '$2y$10$e2wHA8852gfLJC399GVwveYDuSH.Gqz1AAMFDP0VYVPXMz5O.Fxz2', 'customer', '162/c pragathi mawatha nagoda kalutara south\r\nKalutara', NULL, '+94770530832', NULL, NULL, NULL),
(9, 'Jordan Peterson', 'jpeterson@vogue.com', '$2y$10$8eLIUSQ3hPgVI1ZgMU7UTeL.6gMtQYVgOBKk5YQSv0NerLiocIcpG', 'customer', 'Toronto Ontario Canada', NULL, '+94771234567', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
