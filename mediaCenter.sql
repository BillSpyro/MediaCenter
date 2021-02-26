CREATE DATABASE  IF NOT EXISTS `mediaCenter`;
USE `mediaCenter`;

DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `profile`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `friends`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `users` (
  `id` serial UNIQUE NOT NULL,
  `username` varchar(45) UNIQUE NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) UNIQUE NOT NULL,
  `role` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `profile` (
  `id` serial UNIQUE NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `phone` int(10) UNIQUE NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `job` varchar(45) NOT NULL,
  `education` varchar(45) NOT NULL,
  `relationship_status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `posts` (
  `id` serial UNIQUE NOT NULL,
  `name` varchar(45) NOT NULL,
  `content` varchar(255) NOT NULL,
  `post_time` datetime NOT NULL,
  `likes` int NOT NULL,
  `dislikes` int NOT NULL,
  `reposts` int NOT NULL,
  `video_link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `friends` (
  `id` serial UNIQUE NOT NULL,
  `profile_ID` int NOT NULL,
  `friend_ID` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `comments` (
  `id` serial UNIQUE NOT NULL,
  `post_ID` int NOT NULL,
  `profile_ID` int NOT NULL,
  `comment_ID` int NOT NULL,
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `notifications` (
  `id` serial UNIQUE NOT NULL,
  `post_ID` int NOT NULL,
  `profile_ID` int NOT NULL,
  `comment_ID` int NOT NULL,
  `friend_ID` int NOT NULL,
  `user_ID` int NOT NULL,
  `alerted` boolean NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


INSERT INTO `users` (id, username, password, email, role)
VALUES (1, 'Admin', 'Admin', 'admin@gmail.com', 'admin'),
       (2, 'Joe', 'Mama', 'joemama@gmail.com', 'user'),
       (3, 'Alebachew', '12345', 'melaku@gmail.com', 'user'),
       (4, 'Jane', 'Doe', 'janedoe@gmail.com', 'user');
