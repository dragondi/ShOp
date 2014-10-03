-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Окт 02 2014 г., 22:41
-- Версия сервера: 5.5.25
-- Версия PHP: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `administrators`
--

CREATE TABLE IF NOT EXISTS `administrators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rights` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `administrators`
--

INSERT INTO `administrators` (`id`, `email`, `password`, `name`, `rights`) VALUES
(14, 'dragondi@inbox.ru', '0dfbcf0b59d9326a1899a7df445ac552', 'DD', 1),
(15, 'dragondi123@inbox.ru', 'dcde9600b5ed576bf3e30952215b18ec', 'dd2', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `writer_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `img` varchar(200) NOT NULL DEFAULT 'no_image.jpg',
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  `popularity` int(11) NOT NULL DEFAULT '0',
  `views_count` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `writer_id`, `title`, `img`, `text`, `date`, `popularity`, `views_count`, `description`, `keywords`) VALUES
(1, 1, 'Правила чего-то там', 'no_image.jpg', '', 1163318400, 1, 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `rank` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `tab_index` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `rank`, `parent_id`, `tab_index`, `description`, `keywords`) VALUES
(1, 'Уход за протезами', 1, 0, 0, '', ''),
(2, 'Индивидуальная гигиена полости рта', 1, 0, 0, '', ''),
(3, 'Так правильно хранить и обрабатывать средства гигиены полости рта', 1, 0, 0, '', ''),
(4, 'Ортодонтия', 1, 0, 0, '', ''),
(10, 'УЗ мойки', 2, 1, 0, '', ''),
(11, 'UV боксы', 2, 1, 0, '', ''),
(12, 'Боксы для хранения', 2, 1, 0, '', ''),
(13, 'Щетки', 2, 1, 0, '', ''),
(14, 'Чистящие средства', 2, 1, 0, '', ''),
(15, 'Ирригаторы (насадки и жидкости к ним)', 2, 2, 0, '', ''),
(16, 'Зубные щетки', 2, 2, 0, '', ''),
(17, 'Зубные пасты', 2, 2, 0, '', ''),
(18, 'Ополаскиватели', 2, 2, 0, '', ''),
(19, 'Нити', 2, 2, 0, '', ''),
(20, 'Гели', 2, 2, 0, '', ''),
(21, 'УЗ мойки', 2, 3, 0, '', ''),
(22, 'UV боксы', 2, 3, 0, '', ''),
(23, 'Ортодонтические наборы', 2, 4, 0, '', ''),
(24, 'Щетки', 2, 4, 0, '', ''),
(25, 'Ершики', 2, 4, 0, '', ''),
(26, 'Пасты', 2, 4, 0, '', ''),
(27, 'Воски для брекетов', 2, 4, 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_info` text NOT NULL,
  `article_id` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `author_info`, `article_id`, `good_id`, `text`, `date`) VALUES
(7, 'первый автор', 2, 0, 'пппп', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `feedback_messages`
--

CREATE TABLE IF NOT EXISTS `feedback_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `feedback_messages`
--

INSERT INTO `feedback_messages` (`id`, `user_id`, `topic`, `text`, `date`, `comments`) VALUES
(1, 1, 'test1', 'привет мир 1', '0000-00-00', 'первый коммент'),
(2, 1, 'test2', 'Привет мир 2', '0000-00-00', 'второй коммент');

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `info` text NOT NULL,
  `img` varchar(200) NOT NULL DEFAULT 'no_image.jpg',
  `cost` varchar(50) NOT NULL,
  `popularity` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `category_id`, `title`, `info`, `img`, `cost`, `popularity`, `description`, `keywords`) VALUES
(6, 24, 'Щётка 1', '', 'no_image.jpg', '1000', 0, '', ''),
(7, 24, 'Щётка 2', '', 'no_image.jpg', '100', 0, '', ''),
(8, 24, 'Щётка 3', '', 'no_image.jpg', '10000', 0, '', ''),
(10, 10, 'sdddd', '', 'no_image.jpg', '', 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `data` text NOT NULL,
  `date` date NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `data`, `date`, `comments`) VALUES
(1, 1, '6<$#$>Щётка 1<$#$>1000<$#$>2<$###$>7<$#$>Щётка 2<$#$>100<$#$>8<$###$>8<$#$>Щётка 3<$#$>10000<$#$>2', '2014-09-28', 'sdsdsdsd');

-- --------------------------------------------------------

--
-- Структура таблицы `sliders`
--

CREATE TABLE IF NOT EXISTS `sliders` (
  `slider_id` int(11) NOT NULL,
  `tab_index` int(11) NOT NULL,
  `img` varchar(200) NOT NULL DEFAULT 'no_image.jpg',
  `text` text NOT NULL,
  `link` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `texts`
--

CREATE TABLE IF NOT EXISTS `texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `texts`
--

INSERT INTO `texts` (`id`, `title`, `text`, `description`, `keywords`) VALUES
(1, 'О нас', '', '', ''),
(2, 'Контакты', '', '', ''),
(3, 'Оформление заказа и доставка', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `address`, `phone`) VALUES
(1, 'dragondi@inbox.ru', '0dfbcf0b59d9326a1899a7df445ac552', 'DD', 'Москва', '89265379497');

-- --------------------------------------------------------

--
-- Структура таблицы `writers`
--

CREATE TABLE IF NOT EXISTS `writers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `writers`
--

INSERT INTO `writers` (`id`, `name`, `link`) VALUES
(1, 'Иванов Иван Иванович2', 'http://ya.ru'),
(3, 'Петр Петрович', 'http://google.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
