-- Adminer 4.8.1 MySQL 8.0.32-0ubuntu0.22.04.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `BlogProject`;
CREATE DATABASE `BlogProject` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `BlogProject`;

DROP TABLE IF EXISTS `blogPost`;
CREATE TABLE `blogPost` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `post_date` date NOT NULL,
  `blog_post` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `blogPost` (`id`, `post_title`, `post_date`, `blog_post`) VALUES
(1,	'Hello World!',	'2023-03-16',	'Hello World! I\'m making my first post in my blog. I wrote the code for this application based on everything I\'ve learned in my PHP class this semester so far. '),
(2,	'My second post ',	'2023-03-18',	'Phew! I was having a hard time getting a post into the database when it contained special characters-- \"double quotes\" and \'single quotes\' are now adding with a little help from the mysqli_real_escape_string( ) function.\r\n'),
(4,	'My third post',	'2023-03-18',	'Hello, it\'s me! I think I have all the code written for my Blog Project in PHP! I am pretty excited. Now I\'m going to go through and add/edit comments to my code and do some testing to make sure there aren\'t way to break my application :-) ');

-- 2023-03-23 21:00:24