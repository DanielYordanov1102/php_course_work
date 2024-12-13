-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Време на генериране: 25 ное 2024 в 21:08
-- Версия на сървъра: 10.4.27-MariaDB
-- Версия на PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Структура на таблица `favorite_products_users`
--

CREATE TABLE `favorite_products_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Структура на таблица `collection`
--

CREATE TABLE `collection` (
  `id` int(11) NOT NULL COMMENT 'Първичен ключ',
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `year` YEAR NOT NULL,
  `user_collection` INT(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Структура на таблица `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL COMMENT 'Първичен ключ',
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `year` YEAR NOT NULL,
  `for_auction` BOOLEAN NOT NULL DEFAULT FALSE,
  `uploaded_by` INT(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `products`
--

INSERT INTO `products` (`id`, `title`, `image`, `price`, `description`, `year`, `for_auction`, `uploaded_by`) VALUES
(4, 'Elden Ring: Shadow of the Erdtree Edition', 'https://cdn.ozone.bg/media/catalog/product/cache/1/image/400x498/a4e40ebdc3e371adff845072e1c73f37/e/l/631debf1c79ddaa40205135fe4114b64/elden-ring--shadow-of-the-erdtree-edition-ps5-30.jpg', '99.99', 'Жанр: RPG, Soulslike, Екшън-приключенски, Трето лице, Фентъзи\nРазработчик: From Software', '2024', 'FALSE', '1'),
(5, 'Resident Evil 4 Remake', 'https://cdn.ozone.bg/media/catalog/product/cache/1/image/400x498/a4e40ebdc3e371adff845072e1c73f37/r/e/d2ebca06bafb873e88b8c8e0b88e024d/resident-evil-4-remake-ps5-30.jpg', '44.99', 'Жанр: Horror, Екшън-приключенски\nРазработчик: Capcom', '2023', 'FALSE', '1'),
(6, 'The Witcher 3: Wild Hunt - Complete Edition', 'https://cdn.ozone.bg/media/catalog/product/cache/1/image/400x498/a4e40ebdc3e371adff845072e1c73f37/t/h/399933769ffcf9658629d0ad21d98612/the-witcher-3--wild-hunt---complete-edition-xbox-series-x-30.jpg', '44.99', 'Жанр: RPG, Екшън-приключенски, Отворен свят, Трето лице\nРазработчик:CD Projekt RED', '2023', 'FALSE', '1'),
(7, 'Lies of P', 'https://cdn.ozone.bg/media/catalog/product/cache/1/image/400x498/a4e40ebdc3e371adff845072e1c73f37/l/i/a9f8aa06ce411f5b7e3615449a646e54/lies-of-p-xbox-one-series-x-30.jpg', '44.99', 'Жанр: RPG, Екшън-приключенски\nРазработчик:Neowiz', '2023', 'FALSE', '1'),
(8, 'Kingdom Hearts III', 'https://cdn.ozone.bg/media/catalog/product/cache/1/image/400x498/a4e40ebdc3e371adff845072e1c73f37/k/i/82374a0cb4fea9400099e7b5f57af67b/kingdom-hearts-iii-xbox-one-30.jpg', '19.99', 'Жанр: Екшън-приключенски, Трето лице\nРазработчик:Square Enix', '2019', 'FALSE', '1'),
(16, 'Red Dead Redemption 2', 'https://cdn.ozone.bg/media/catalog/product/cache/1/image/400x498/a4e40ebdc3e371adff845072e1c73f37/r/e/595534629474bee06820e6ce22dd2ea3/red-dead-redemption-2-ps4-30.jpg', '37.99', 'Жанр: Екшън-приключенски, Отворен свят, Трето лиц\nРазработчик:Rockstar Games', '2018', 'FALSE', '1');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `names`, `email`, `password`) VALUES
(1, 'Daniel', 'danielyordanov@abv.bg', '108911'),
(2, 'if0_37902962', 'if0_37902962@abv.bg', 'rdw1cyOxAhU'),
(3, 'Ivan', 'ivanbalakov@abv.bg', '1132');

--
-- Indexes for dumped tables
--

--
-- Индекси за таблица `favorite_products_users`
--
ALTER TABLE `favorite_products_users`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `collection`
--
  ALTER TABLE `collection`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorite_products_users`
--
ALTER TABLE `favorite_products_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Първичен ключ', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
