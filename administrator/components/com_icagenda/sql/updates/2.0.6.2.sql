UPDATE `#__icagenda` SET version='2.1 beta', releasedate='2013-02-22' WHERE id=1;

ALTER TABLE `#__icagenda_events` ADD COLUMN `displaytime` INT(10) NOT NULL DEFAULT '1' AFTER `file`;
