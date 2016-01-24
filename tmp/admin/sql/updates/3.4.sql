UPDATE `#__icagenda` SET version='3.4', releasedate='2014-07-03' WHERE id=3;

ALTER TABLE `#__icagenda_customfields` ADD COLUMN `description` VARCHAR(255) NOT NULL DEFAULT '' AFTER `slug`;

-- --------------------------------------------------------

--
-- Table structure for table `#__icagenda_customfields_data`
--

CREATE TABLE IF NOT EXISTS `#__icagenda_customfields_data` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `state` TINYINT(1) NOT NULL DEFAULT '1',
  `slug` VARCHAR(255) NOT NULL,
  `parent_form` INT(11) NOT NULL DEFAULT '0',
  `parent_id` INT(11) NOT NULL DEFAULT '0',
  `value` VARCHAR(255) NOT NULL,
  `language` varchar(10) NOT NULL DEFAULT '*',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `#__icagenda_feature`
--

CREATE TABLE IF NOT EXISTS  `#__icagenda_feature` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ordering` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `desc` mediumtext NOT NULL,
  `icon` varchar(255) NOT NULL,
  `icon_alt` varchar(255) NOT NULL,
  `show_filter` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `#__icagenda_feature_xref`
--

CREATE TABLE IF NOT EXISTS  `#__icagenda_feature_xref` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;
