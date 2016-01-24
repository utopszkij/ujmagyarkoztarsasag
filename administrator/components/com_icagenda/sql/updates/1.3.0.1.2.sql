UPDATE `#__icagenda` SET version='1.3 beta1', releasedate='2012-12-03' WHERE id=1;

ALTER TABLE `#__icagenda_registration` MODIFY COLUMN `date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';
