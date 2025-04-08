-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 19 2024 г., 18:32
-- Версия сервера: 5.5.68-MariaDB
-- Версия PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testtgbot`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL,
  `login` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `login`, `password`) VALUES
(1, 'kasimov', '$2y$10$vD/abYGvDNYrf4Mvp.hFC.FdmNFvlENf/spU0pMe7.FOqYbhwO9qe');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `background` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplement` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `background`, `supplement`, `status`) VALUES
(1, 'Выживание', 'cases.png', 1, 1),
(5, 'Гриферский', 'cases.png', 1, 1),
(6, 'Анархия', 'cases.png', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `lastbuys`
--

CREATE TABLE IF NOT EXISTS `lastbuys` (
  `id` int(11) NOT NULL,
  `setting` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lastbuys`
--

INSERT INTO `lastbuys` (`id`, `setting`, `value`) VALUES
(1, 'status', 'enabled');

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `product` int(5) NOT NULL,
  `date` datetime NOT NULL,
  `payment` varchar(20) NOT NULL,
  `profit` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL,
  `setting` varchar(255) NOT NULL,
  `value` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`id`, `setting`, `value`) VALUES
(1, 'qiwi_status', 'enabled'),
(2, 'qiwi_public', '48e7qUxn9T7RyYE1MVZswX1FRSbE6iyCj2gCRwwF3Dnh5XrasNTx3BGPiMsyXQFNKQhvukniQG8RTVhYm3iPuhmF1roP2ABYYtvgixpY15BpP7NRHDHkec87YYQDevWae2wNFRYKtHCVKWPpDtz3p5djJmnAyN3xbw6ffHCjw6Jzd7WNti2M3WR34p7Hk'),
(3, 'qiwi_secret', 'eyJ2ZXJzaW9uIjoiUDJQIiwiZGF0YSI6eyJwYXlpbl9tZXJjaGFudF9zaXRlX3VpZCI6Im16OHlici0wMCIsInVzZXJfaWQiOiIzNzUyOTI0MjA3MzUiLCJzZWNyZXQiOiJhOWE4YzQ2YzY4YjVmMDkzOTM0MmQ5OWEyNmQ1NzE3OWRkMmU2ZmMwYTZkOWYzNzhmMzU3MDBkNTk0MDQ2ZWFlIn19'),
(4, 'yoomoney_status', 'enabled'),
(5, 'yoomoney_id', ' 4100117546909744'),
(6, 'yoomoney_secret', 'xTh3vJuUvxcIKlMbnLHKDseJ'),
(7, 'freekassa_status', 'enabled'),
(8, 'freekassa_id', '1234'),
(9, 'freekassa_secret1', 'Идентификатор кошелька'),
(10, 'freekassa_secret2', 'Секретный ключ #1'),
(19, 'enot_status', 'enabled'),
(20, 'enot_id', '55025'),
(21, 'enot_secret1', 'QPcjtibD16k80Gg-iQyFdg0ef9VO-jCW'),
(22, 'enot_secret2', 'pLCwtB2beMatsgh8aZTNQuQsYLByosrR'),
(23, 'anypay_status', 'enabled'),
(24, 'anypay_id', ' 10294'),
(25, 'anypay_secret', '12345gshtyHTYDNgvt');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `displayname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(100) NOT NULL,
  `discount` int(100) NOT NULL,
  `amounted` tinyint(1) NOT NULL,
  `background` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `servers` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commands` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `displayname`, `description`, `price`, `discount`, `amounted`, `background`, `category_id`, `servers`, `commands`, `status`) VALUES
(1, 'dddaannyy', '12345', '123456', 12345, 0, 1, 'donate/GRIEFER.png', 1, '3', '123', 1),
(2, '123', '123456', 'donate/GRIEFER.png', 12345, 0, 1, 'donate/GRIEFER.png', 1, '3', '12345', 1),
(3, 'LIGHTLEAK', '12345', '123456', 12345, 0, 1, 'donate/GRIEFER.png', 1, '3', '123', 1),
(4, '123', '123456', 'donate/GRIEFER.png', 12345, 0, 1, 'donate/GRIEFER.png', 1, '3', '12345', 1),
(5, 'LIGHTLEAK', '12345', '123456', 12345, 0, 1, 'donate/GRIEFER.png', 1, '3', '123', 1),
(6, '123', '123456', 'donate/GRIEFER.png', 12345, 0, 1, 'donate/GRIEFER.png', 1, '3', '12345', 1),
(7, 'LIGHTLEAK', '12345', '123456', 12345, 0, 1, 'donate/GRIEFER.png', 1, '3', '123', 1),
(8, '123', '123456', 'donate/GRIEFER.png', 12345, 0, 1, 'donate/GRIEFER.png', 1, '3', '12345', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `promocodes`
--

CREATE TABLE IF NOT EXISTS `promocodes` (
  `id` int(11) NOT NULL,
  `promocode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int(3) NOT NULL,
  `amount` int(100) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `promocodes`
--

INSERT INTO `promocodes` (`id`, `promocode`, `discount`, `amount`, `status`) VALUES
(2, 'WELF', 15, 1213, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `servers`
--

CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `servers`
--

INSERT INTO `servers` (`id`, `name`, `ip`, `port`, `password`, `status`) VALUES
(3, 'LIGHTLEAK', '20.16.216.37', '25579', '242ghtahGBONTAIOUGBN', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL,
  `setting` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `setting`, `value`) VALUES
(1, 'name', 'LIGHTLEAK'),
(2, 'domain', 'LIGHTLEAK.pro'),
(3, 'ip', 'LIGHTLEAK.pro'),
(4, 'port', '25565'),
(5, 'description', 'Простых путей не ищем!'),
(6, 'full_description', 'Здесь вы сможете приобрести любые товары на сервере'),
(7, 'logotype', 'logotype.png'),
(8, 'favicon', 'icon.png'),
(9, 'book_image', 'minecraft/book.png'),
(10, 'book', '▸ Приветствуем тебя в нашем онлайн-магазине!\r\n\r\n▸ Хочешь купить товар, но не хватает денег? Тогда воспользуйся промокодом "LIGHTLEAK", он снизит цену товара на 15%!\r\n\r\n▸ Если есть вопросы, пишите мне - LIGHTLEAK.pro'),
(11, 'ds', 'https://discord.gg/3GWXAPe5zE'),
(12, 'vk', 'https://vk.com/durov'),
(13, 'tg', 'https://t.me/lightleakforum'),
(15, 'btn_play', 'enabled'),
(16, 'btn_donate', 'enabled'),
(17, 'online_toogle', 'disabled'),
(18, 'email', 'nekkastreim@gmail.com');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`login`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lastbuys`
--
ALTER TABLE `lastbuys`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
