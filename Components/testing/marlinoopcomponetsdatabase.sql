-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 05 2020 г., 20:32
-- Версия сервера: 5.6.43
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `marlinoopcomponetsdatabase`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `email`, `password`) VALUES
(1, '1234561', '1234561', '1234561', '1234561'),
(2, '1234561', '1234561', '1234561', '1234561'),
(5, '1', '2', '3', '4'),
(6, '1', '2', '3', '4'),
(7, '1', '2', '3', '41'),
(8, '1', '2', '3', '4'),
(9, '1', '2', '3', '4'),
(10, '1', '2', '3', '4'),
(11, '44', '44', '44', '44'),
(12, '4333344', '4333344', '4333344', '4333344'),
(13, '112', '223', '334', '445'),
(14, '1', '2', '3', '4'),
(19, '151', '151', '151', '151'),
(20, '2033', '2033', '2033', '2033'),
(22, '555', '555', '555', '555'),
(23, '555', '555', '555', '555'),
(24, '2222', '2222', '2222', '2222'),
(25, '44', '44', '44', '44'),
(26, '77777', '77777', '77777', '77777'),
(27, '', '', '', ''),
(28, '66', '66', '66', '666'),
(29, '8888нн', '8888нн', '8888нн', '8888нн'),
(30, 'eeee', '3333', '555', '76666'),
(31, 'rrr', 'r2', '4', '5'),
(32, 'rrrr1', 'rrr2', 'rrrrr3', '2224'),
(34, 'rrii', '66i6', '77iu7', '88oo0099'),
(35, '7774', '9995', '776', '9996'),
(36, '12', '23', '34', '45'),
(38, 'ttt', '777', 'uuiiu', '8887'),
(39, 'ff', 'ff', 'ff', 'fff'),
(40, 'rrr', 'rr66', 'yyyyty', 'ttytyyy');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
