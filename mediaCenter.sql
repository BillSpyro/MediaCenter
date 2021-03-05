DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `profile`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `friends`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `users` (
  `id` serial UNIQUE NOT NULL,
  `username` varchar(225) UNIQUE NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(225) UNIQUE NOT NULL,
  `role` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `profile` (
  `id` serial UNIQUE NOT NULL,
  `user_ID` int UNIQUE NOT NULL,
  `profile_picture` varchar(255),
  `first_name` varchar(45) NOT NULL,
  `middle_name` varchar(45),
  `last_name` varchar(45) NOT NULL,
  `phone` varchar(15) UNIQUE,
  `date_of_birth` date,
  `gender` varchar(45) NOT NULL,
  `description` varchar(255),
  `location` varchar(255),
  `job` varchar(45),
  `education` varchar(45),
  `relationship_status` varchar(45),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `posts` (
  `id` serial UNIQUE NOT NULL,
  `user_ID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `post_time` datetime NOT NULL,
  `likes` int NOT NULL,
  `dislikes` int NOT NULL,
  `reposts` int NOT NULL,
  `video_link` varchar(255),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `friends` (
  `id` serial UNIQUE NOT NULL,
  `user_ID` int NOT NULL,
  `friend_ID` int NOT NULL,
  `friends` boolean DEFAULT false,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `comments` (
  `id` serial UNIQUE NOT NULL,
  `user_ID` int NOT NULL,
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
VALUES (1, 'Admin', '$2y$10$.L1BYSokzecY8cwYmd3e1ulXzrrCr2Stf0xwjIFpOzMZ/kJ3I5g6q', 'admin@gmail.com', 'admin'),
       (2, 'Joe', '$2y$10$mLi7POFpR9XgOuW3dO5bIuyNIrS9lztlqIsGFjvhkW/2DabSyY1yS', 'joemama@gmail.com', 'user'),
       (3, 'Alebachew', '$2y$10$qczcjJJnpriwxAtM2YDO..fxRHQf1tUDt0wj.feKXuM5lj3/AA09a', 'melaku@gmail.com', 'user'),
       (4, 'Jane', '$2y$10$EvOVVNvsUi0gUiIixC9jr.Mc6wPrprqfE89eD0nk./bel.m9FfrFS', 'janedoe@gmail.com', 'user');

INSERT INTO `profile` (id, user_ID, profile_picture, first_name, middle_name, last_name, phone, date_of_birth, gender, description, location, job, education, relationship_status)
VALUES (1, 1, null, 'Mr', 'Admin', 'Jr', '71791254321', '2000-07-27', 'male', null, 'PA, USA', 'Media Center Admin', 'Masters Degree', 'Single'),
       (2, 2, null, 'Joe', 'Man', 'Mama', '7178430435', '1950-02-19', 'male', null, 'AL, USA', 'Store', 'None', 'married'),
       (3, 3, null, 'Alebachew', null, 'Melaku', '7174929530', '1990-11-27', 'female', null, 'Ethopia', 'Facebook Programmer', 'Associates Degree', 'Single'),
       (4, 4, null, 'Jane', 'Moe', 'Doe', '717943049', '1987-09-24', 'female', null, 'TX, USA', null, null, 'Married');

INSERT INTO `posts` (id, user_ID, name, content, post_time, likes, dislikes, reposts, video_link)
VALUES (1, 2, 'My First Post', 'Hello this is my first post.', '9999-12-31 23:59:59', 0, 0, 0, null),
       (2, 3, 'Hello everyone!', 'My name is Alebachew.', '2021-2-26 15:34:19', 0, 0, 0, null);
