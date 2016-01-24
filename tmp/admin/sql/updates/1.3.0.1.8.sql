UPDATE `#__icagenda` SET version='1.3 beta4', releasedate='2012-12-24' WHERE id=1;

ALTER TABLE `#__icagenda_events` ADD COLUMN `country` VARCHAR(255) NOT NULL AFTER `city`;
