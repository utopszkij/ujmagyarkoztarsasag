UPDATE `#__icagenda` SET version='3.4.1-alpha1', releasedate='2015-01-24' WHERE id=3;

ALTER TABLE `#__icagenda_events` ADD COLUMN `site_itemid` INT(10) NOT NULL DEFAULT '0' AFTER `approval`;
