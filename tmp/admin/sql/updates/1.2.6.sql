ALTER TABLE `#__icagenda` ADD COLUMN `releasedate` TEXT(65535)  NOT NULL AFTER `version`;
UPDATE `#__icagenda` SET version='1.2.6', releasedate='2012-10-06' WHERE id=1;

DROP TABLE IF EXISTS `#__icagenda_registration`;

CREATE TABLE `#__icagenda_registration` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`ordering` INT(11)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`userid` INT(11)  NOT NULL ,
`eventid` INT(11)  NOT NULL ,
`name` VARCHAR(255)  NOT NULL ,
`email` VARCHAR(255)  NOT NULL ,
`phone` VARCHAR(255)  NOT NULL ,
`date` DATE NOT NULL ,
`people` INT(2)  NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

