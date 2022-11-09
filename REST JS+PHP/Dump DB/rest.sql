-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 08 2020 г., 00:54
-- Версия сервера: 5.7.23
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lab_rest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `appartments`
--

DROP TABLE IF EXISTS `appartments`;
CREATE TABLE IF NOT EXISTS `appartments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(200) NOT NULL,
  `id_owner` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_owner` (`id_owner`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `appartments`
--

INSERT INTO `appartments` (`id`, `address`, `id_owner`) VALUES
(1, 'Улица Пушкина 3 кв. 5', 2),
(2, 'Улица Ленина 11 кв.22', 1),
(3, 'улица Центральная 14 кв. 88', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `counters`
--

DROP TABLE IF EXISTS `counters`;
CREATE TABLE IF NOT EXISTS `counters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) NOT NULL,
  `id_appartment` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_appartment` (`id_appartment`),
  KEY `id_type` (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `counters`
--

INSERT INTO `counters` (`id`, `id_type`, `id_appartment`, `value`) VALUES
(1, 4, 1, 16),
(2, 2, 1, 4),
(3, 1, 1, 135),
(4, 4, 2, 561),
(5, 2, 2, 31),
(6, 1, 2, 146),
(7, 3, 2, 234),
(8, 4, 3, 13252);

-- --------------------------------------------------------

--
-- Структура таблицы `type_counters`
--

DROP TABLE IF EXISTS `type_counters`;
CREATE TABLE IF NOT EXISTS `type_counters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `type_counters`
--

INSERT INTO `type_counters` (`id`, `title`) VALUES
(1, 'Газовый'),
(2, 'Водяной'),
(3, 'Тепловой'),
(4, 'Электрический');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`) VALUES
(1, 'Иванов Иван Иванович'),
(2, 'Петров Пётр Петрович');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `appartments`
--
ALTER TABLE `appartments`
  ADD CONSTRAINT `appartments_ibfk_1` FOREIGN KEY (`id_owner`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `counters`
--
ALTER TABLE `counters`
  ADD CONSTRAINT `counters_ibfk_1` FOREIGN KEY (`id_appartment`) REFERENCES `appartments` (`id`),
  ADD CONSTRAINT `counters_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `type_counters` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
