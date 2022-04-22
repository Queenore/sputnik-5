-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 22 2022 г., 15:25
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `webtest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `testtable`
--

CREATE TABLE IF NOT EXISTS `testtable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pathImg` varchar(20) DEFAULT NULL,
  ` date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `testtable`
--

INSERT INTO `testtable` (`id`, `pathImg`, ` date`, `time`) VALUES
(1, 'img1', '2022-04-06', '15:00:00'),
(2, 'img2', '2022-04-06', '16:30:00'),
(3, 'img3', '2022-04-07', '11:02:00'),
(4, 'img3', '2022-04-07', '16:35:00'),
(5, 'img3', '2022-04-08', '15:13:00'),
(8, 'img3', '2022-04-09', '16:12:23'),
(9, 'img3', '2022-04-09', '16:12:23'),
(10, 'img3', '2022-03-08', '16:30:00'),
(12, 'img3', '2022-04-09', '16:12:23');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
