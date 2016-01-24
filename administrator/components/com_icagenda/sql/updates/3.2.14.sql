ALTER TABLE `#__icagenda` ADD COLUMN `params` TEXT NOT NULL DEFAULT '' AFTER `releasedate`;
INSERT INTO `#__icagenda` (id,version,releasedate,params) VALUES (3,'3.2.14','2014-03-01','');

ALTER TABLE `#__icagenda_events` ADD COLUMN `metadesc` TEXT NOT NULL DEFAULT '' AFTER `desc`;

ALTER TABLE `#__icagenda_registration` ADD COLUMN `custom_fields` TEXT NOT NULL DEFAULT '' AFTER `notes`;

-- --------------------------------------------------------

--
-- Table structure for table `#__icagenda_customfields`
--

CREATE TABLE IF NOT EXISTS `#__icagenda_customfields` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ordering` INT(11) NOT NULL,
  `state` TINYINT(1) NOT NULL DEFAULT '1',
  `checked_out` INT(11) NOT NULL,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` VARCHAR(255) NOT NULL,
  `alias` VARCHAR(255) NOT NULL,
  `parent_form` INT(11) NOT NULL DEFAULT '0',
  `type` VARCHAR(255) NOT NULL,
  `options` mediumtext,
  `default` VARCHAR(255) NOT NULL,
  `required` tinyint(3) NOT NULL DEFAULT '0',
  `language` varchar(10) NOT NULL DEFAULT '*',
  `params` mediumtext,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
