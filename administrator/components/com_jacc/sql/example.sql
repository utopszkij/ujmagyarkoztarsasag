CREATE TABLE IF NOT EXISTS `#__book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `type` set('paperback','hardback') DEFAULT 'paperback',
  `pages` int(3) DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL,
  `in_stock` int(4) DEFAULT NULL,
  `description` text,
  `published` tinyint(1) DEFAULT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created` datetime DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `params` text,
  PRIMARY KEY (`id`),
  KEY `fk_book_book_publisher` (`publisher_id`),
  KEY `fk_book_book_author1` (`author_id`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__book_author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `params` text,
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__book_publisher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `country` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `description` text,
  `published` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `params` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

