UPDATE `#__icagenda` SET version='1.3 beta1', releasedate='2012-12-11' WHERE id=1;

ALTER TABLE `#__icagenda_registration` ADD COLUMN `period` TINYINT(1) NOT NULL DEFAULT '0' AFTER `date`;
