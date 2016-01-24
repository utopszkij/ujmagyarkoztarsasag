UPDATE `#__icagenda` SET version='1.3 beta1', releasedate='2012-12-10' WHERE id=1;

ALTER TABLE `#__icagenda_events` MODIFY COLUMN `params` TEXT NOT NULL DEFAULT '';
