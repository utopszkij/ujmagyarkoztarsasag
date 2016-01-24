UPDATE `#__icagenda` SET version='1.3 beta1', releasedate='2012-10-28' WHERE id=1;

ALTER TABLE `#__icagenda_events` ADD COLUMN `registration` TINYINT(1)  NOT NULL DEFAULT '1';

