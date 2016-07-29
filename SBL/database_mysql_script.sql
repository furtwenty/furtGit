CREATE TABLE `users` (
  `usrname` varchar(255) NOT NULL,
  `password` varchar(512) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `libr` varchar(45) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`usrname`),
  UNIQUE KEY `usrname_UNIQUE` (`usrname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `shelves` (
  `shelf_id` varchar(255) NOT NULL,
  `copy_id` varchar(255) NOT NULL,
  PRIMARY KEY (`copy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `loanhistory` (
  `usrname` varchar(255) NOT NULL,
  `copy_id` varchar(255) NOT NULL,
  `due_date` varchar(45) DEFAULT NULL,
  `ret_date` varchar(45) DEFAULT NULL,
  `ind` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ind`,`usrname`,`copy_id`),
  UNIQUE KEY `ind_UNIQUE` (`ind`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='		';
CREATE TABLE `books` (
  `book_id` varchar(255) NOT NULL,
  `book_title` varchar(1025) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `bookcopy` (
  `copy_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` varchar(255) NOT NULL,
  PRIMARY KEY (`copy_id`,`book_id`),
  UNIQUE KEY `copy_id_UNIQUE` (`copy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
