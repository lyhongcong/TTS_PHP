-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 16, 2025 at 07:20 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ngay10_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE `poll` (
  `id` int NOT NULL,
  `option_name` varchar(100) DEFAULT NULL,
  `votes` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `poll`
--

INSERT INTO `poll` (`id`, `option_name`, `votes`) VALUES
(1, 'Giao diện', 37),
(2, 'Tốc độ', 11),
(3, 'Dịch vụ khách hàng', 51);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` text,
  `unit_price` int DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `stock_quantity` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `brand`, `description`, `unit_price`, `category`, `stock_quantity`, `image`) VALUES
(1, 'iPhone 14 Pro', 'Samsung', 'Điện thoại cao cấp của Apple, màn hình OLED, camera 48MP.', 21000000, 'Điện tử', 10, 'https://th.bing.com/th/id/OIP.zyuptcCUvi6EaBdq2UN7NQHaHa?cb=iwc2&rs=1&pid=ImgDetMain'),
(2, 'Samsung TV', 'Samsung', 'Smart TV 4K 55 inch, hỗ trợ HDR, điều khiển giọng nói.', 8000000, 'Điện tử', 7, 'https://th.bing.com/th/id/R.dc0c0fbff861d5860ed148e36782342e?rik=4mU8edIELacV6w&riu=http%3a%2f%2fmedia.vietq.vn%2ffiles%2fthutrang%2ftivi_samsung_led_32eh4500.jpg&ehk=MvwQKbQ9KNbNbZeyAAARTwjTyWOt126nUE%2bKRktB%2fEQ%3d&risl=&pid=ImgRaw&r=0'),
(3, 'Nike Air Max', 'Zara', 'Giày thể thao Nike Air Max chính hãng, êm ái, thời trang.', 3200000, 'Thời trang', 15, 'https://myshoes.vn/image/cache/catalog/2022/nike/15.11/giay-nike-revolution-6-xanh-trang-01-1000x1000.jpg'),
(4, 'Dell XPS 13', 'Sony', 'Laptop Dell XPS 13, màn hình cảm ứng, pin lâu, thiết kế mỏng nhẹ.', 28000000, 'Điện tử', 5, 'https://www.techlandbd.com/image/cache/catalog/Chuwi/chuwi-corebook-x-core-i3-laptop-1000x1000.jpg'),
(5, 'Sony WH-1000XM4', 'Sony', 'Tai nghe chống ồn Sony WH-1000XM4, pin 30h, âm thanh Hi-Res.', 6500000, 'Điện tử', 12, 'https://th.bing.com/th/id/OIP.TRujoRRqyg_W1cmZwYkfrAHaHG?cb=iwc2&rs=1&pid=ImgDetMain'),
(6, 'đồng hồ', 'Gucci', 'Vip', 2500000, 'Thời trang', 9, 'https://th.bing.com/th/id/OIF.VV5LQkJYfaz3CIUcfNuWOw?cb=iwc2&rs=1&pid=ImgDetMain');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `content` text,
  `rating` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_name`, `content`, `rating`, `created_at`) VALUES
(1, 1, 'Công', 'Sản phẩm tốt', 5, '2025-05-16 12:46:59'),
(2, 2, 'Minh', 'Sản phẩm tốt', 5, '2025-05-16 12:46:59'),
(3, 3, 'Giang', 'Sản phẩm k tệ', 4, '2025-05-16 13:41:39'),
(4, 4, 'Hòa', 'Sản phẩm chất lượng', 5, '2025-05-16 13:46:29'),
(5, 5, 'Khanh', 'Quá ok', 5, '2025-05-16 13:46:29'),
(6, 6, 'việt', 'sản phẩm tuyệt vời', 5, '2025-05-16 13:47:44'),
(7, 6, 'linh', 'sản phẩm đẹp', 5, '2025-05-16 13:47:44'),
(8, 6, 'Huyền', 'Đẹp quá shop ơi', 5, '2025-05-16 13:49:47'),
(9, 6, 'Trường', 'Sản phẩm rất đẹp, tôi rất thích', 5, '2025-05-16 13:49:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `poll`
--
ALTER TABLE `poll`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
