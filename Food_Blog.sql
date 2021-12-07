CREATE TABLE `FoodPost` (
  `postID` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `tags` varchar(255) NOT NULL,
  `displaypicture` varchar(255) NOT NULL,
  `extraimages` mediumtext,
  PRIMARY KEY (`postID`),
  UNIQUE KEY `postID_UNIQUE` (`postID`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `reactions` (
  `postID` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `reaction` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`postID`,`username`),
  KEY `reaction` (`reaction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `ReportPost` (
  `idReportPost` int unsigned NOT NULL AUTO_INCREMENT,
  `postID` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `reportContent` mediumtext NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`idReportPost`),
  UNIQUE KEY `idReportPost_UNIQUE` (`idReportPost`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=ujis;

CREATE TABLE `User_Account` (
  `member_id` int unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(45) NOT NULL,
  `emailnotification` varchar(45) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `2FA` varchar(45) NOT NULL,
  `2FA_TimeStamp` varchar(45) NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `member_id_UNIQUE` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb3;

CREATE TABLE Profile  
( 
  profile_id int unsigned NOT NULL AUTO_INCREMENT, 
  username varchar(45) NOT NULL, 
  bio varchar(255) NOT NULL, 
  facebook  varchar(255) NOT NULL, 
  instagram varchar(255) NOT NULL, 
  twitter varchar(255) NOT NULL, 
  snapchat varchar(255) NOT NULL, 
  PRIMARY KEY (profile_id), 
  UNIQUE KEY profile_id_UNIQUE (profile_id) 
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb3;


