-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Värd: localhost:9001
-- Tid vid skapande: 16 dec 2014 kl 20:45
-- Serverversion: 5.5.38
-- PHP-version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `projekt`
--

-- --------------------------------------------------------

--
-- Ersättningsstruktur för vy `activity`
--
CREATE TABLE `activity` (
`id` int(11)
,`user` varchar(20)
,`title` varchar(80)
,`content` text
,`created` datetime
,`type` varchar(50)
);
-- --------------------------------------------------------

--
-- Tabellstruktur `answers`
--

CREATE TABLE `answers` (
  `question` int(11) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
`id` int(11) NOT NULL,
  `content` text,
  `created` datetime DEFAULT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `answers`
--

INSERT INTO `answers` (`question`, `user`, `id`, `content`, `created`, `type`) VALUES
(1, 'admin', 5, 'Min favorit är Eden Hazard\r\n', '2014-12-11 17:40:13', 'Svar'),
(1, 'admin', 7, 'Schurrle\r\n', '2014-12-11 21:11:56', 'Svar'),
(2, 'admin', 9, 'Heja chelsea\r\n', '2014-12-15 12:02:29', 'Svar'),
(3, 'berra', 10, '<p>Min favorit är Gianfranco Zola</p>\n', '2014-12-16 20:29:46', 'Svar');

-- --------------------------------------------------------

--
-- Tabellstruktur `comments`
--

CREATE TABLE `comments` (
  `linkid` int(11) DEFAULT NULL,
`id` int(11) NOT NULL,
  `content` text,
  `comment` varchar(20) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `questionid` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `comments`
--

INSERT INTO `comments` (`linkid`, `id`, `content`, `comment`, `user`, `created`, `type`, `questionid`) VALUES
(1, 22, 'Min med', 'question', 'admin', '2014-12-11 22:07:32', 'Kommentar', '1'),
(7, 23, 'Min favorit med', 'answer', 'admin', '2014-12-11 22:10:55', 'Kommentar', '1'),
(5, 24, 'Han är bäst', 'answer', 'admin', '2014-12-16 12:39:47', 'Kommentar', '1'),
(3, 26, 'John Terry är bäst', 'question', 'admin', '2014-12-16 17:36:06', 'Kommentar', '3'),
(3, 27, 'Eller hur', 'question', 'admin', '2014-12-16 17:36:17', 'Kommentar', '3');

-- --------------------------------------------------------

--
-- Tabellstruktur `questions`
--

CREATE TABLE `questions` (
`id` int(11) NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `title` varchar(80) DEFAULT NULL,
  `content` text,
  `created` datetime DEFAULT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `questions`
--

INSERT INTO `questions` (`id`, `user`, `title`, `content`, `created`, `type`) VALUES
(1, 'admin', 'Vem är er favoritspelare?', 'Min favorit är Diego Costa, diskutera gärna vem er favorit är :)', '2014-12-08 14:43:11', 'Fråga'),
(2, 'admin', 'Chelsea - Sporting CP', 'Här får ni gärna dela med era tankar om dagens match', '2014-12-08 14:43:11', 'Fråga'),
(3, 'doe', 'Vem är er favoritspelare genomtiderna', 'Min favorit är John Terry', '2014-12-08 14:43:11', 'Fråga');

-- --------------------------------------------------------

--
-- Tabellstruktur `tags`
--

CREATE TABLE `tags` (
`id` int(11) NOT NULL,
  `tag` varchar(20) DEFAULT NULL,
  `linkid` int(11) DEFAULT NULL,
  `tag1` varchar(20) NOT NULL,
  `tag2` varchar(20) NOT NULL,
  `tag3` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tags`
--

INSERT INTO `tags` (`id`, `tag`, `linkid`, `tag1`, `tag2`, `tag3`) VALUES
(1, 'Chelsea', 1, '', '', ''),
(2, 'KTBFFH', 1, '', '', ''),
(3, 'Chelsea', 3, '', '', ''),
(4, 'Sporting', 2, '', '', ''),
(5, 'Chelsea', 2, '', '', '');

-- --------------------------------------------------------

--
-- Ersättningsstruktur för vy `tagslist`
--
CREATE TABLE `tagslist` (
`id` int(11)
,`user` varchar(20)
,`title` varchar(80)
,`content` text
,`created` datetime
,`type` varchar(50)
,`tags` text
);
-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE `user` (
`id` int(11) NOT NULL,
  `acronym` varchar(20) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `active` datetime DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`id`, `acronym`, `email`, `name`, `password`, `created`, `updated`, `deleted`, `active`, `image`) VALUES
(1, 'admin', 'admin@dbwebb.se', 'Erik Naess', '$2y$10$l3ebzZ9wpt8qO8x7ylbVH.GU3nnvIxRw5IRFSAnhJqnNQeY2agBs6', '2014-12-04 14:36:56', NULL, NULL, '2014-12-04 14:36:56', 'https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-xfp1/v/t1.0-9/10385501_10152312165394091_2667130861679280677_n.jpg?oh=fd996fd76000553cb37da6a2aa909be4&oe=54FDA5C3&__gda__=1427826086_97037c46cb88f10df8dc3874fba9a613'),
(2, 'doe', 'doe@dbwebb.se', 'John/Jane Doe', '$2y$10$9vYjbO5OqMcZdDMDP2zDcOF1C4a30t9c2TOta/.dpr0NW0Cr2v84e', '2014-12-04 14:36:56', NULL, NULL, '2014-12-04 14:36:56', NULL),
(3, 'berra', 'admin@dbwebb.se', 'Berra', '$2y$10$1C8JLpzhKLYJSiEWYcVYYO33Q8HYRPg8C5YTuWqieOPzvvRavsMpq', '2014-12-16 20:19:01', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur för vy `activity`
--
DROP TABLE IF EXISTS `activity`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `activity` AS select `questions`.`id` AS `id`,`questions`.`user` AS `user`,`questions`.`title` AS `title`,`questions`.`content` AS `content`,`questions`.`created` AS `created`,`questions`.`type` AS `type` from `questions` where (`questions`.`user` = 'admin') group by `questions`.`id` union all select `answers`.`question` AS `question`,`answers`.`user` AS `user`,`answers`.`id` AS `id`,`answers`.`content` AS `content`,`answers`.`created` AS `created`,`answers`.`type` AS `type` from `answers` where (`answers`.`user` = 'admin') union all select `comments`.`linkid` AS `linkid`,`comments`.`user` AS `user`,`comments`.`id` AS `id`,`comments`.`content` AS `content`,`comments`.`created` AS `created`,`comments`.`type` AS `type` from `comments` where (`comments`.`user` = 'admin') group by `comments`.`id` order by `created` desc;

-- --------------------------------------------------------

--
-- Struktur för vy `tagslist`
--
DROP TABLE IF EXISTS `tagslist`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tagslist` AS select `q`.`id` AS `id`,`q`.`user` AS `user`,`q`.`title` AS `title`,`q`.`content` AS `content`,`q`.`created` AS `created`,`q`.`type` AS `type`,group_concat(`t`.`tag` separator ',') AS `tags` from (`questions` `q` left join `tags` `t` on((`q`.`id` = `t`.`linkid`))) group by `q`.`id`;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `answers`
--
ALTER TABLE `answers`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `questions`
--
ALTER TABLE `questions`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `acronym` (`acronym`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `answers`
--
ALTER TABLE `answers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT för tabell `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT för tabell `questions`
--
ALTER TABLE `questions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT för tabell `tags`
--
ALTER TABLE `tags`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT för tabell `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
