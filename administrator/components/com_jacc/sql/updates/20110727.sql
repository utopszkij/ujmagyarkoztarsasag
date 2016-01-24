CREATE TABLE IF NOT EXISTS `#__jacc_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `use` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `#__jacc_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `folder` varchar(45) NOT NULL,
  `use` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `#__jacc_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `packagerurl` varchar(150) NOT NULL,
  `updateurl` varchar(150) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `#__jacc_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `use` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
